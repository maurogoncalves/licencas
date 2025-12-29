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
   $this->load->helper('general_helper');
   $this->load->library('form_validation');
   $this->load->model('imovel_model','',TRUE);
   $this->load->model('lojas_licencas_model','',TRUE);
   $this->load->model('licenca_model','',TRUE);
   $this->load->model('cnd_estadual_model','',TRUE);
   $this->load->model('cnd_mobiliaria_model','',TRUE);
   
   session_start();

 }
 
  function mudarCnd(){
	if(empty($_SESSION['loginTeste'])){
	  redirect('login', 'refresh');
	}
	$id = $this->input->get('id');		  	 	
	$_SESSION['loginTeste']['tipo_cnd']=$id;
	redirect('home', 'refresh');
		 
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
	 

	 if($session_data['primeiro_acesso'] == 0){
		 redirect('home/perfil', 'refresh');	
	 }	 
	  
	 $idContratante = $session_data['id_contratante'];
	 
	 $estados = $this->cnd_estadual_model->listarEstados();
	 $i=1;
	
	 foreach($estados as $est){		

		$dadosEstado =  $this->loja_model->contarCndByEst($idContratante,$est->uf,1);	
		
		if(count($dadosEstado) <> 0){
			if(($est->uf =='DF')|| ($est->uf =='RJ')|| ($est->uf =='ES')|| ($est->uf =='SE')|| ($est->uf =='AL')||  ($est->uf =='RN')){
				$estadosCnds[$i]['cor'] ='#01a8fe';
			}else{
				$estadosCnds[$i]['cor'] ='#01a8fe';
			}		
		}else{
			if(($est->uf =='DF')|| ($est->uf =='RJ')|| ($est->uf =='ES')|| ($est->uf =='SE')|| ($est->uf =='AL')||  ($est->uf =='RN')){
				$estadosCnds[$i]['cor'] ='#bababa';
			}else{
				$estadosCnds[$i]['cor'] ='#dedede';
			}		
		}
		
		
		$i++;		
	}
	
	
	
	//$data['iptus'] = $this->cnd_federal_model->listarCnd($idContratante);
	$pendencias = $this->cnd_mobiliaria_model->contarPendenciasTratativas($idContratante); 
	
	$labelsPendencias ='';
	$dadosPendencias ='';
	if($pendencias == 0){
		$data['labelsPendencias'] = '';
		$data['pendencias'] = '';
	}else{
		foreach($pendencias as $pen){
			$labelsPendencias .= '"'.$pen->descricao_natureza_raiz.'",';
			//$dadosPendencias .= $pen->total.',';
		}
		$data['labelsPendencias'] = $labelsPendencias;
		$data['pendencias'] = $pendencias;
	}
	
	
	
    //$data['dadosPendencias'] = $dadosPendencias; 
	 
	$data['cndEstado'] = $estadosCnds;
	 
	
	if(empty($_POST['estadoFiltro'])){
		$estado='BR';
	}else{
		$estado = $_POST['estadoFiltro'];
	}
	
	$resultEmitida =  $this->loja_model->contarCndByStatus($idContratante,$estado,1);		
	$resultNaoTratada =  $this->loja_model->contarCndByStatus($idContratante,$estado,2);		
	$resultPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,3);		
	$resultSPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,4);		

	$data['grafEmitida'] = $resultEmitida[0]->total;
	$data['grafNaoTratada'] = $resultNaoTratada[0]->total;
	$data['grafPendencia'] = $resultPendencia[0]->total;
	$data['grafSpendencia'] = $resultSPendencia[0]->total;
	$data['grafEstado'] = $estado;
	
	$data['todasCnds'] =  $this->loja_model->contarCndByEst($idContratante,$estado,1);	
	 
	$this->load->view('header_pages_view',$data);
    $this->load->view('dados_agrupados_mapa', $data);
	$this->load->view('footer_pages_view');
	 
	  } else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }
 function exportMapa(){
	  if(!empty($_SESSION['loginTeste'])) {
	   
     $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $data['menu'] = $session_data['menu'];
	 $data['visitante'] = $session_data['visitante'];
	 

	 if($session_data['primeiro_acesso'] == 0){
		 redirect('home/perfil', 'refresh');	
	 }	 
	  
	 $idContratante = $session_data['id_contratante'];
	 
	 $estados = $this->cnd_estadual_model->listarEstados();
	 $i=1;
	
	 foreach($estados as $est){		

		$dadosEstado =  $this->loja_model->contarCndByEst($idContratante,$est->uf,1);	
		
		if(count($dadosEstado) <> 0){
			if(($est->uf =='DF')|| ($est->uf =='RJ')|| ($est->uf =='ES')|| ($est->uf =='SE')|| ($est->uf =='AL')||  ($est->uf =='RN')){
				$estadosCnds[$i]['cor'] ='#01a8fe';
			}else{
				$estadosCnds[$i]['cor'] ='#01a8fe';
			}		
		}else{
			if(($est->uf =='DF')|| ($est->uf =='RJ')|| ($est->uf =='ES')|| ($est->uf =='SE')|| ($est->uf =='AL')||  ($est->uf =='RN')){
				$estadosCnds[$i]['cor'] ='#bababa';
			}else{
				$estadosCnds[$i]['cor'] ='#dedede';
			}		
		}
		
		
		$i++;		
	}
	
	
	
	//$data['iptus'] = $this->cnd_federal_model->listarCnd($idContratante);
	$pendencias = $this->cnd_mobiliaria_model->contarPendenciasTratativas($idContratante); 
	
	$labelsPendencias ='';
	$dadosPendencias ='';
	if($pendencias == 0){
		$data['labelsPendencias'] = '';
		$data['pendencias'] = '';
	}else{
		foreach($pendencias as $pen){
			$labelsPendencias .= '"'.$pen->descricao_natureza_raiz.'",';
			//$dadosPendencias .= $pen->total.',';
		}
		$data['labelsPendencias'] = $labelsPendencias;
		$data['pendencias'] = $pendencias;
	}
	
	
	
    //$data['dadosPendencias'] = $dadosPendencias; 
	 
	$data['cndEstado'] = $estadosCnds;
	 

	if(empty($_POST['estadoFil'])){
		$estado='BR';
	}else{
		$estado = $_POST['estadoFil'];
	}

	
	$result =  $this->loja_model->contarCndByEst($idContratante,$estado,1);	
	 
									
									
	$test="<table border=1>
			<tr>
			<td>UF</td>
			<td>Cidade</td>
			<td>Inscrição</td>
			<td>CNPJ</td>
			<td>Possui Cnd</td>
			<td>Data Emi/Pend</td>
			<td>Data Vencimento</td>
			<td>Valor total</td>
			</tr>
			";
			$base = base_url();
			foreach($result as $key => $iptu){ 	
			
				$nome = $iptu->nome_fantasia;
				$cidade = $iptu->cidade;
				$inscricao = $iptu->ins_cnd_mob;
											
				if($iptu->possui_cnd == 1){
					$status ='Sim';	
					$totalEmitida = 'OK';
					$totalPendente = '-';
					$totalNaoTratada = '-';
					$totalSPendente = '-';
					$data = $iptu->emissao_br;
					$arquivoPendente = "<a style='color:#238E08;' href=".$base."index.php/cnd_brasil/visao_interna_cnd_mob?id=".$iptu->id_cnd." target='_blank'> <i class='fa fa-check-circle' aria-hidden='true'></i></a>";	
				}elseif($iptu->possui_cnd == 2){
					$status ='Não';	
					$totalEmitida = '-';
					$totalPendente = '-';
					$totalNaoTratada = 'OK';
					$totalSPendente = '-';
					$arquivoPendente = "<a style='color:#ffa500;' href=".$base."index.php/cnd_brasil/visao_interna_cnd_mob?id=".$iptu->id_cnd." target='_blank'>  <i class='fa fa-exclamation' aria-hidden='true'></i></a>";	
					$data = '-';
				}elseif($iptu->possui_cnd == 3){
					$status ='Não';	
					$totalEmitida = '-';
					$totalPendente = 'OK';
					$totalNaoTratada = '-';
					$totalSPendente = '-';
					$data = $iptu->pendencia_br;
					$arquivoPendente = "<a style='color:#ff0000;' href=".$base."index.php/cnd_brasil/visao_interna_cnd_mob?id=".$iptu->id_cnd." target='_blank'>  <i class='fa fa-exclamation-triangle' aria-hidden='true'></i></a>";	
				}else{
					$status ='Não';	
					$totalEmitida = '-';
					$totalPendente = '-';
					$totalSPendente = 'OK';
					$totalNaoTratada = '-';
					$data = '-';
					$arquivoPendente = "<a style='color:#238E08;' href=".$base."index.php/cnd_brasil/visao_interna_cnd_mob?id=".$iptu->id_cnd." target='_blank'> <i class='fa fa-check-circle' aria-hidden='true'></i></a>";	
				}
				
				$linkValorTotal = "<a style='color:inherit;'href=".$base."index.php/cnd_brasil/listar_pendencia?cnpj=".$iptu->cpf_cnpj."&estado=".$iptu->estado."&valorPendencia=".$iptu->valor_total." target='_blank'>  ".$iptu->valor_total."</a>";	
				if($iptu->vencto_br == '11/11/1111'){
					$iptu->vencto_br='-';
				}						
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				$test .= "<td>".utf8_decode($cidade)."</td>";
				$test .= "<td>".utf8_decode($inscricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>".utf8_decode($status)."</td>";
				$test .= "<td>".utf8_decode($data)."</td>";
				$test .= "<td>".utf8_decode($iptu->vencto_br)."</td>";
				$test .= "<td>".utf8_decode($iptu->valor_total)."</td>";				
				$test .= "</tr>";

			}
				
			
				
			$test .='</table>';

		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=export.xls");
		echo $test;	
	 
	  } else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }	 
 
 function vencimento(){
	  if(!empty($_SESSION['loginTeste'])) {	   
		 $session_data = $_SESSION['loginTeste'];
		 $data['email'] = $session_data['email'];
		 $data['empresa'] = $session_data['empresa'];
		 $data['perfil'] = $session_data['perfil'];
		 $data['menu'] = $session_data['menu'];
		 $data['visitante'] = $session_data['visitante'];
		 if($session_data['primeiro_acesso'] == 0){
			 redirect('home/perfil', 'refresh');	
		 }	 		  
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
		$ultimoDia =  date("t");
		$dataIni =date('Y-m-').'01'; 	  
		$dataFim =date('Y-m-').$ultimoDia; 	 
		$data['vencimentos'] = $this->loja_model->contarCndByEstadoVencto($idContratante,0,$dataIni,$dataFim); 		
		$data['cndEstado'] = $estadosCnds;

		$this->load->view('header_pages_view',$data);
		$this->load->view('dados_agrupados_mapa_vencto', $data);
		$this->load->view('footer_pages_view');
	 
	  } else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }	 
 
 function tratativa_pendencia(){
	  if(!empty($_SESSION['loginTeste'])) {
	   
     $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $data['menu'] = $session_data['menu'];
	 $data['visitante'] = $session_data['visitante'];
	  
	  
	 $idContratante = $session_data['id_contratante'];
	 
	 
	$pendencias = $this->cnd_mobiliaria_model->contarPendenciasTratativas($idContratante); 
	
	
	$labelsPendencias ='';
	$dadosPendencias ='';
	if($pendencias == 0){
		$data['labelsPendencias'] = '';
		$data['pendencias'] = '';
		$data['cores'] ='';	
	}else{
		$cores ='';
		foreach($pendencias as $pen){
			$labelsPendencias .= '"'.$pen->descricao_natureza_raiz.'",';
			//$dadosPendencias .= $pen->total.',';
			$cores .= '"'.$pen->cor.'",';
		}
		$data['labelsPendencias'] = $labelsPendencias;
		$data['pendencias'] = $pendencias;
		$data['cores'] =$cores;	
	}
	
	
	 $this->load->view('header_pages_view',$data);
     $this->load->view('dados_agrupados_tratativa', $data);
	 $this->load->view('footer_pages_view');
	 
	  } else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }	 
 
  function cnd_status(){
	  if(!empty($_SESSION['loginTeste'])) {
	   
     $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $data['menu'] = $session_data['menu'];
	 $data['visitante'] = $session_data['visitante'];
	  
	  
	 $idContratante = $session_data['id_contratante'];
	 
	
	$estado ='BR';
	$resultEmitida =  $this->loja_model->contarCndByStatus($idContratante,$estado,1);		
	$resultNaoTratada =  $this->loja_model->contarCndByStatus($idContratante,$estado,2);		
	$resultPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,3);		
	$resultSPendencia =  $this->loja_model->contarCndByStatus($idContratante,$estado,4);		

	$data['grafEmitida'] = $resultEmitida[0]->total;
	$data['grafNaoTratada'] = $resultNaoTratada[0]->total;
	$data['grafPendencia'] = $resultPendencia[0]->total;
	$data['grafSpendencia'] = $resultSPendencia[0]->total;
	
	
	
	 $this->load->view('header_pages_view',$data);
     $this->load->view('dados_agrupados_cnd_status', $data);
	 $this->load->view('footer_pages_view');
	 
	  } else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }	 
 
 function contaVencto(){	
	$session_data = $_SESSION['loginTeste'];
	$data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$data['menu'] = $session_data['menu'];
	$data['visitante'] = $session_data['visitante'];
	  
	$estado = $this->input->get('estado');		  
	$idContratante = $session_data['id_contratante'];		 

	$resultEmitida =  $this->loja_model->contarCndByStatusVencto($idContratante,$estado,1);		
	$resultNaoTratada =  $this->loja_model->contarCndByStatusVencto($idContratante,$estado,2);		
	$resultPendencia =  $this->loja_model->contarCndByStatusVencto($idContratante,$estado,3);		
	$resultSPendencia =  $this->loja_model->contarCndByStatusVencto($idContratante,$estado,4);		

	$estadosCnds['emitida'] = $resultEmitida[0]->total;
	$estadosCnds['naoTratada'] = $resultNaoTratada[0]->total;
	$estadosCnds['pendencia'] = $resultPendencia[0]->total;
	$estadosCnds['sPendencia'] = $resultSPendencia[0]->total;
	$estadosCnds['estado'] = $estado;



	echo json_encode($estadosCnds);	 
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
								<td style='width:10%!important;text-align:center;border:1px solid #002060;'>UF</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>Cidade</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>Inscrição</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>CNPJ</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>Possui CND</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>Data Emi/Pend</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>Valor total</td>
						</tr>			
			";
			$total =0;
			
			foreach($result as $res){

				
				if($res->possui_cnd == 1){
					$status ='Sim';	
					$totalEmitida = 'OK';
					$totalPendente = '-';
					$totalNaoTratada = '-';
					$totalSPendente = '-';
					$data = $res->emissao_br;
				}elseif($res->possui_cnd == 2){
					$status ='Não';	
					$totalEmitida = '-';
					$totalPendente = '-';
					$totalNaoTratada = 'OK';
					$totalSPendente = '-';
					$data = '-';
				}elseif($res->possui_cnd == 3){
					$status ='Não';	
					$totalEmitida = '-';
					$totalPendente = 'OK';
					$totalNaoTratada = '-';
					$totalSPendente = '-';
					$data = $res->pendencia_br;
				}else{
					$status ='Não';	
					$totalEmitida = '-';
					$totalPendente = '-';
					$totalSPendente = 'OK';
					$totalNaoTratada = '-';
					$data = '-';
				}
				$base = base_url();
				if($totalPendente == 'OK'){					
					$arquivoPendente = "<a style='color:inherit;' href=".$base."index.php/cnd_brasil/visao_interna_cnd_mob?id=".$res->id_cnd." target='_blank'>  ".$totalPendente."</a>";	
				}else{
					$arquivoPendente =$totalPendente;
				}
				
				
				$linkTratativas = "<a style='color:inherit;' href=".$base."index.php/cnd_brasil/visao_interna_cnd_mob?id=".$res->id_cnd." target='_blank'>  ".$res->ins_cnd_mob."</a>";											
				$linkValorTotal = "<a style='color:inherit;' href=".$base."index.php/cnd_brasil/listar_pendencia?cnpj=".$res->cpf_cnpj."&estado=".$res->estado."&valorPendencia=".$res->valor_total." target='_blank'>  ".$res->valor_total."</a>";	
										
				$retornoNot .="<tr style='font-weight:bold!important'>
										<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$res->estado."</td>
										<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$res->cidade."</td>
										<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$linkTratativas."</td>				
										<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$res->cpf_cnpj."</td>				
										<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$status."</td>
										<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$data."</td>
										<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$linkValorTotal ."</td>
				</tr>
				";
			}
		}
										
		
		
		
		$estadosCnds['listagemNotificacao'] = $retornoNot;
		echo json_encode($estadosCnds);
	 
	 }
	 
	 
	  function listaOld(){	
	 
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
				
				if($totalPendente == 'OK'){
					$base = base_url();
					$arquivoPendente = "<a style='color:inherit;' href=".$base."index.php/cnd_brasil/visao_interna_cnd_mob?id=".$res->id_cnd." target='_blank'>  ".$totalPendente."</a>";	
				}else{
					$arquivoPendente =$totalPendente;
				}
				
				$retornoNot .="<tr style='font-weight:bold!important'>
				<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$nome."</td>
				<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$cidade."</td>
				<td style='text-align:center;width:11%;border:1px solid #002060;font-weight:bold!important'>".$inscricao."</td>				
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$totalEmitida."</td>
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$totalSPendente."</td>								
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$arquivoPendente."</td>				
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$totalNaoTratada."</td>
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$data."</td>
				</tr>
				";
			}
		}
										
		
		
		
		$estadosCnds['listagemNotificacao'] = $retornoNot;
		echo json_encode($estadosCnds);
	 
	 }
  function lista_vecto(){	
	 
		 $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $data['menu'] = $session_data['menu'];
	 $data['visitante'] = $session_data['visitante'];

		  
		$estado = $this->input->get('estado');	
		$mes = $this->input->get('mes');

		if($mes == 0){
			$ultimoDia =  date("t");
			$dataIni =date('Y-m-').'01'; 	  
			$dataFim =date('Y-m-').$ultimoDia; 	 	
		}else{
			$dtArr = explode("-",$mes);
			$diaFim = cal_days_in_month(CAL_GREGORIAN, $dtArr[1] , $dtArr[0]);
			$dataIni =$mes.'-01'; 
			$dataFim =$mes.'-'.$diaFim; 
		}
		
		$idContratante = $session_data['id_contratante'];
		$result = $this->loja_model->contarCndByEstadoVencto($idContratante,$estado,$dataIni,$dataFim); 	
	
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
			<td style='width:10%!important;text-align:center;border:1px solid #002060;'>Data Vencto</td>
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
				<td style='text-align:center;width:5%;border:1px solid #002060;font-weight:bold!important'>".$res->data_vencto_br."</td>
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
			'whatsapp' => $whats,
			'primeiro_acesso' => 1
		);
	 }else{
		 $dados = array(
			'nome_usuario' => $nome,
			'telefone' => $tel,
			'celular' => $cel,
			'whatsapp' => $whats,
			'primeiro_acesso' => 1,
			'senha' => md5($senha)
		);
	 }
	 
		
	 $dados = $this->user->atualizar_dados_usuario($dados,$session_data['id']);
	 redirect('/home/logout');

 }
 function grafico(){
	 $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $idContratante = $session_data['id_contratante'];	
	 $hoje =date("Y-m-d");
	 
	 $acimaTrintaDias =  date('Y-m-d', strtotime("30 days",strtotime($hoje)));
	 
	 $data['acimaTrintaVencer'] =  date('d-m-Y', strtotime("+30 days",strtotime($hoje))); 
	 
	 
	 $result = $this->imovel_model->contaVencerTrinta($idContratante, 1,$acimaTrintaDias );	
	 $count = is_array($result) ? '1' : '0';
	 if($count == 0){
		$data['dadosEmitidasEstadualTotalAcimaTrintaDiasVencer'] = '0';
	 }else{
		$data['dadosEmitidasEstadualTotalAcimaTrintaDiasVencer'] = (array)$result;
	 }
	 
	 $iniTrintaVencer =  date('Y-m-d', strtotime("+0 days",strtotime($hoje))); 
	 $fimTrintaVencer =  date('Y-m-d', strtotime("+30 days",strtotime($hoje))); 	
	 
	 $data['iniTrintaVencer'] = date('d-m-Y', strtotime("+0 days",strtotime($hoje))); 
	 $data['fimTrintaVencer'] =  date('d-m-Y', strtotime("+30 days",strtotime($hoje))); 
	 
	 
	 $result = $this->imovel_model->contaVencerTrinta($idContratante, $iniTrintaVencer,$fimTrintaVencer );	
	 //print_r($this->db->last_query());exit;
	 $count = is_array($result) ? '1' : '0';
	 if($count == 0){
		$data['dadosEmitidasEstadualTotalTrintaDiasVencer'] = '0';
	 }else{
		$data['dadosEmitidasEstadualTotalTrintaDiasVencer'] = (array)$result;
	 }
	 
	 $iniQuinzeVencer =  $hoje; 
	 $fimQuinzeVencer =  date('Y-m-d', strtotime("+15 days",strtotime($hoje))); 	
	 
	 $data['iniQuinzeVencer'] =date("d-m-Y");
	 $data['fimQuinzeVencer'] =   date('d-m-Y', strtotime("+15 days",strtotime($hoje))); 	
	 
	 $result = $this->imovel_model->contaVencerTrinta($idContratante, $iniQuinzeVencer,$fimQuinzeVencer );	
	 $count = is_array($result) ? '1' : '0';
	 if($count == 0){
		$data['dadosEmitidasEstadualTotalQuinzeDiasVencer'] = '0';
	 }else{
		$data['dadosEmitidasEstadualTotalQuinzeDiasVencer'] = (array)$result;
	 }
	 
	 
	 $iniQuinzeVenci =  $hoje; 
	 $fimQuinzeVenci =  date('Y-m-d', strtotime("-15 days",strtotime($hoje))); 	
	 
	 $data['iniQuinzeVenci'] = date("d-m-Y");
	 $data['fimQuinzeVenci'] =    date('d-m-Y', strtotime("-15 days",strtotime($hoje))); 	
	 
	 $result = $this->imovel_model->contaVencerTrinta($idContratante, $fimQuinzeVenci,$iniQuinzeVenci );	
	 $count = is_array($result) ? '1' : '0';
	 if($count == 0){
		 $data['dadosEmitidasEstadualTotalQuinzeDiasVencidas'] = '0';
	 }else{
		$data['dadosEmitidasEstadualTotalQuinzeDiasVencidas'] = (array)$result; 
	 }
	
	  //print_r($this->db->last_query());exit;
	 $fimQuinzeVenci =  date('Y-m-d', strtotime("-16 days",strtotime($hoje))); 	
	 
	 $result = $this->imovel_model->contaVencerTrinta($idContratante, 0,$fimQuinzeVenci );	
	 $count = is_array($result) ? '1' : '0';
	 if($count == 0){
		 $data['dadosEmitidasEstadualTotalMaiorQuinzeDiasVencidas'] = '0';
	 }else{
		$data['dadosEmitidasEstadualTotalMaiorQuinzeDiasVencidas'] = (array)$result; 
	 }
	  
	
	 if($_SESSION['loginTeste']['tipo_cnd'] == 2){
		$data['tipo_cnd'] = 'Estadual ';
		$data['nome_cnd'] = 'CND Estadual - Ativas';
	}elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		$data['tipo_cnd'] = 'Mobiliária ';
		$data['nome_cnd'] = 'CND Mobiliária - Ativas';
	}else{
		$data['tipo_cnd'] = 'Federal ';
		$data['nome_cnd'] = 'CND Federal - Ativas';
	}	
	 $this->load->view('header_view',$data);
     $this->load->view('grafico_view', '');
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