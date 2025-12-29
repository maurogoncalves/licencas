<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
class Home extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('cnd_federal_model','',TRUE);	
   $this->load->model('loja_model','',TRUE);	
   $this->load->model('user','',TRUE);
   $this->load->library('session');
   $this->load->helper('url');
   $this->load->library('form_validation');
   $this->load->model('imovel_model','',TRUE);
   $this->load->model('lojas_licencas_model','',TRUE);
   $this->load->model('licenca_model','',TRUE);
   $this->load->model('cnd_estadual_model','',TRUE);
   $this->load->model('cnd_mobiliaria_model','',TRUE);
   
   session_start();

 }
 
  function report(){	
		if(empty($_SESSION['loginTeste'])){
			  redirect('login', 'refresh');
		 }
		 
		$session_data = $_SESSION['loginTeste'];
		$data['email'] = $session_data['email'];
		$data['empresa'] = $session_data['empresa'];
		$data['perfil'] = $session_data['perfil'];
		
		$data['result'] =  $this->user->online();	
		
		$this->load->view('header_pages_view',$data);
		$this->load->view('report', $data);
		$this->load->view('footer_pages_view');
		
	}
	
 function mapa(){
	  if(!empty($_SESSION['loginTeste'])) {
	   
     $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $data['menu'] = $session_data['menu'];
	 $data['visitante'] = $session_data['visitante'];
	  
	  
	 $idContratante = $session_data['id_contratante'];
	 
	 $estados = $this->cnd_estadual_model->listarEstados();
	 $i=1;
	 foreach($estados as $est){			
		if(($est->uf =='DF')|| ($est->uf =='RJ')|| ($est->uf =='ES')|| ($est->uf =='SE')|| ($est->uf =='AL')||  ($est->uf =='RN')){
			$estadosCnds[$i]['cor'] ='#bababa';
		}else{
			$estadosCnds[$i]['cor'] ='#dedede';
		}		
		$i++;		
	}
	$estado ='BR';
	$resultEmitida =  $this->loja_model->contarCndByStatus($idContratante,$estado,1);		
	$resultNaoTratada =  $this->loja_model->contarCndByStatus($idContratante,$estado,2);		
	$resultPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,3);		
	$resultSPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,4);		

	$data['grafEmitida'] = $resultEmitida[0]->total;
	$data['grafNaoTratada'] = $resultNaoTratada[0]->total;
	$data['grafPendencia'] = $resultPendencia[0]->total;
	$data['grafSpendencia'] = $resultSPendencia[0]->total;
	
	$data['iptus'] = $this->cnd_federal_model->listarCnd($idContratante);
	$pendencias = $this->cnd_mobiliaria_model->contarPendenciasTratativas($idContratante); 
	
	$labelsPendencias ='';
	$dadosPendencias ='';
	foreach($pendencias as $pen){
		$labelsPendencias .= '"'.$pen->descricao_natureza_raiz.'",';
		//$dadosPendencias .= $pen->total.',';
	}
    $data['labelsPendencias'] = $labelsPendencias;
	$data['pendencias'] = $pendencias;
	
    //$data['dadosPendencias'] = $dadosPendencias; 
	 
	 $data['cndEstado'] = $estadosCnds;
	 $this->load->view('header_pages_view',$data);
     $this->load->view('dados_agrupados_mapa', $data);
	 $this->load->view('footer_pages_view');
	 
	  } else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }	 
 
function conta(){	
	$session_data = $_SESSION['loginTeste'];
	$data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$data['menu'] = $session_data['menu'];
	$data['visitante'] = $session_data['visitante'];
	  
	$estado = $this->input->get('estado');		  
	$idContratante = $session_data['id_contratante'];		 

	$resultEmitida =  $this->loja_model->contarCndByStatus($idContratante,$estado,1);		
	$resultNaoTratada =  $this->loja_model->contarCndByStatus($idContratante,$estado,2);		
	$resultPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,3);		
	$resultSPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,4);		

	$estadosCnds['emitida'] = $resultEmitida[0]->total;
	$estadosCnds['naoTratada'] = $resultNaoTratada[0]->total;
	$estadosCnds['pendencia'] = $resultPendencia[0]->total;
	$estadosCnds['sPendencia'] = $resultSPendencia[0]->total;
	$estadosCnds['estado'] = $estado;



	echo json_encode($estadosCnds);	 
}
	 
  function lista(){	
	 
		 $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $data['menu'] = $session_data['menu'];
	 $data['visitante'] = $session_data['visitante'];

		  
		$estado = $this->input->get('estado');	
		  
		$idContratante = $session_data['id_contratante'];
		 
		$result =  $this->loja_model->contarCndByEstado($idContratante,$estado);	
	
		 
		$i=1;
		
		$retornoNot='';
		
		
		$isArray =  count($result);	
			
		if($isArray == 0){ 
				$retornoNot .="<tr style='font-weight:bold!important'>
				<td colspan='7' style='background-color:002060;text-align:center;border:1px solid #002060;font-weight:bold!important'>Sem dados para esse Estado</td>
				</tr>
				";
		}else{
			$retornoNot .="<tr style='background-color:#002060;color:#fff!important;'>
			<td style='width:40%!important;text-align:center;border:1px solid #002060;'>Nome do Imóvel</td>
			<td style='width:20%!important;text-align:center;border:1px solid #002060;'>Cidade</td>
			<td style='width:10%!important;text-align:center;border:1px solid #002060;'>Inscrição</td>
			<td style='width:10%!important;text-align:center;border:1px solid #002060;'>Emitida</td>
			<td style='width:10%!important;text-align:center;border:1px solid #002060;'>Sem Pendência</td>
			<td style='width:10%!important;text-align:center;border:1px solid #002060;'>Pendente</td>
			<td style='width:10%!important;text-align:center;border:1px solid #002060;'>Não Tratada</td>
			<td style='width:10%!important;text-align:center;border:1px solid #002060;'>Data Emi/Pend</td>
			";
			$total =0;
			
			foreach($result as $res){

				$nome = $res->nome_fantasia;
				$cidade = $res->cidade;
				$inscricao = $res->ins_cnd_mob;
				
				if($res->possui_cnd == 1){
					$totalEmitida = 'OK';
					$totalPendente = '-';
					$totalNaoTratada = '-';
					$totalSPendente = '-';
					$data = $res->emissao_br;
				}elseif($res->possui_cnd == 2){
					$totalEmitida = '-';
					$totalPendente = '-';
					$totalNaoTratada = 'OK';
					$totalSPendente = '-';
					$data = '-';
				}elseif($res->possui_cnd == 3){
					$totalEmitida = '-';
					$totalPendente = 'OK';
					$totalNaoTratada = '-';
					$totalSPendente = '-';
					$data = $res->pendencia_br;
				}else{
					$totalEmitida = '-';
					$totalPendente = '-';
					$totalSPendente = 'OK';
					$totalNaoTratada = '-';
					$data = '-';
				}
				
				$retornoNot .="<tr style='font-weight:bold!important'>
				<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$nome."</td>
				<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$cidade."</td>
				<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$inscricao."</td>				
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$totalEmitida."</td>
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$totalSPendente."</td>								
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$totalPendente."</td>				
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$totalNaoTratada."</td>
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$data."</td>
				</tr>
				";
			}
		}
										
		
		
		
		$estadosCnds['listagemNotificacao'] = $retornoNot;
		echo json_encode($estadosCnds);
	 
	 }
	 
 function index(){	
 
   redirect('home/mapa', 'refresh');
 }
	
 function perfil(){
	 $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	$data['dadosUsu'] = $this->user->dadosUsu($session_data['id'] ,$session_data['id_contratante']);
	
	 
	$this->load->view('header_pages_view',$data);
	$this->load->view('perfil', $data);
	$this->load->view('footer_pages_view');
 }
 
 	
 function calendario(){
	 $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	 $this->load->view('header_pages_view',$data);
	$this->load->view('calendario', $data);
	$this->load->view('footer_pages_view');
	 
 }	
 function atualizar_perfil(){
	  $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	 
	 $nome = $this->input->post('nome');
	 $tel = $this->input->post('tel');
	 $cel = $this->input->post('cel');
	 $whats = $this->input->post('whats');
	 $senha = $this->input->post('senha');
	 
	 if(empty($senha)){
		 $dados = array(
			'nome_usuario' => $nome,
			'telefone' => $tel,
			'celular' => $cel,
			'whatsapp' => $whats
		);
	 }else{
		 $dados = array(
			'nome_usuario' => $nome,
			'telefone' => $tel,
			'celular' => $cel,
			'whatsapp' => $whats,
			'senha' => md5($senha)
		);
	 }
	 
		
	 $dados = $this->user->atualizar_dados_usuario($dados,$session_data['id']);
	 redirect('/home/perfil');

 }
 function grafico(){
 
  $session_data = $this->session->userdata('logged_in');
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	
	 
	 $idContratante = $session_data['id_contratante'];
	 $data['estados'] = $this->imovel_model->buscaEstado($idContratante);
	 $data['imSituacao'] = $this->imovel_model->buscaImSituacao($idContratante);
	 
	 $data['iptuEstado']  = $this->imovel_model->buscaIptuEstado($idContratante);
	 //$data['iptuEstadoAno']  = $this->imovel_model->buscaIptuEstadoAno($idContratante);
	 
	 $data['cndMobiliaria']  = $this->imovel_model->buscaCNDMobiliaria($idContratante);
	 $data['cndImobiliaria']  = $this->imovel_model->buscaCNDImobiliaria($idContratante);
	 //$totalLicencaVencida = $this->licenca_model->licencasVencidas($idContratante);
	 //$data['licenca_vencida'] =  $totalLicencaVencida[0]['total'];
	 
		//$id = $this->input->get('id');
	$hoje = date("Y-m-d");
	$hojeMenosUm = strtotime("-1 year", strtotime($hoje));
	$hojeMenosDois = strtotime("-2 year", strtotime($hoje));
	$hojeMenosTres = strtotime("-3 year", strtotime($hoje));
	$hojeMenosQuatro = strtotime("-4 year", strtotime($hoje));
	
	$anoAtual =  date("Y");
	$esseAnoMenosUm =  date("Y", $hojeMenosUm);
	$esseAnoMenosDois =  date("Y", $hojeMenosDois);
	$esseAnoMenosTres =  date("Y", $hojeMenosTres);
	$esseAnoMenosQuatro =  date("Y", $hojeMenosQuatro);
	
	$anos = array('Estado',$anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro);
	$estados1 = "'RS', 'BA', 'PE', 'SP', 'PB', 'PR', 'SC', 'CE', 'MG', 'RN'";
	$estados2 = "'AL', 'MS', 'RJ', 'PI', 'SE', 'GO', 'DF', 'MA', 'ES'";
	

	
	$data['iptuByAnoUm']  = $this->imovel_model->buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados1);
	$data['iptuByAnoDois']  = $this->imovel_model->buscaIptuEstadoAno($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro,$idContratante,$estados2);
	$data['anos'] = $anos;
	 
	 $this->load->view('header_view',$data);
     $this->load->view('grafico_home_view', $data);
	 $this->load->view('footer_view');
 
 }
 
 
 function logout()
 {
   $_SESSION['loginTeste'] = '';
   redirect('login', 'refresh');
 }
 
  function troca_senha()
 {
    $session_data = $this->session->userdata('logged_in');
	
	//print_r($session_data);exit;
	$data['id'] = $session_data['id'];
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
    $this->load->view('header_view',$data);
    $this->load->view('troca_senha', $data);
	$this->load->view('footer_view');


	 
   
 }
 
 function atualizar_senha(){
 
	$senha = md5($this->input->post('senha'));
	$id_usuario = $this->input->post('id');
	
	$this->user->atualizar($senha,$id_usuario);
	$session_data = $this->session->userdata('logged_in');
	$data['id'] = $session_data['id'];
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$data['mensagem'] = 'Senha Alterada Com Sucesso';
	
	$this->load->view('header_view',$data);
    $this->load->view('troca_senha', $data);
	$this->load->view('footer_view');
	
 
 }
 
}
 
?>