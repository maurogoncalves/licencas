<?php
Class User extends CI_Model
{
 function login($email, $password,$id_contratante)
 {
   $this -> db -> select('usuarios.id, usuarios.email,usuarios.primeiro_acesso,usuarios.perfil');
   $this -> db -> from('usuarios');
   $this -> db -> join('usuario_contratante','usuario_contratante.id_usuario = usuarios.id');   
   $this -> db -> join('contratante','contratante.id = usuario_contratante.id_contratante');
   $this -> db -> where('usuarios.email', $email);
   $this -> db -> where('usuarios.senha', MD5($password));
   $this -> db -> where('contratante.id', $id_contratante);
   $this -> db -> where('usuarios.status', 0);
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
  function buscaEmailById($id)
 {
   $sql = "select email from usuarios u where u.id = ? ";

   $query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }
 }
 
 function dadosUsu($id,$id_contratante)
 {
   $this -> db -> select('usuarios.id, usuarios.email,usuarios.nome_usuario, usuarios.telefone,usuarios.celular,usuarios.whatsapp');
   $this -> db -> from('usuarios');
   $this -> db -> where('usuarios.id', ($id));
   $this -> db -> where('usuarios.id_contratante', $id_contratante);
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
   function atualizar_usuario($dados,$id){
 
	$this->db->where('id', $id);
	$this->db->update('usuarios', $dados); 
	
	return true;
  
 } 
 
 function dadosUsuarios()
 {
	 
	$sql = "select usuarios.id, usuarios.email,usuarios.nome_usuario, usuarios.telefone,usuarios.celular,usuarios.whatsapp from usuarios   ";
   $query = $this->db->query($sql, array());

   $array = $query->result_array(); 
   return($array);
   
   
 }
 
 
 function perfil_excluir($id_usuario){
   $sql = "select count(*) as total from usuario_perfil  left join usuarios on usuario_perfil.id_usuario = usuarios.id where id_perfil = 1 and usuarios.id = ?";
   $query = $this->db->query($sql, array($id_usuario));

   $array = $query->result_array(); 
   return($array);
   
 }
 
  function perfil($id_usuario,$tipo){
   $sql = "SELECT  distinct modulos.pagina,modulos.nome,modulos.controller,modulos.pai,modulos.id_modulo,modulos.pai,modulos.icone,
			(select count(*) from modulos m where m.id_modulo in (select pai from modulos mm where mm.pai = m.id_modulo ) and m.id_modulo = modulos.id_modulo ) as tem_filho
			from usuario_perfil  left join modulo_perfil  on usuario_perfil.id_perfil = modulo_perfil.id_perfil
			left join modulos on modulos.id_modulo = modulo_perfil.id_modulo WHERE `id_usuario` = ? and modulos.tipo = ? and modulos.status = 1
			";
   $query = $this->db->query($sql, array($id_usuario,$tipo));
   print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
   
 }
 
  function perfil_visitante($id_usuario){
   $sql = "SELECT  visitante from usuarios where id = ? ";
   $query = $this->db->query($sql, array($id_usuario));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
   
 }
 
  function uf_do_usuario($id_usuario){
   $sql = "select GROUP_CONCAT(uf ORDER BY uf ASC SEPARATOR ',') as ufs from cepbr_estado
			join usuario_uf on usuario_uf.id_uf = cepbr_estado.id_uf
			left join usuarios on usuarios.id = usuario_uf.id_usuario
			where usuarios.id = ?";
   $query = $this->db->query($sql, array($id_usuario));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   
 }
 
  function perfil_grafico($id_usuario){
   $sql = "SELECT  GROUP_CONCAT(distinct perfil.id ORDER BY perfil.id ASC SEPARATOR ',') as perfil
			from usuario_perfil  left join modulo_perfil  on usuario_perfil.id_perfil = modulo_perfil.id_perfil
			left join modulos on modulos.id_modulo = modulo_perfil.id_modulo 
			left join perfil on perfil.id = usuario_perfil.id_perfil
			WHERE `id_usuario` = ?
			order by usuario_perfil.id_perfil";
   $query = $this->db->query($sql, array($id_usuario));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   
 }
 
 function atualizar($senha,$id){
 
	$dados = array('senha' => $senha);
	
	$this->db->where('id', $id);

	$this->db->update('usuarios', $dados); 

	//print_r($this->db->last_query());exit;

	return true;
 
 }
 
 
  function atualizar_dados_usuario($dados,$id){
 

	$this->db->where('id', $id);

	$this->db->update('usuarios', $dados); 

	//print_r($this->db->last_query());exit;

	return true;
 
 }
 
  function excluir($id){
 
	$data = array('status' => 1);

	$this->db->where('id', $id);
	$this->db->update('usuarios', $data); 
	
	return true;
  
 } 
 
  function ativar($id){
 
	$data = array('status' => 0);

	$this->db->where('id', $id);
	$this->db->update('usuarios', $data); 
	
	return true;
  
 } 
 
 
 function excluirFisicamente($id,$tabela){
	$this->db->where('id', $id);
	$this->db->delete($tabela); 
	return true;
 } 

 function update_user_online($dados,$id,$acao){
	if($acao == 1){
		$this->db->where('id', $id);
		$this->db->update('usuarios_on_line', $dados); 
		return true;
	}else{
		if($this->db->insert('usuarios_on_line', $dados)) {			
			$id = $this->db->insert_id();
			return true;
		}
		return false;
	} 
 }
 
  function online(){
   $sql = "SELECT u.email,DATE_FORMAT(uu.`data`, '%d-%m-%Y %H:%i') as data,ip  from usuarios_on_line uu left join usuarios u on u.id = uu.id_usuario";
   $query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   
 }
 
  
 function delete_user_online($agora,$limite){
	$sql = "delete from   usuarios_on_line  where data between ? and ?  ";
    $query = $this->db->query($sql, array($limite,$agora));
   
	//print_r($this->db->last_query());exit;
	return true;
 } 
 
 function verify_user_online($id_usuario){
   $sql = "SELECT  id_usuario from usuarios_on_line where id_usuario = ? ";
   $query = $this->db->query($sql, array($id_usuario));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
   
 }
 
   function listarUsuarios($id_contratante,$id){
   //$this->db->limit( $_limit, $_start ); 	
   $this -> db -> select('u.id,u.email,u.nome_usuario,u.perfil,u.telefone,u.celular,u.whatsapp,u.status');
   $this -> db -> from('usuarios u');
   $this -> db -> where('id_contratante', $id_contratante);
   if($id <> 0){
	  $this -> db -> where('id', $id); 
   }
   $this -> db -> order_by('u.nome_usuario');
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
   
   }
   
    public function add($detalhes = array()){
	if($this->db->insert('usuarios', $detalhes)) {		
		return $id = $this->db->insert_id();
	}	
	return false;
	}
	
	public function add_usu_contratante($detalhes = array()){
	if($this->db->insert('usuario_contratante', $detalhes)) {		
		return $id = $this->db->insert_id();
	}	
	return false;
	}
	

    function listarPerfilUsuario(){
   $this -> db -> select('u.id,u.nome_perfil');
   $this -> db -> from('perfil_usuario u');
   $this -> db -> order_by('u.nome_perfil');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
   
 }
 
}
?>