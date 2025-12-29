<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacao extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('notificacao_model','',TRUE);
   $this->load->model('acomp_cnd_model','',TRUE);
   $this->load->model('licenca_model','',TRUE);
   $this->load->model('log_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
   $this->load->model('loja_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
   date_default_timezone_set('America/Sao_Paulo');
   //$this->db->cache_on();
    session_start();
  
 }
 
 function index()
 {
   if($_SESSION['loginTeste'])
   {
	
     $session_data = $_SESSION['loginTeste'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
     $this->load->view('home_view', $data);
   }
   else
   {
     
     redirect('login', 'refresh');
   }
 }
 
 
 function export(){	
		
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$id = $this->input->post('id_imovel_export');
	if($id == '0'){
		$result = $this->notificacao_model->listarTodos($idContratante,0,0);
	}else{
		$result = $this->notificacao_model->listarNotById($id);
	}
	
	$this->csv($result);
			
 }
 
   function export_mun(){	
		
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$id = $this->input->post('id_mun_export');	
	$result = $this->notificacao_model->listarTodasNotificacaoByEstadoCidade($idContratante,$id,1);
	
	$this->csv($result);
		
 }
 
 function export_est(){	
		
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$id = $this->input->post('id_estado_export');	
	$result = $this->notificacao_model->listarTodasNotificacaoByEstadoCidade($idContratante,$id,2);
	
	$this->csv($result);
		
 }
 
 function csv($result){
	 
	 $file="notificacao.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>Raz&atilde;o Social</td>		
		<td>Cidade</td>
		<td>Estado</td>
		<td>Nome Empresa Notificada</td>
		<td>Data da Ci&ecirc;ncia da Notifica&ccedil;&atilde;o</td>
		<td>Esfera</td>
		<td>Ano Compet&ecirc;ncia</td>
		<td>N&#176; do processo/Notifica&ccedil;&atilde;o</td>
		<td>Descri&ccedil;&atilde;o da solicita&ccedil;&atilde;o </td>
		<td>Tipo de solicita&ccedil;&atilde;o </td>
		<td>A&ccedil;&atilde;o a ser tomada </td>
		<td>Respons&aacute;vel </td>
		<td>Prazo de atendimento </td>
		<td>Alerta no prazo</td>
		<td>Direcionado para </td>
		<td>Data de Envio </td>
		<td>N&uacute;mero da solicita&ccedil;&atilde;o </td>
		<td>Prioridade </td>
		<td>Data de atendimento </td>
		<td>Dias de atendimento </td>
		<td>Nome do auditor </td>
		<td>Contato do auditor </td>
		<td>Data, Hora, Email e Observa&ccedil;&otilde;es</td>
		<td>Risco da autua&ccedil;&atilde;o </td>
		<td>Data de encerramento fiscaliza&ccedil;&atilde;o </td>
		<td>Data de recebimento do Termo de Encerramento </td>
		<td>Status</td>
		<td>Alterado Por </td>
		<td>Data Altera&ccedil;&atilde;o </td>
		<td>Dados Alterados </td>	
		</tr>
		";
		
		$isArray =  is_array($result) ? '1' : '0';
		if($isArray == 0){
			$test="
			<tr>
			<td>Não Há Dados para exibi&ccedil;&atilde;o</td>		
			</tr>
			";
		}else{			
			  foreach($result as $key => $emitente){ 	
			  $dadosLog = $this->log_model->listarLog($emitente->id,'notificacao');				
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';
			  
			 
			  $dadosObs = $this->notificacao_model->buscaTodasObservacoes($emitente->id_notif);		

				$obs = '';	
			  foreach($dadosObs as $dado){
				  $obs .= $dado->data.'-'.$dado->hora.'-'.$dado->email.'-'.$dado->observacao;
				  $obs .= '<BR>';
				  
			  }
			  

				$test .= "<tr>";
				$test .= "<td>".utf8_decode($emitente->id_notif)."</td>";
				$test .= "<td>".utf8_decode($emitente->nome)."</td>";
				$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
				$test .= "<td>".utf8_decode($emitente->estado)."</td>";
				$test .= "<td>".utf8_decode($emitente->nome_empresa_notificada)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_ciencia_notificacao_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->descricao_esfera)."</td>";
				$test .= "<td>".utf8_decode($emitente->ano_competencia)."</td>";
				$test .= "<td>".utf8_decode($emitente->numero_processo)."</td>";
				$test .= "<td>".utf8_decode($emitente->descricao_solicitacao)."</td>";
				$test .= "<td>".utf8_decode($emitente->tipo_solicitacao)."</td>";
				$test .= "<td>".utf8_decode($emitente->plano_acao)."</td>";
				$test .= "<td>".utf8_decode($emitente->responsavel)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_atendimento_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_prazo_atendimento_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->direcionado_para)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_envio_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->numero_solicitacao)."</td>";
				$test .= "<td>".utf8_decode($emitente->prioridade_demanda)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_atendimento_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->dias_atendimento)."</td>";
				$test .= "<td>".utf8_decode($emitente->nome_auditor)."</td>";
				$test .= "<td>".utf8_decode($emitente->contato_auditor)."</td>";
				$test .= "<td>".$obs."</td>";
				$test .= "<td>".utf8_decode($emitente->risco_atuacao)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_encerr_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_receb_term_encerr_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->descricao)."</td>";
						if($isArrayLog <> 0){
						 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
						 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
						 $test .="<td>".$dadosLog[0]->email."</td>";
						 $test .="<td>".$dataFormatada."</td>";
						 $test .="<td>"."'".utf8_decode($dadosLog[0]->texto)."'"."</td>";
					}else{
						$test .="<td></td>";
						$test .="<td></td>";
						$test .="<td></td>";
					}
				$test .= "</tr>";
				
			}
		}
		$test .='</table>';

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
		
 }	
 
 function calcularDias(){

	$dtAtendi = $this->input->get('dtAtendi');
	$dataEnvio = $this->input->get('dataEnvio');
	
	$dtAtendiArr = explode("/",$dtAtendi);		
	$dataEncerrArr = explode("/",$dataEnvio);		
	
	$dtAtend = $dtAtendiArr[2].'-'.$dtAtendiArr[1].'-'.$dtAtendiArr[0];
	$dtEnvio = $dataEncerrArr[2].'-'.$dataEncerrArr[1].'-'.$dataEncerrArr[0];
	
	$obj = array();
	if($dtEnvio > $dtAtend){
		$obj['status']=1;
		$obj['dias']=0;
	}else{
		$obj['status']=0;
		$result = $this->notificacao_model->calcularDias($dtAtend,$dtEnvio);
		$obj['dias']=$result[0]->dias;		
	}
	
	echo json_encode($obj);
	
	
}

  function buscaLojasByCidadeNotificacao(){	
	 $session_data = $_SESSION['loginTeste'];
	 $id = $this->input->get('id_cidade');
	 $idContratante = $session_data['id_contratante'];	
	 $retorno ='';
	 $result = $this->notificacao_model->buscaLojaByCidade($idContratante,$id);
	 
	 $isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $imovel){ 	
		 
			$retorno .="<option value='".$imovel->id_loja."'>".$imovel->razao_social."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
 
 }
 
 function cadastrar(){
	 
	 if(!$_SESSION['loginTeste']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$data['estados'] = $this->loja_model->listarEstado($idContratante);	
	$data['cidades'] = $this->loja_model->listarCidade($idContratante);		
	$data['perfil'] = $session_data['perfil'];
	$data['esferas'] = $this->notificacao_model->listarEsfera();
	$data['alertas'] = $this->notificacao_model->listarAlerta();
	$data['prioridades'] = $this->notificacao_model->listarPrioridade();
	$data['status'] = $this->notificacao_model->listarStatus();
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_notificacao_view', $data);
	$this->load->view('footer_pages_view');
	
	
 }
 
 
  function cadastrar_noti(){
	 
	 if(!$_SESSION['loginTeste']) {
			redirect('login', 'refresh');
	}
	
	$session_data = $_SESSION['loginTeste'];
	$id_loja=$this->input->post('id_loja');
	$id_contratante=$session_data['id_contratante'];
	$id_esfera=$this->input->post('esfera');
	$nome_empresa_notificada=$this->input->post('nome_empresa');
	$data_ciencia_notificacao=$this->input->post('data_ciencia');
	$ano_competencia=$this->input->post('ano_competencia');
	$numero_processo=$this->input->post('numero_processo');
	$descricao_solicitacao=$this->input->post('descr_solic');
	$tipo_solicitacao=$this->input->post('tipo_solic');
	$plano_acao=$this->input->post('acoes');
	$responsavel=$this->input->post('resp');
	$data_prazo_atendimento=$this->input->post('prazo_atendimento');
	$alerta_prazo_atendimento=$this->input->post('alerta');
	$direcionado_para=$this->input->post('direcionado');
	$data_envio=$this->input->post('data_envio');
	$numero_solicitacao=$this->input->post('num_solic');
	$prioridade=$this->input->post('prioridade');
	$data_atendimento=$this->input->post('data_atendimento');
	$dias_atendimento=$this->input->post('dias_atendimento');
	$nome_auditor=$this->input->post('nome_auditor');
	$contato_auditor=$this->input->post('contato_auditor');
	$risco_atuacao=$this->input->post('risco');
	$observacoes=$this->input->post('observacao');
	$status=$this->input->post('status');
	$data_encerr=$this->input->post('data_encerra');
	$data_receb_term_encerr=$this->input->post('data_recebe_termo');
	
	
	
	$dados = array(
	'id_loja'=>$id_loja,
	'id_contratante'=>$id_contratante,
	'id_esfera'=>$id_esfera,
	'nome_empresa_notificada'=>$nome_empresa_notificada,
	'data_ciencia_notificacao'=>$data_ciencia_notificacao,
	'ano_competencia'=>$ano_competencia,
	'numero_processo'=>$numero_processo,
	'descricao_solicitacao'=>$descricao_solicitacao,
	'tipo_solicitacao'=>$tipo_solicitacao,
	'plano_acao'=>$plano_acao,
	'responsavel'=>$responsavel,
	'data_prazo_atendimento'=>$data_prazo_atendimento,
	'alerta_prazo_atendimento'=>$alerta_prazo_atendimento,
	'direcionado_para'=>$direcionado_para,
	'data_envio'=>$data_envio,
	'numero_solicitacao'=>$numero_solicitacao,
	'prioridade'=>$prioridade,
	'data_atendimento'=>$data_atendimento,
	'dias_atendimento'=>$dias_atendimento,
	'nome_auditor'=>$nome_auditor,
	'contato_auditor'=>$contato_auditor,
	'risco_atuacao'=>$risco_atuacao,
	'observacoes'=>$observacoes,
	'status'=>$status,
	'data_encerr'=>$data_encerr,
	'data_receb_term_encerr'=>$data_receb_term_encerr);

	$id = $this->notificacao_model->add($dados);
	
	$dadosObs = array(
		'id_not'=>$id,
		'data'=>date("Y-m-d"),
		'hora'=>date("h:i:s"),
		'id_usuario'=>$session_data['id'],
		'observacao'=>$observacoes,	
	);
	
	$this->notificacao_model->addObs($dadosObs);
	
	redirect('notificacao/listar', '');
		
	
	
  }	
  
   function atualiza_noti(){
	 
	 if(!$_SESSION['loginTeste']) {
			redirect('login', 'refresh');
	}
	
	$session_data = $_SESSION['loginTeste'];
	
	$id_not=$this->input->post('id_not');
	$id_loja=$this->input->post('id_loja');
	$id_contratante=$session_data['id_contratante'];
	$id_esfera=$this->input->post('esfera');
	$nome_empresa_notificada=$this->input->post('nome_empresa');
	$data_ciencia_notificacao=$this->input->post('data_ciencia');
	$ano_competencia=$this->input->post('ano_competencia');
	$numero_processo=$this->input->post('numero_processo');
	$descricao_solicitacao=$this->input->post('descr_solic');
	$tipo_solicitacao=$this->input->post('tipo_solic');
	$plano_acao=$this->input->post('acoes');
	$responsavel=$this->input->post('resp');
	$data_prazo_atendimento=$this->input->post('prazo_atendimento');
	$alerta_prazo_atendimento=$this->input->post('alerta');
	$direcionado_para=$this->input->post('direcionado');
	$data_envio=$this->input->post('data_envio');
	$numero_solicitacao=$this->input->post('num_solic');
	$prioridade=$this->input->post('prioridade');
	$data_atendimento=$this->input->post('data_atendimento');
	$dias_atendimento=$this->input->post('dias_atendimento');
	$nome_auditor=$this->input->post('nome_auditor');
	$contato_auditor=$this->input->post('contato_auditor');
	$risco_atuacao=$this->input->post('risco');
	$observacoes=$this->input->post('observacao');
	$status=$this->input->post('status');
	$data_encerr=$this->input->post('data_encerra');
	$data_receb_term_encerr=$this->input->post('data_recebe_termo');
	
	$dataPrazoArr = explode("/",$data_prazo_atendimento);	
	$dataPrazo = $dataPrazoArr[2].'-'.$dataPrazoArr[1].'-'.$dataPrazoArr[0];
	
	$dataCienciaArr = explode("/",$data_ciencia_notificacao);	
	$dataCiencia = $dataCienciaArr[2].'-'.$dataCienciaArr[1].'-'.$dataCienciaArr[0];
	
	$dataEnvioArr = explode("/",$data_envio);									 
	$dataEnvio = $dataEnvioArr[2].'-'.$dataEnvioArr[1].'-'.$dataEnvioArr[0];	
	
	$dataAtendArr = explode("/",$data_atendimento);									 
	$dataAtend = $dataAtendArr[2].'-'.$dataAtendArr[1].'-'.$dataAtendArr[0];
	
	$dataEncerrArr = explode("/",$data_encerr);									 
	$dataEncerr = $dataEncerrArr[2].'-'.$dataEncerrArr[1].'-'.$dataEncerrArr[0];
	
	$dataRecebArr = explode("/",$data_receb_term_encerr);									 
	$dataReceb = $dataRecebArr[2].'-'.$dataRecebArr[1].'-'.$dataRecebArr[0];
	
	$dadosObs = array(
		'id_not'=>$id_not,
		'data'=>date("Y-m-d"),
		'hora'=>date("h:i:s"),
		'id_usuario'=>$session_data['id'],
		'observacao'=>$observacoes,	
	);
	
	$this->notificacao_model->addObs($dadosObs);

	$dados = array(
	'id_loja'=>$id_loja,
	'id_contratante'=>$id_contratante,
	'id_esfera'=>$id_esfera,
	'nome_empresa_notificada'=>$nome_empresa_notificada,
	'data_ciencia_notificacao'=>$dataCiencia,
	'ano_competencia'=>$ano_competencia,
	'numero_processo'=>$numero_processo,
	'descricao_solicitacao'=>$descricao_solicitacao,
	'tipo_solicitacao'=>$tipo_solicitacao,
	'plano_acao'=>$plano_acao,
	'responsavel'=>$responsavel,
	'data_prazo_atendimento'=>$dataPrazo,
	'alerta_prazo_atendimento'=>$alerta_prazo_atendimento,
	'direcionado_para'=>$direcionado_para,
	'data_envio'=>$dataEnvio,
	'numero_solicitacao'=>$numero_solicitacao,
	'prioridade'=>$prioridade,
	'data_atendimento'=>$dataAtend,
	'dias_atendimento'=>$dias_atendimento,
	'nome_auditor'=>$nome_auditor,
	'contato_auditor'=>$contato_auditor,
	'risco_atuacao'=>$risco_atuacao,
	'status'=>$status,
	'data_encerr'=>$dataEncerr,
	'data_receb_term_encerr'=>$dataReceb);

	$retorno = $this->notificacao_model->atualizar($dados,$id_not);
			
	redirect('notificacao/listar', '');
		
	
	
  }	
  
  function enviar(){		

	$session_data = $_SESSION['loginTeste'];
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/notificacao/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				

	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{		
		$dadosLog = array(
		'id_contratante' => $session_data['id_contratante'],
		'tabela' => 'notificacao',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo Notificação',
		'data' => date("Y-m-d"),
		'upload' => 1
		);

		$this->log_model->log($dadosLog);

		$dados = array(
			'arquivo' => $id.'.'.$extensao
			);				

		$this->notificacao_model->atualizar($dados,$id);		
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';

	}



//redirect('/iptu/listar', 'refresh');		 

}

 function upload(){
  $session_data = $_SESSION['loginTeste'];	
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  $id = $this->input->get('id');
  $dados = $this->notificacao_model->listarNotById($id);

  $data['imovel'] = $dados;
  $data['perfil'] = $session_data['perfil'];
  if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  $this->load->view('header_pages_view',$data);
  $this->load->view('upload_notificacao', $data);
  $this->load->view('footer_pages_view');
 }
  
  function ver(){
  $session_data = $_SESSION['loginTeste'];	
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  $id = $this->input->get('id');
  $dados = $this->notificacao_model->listarNotById($id);

  $data['imovel'] = $dados;
  $data['perfil'] = $session_data['perfil'];
  if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  $this->load->view('header_pages_view',$data);
  $this->load->view('ver_notificacao', $data);
  $this->load->view('footer_pages_view');
 }
 
  function excluir(){
 
	$id = $this->input->get('id');
	$session_data = $_SESSION['loginTeste'];
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	if($podeExcluir[0]['total'] == 1){	
		$this->notificacao_model->excluirFisicamente($id);
		$_SESSION['mensagemImovel'] =  CADASTRO_INATIVO;		
	}else{
		//if($this->notificacao_model->excluir($id)) {
			//$_SESSION['mensagemLoja'] =  CADASTRO_INATIVO;
		//}else{	
			//$_SESSION['mensagemLoja'] =  ERRO;
		//}	
	}			
	redirect('/notificacao/listar', 'refresh');	
 }
 
   function buscaTodasLojasNotificacao(){	
	 $session_data = $_SESSION['loginTeste'];
	 $id = $this->input->get('id_cidade');
	 $idContratante = $session_data['id_contratante'];	
	 $retorno ='';
	 $result = $this->notificacao_model->buscaTodasLojasNotificacao($idContratante);
	 
	 $isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $imovel){ 	
		 
			$retorno .="<option value='".$imovel->id_loja."'>".$imovel->razao_social."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
 
 }
 
  function editar(){	
	$id = $this->input->get('id');
	if(!$_SESSION['loginTeste']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
	$data['estados'] = $this->loja_model->listarEstado($idContratante);	
	$data['cidades'] = $this->loja_model->listarCidade($idContratante);	
	$data['lojas'] = $this->notificacao_model->buscaTodasLojasNotificacao($idContratante);	
	$data['id_not'] = $id;
	$data['perfil'] = $session_data['perfil'];
	$data['esferas'] = $this->notificacao_model->listarEsfera();
	$data['alertas'] = $this->notificacao_model->listarAlerta();
	$data['prioridades'] = $this->notificacao_model->listarPrioridade();
	$data['status'] = $this->notificacao_model->listarStatus();
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['obs'] = $this->notificacao_model->buscaTodasObservacoes($id);	
	
	$result = $this->notificacao_model->listarNotById($id);
	
	$data['dados'] = $result;
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_notificacao_view', $data);
	$this->load->view('footer_pages_view');
	
	
 
 }
 
 function buscaNotificacao(){	
	$id = $this->input->get('id');
	$op = $this->input->get('op');
	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];	
	
	$retorno ='';
	$result = $this->notificacao_model->listarTodasNotificacao($idContratante,$id,$op);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{	
		$retorno .="<option value=0>Escolha</option>";
		foreach($result as $key => $imovel){ 			 
			$retorno .="<option value='".$imovel->id."'>".$imovel->razao_social."</option>";		 
		}	
	}	
	echo json_encode($retorno);		
 }
 
 function buscaCidade(){	
	$estado = $this->input->get('estado');
	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];	
	
	$retorno ='';
	$result = $this->notificacao_model->buscaCidade($idContratante,$estado);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->cidade."'>".$imovel->cidade."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
function listar(){	
 
	if(!$_SESSION['loginTeste']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['loginTeste'];
	
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
	$idContratante = $session_data['id_contratante'];
	
	$data['estados'] = $this->notificacao_model->buscaEstado($idContratante,0);
	$cidade = '0';
	$estado = '0';	
	$data['cidades'] = $this->notificacao_model->buscaCidade($idContratante,0);
	
	$data['notificacoes'] = $this->notificacao_model->listarTodasNotificacao($idContratante,0,0);
	
	if(empty($_POST)){		
		$data['cidadeBD'] = 0;	
		$data['estadoBD'] = 0;	
		$data['idLojaBD'] = 0;	
		$result = $this->notificacao_model->listarTodos($idContratante,$cidade,$estado);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $municipioListar;	
		$data['estadoBD'] = $estadoListar ;	
		$data['idLojaBD'] = $idImovelListar;	
		
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				//print'aqui';exit;
				$result = $this->notificacao_model->listarTodasNotificacaoByEstadoCidade($idContratante,$municipioListar,1);
			}else if($estadoListar <> '0'){
				//print'aqui1';exit;
				$result = $this->notificacao_model->listarTodasNotificacaoByEstadoCidade($idContratante,$estadoListar,2);
			}else{
				//print'aqui2';exit;
				$result = $this->notificacao_model->listarTodasNotificacaoByEstadoCidade($idContratante,$idImovelListar,3);
				//print_r($this->db->last_query());exit;
			}
		}else{	
			$result = $this->notificacao_model->listarTodasNotificacaoByEstadoCidade($idContratante,$idImovelListar,3);
		}
	   
		
	}	
	
	
	if(empty($_SESSION["mensagemLoja"])){
		$data['mensagemLoja'] = '';
	}else{
		$data['mensagemLoja'] = $_SESSION['mensagemLoja'];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['dados'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_notificacao_view', $data);
	$this->load->view('footer_pages_view');
	
 
 }
 
 	
}
 
?>