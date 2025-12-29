<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Cnd_mob extends CI_Controller {


 


 function __construct(){
	parent::__construct();
	$this->load->model('log_model','',TRUE);
	$this->load->model('cnd_mobiliaria_model','',TRUE);	
	$this->load->model('cnd_mobiliaria_model','',TRUE);
    $this->load->model('emitente_imovel_model','',TRUE);
    $this->load->model('tipo_emitente_model','',TRUE);
    $this->load->model('situacao_imovel_model','',TRUE);
    $this->load->model('informacoes_inclusas_iptu_model','',TRUE);
    $this->load->model('user','',TRUE);
    $this->load->model('contratante','',TRUE);
    $this->load->model('emitente_model','',TRUE);
    $this->load->model('imovel_model','',TRUE);
    $this->load->model('iptu_model','',TRUE);
    $this->load->library('Cep');
    $this->load->library('session');   
    $this->load->library('form_validation');
    $this->load->helper('url');
	
	session_start();

 }


 


 function index(){


   if($_SESSION['loginTeste']){

     $session_data = $_SESSION['loginTeste'];

     $data['email'] = $session_data['email'];


	 $data['empresa'] = $session_data['empresa'];


	 $data['perfil'] = $session_data['perfil'];


     $this->load->view('home_view', $data);


   }else{


     //If no session, redirect to login page


     redirect('login', 'refresh');


   }


 }


 function dados_agrupados(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  
	$cidade = '0';
	$estado = '0';
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
				
	$data['perfil'] = $session_data['perfil'];

	      

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['loginTeste'];
	$ano = date('Y');
	
	$regionais = $this->cnd_mobiliaria_model->regionais();
	$regionalSim = array();
	$regionalNao = array();
	$regionalPend = array();
	$regionalTodos = array();
	$regionalNC = array();
	
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_mobiliaria_model->contaCndRegional($idContratante,$ano,1,$reg->id);
		$regionalSim[$i]['regional'] = $reg->descricao;
		$regionalSim[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_mobiliaria_model->contaCndRegional($idContratante,$ano,2,$reg->id);
		$regionalNao[$i]['regional'] = $reg->descricao;
		$regionalNao[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_mobiliaria_model->contaCndRegional($idContratante,$ano,3,$reg->id);
		$regionalPend[$i]['regional'] = $reg->descricao;
		$regionalPend[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_mobiliaria_model->contaCndRegional($idContratante,$ano,4,$reg->id);
		$regionalNC[$i]['regional'] = $reg->descricao;
		$regionalNC[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	//seleciona todos
	foreach($regionais as $reg){
		$result = $this->cnd_mobiliaria_model->contaCndRegional($idContratante,$ano,0,$reg->id);
		$regionalTodos[$i]['regional'] = $reg->descricao;
		$regionalTodos[$i]['total'] = $result[0]->total;
		$i++;
	}

	//print_r($regionalNC);exit;
	$data['regionalSim'] = $regionalSim ;
	$data['regionalNao'] = $regionalNao;
	$data['regionalPend'] = $regionalPend;
	$data['regionalNC'] = $regionalNC;
	$data['regionalTodos'] = $regionalTodos;
	
	$data['modulo'] = 'cnd_mob';
	$data['nome_modulo'] = 'CND Mobiliária';
	$data['iptus'] = $this->cnd_mobiliaria_model->contaCnd($idContratante,$ano);

	
	$data['perfil'] = $session_data['perfil'];
	
	$_SESSION["idCNDMBD"]='0';
  	$_SESSION["cidadeCNDMBD"] = 0;
	$_SESSION["estadoCNDMBD"] = 0;
	$_SESSION["modulo"] ='';
	
	
	
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('dados_agrupados_cnd_mob_view', $data);

	$this->load->view('footer_pages_view');
	


 }


 function cadastrar(){
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }



	$session_data = $_SESSION['loginTeste'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$idContratante = $session_data['id_contratante'];
	
	$id_loja = $this->input->get('id');

	$data['emitente'] = $this->cnd_mobiliaria_model->listarEmitenteById($id_loja);
	
	//$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();
		
 	$data['perfil'] = $session_data['perfil'];


	$this->load->view('header_pages_view',$data);


    $this->load->view('cadastrar_cnd_mob_view', $data);


	$this->load->view('footer_pages_view');


 }
 
 function enviar(){		
	$session_data = $_SESSION['loginTeste'];
	
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnds_mob/';		
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
		'tabela' => 'cnd_mob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Mobiliária',
		'data' => date("Y-m-d"),
		'upload' => 1
		);
		$this->log_model->log($dadosLog);
		
		$dados = array('arquivo_cnd' => $id.'.'.$extensao);							
		$this->cnd_mobiliaria_model->atualizar($dados,$id);		
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

 
 function enviarOld(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnds_mob/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		$this->load->library('upload', $config);
		
		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$mensagem = $this->upload->display_errors();
			$this->session->set_flashdata('mensagem',$mensagem);

		}else{
			$dados = array('arquivo_cnd' => $id.'.'.$extensao);
				
			$this->cnd_mobiliaria_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$this->session->set_flashdata('mensagem','Upload Feito com Sucesso');	
		}		
		
			
		$dadosImovel = $this->cnd_mobiliaria_model->listarCidadeEstadoById($id);
		$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
		$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
		$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;

		$modulo = $_SESSION["CNDMob"];
	
		redirect('/cnd_mob/'.$modulo, 'refresh');		
 }
 
 function enviar_pend(){		
	$session_data = $_SESSION['loginTeste'];
	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/cnd_pend/';		
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
		'tabela' => 'cnd_mob',
		'id_usuario' => $session_data['id'],
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => 'Upload de Arquivo CND Mobiliária - Pendência',
		'data' => date("Y-m-d"),
		'upload' => 1
		);
		$this->log_model->log($dadosLog);
	
		
		$dados = array(
			'arquivo_pendencias' => $id.'.'.$extensao
			);	
			
		$this->cnd_mobiliaria_model->atualizar($dados,$id);		
		$data = array('upload_data' => $this->upload->data($field_name));		
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 

 function enviar_pend_old(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnd_pend/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		$config['overwrite'] = 'true';	
		$this->load->library('upload', $config);

		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			$mensagem = $this->upload->display_errors();
			$this->session->set_flashdata('mensagem',$mensagem);
			
		}else{
			$data = date('Y-m-d');
			$dados = array(
			'arquivo_pendencias' => $id.'.'.$extensao
			);
			
				
			$this->cnd_mobiliaria_model->atualizar($dados,$id);
			//print_r($this->db->last_query());exit;
			$data = array('upload_data' => $this->upload->data($field_name));
			$mensagem = 'Upload Feito com Sucesso';
			
			
			
		}
		
		$dadosImovel = $this->cnd_mobiliaria_model->listarCidadeEstadoById($id);
		$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
		$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
		$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;

		$modulo = $_SESSION["CNDMob"];
		
		//print_r($this->db->last_query());exit;
		$_SESSION['msgCNDMob'] =  $mensagem;
		
		redirect('/cnd_mob/editar?id='.$id);
		

		
 }
 function upload_cnd(){
	
	
  $session_data = $_SESSION['loginTeste'];	
 
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['dataEmissao'] = $this->cnd_mobiliaria_model->listarTodasDataEmissao($id,'mob');		

  $dados = $this->cnd_mobiliaria_model->listarInscricaoById($id);
	$data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_cnd_mob', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
  function upload_pend(){
	
	
  $session_data = $_SESSION['loginTeste'];	
 
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  
  $dados = $this->cnd_mobiliaria_model->listarInscricaoById($id);
  $data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_pendencia', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 function ver(){
	
	
  $session_data = $_SESSION['loginTeste'];	
 
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->cnd_mobiliaria_model->listarInscricaoById($id);

	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('ver-cnd-mob', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 

 function cadastrar_cnd_mob(){
 
   if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }


	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	//$inscricao = $this->input->post('inscricao');	
	
	$id_loja = $this->input->post('id_loja');	
	if(empty($id_loja )){
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
		redirect('/loja/listar', 'refresh');
		exit;
	}
	
	$possui_cnd = $this->input->post('possui_cnd');		
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');	
	
	$data_vencto = $this->input->post('data_vencto');
	if(!empty($data_vencto )){
		$arrDataVencto = explode("/",$data_vencto);
		$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	}else{
		$dataVencto ='0000-00-00';
	}
	if($possui_cnd == 1){

		$_SESSION["CNDMob"] = 'listarPorTipoSim';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		
		$data_emissao = $this->input->post('data_emissao');
	
		if(!empty($data_emissao )){
			$arrDataEmissao = explode("/",$data_emissao);
			$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		}else{
			$dataEmissao ='0000-00-00';
		}
		
		
	}elseif($possui_cnd == 2){
		$_SESSION["CNDMob"] = 'listarPorTipoNao';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 1,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
			
		);
		
	}else{
		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
		$dados = array(
			'id_loja' => $id_loja,
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 1,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		
	}

	
	$id = $this->cnd_mobiliaria_model->add($dados);
	
	if($id) {
		$this->db->cache_off();
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'mob',
			'data_emissao' =>$dataEmissao,
			);
			
		$this->cnd_mobiliaria_model->addDataEmissao($dadosDataEmissao,$id,'mob');
		$_SESSION['msgCNDMob'] =  CADASTRO_FEITO;
		$this->session->set_flashdata('mensagem','Cadastro Realizado com sucesso');
		$url = 'cnd_mob/editar?id='.$id;
	}else{
		$_SESSION['msgCNDMob'] =  ERRO;	
	}


	redirect($url, 'refresh');
				


 }

  function excluir(){
	if(!$_SESSION['loginTeste']){
			redirect('login', 'refresh');
	  }

  
	$id = $this->input->get('id');

	$session_data = $_SESSION['loginTeste'];

	$idContratante = $session_data['id_contratante'];


	$dados = array('ativo' => 0);

	if($this->iptu_model->atualizar($dados,$id)) {
		$_SESSION['mensagemCNDMOB'] =  CADASTRO_INATIVO;	
	}else{	
		$_SESSION['mensagemCNDMOB'] =  ERRO;
	}
	redirect('/cnd_mob/listar', 'refresh');
				

 }
 

 function inativar(){
	if(!$_SESSION['loginTeste']){
			redirect('login', 'refresh');
	  } 
	$id = $this->input->get('id');
	$session_data = $_SESSION['loginTeste'];
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	$dadosImovel = $this->cnd_mobiliaria_model->listarCidadeEstadoById($id);
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
		
	if($podeExcluir[0]['total'] == 1){		
		$this->cnd_mobiliaria_model->excluirFisicamente($id);
		$_SESSION['mensagemImovel'] =  CADASTRO_APAGADO;		
	}else{	
		$dados = array('ativo' => 1);
		if($this->cnd_mobiliaria_model->atualizar($dados,$id)) {
			$_SESSION['mensagemCNDMOB'] =  CADASTRO_INATIVO;	
		}else{	
			$_SESSION['mensagemCNDMOB'] =  ERRO;	
		}
		
	}
	
	$modulo = $_SESSION["CNDMob"];
	
	redirect('/cnd_mob/'.$modulo, 'refresh');
 }
 
 function ativar(){
	if(!$_SESSION['loginTeste']){
			redirect('login', 'refresh');
	  }  
	$id = $this->input->get('id');

	$dados = array('ativo' => 0);

	if($this->cnd_mobiliaria_model->atualizar($dados,$id)) {
		$_SESSION['mensagemCNDMOB'] =  CADASTRO_ATIVO;	
	}else{	
		$_SESSION['mensagemCNDMOB'] = ERRO;
	}
	
	$dadosImovel = $this->cnd_mobiliaria_model->listarCidadeEstadoById($id);
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	
	$modulo = $_SESSION["CNDMob"];
	
	redirect('/cnd_mob/'.$modulo, 'refresh');

 }
 

 function atualizar_cnd(){
	if(!$_SESSION['loginTeste']){
			redirect('login', 'refresh');
	  }

	 
	  
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$idUsuario = $session_data['id'];
	$id = $this->input->post('id');
	$id_emitente = $this->input->post('id_emitente');
	$inscricao = $this->input->post('inscricao');
	$possui_cnd = $this->input->post('possui_cnd');
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);	
	$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');	
	$modulo = $_SESSION["CNDMob"];		
	if($possui_cnd == 1){
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 1,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		$_SESSION["CNDMob"] = 'listarPorTipoSim';
		
		$data_emissao = $this->input->post('data_emissao');	
		if(empty($data_emissao)){
			$this->session->set_flashdata('mensagem','Data de Emiss&atilde;o n&atilde;o pode ser vazia');
			redirect('/cnd_mob/'.$modulo);	
			exit;
		}
		$arrDataEmissao = explode("/",$data_emissao);	
		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		
		$dadosDataDb = $this->cnd_mobiliaria_model->listarDataEmissao($id,'mob');
		
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'mob',
			'data_emissao' =>$dataEmissao,
			);
        $isArray =  is_array($dadosDataDb) ? '1' : '0';
		if($isArray == 1){
		
			if($dadosDataDb[0]->data_emissao <> $dataEmissao ){
				$this->cnd_mobiliaria_model->addDataEmissao($dadosDataEmissao);
			}
			
			
		}else{
			$this->cnd_mobiliaria_model->addDataEmissao($dadosDataEmissao);
		}
		
		
	}elseif($possui_cnd == 2){
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 2,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		$_SESSION["CNDMob"] = 'listarPorTipoNao';
	}else{
		$dados = array(
			//'inscricao' => $inscricao,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano
		);
		$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
	
	}
	$dadosImovel = $this->cnd_mobiliaria_model->listarCidadeEstadoById($id);
	
	
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	
	
	
	//print_r($this->session->userdata);exit;
	$dadosAtuais = $this->cnd_mobiliaria_model->listarCNDById($id);
	
	$dadosAlterados ='';
	$arrDataAtual = explode("-",$dadosAtuais[0]->data_vencto);	
	$dataAtual = $arrDataAtual[2].'/'.$arrDataAtual[1].'/'.$arrDataAtual[0];
	$arrDataPAtual = explode("-",$dadosAtuais[0]->data_pendencias);	
	$dataPAtual = $arrDataPAtual[2].'/'.$arrDataPAtual[1].'/'.$arrDataPAtual[0];
	
	if($dadosAtuais[0]->possui_cnd <> $possui_cnd){
		if($dadosAtuais[0]->possui_cnd == 1){
			$dadosAlterados .= ' - Possui CND: Sim';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;			
			}
		}else if($dadosAtuais[0]->possui_cnd == 2){
			$dadosAlterados .= ' - Possui CND: Não';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;			
			}			
		}
		else{
			$dadosAlterados .= ' - Possui CND: Pendência';		
			if($dadosAtuais[0]->data_pendencias <> $dataVencto){
				$dadosAlterados .= ' - Data Pendência: '.$dataPAtual;			
			}

		}
	}
	
	if($dadosAtuais[0]->observacoes <> $observacoes){

		$dadosAlterados .= ' - Observações: '.$dadosAtuais[0]->observacoes;	
	}
	

	if(!empty($dadosAlterados)){
		$dadosLog = array(
		'id_contratante' => $idContratante,
		'tabela' => 'cnd_mob',
		'id_usuario' => $idUsuario,
		'id_operacao' => $id,
		'tipo' => 2,
		'texto' => $dadosAlterados,
		'data' => date("Y-m-d"),
		);
		$this->log_model->log($dadosLog);
	}
	
	
	
	
	
	if($this->cnd_mobiliaria_model->atualizar($dados,$id)){		
		$this->cnd_mobiliaria_model->atualizar_loja($inscricao,$id_emitente);
	}	
	//print_r($this->db->last_query());exit;
	$_SESSION['msgCNDMob'] =  CADASTRO_ATUALIZADO;
	
	redirect('/cnd_mob/editar?id='.$id);

 }


 

  function editar(){	
    
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
   $session_data = $_SESSION['loginTeste'];
	$id = $this->input->get('id');
	$idContratante = $session_data['id_contratante'];
	
  $dados = $this->cnd_mobiliaria_model->listarInscricaoByLoja($id);
	$data['imovel'] = $dados;
	if($dados[0]->possui_cnd == 1){
		$data['modulo'] = 'listarPorTipoSim';
	}else if($dados[0]->possui_cnd == 2){
		$data['modulo'] = 'listarPorTipoNao';
	}else{
		$data['modulo'] = 'listarPorTipoPendencia';
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$dadosImovel = $this->cnd_mobiliaria_model->listarCidadeEstadoById($id);
	$dadosDataDb = $this->cnd_mobiliaria_model->listarDataEmissao($id,'mob');
	$data['data_emissao'] = $dadosDataDb;
	$_SESSION["idCNDMBD"]= $dadosImovel[0]->id;
  	$_SESSION["cidadeCNDMBD"] = $dadosImovel[0]->cidade;
	$_SESSION["estadoCNDMBD"] = $dadosImovel[0]->estado;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_cnd_mob_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function csvGrafico($result){
	 
	 $file="cnd_mob.xls";

	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{	
			
			$test="<table border=1>
			<tr>
			<td>Nome Fantasia</td>
			<td>CPF/CNPJ</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Regional</td>
			<td>Bandeira</td>
			<td>Cidade</td>
			<td>Estado</td>			
			<td>Possui CND</td>
			<td>Data Vencto/Pend </td>
			</tr>
			";
			
			
	 
			foreach($result as $key => $iptu){ 	
			 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');				
			 $isArrayLog =  is_array($dadosLog) ? '1' : '0';

			$datasEmissao = $this->cnd_mobiliaria_model->listarTodasDataEmissao($iptu->id_cnd,'mob');
			$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 
			  
				if($iptu->status_cnd == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					$data = 'Vencimento';
				}else{
					$possui_cnd ='Não';
					$data = 'Pend&ecirc;ncia';
				}
				
				if($iptu->possui_cnd == 1){
					$cnd ='Sim';
					$corCnd = '#000099';	
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_pendencias);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}
				
				$arrDataVencto = explode("-",$iptu->data_vencto);
				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";
				
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				
				$test .= "<td>".utf8_decode($cnd)."</td>";
				$test .= "<td>".$dataV."</td>";					
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
 }
 
 function csv($result){
	 
	 $file="cnd_mob.xls";

	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{	
			
			$test="<table border=1>
			<tr>
			<td>Id</td>
			<td>Raz&atilde;o Social</td>
			<td>CPF/CNPJ</td>
			<td>Inscri&ccedil;&atilde;o</td>			<td>Cod. 1</td>
			<td>Cod. 2</td>
			<td>Regional</td>
			<td>Bandeira</td>
			<td>Cidade</td>
			<td>Estado</td>			
			<td>Observa&ccedil;&otilde;es</td>	
			<td>Plano de A&ccedil;&atilde;o</td>	
			<td>Status CND</td>
			<td>Possui CND</td>
			<td>Data Vencto/Pend </td>
			<td>Data de Emiss&atilde;o </td>	
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>				
			
			</tr>
			";
			
			
	 
			foreach($result as $key => $iptu){ 	
			 $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_mob');				
			 $isArrayLog =  is_array($dadosLog) ? '1' : '0';

			$datasEmissao = $this->cnd_mobiliaria_model->listarTodasDataEmissao($iptu->id_cnd,'mob');
			$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';				 
			  
				if($iptu->status_cnd == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					$data = 'Vencimento';
				}else{
					$possui_cnd ='Não';
					$data = 'Pend&ecirc;ncia';
				}
				
				if($iptu->possui_cnd == 1){
					$cnd ='Sim';
					$corCnd = '#000099';	
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}elseif($iptu->possui_cnd == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
					$dataVArr = explode("-",$iptu->data_pendencias);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}
				
				$arrDataVencto = explode("-",$iptu->data_vencto);
				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->ins_cnd_mob)."'"."</td>";
								$test .= "<td>".utf8_decode($iptu->cod1)."</td>";
				$test .= "<td>".utf8_decode($iptu->cod2)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";
				$test .= "<td>".utf8_decode($iptu->plano)."</td>";
				$test .= "<td>".utf8_encode($ativo)."</td>";
				
				$test .= "<td>".utf8_decode($cnd)."</td>";
				$test .= "<td>".$dataV."</td>";
				if($isdatasEmissao <> 0){
					$test .="<td>";					
					foreach($datasEmissao as $dataE){ 					
						$test .= $dataE->data_emissao.' ';					
					}	
					$test .="</td>";				
				}else{
					$test .="<td>";
					$test .="</td>";						
				}
				if($isArrayLog <> 0){
					 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
					 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
					 $test .="<td>".$dadosLog[0]->email."</td>";
					 $test .="<td>".$dataFormatada."</td>";
					 $test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
				}else{
					$test .="<td></td>";
					$test .="<td></td>";
					$test .="<td></td>";
				}		
				$test .= "</tr>";
			
				
			}
			$test .='</table>';
		}
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
 }

 
function export_mun(){	  
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
	$id = $this->input->post('id_mun_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];	
	$result = $this->cnd_mobiliaria_model->listarIptuCsvByCidade($id,$tipo);
	$this->csv($result);		
 }
 
 function export_est(){	  
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
	$id = $this->input->post('id_estado_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$result = $this->cnd_mobiliaria_model->listarIptuCsvByEstado($id,$tipo);
	$this->csv($result);
 }
 

  function export(){	
  
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_imovel_export');
	$tipo = $this->input->post('possuiCnd');
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	

	if($id == 0){
	
		$result = $this->cnd_mobiliaria_model->listarIptuCsv($idContratante,$tipo);
	}else{

		$result = $this->cnd_mobiliaria_model->listarIptuCsvById($id,$tipo);
	}
	
	$this->csv($result);
	
		
 }
 
 function export_total_mob(){	
  
  if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_imovel_export');
	$tipo = 'X';
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	

	$result = $this->cnd_mobiliaria_model->listarIptuCsv($idContratante,$tipo);
	$this->csvGrafico($result);
	
		
 }
 
 function buscaCidade(){	
 
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	
	$id = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarCidadeByEstado($idContratante,$id,$tipo);
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaTodasCidades(){	
	$cidadeFiltro = $this->input->get('cidadeFiltro');
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarCidade($idContratante,$tipo);
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
			if($iptu->cidade == $cidadeFiltro){
				$retorno .="<option value='".$iptu->cidade."' selected>".$iptu->cidade."</option>";
			}else{
				$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
			}
		 
		}
		
	
	}
	echo json_encode($retorno);
	
 }
 function buscaInscricaoByEstado(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarImovelByEstado($id,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 function buscaLojaByCidadeEstado(){		$id = $this->input->get('id');		$uf = $this->input->get('uf');	$tipo = $this->input->get('tipo');		$retorno ='';	$result = $this->cnd_mobiliaria_model->listarImovelByCidadeEstado($id,$tipo,$uf);		if($result == 0){		$retorno .="<option value='0'>Não Há Dados</option>";	}else{			$retorno .="<option value=0>Escolha um Imóvel</option>";		foreach($result as $key => $iptu){ 			 			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";		 		}		}	echo json_encode($retorno);	 } 
 function buscaLoja(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarImovelByCidade($id,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function busca(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarLojaByImovel($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }


	 if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
	 
	 
								
	 $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaPendentes(){	
	//$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarImovelPendente();
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	 if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
								 
	//$arrDataVencto = explode("-",$iptu->data_vencto);
	//$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];

								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  if($iptu->loja_acomp){
		$retorno .="<td width='14%'><a href='$base/acomp_cnd/painel?id=$iptu->loja_acomp'>".$iptu->cpf_cnpj."</a></td>";
	  }else{
		$retorno .="<td width='14%'><a style='color:#000' href='$base/loja/acomp?id=$iptu->id_loja'>".$iptu->cpf_cnpj."</a></td>";
	  }
	  
	  
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
  function buscaEstado(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarImovelByUf($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	 if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
								 
	//$arrDataVencto = explode("-",$iptu->data_vencto);
	//$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];

								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaMunicipio(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	
	$retorno ='';
	$result = $this->cnd_mobiliaria_model->listarImovelByMunicipio($id,$tipo);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_insc == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	 if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	 }
	 

								
      $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
	  $retorno .="<td width='18%'><a href='#'>".$iptu->nome."</a></td>";
	  $retorno .="<td width='14%'>".$iptu->cpf_cnpj."</td>";
      $retorno .="<td width='14%' class='hidden-phone'>";
		if($iptu->ins_cnd_mob){
			$retorno .= "<a href='$base/cnd_mob/ver?id=$iptu->id_cnd'>$iptu->ins_cnd_mob</a>";
		}else{	
			$retorno .=$iptu->ins_cnd_mob;
		}		$retorno .="</td>";
		$retorno .="<td width='15%' class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%' class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='14%'>";            
		if(($iptu->possui_cnd == 3 )){	
			$retorno .="<a href='$base/cnd_mob/upload_pend?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  			
		}else{
			$retorno .="<a href='$base/cnd_mob/upload_cnd?id=$iptu->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  	
		} 		
		$retorno .="<a href='$base/cnd_mob/editar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_mob/inativar?id=$iptu->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_mob/ativar?id=$iptu->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function listarTodos(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  
	$tipo = 'X';
	$cidade = '0';
	$estado = '0';
	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['loginTeste'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		$result = $this->cnd_mobiliaria_model->listarCndTipo($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_mobiliaria_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_mobiliaria_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_mobiliaria_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}
	}

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarTodos';
	$data['CNDMob'] = 'listarTodos';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
		
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarPorTipoSim(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  
	$tipo = '1';
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['loginTeste'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){
		$result = $this->cnd_mobiliaria_model->listarCndTipo($idContratante,$tipo);
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_mobiliaria_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_mobiliaria_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_mobiliaria_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
			//print_r($this->db->last_query());exit;
		}
	}

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarPorTipoSim';
	$data['CNDMob'] = 'listarPorTipoSim';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
		

	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 
 function listarPorRegional(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
  
	$tipo  = $this->input->get('tipo');
	$regional  = $this->input->get('reg');
	
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];				
	$data['perfil'] = $session_data['perfil'];
	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante,$tipo);	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante,$tipo);	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante,$tipo);
	$session_data = $_SESSION['loginTeste'];
	
	
	$result =  $this->cnd_mobiliaria_model->listarCndTipoReg($idContratante,$regional,$tipo);

	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

	if(empty($_SESSION["cidadeCNDMBD"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeCNDMBD"];
	}
	if(empty($_SESSION["estadoCNDMBD"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION["estadoCNDMBD"];
	}
	if(empty($_SESSION["idCNDMBD"])){
		$data['idCNDMBD'] = 0;
	}else{
		$data['idCNDMBD'] = $_SESSION["idCNDMBD"];
	}
	
	$_SESSION["CNDMob"] = 'listarPorTipoSim';
	$data['CNDMob'] = 'listarPorTipoSim';
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
		
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarPorTipoPendencia(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
	$tipo = '3';
	
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante,$tipo);
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}

	$session_data = $_SESSION['loginTeste'];
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		
		$result = $this->cnd_mobiliaria_model->listarCndTipo($idContratante,$tipo);		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_mobiliaria_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_mobiliaria_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_mobiliaria_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}	   
	}
	//print'<BR>';
	//print_r($this->db->last_query());exit;
	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];
		
	
	$_SESSION["CNDMob"] = 'listarPorTipoPendencia';
	
	$data['CNDMob'] = 'listarPorTipoPendencia';
	
	
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
function listarPorTipoNao(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }
	$tipo = '2';
	$cidade = '0';
	$estado = '0';
	
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante,$tipo);
	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante,$tipo);
	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante,$tipo);
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['loginTeste'];
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['estadoBD'] = 0;	
		$data['idCNDMBD'] = 0;
		$result = $this->cnd_mobiliaria_model->listarCndTipo($idContratante,$tipo);
		
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $_POST['municipioListar'];
		$data['estadoBD'] = $_POST['estadoListar'];
		$data['idCNDMBD'] = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->cnd_mobiliaria_model->listarCndTipoMun($idContratante,$municipioListar,$tipo);
			}else{
				$result =  $this->cnd_mobiliaria_model->listarCndTipoEst($idContratante,$estadoListar,$tipo);
			}
		}else{	
			$result = $this->cnd_mobiliaria_model->listarCndTipoId($idContratante,$idImovelListar,$tipo);
		}
	   
	   	
		

	}


	$data['iptus'] = $result;
	$data['tipo'] = $tipo;

	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION["CNDMob"] = 'listarPorTipoNao';
	
	$data['CNDMob'] = 'listarPorTipoNao';
	
	if(!empty($_SESSION["mensagemCNDMOB"])){
		$data['mensagemCNDMOB'] =  $_SESSION["mensagemCNDMOB"];
	}else{
		$data['mensagemCNDMOB'] =  '';
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
  function limpar_filtro(){	
 
	$_SESSION["idCNDMBD"]=0;
  	$_SESSION["cidadeCNDMBD"] = 0;
	$_SESSION["estadoCNDMBD"] = 0;

	$modulo = $_SESSION["CNDMob"];
	redirect('/cnd_mob/'.$modulo, '');

 }
 
 function listarLoja(){	
 
	redirect('loja/listar_status?status=4', '');

 }
 
  function listar(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante,'X');
	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante,'X');
	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante,'X');
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['loginTeste'];
	
	$result = $this->cnd_mobiliaria_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	
	$total = $this->cnd_mobiliaria_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	$_SESSION["CNDMob"] = 'listar';

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->session->set_userdata('CNDMob', 'listar');
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 function listar_old(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }

	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante,'X');
	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante,'X');
	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante,'X');
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['loginTeste'];
	
	$result = $this->cnd_mobiliaria_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	
	$total = $this->cnd_mobiliaria_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	$_SESSION["CNDMob"] = 'listar';

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->session->set_userdata('CNDMob', 'listar');
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_cnd_mobiliaria_view', $data);

	$this->load->view('footer_pages_view');
	


 }

 function listarComParametro(){	
 
 if(!$_SESSION['loginTeste']){
		redirect('login', 'refresh');
  }

	$cidade  = $this->input->get('cidade');
	$estado  = $this->input->get('uf');
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['loginTeste'];
	
	$idContratante = $session_data['id_contratante'];
				
	$data['perfil'] = $session_data['perfil'];

	$data['lojas'] = $this->cnd_mobiliaria_model->listarLoja($idContratante);
	
	$data['estados'] = $this->cnd_mobiliaria_model->listarEstado($idContratante);
	
	$data['cidades'] = $this->cnd_mobiliaria_model->listarCidade($idContratante);
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['loginTeste'];
	
	$result = $this->cnd_mobiliaria_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	
	//print_r($this->db->last_query());exit;
	$total = $this->cnd_mobiliaria_model->somarTodos($idContratante,$cidade,$estado);
	$data['paginacao'] = createPaginate('cnd_mob', $total[0]->total) ;

	
	$data['iptus'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_mobiliaria_view', $data);
	$this->load->view('footer_pages_view');
	

 }
 

}
?>