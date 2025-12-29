<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
class Usuarios extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('log_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
    $this->load->model('user','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->library('Auxiliador');
   $this->load->helper('url');   $this->db->cache_on();
     session_start();
   
  
 }
 
 function index()
 {
   if($this->session->userdata('logged_in'))
   {
	
     $session_data = $this->session->userdata('logged_in');
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	 $this->load->view('header_view',$data);
     $this->load->view('usuario_login_view', $data);
	 $this->load->view('footer_view');
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }
 
  function listar(){	
	if(empty($_SESSION['loginTeste'])){
		redirect('login', 'refresh');
	}
	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$data['usuarios'] = $this->user->listarUsuarios($idContratante,0);
	$data['perfil'] = $session_data['perfil'];
	$data['perfil_usu'] = $session_data['adm'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_usuarios_view', $data);
	$this->load->view('footer_pages_view');
 
 }
 
 function cadastrar(){
	if(empty($_SESSION['loginTeste'])){
		redirect('login', 'refresh');
	}
		 	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$data['perfil'] = $session_data['perfil'];
	$data['perfil_usu'] = $session_data['adm'];
	$data['perfil_usuario'] = $this->user->listarPerfilUsuario();
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_usuarios_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function editar(){
	if(empty($_SESSION['loginTeste'])){
		redirect('login', 'refresh');
	}
		 	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];	
	$data['perfil'] = $session_data['perfil'];
	$data['perfil_usu'] = $session_data['adm'];	
	$data['perfil_usuario'] = $this->user->listarPerfilUsuario();
	
	$id = $this->input->get('id');
	$data['usuarios'] = $this->user->listarUsuarios($idContratante,$id);
	$retorno = $this->auxiliador->verificaID($id);

	if($retorno){
		redirect('usuarios/listar', 'refresh');
	}
	if($data['usuarios'] == false or is_null($data['usuarios'])){
		redirect('usuarios/listar', 'refresh');
	}
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_usuarios_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function ativar(){
 
	$id = $this->input->get('id');
	
	if($this->user->ativar($id)) {
		$data['mensagem'] = 'Usu�rio foi ativado';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}
	
	redirect('/usuarios/listar', 'refresh');
	
 }
 
 function excluir(){
 
	$id = $this->input->get('id');
	
	if($this->user->excluir($id)) {
		$data['mensagem'] = 'Usu�rio foi inativado';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}
	redirect('/usuarios/listar', 'refresh');
	
 }
  function resetar(){
	if(empty($_SESSION['loginTeste'])){
		redirect('login', 'refresh');
	}
	$id = $this->input->get('id');
	$dados = array('senha' => MD5('123456'));

	if($this->user->atualizar_usuario($dados,$id)) {		
		$data['mensagem'] = 'Cadastro Atualizado com Sucesso';
	}else{	
		$data['mensagem'] = 'Algum Erro Aconteceu';
	}	
	redirect('/usuarios/listar', 'refresh');
	
  }	
 function inserir(){
	if(empty($_SESSION['loginTeste'])){
		redirect('login', 'refresh');
	}
		 	
	$session_data = $_SESSION['loginTeste'];
	$idContratante = $session_data['id_contratante'];
	$data['perfil'] = $session_data['perfil'];
	$data['visitante'] = $session_data['adm'];
	
	
	$nome = $this->input->post('nome');	
	$email = $this->input->post('email');	
	$tipoPerfil = $this->input->post('tipoPerfil');	
	$tel = $this->input->post('tel');	
	$cel = $this->input->post('cel');	
	$whats = $this->input->post('whats');	
	
	$op = $this->input->post('op');	
	$id = $this->input->post('id');	
	
	
	if($op == 1){
		$dados = array('id_contratante' => $idContratante,
					'nome_usuario' => $nome,
					'email' => $email,
					'perfil' => $tipoPerfil,
					'telefone' => $tel,
					'celular' => $cel,
					'telefone' => $tel,
					'whatsapp' => $whats,
					
		);
	
		if($this->user->atualizar_usuario($dados,$id)) {		
			$data['mensagem'] = 'Cadastro Atualizado com Sucesso';
		}else{	
			$data['mensagem'] = 'Algum Erro Aconteceu';
		}	
	}else{
		$dados = array('id_contratante' => $idContratante,
					'nome_usuario' => $nome,
					'email' => $email,
					'perfil' => $tipoPerfil,
					'telefone' => $tel,
					'celular' => $cel,
					'telefone' => $tel,
					'whatsapp' => $whats,
					'status' => 0,
					'senha' => MD5('123456'),
					
	);
		$id = $this->user->add($dados);
		if($id) {		
			
			$dadosUsu = array(
				'id_usuario'  => $id,		
				'id_contratante' => $idContratante,					
			);
			$this->user->add_usu_contratante($dadosUsu,$id);
			$data['mensagem'] = 'Cadastro Realizado com Sucesso';
		}else{	
			$data['mensagem'] = 'Algum Erro Aconteceu';
		}
	}
	
	
	redirect('/usuarios/listar', 'refresh');
				
 }
 
 function atualizar_emitente(){
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $session_data['id_contratante'];
	$idUsuario = $session_data['id'];
	
	$id = $this->input->post('id');
	$razaoSocial = $this->input->post('razaoSocial');	
	$nomeFantasia = $this->input->post('nomeFantasia');	
	$tipoPessoa = $this->input->post('tipoPessoa');	
	$tipoEmitente = $this->input->post('tipoEmitente');	
	if($tipoPessoa == 1){
		$cpfCnpj = $this->input->post('cpf');	
	}else{
		$cpfCnpj = $this->input->post('cnpj');	
	}	
	$tipoEmitente = $this->input->post('tipoEmitente');	
	$tel = $this->input->post('tel');	
	$cel = $this->input->post('cel');	
	$nomeResp = $this->input->post('nomeResp');	
	$emailResp = $this->input->post('emailResp');	
	
	$dados = array('id_contratante' => $idContratante,
					'razao_social' => $razaoSocial,
					'nome_fantasia' => $nomeFantasia,
					'tipo_pessoa' => $tipoPessoa,
					'tipo_emitente' => $tipoEmitente,
					'cpf_cnpj' => $cpfCnpj,
					'telefone' => $tel,
					'celular' => $cel,
					'nome_resp' => $nomeResp,
					'email_resp' => $emailResp,
					'ativo' => 1
	);
	
	$dadosAlterados = '';
	$dadosAtuais = $this->emitente_model->listarEmitenteById($idContratante,$id);
	$tipos = $this->emitente_model->listarTipoEmitenteById($dadosAtuais[0]->tipo_emitente);
	
	
	
	if($dadosAtuais[0]->razao_social <> $razaoSocial){
		$dadosAlterados .= ' - Nome Fantasia: '.$dadosAtuais[0]->razao_social;
	}
	if($dadosAtuais[0]->nome_fantasia <> $nomeFantasia){
		$dadosAlterados .= ' - Nome Fantasia: '.$dadosAtuais[0]->nome_fantasia;
	}
	if($dadosAtuais[0]->tipo_pessoa <> $tipoPessoa){
		if($tipoPessoa == 1){
			$dadosAlterados .= ' - Tipo de Pessoa: Juridica';
		}else{
			$dadosAlterados .= ' - Tipo de Pessoa: Fisica';
		}
	}
	if($dadosAtuais[0]->tipo_emitente <> $tipoEmitente){
		$dadosAlterados .= ' - Tipo de Emitente: '.$tipos[0]->descricao;
	}
	if($dadosAtuais[0]->cpf_cnpj <> $cpfCnpj){
		$dadosAlterados .= ' - CPF/CNPJ: '.$dadosAtuais[0]->cpf_cnpj;
	}
	if($dadosAtuais[0]->telefone <> $tel){
		$dadosAlterados .= ' - Telefone: '.$dadosAtuais[0]->telefone;
	}
	if($dadosAtuais[0]->celular <> $cel){
		$dadosAlterados .= ' - Celular: '.$dadosAtuais[0]->celular;
	}
	if($dadosAtuais[0]->nome_resp <> $nomeResp){
		$dadosAlterados .= ' - Nome Respons�vel: '.$dadosAtuais[0]->nome_resp;
	}
	if($dadosAtuais[0]->email_resp <> $emailResp){
		$dadosAlterados .= ' - Email Respons�vel: '.$dadosAtuais[0]->email_resp;
	}
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'emitente',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => utf8_encode($dadosAlterados),
	'data' => date("Y-m-d h:s"),
	);
	
	$this->log_model->log($dadosLog);
					
	
	if($this->emitente_model->atualizar($dados,$id)) {
		//$data['mensagem'] = 'Cadastro Atualizado com Sucesso';
		redirect('/emitente/listar', 'refresh');
	}else{	
		//$data['mensagem'] = 'Algum Erro Aconteceu';
		echo "<script>alert('Algum Erro Aconteceu'); window.history.go(-1);</script>";
	}
	
	
				
 }
 
 
 function buscaEmitenteById(){	
	$id = $this->input->get('id');
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $session_data['id_contratante'];
	
	$result = $this->emitente_model->listarUmEmitente($idContratante,$id);
	$retorno = '';
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> N�o H� Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
		foreach($result as $key => $iptu){ 	
		 
		if($iptu->ativo == 1){
			$status ='Sim';
			$cor = '#009900';
		 }else{
			$status ='N&atilde;o';
			$cor = '#CC0000';
		 }
		$corCelula = $iptu->cor;
		$base = $this->config->base_url().'index.php';	
		$retorno .="<tr >";
		$retorno .="<td width='30%'><a href='#'>".$iptu->razao_social."</a></td>";
		$retorno .="<td width='25%'>$iptu->nome_fantasia</td>";
		$retorno .="<td width='20%'> <span style='font-weight:bold' class='label label-$iptu->cor label-mini'>$iptu->descricao</span></td>";
		
		$retorno .="<td width='10%'>".$status."</td>";
		
		$retorno .="<td width='15%'><a href='$base/emitente/ativar?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
		$retorno .="<a href='$base/emitente/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/emitente/excluir?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
		
		$retorno .="</td>";
		$retorno .="</tr>";
		
		
		 
		}
	
	}
	echo json_encode($retorno);
	
	
 
 }
 function export(){	
		
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $session_data['id_contratante'];
					
	$result = $this->emitente_model->listarEmitenteCsv($idContratante);
	
	$file="emitente.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>Raz�o Social</td>
		<td>Nome Fantasia</td>
		<td>Tipo de Emitente</td>
		<td>Tipo</td>
		<td>Documento</td>
		<td>Telefone</td>
		<td>Celular</td>
		<td>Respons�vel</td>
		<td>Email Respons�vel</td>
		<td>Ativo</td>
		<td>Alterado Por </td>
		<td>Data Altera&ccedil;&atilde;o </td>
		<td>Dados Alterados </td>		
		</tr>
		";
		
 
		  foreach($result as $key => $emitente){ 
			//$dadosLog = $this->emitente_model->listarLog($emitente->id);
			$dadosLog = $this->log_model->listarLog($emitente->id,'emitente');				
		    $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			if($emitente->tipo_pessoa == 1){
				$tipoPessoa='Pessoa F�sica';
			}else{
				$tipoPessoa='Pessoa Jur�dica';
			}
			if($emitente->ativo == 1){
				$ativo='Ativo';
			}else{
				$ativo='Inativo';
			}
			
			$test .= "<tr>";
			$test .= "<td>".utf8_decode($emitente->id)."</td>";
			$test .= "<td>".utf8_decode($emitente->razao_social)."</td>";
			$test .= "<td>".utf8_decode($emitente->nome_fantasia)."</td>";
			$test .= "<td>".utf8_decode($emitente->descricao)."</td>";
			$test .= "<td>".($tipoPessoa)."</td>";			
			$test .= "<td>".utf8_encode($emitente->cpf_cnpj)."</td>";

			$test .= "<td>".utf8_encode($emitente->telefone)."</td>";
			$test .= "<td>".utf8_encode($emitente->celular)."</td>";
			$test .= "<td>".utf8_decode($emitente->nome_resp)."</td>";
			$test .= "<td>".utf8_encode($emitente->email_resp)."</td>";
			$test .= "<td>".utf8_encode($ativo)."</td>";
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
		//echo $test;	exit;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
	
		
 }

 
 function contaCpf(){
	$cpf = $this->input->get('cpf');	
	$result = $this->emitente_model->verificaCPF($cpf,1);
	$total = $result[0]->total;
	if($total == 0){
		$valido = $this->validaCpf($cpf);
		echo json_encode($valido);
	}else{
		echo json_encode($total); 
	}	
 
 }
 function contaCnpj(){
	$cnpj = $this->input->get('cnpj');	
	$result = $this->emitente_model->verificaCPF($cnpj,2);
	$total = $result[0]->total;
	echo json_encode($total);
		
 
 }
 
  function contaEmail(){
	$email = $this->input->get('email');	
	$result = $this->emitente_model->verificaEmail($email);
	$total = $result[0]->total;
	echo json_encode($total);
		
 
 }
 

 
}
//session_destroy(); //we need to call PHP's session object to access it through CI
?>