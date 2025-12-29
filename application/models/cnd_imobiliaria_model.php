<?php


Class Cnd_Imobiliaria_model extends CI_Model{


	function excluirFisicamente($id){
		$this->db->where('id', $id);
		$this->db->delete('cnd_imobiliaria'); 
		return true;
	 } 
	 
	  function addObsTrat($detalhes = array()){ 
	if($this->db->insert('cnd_mob_tratativa_obs', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	return false;
 }
	 
	 function contaCndImob($id_contratante,$status){
	$sql = "SELECT count(*) as total  FROM (`cnd_imobiliaria`) 	WHERE `cnd_imobiliaria`.`id_contratante` = ? and cnd_imobiliaria.`possui_cnd` = ? ";
	$query = $this->db->query($sql, array($id_contratante,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function listarStatusInterno(){
   $this -> db -> select('*');
   $this -> db -> from('status_chamado_interno_mobiliario');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
   function contaCndImobByUf($id_contratante,$status,$estado){
	$sql = "SELECT count(*) as total FROM (`cnd_imobiliaria`) 
			left join iptu on iptu.id = cnd_imobiliaria.id_iptu
			left join imovel on iptu.id_imovel = imovel.id
			WHERE `cnd_imobiliaria`.`id_contratante` = ?  and cnd_imobiliaria.`possui_cnd` = ? and imovel.estado = ?";
	$query = $this->db->query($sql, array($id_contratante,$status,$estado));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function listarEstado($idContratante,$tipo,$situacao){
	$data = date('Y-m-d');
	$this->db->distinct();
	$this -> db -> select('estado as uf');
	$this -> db -> from('imovel'); 
	$this -> db -> join('iptu','iptu.id_imovel = imovel.id');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	$this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);
	if($tipo <> '0'){
		  $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	$this -> db -> order_by('imovel.estado');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }

  
    function listarCidade($idContratante,$tipo,$situacao){
    $data = date("Y-m-d");
	$this->db->distinct();
	$this -> db -> select('imovel.cidade');
	$this -> db -> from('imovel'); 
	$this -> db -> join('iptu','iptu.id_imovel = imovel.id');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	$this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);
	if($tipo <> '0'){
		  $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
	$this -> db -> order_by('imovel.cidade');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }

  
  function listarCndTipo($id_contratante,$cidade,$estado,$tipo ){
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   
   if($cidade){
	$this -> db -> where('imovel.cidade', $cidade);
	$this -> db -> where('imovel.estado', $estado);   
   }   
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function listarCndTipoId($id_contratante,$id,$tipo ){
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.id', $id);
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function listarCndTipoEst($id_contratante,$estado,$tipo,$situacao ){
	$data = date("Y-m-d");
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.estado', $estado);
   if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function situacao(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('tipo_situacao');  
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
  function listarCndVigente($id_contratante,$situacao ){
	  
	 $data = date("Y-m-d");
	  
	 if($situacao == 2) {
		 
		  $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
		   $this -> db -> from('cnd_imobiliaria'); 
		   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
		   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
		   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
		   $this -> db -> where('cnd_imobiliaria.possui_cnd', 1);
		   $this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		   $this -> db -> order_by('imovel.nome');
		   $query = $this -> db -> get();
   
	 }else{
		  $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
		   $this -> db -> from('cnd_imobiliaria'); 
		   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
		   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
		   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
		   $this -> db -> where('cnd_imobiliaria.possui_cnd',1);
		   $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
		   $this -> db -> order_by('imovel.nome');
		   $query = $this -> db -> get();
	 }
  
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function listarCndTipoSituacao($id_contratante,$situacao,$tipo ){
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.situacao', $situacao);
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
  
    function buscaTodasObservacoes($id,$modulo){	
	$sql = "SELECT DATE_FORMAT(data,'%d/%m/%Y') as data,hora,observacao,usuarios.email
			FROM (`cnd_mob_observacao`) 	
			left join usuarios on usuarios.id = cnd_mob_observacao.id_usuario
			WHERE `cnd_mob_observacao`.`id_cnd_mob` = ? and cnd_mob_observacao.modulo = ?
			ORDER BY `cnd_mob_observacao`.`data` ";
			
	$query = $this->db->query($sql, array($id,$modulo));
	$array = $query->result(); 
    return($array);

 }
 
   function listarCndTipoMun($id_contratante,$cidade,$tipo,$situacao ){
	$data = date("Y-m-d");
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.cidade', $cidade);
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
  function listarCnd($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){


   $this -> db ->limit( $_limit, $_start ); 	


   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');


   $this -> db -> from('cnd_imobiliaria');
   
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');


   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   
   if($cidade){
	$this -> db -> where('imovel.cidade', $cidade);
	$this -> db -> where('imovel.estado', $estado);
   
   }
   
   $this -> db -> order_by('imovel.nome');


   $query = $this -> db -> get();


   //print_r($this->db->last_query());exit;


   if($query -> num_rows() <> 0) {
     return $query->result();

   } else{

     return false;

   }


 }

 
 function listarIptuCsv($id_contratante,$possuiCnd,$situacao){
	 
	 $data =date("Y-m-d");
	
   $this -> db -> select('cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.id as id_cnd,imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.plano,cnd_imobiliaria.observacoes as obs_cnd, emitente.cpf_cnpj,imovel.cidade,imovel.estado');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left'); 
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');   
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   
   if($possuiCnd <> 'X'){
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $possuiCnd);   
	$this -> db -> order_by('iptu.id');
   }else{
	$this -> db -> order_by('cnd_imobiliaria.possui_cnd');   
   }
   
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   

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
 
  function listarIptuCsvByCidade($id_contratante,$possuiCnd,$situacao){
	  
	 $data =date("Y-m-d");  


   $this -> db -> select('cnd_imobiliaria.id as id_cnd,imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.plano,cnd_imobiliaria.plano,cnd_imobiliaria.observacoes as obs_cnd, emitente.cpf_cnpj,imovel.cidade,imovel.estado');

   $this -> db -> from('cnd_imobiliaria');

   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');

   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');
   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');
   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');
   

   $this -> db -> where('imovel.cidade', $id_contratante);
   
   if($possuiCnd <> 'X'){
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $possuiCnd); 
   }
   
   
 if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   $this -> db -> order_by('iptu.id');

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
 
 function listarIptuCsvByEstado($id_contratante,$possuiCnd,$situacao){


	 $data =date("Y-m-d");
   $this -> db -> select('cnd_imobiliaria.id as id_cnd, imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.observacoes as obs_cnd,cnd_imobiliaria.plano, emitente.cpf_cnpj,imovel.cidade,imovel.estado');

   $this -> db -> from('cnd_imobiliaria');

   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
   
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');
   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');
   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');
   
   $this -> db -> where('imovel.estado', $id_contratante);
   if($possuiCnd <> 'X'){
	   $this -> db -> where('cnd_imobiliaria.possui_cnd', $possuiCnd);
   }
   
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
   $this -> db -> order_by('cnd_imobiliaria.id');
   


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
 
 function listarTodasCidades($tipo){

   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel'); 
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');   
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   }
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarEmitentes($id_contratante){

   $this -> db -> select('emitente.id,emitente.razao_social');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');

   $this -> db -> where('id_contratante', $id_contratante);

   $this -> db -> where('tipo_emitente', 4);
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
 
 function listarCidadeByEstadoVig($id,$tipo,$situacao){
	$data = date('Y-m-d');
	
   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');   
   $this -> db -> where('imovel.estado', $id);
   
   if($tipo <> '0'){
	    $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   }
   
   if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarCidadeByEstado($id,$tipo,$situacao){
	 
   $data = date("Y-m-d");
   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');   
   $this -> db -> where('imovel.estado', $id);
   if($tipo <> '0'){
	    $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   }
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarIptuCsvById($id_imovel){
 
  $this -> db -> select('cnd_imobiliaria.id as id_cnd,imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.plano,cnd_imobiliaria.plano,cnd_imobiliaria.observacoes as obs_cnd,emitente.cpf_cnpj,imovel.cidade,imovel.estado');

   $this -> db -> from('cnd_imobiliaria');
   
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');

   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');
   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');
   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');
   
   
   $this -> db -> where('iptu.id_imovel', $id_imovel);   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 

 }

  function somarTodosTipo($idContratante,$cidade,$estado,$tipo){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> join('iptu','iptu.id = cnd_imobiliaria.id_iptu','left');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);  
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);  
   
   
   if($cidade){
		$this -> db -> where('imovel.cidade', $cidade);
		$this -> db -> where('imovel.estado', $estado);   
   }
     
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
 function somarTodos($idContratante,$cidade,$estado){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> join('iptu','iptu.id = cnd_imobiliaria.id_iptu','left');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);  
   
   if($cidade){
		$this -> db -> where('imovel.cidade', $cidade);
		$this -> db -> where('imovel.estado', $estado);   
   }
     
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }

  function status_iptu(){
   $this -> db -> select('status_iptu.id,status_iptu.descricao');
   $this -> db -> from('status_iptu');
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
 
 function listarInscricaoByIptu($id){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('iptu.id', $id);

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
 

function listarTodasInscricoes($id_contratante){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('imovel.id_contratante', $id_contratante);
   $this -> db -> order_by('iptu.inscricao');

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
 
 function listarImovelVig($id_contratante,$tipo,$situacao){
	 $data = date("Y-m-d");
   $this->db->distinct();
   $this -> db -> select('imovel.id,imovel.nome');
   $this -> db -> from('imovel');
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
  
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}	
   
   $this -> db -> order_by('imovel.id');

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
 
  function listarImovel($id_contratante,$tipo,$situacao){
   $data = date("Y-m-d");
   $this->db->distinct();
   $this -> db -> select('imovel.id,imovel.nome');
   $this -> db -> from('imovel');
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
  }		
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}	
   
   
   $this -> db -> order_by('imovel.id');

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
 
 function listarImovelByEstado($id,$tipo,$situacao){
	 $data = date("Y-m-d");
	$this -> db ->distinct();
	$this -> db -> select('imovel.id,imovel.nome');
	$this -> db -> from('imovel');
	$this -> db -> join('iptu','imovel.id = iptu.id_imovel');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	$this -> db -> where('estado', $id);
	if($tipo <> '0'){
		$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	
	 if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
	$this -> db -> order_by('imovel.id');
	$query = $this -> db -> get();
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
function listarImovelByCidade($id,$tipo,$situacao){
	$data = date("Y-m-d");
	$this->db->distinct();
	$this -> db -> select('imovel.id,imovel.nome');
	$this -> db -> from('imovel');
	$this -> db -> join('iptu','imovel.id = iptu.id_imovel');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	if($id <> '0'){
		$this -> db -> where('cidade', $id);
	}	
	if($tipo <> '0'){
		$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	 if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
	
	$this -> db -> order_by('imovel.id');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 public function addDataEmissao($detalhes = array()){

 

	if($this->db->insert('cnd_data_emissao', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
 
  public function add($detalhes = array()){

 

	if($this->db->insert('cnd_imobiliaria', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
	 function atualizar($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('cnd_imobiliaria', $dados); 

	//print_r($this->db->last_query());exit;

	return true;

  

 } 
 
  
 function listarObsTratById($id){ 
	$sql = "select DATE_FORMAT(c.data,'%d/%m/%Y') as data,c.hora,c.data_hora,u.email,u.nome_usuario,c.observacao,c.id,c.arquivo
		from cnd_mob_tratativa_obs c left join usuarios u on u.id = c.id_usuario where c.id_cnd_trat = ? order by c.id desc";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  
 public function add_tratativa($detalhes = array()){
	if($this->db->insert('cnd_mob_tratativa', $detalhes)) {			
		$id = $this->db->insert_id();
		return $id;
	}
	return false;
}
 
  function atualizar_tratativa($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_mob_tratativa', $dados); 
	return true;
 }
 
 function listarCNDById($id){
   $this -> db -> select('*');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> where('cnd_imobiliaria.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarCidadeEstadoById($id){
   $this -> db -> select('imovel.id,imovel.cidade,imovel.estado,cnd_imobiliaria.possui_cnd');
   $this -> db -> from('iptu');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
function listarInscricaoById($id){
   $this -> db -> select('iptu.inscricao,iptu.ano_ref, iptu.id as id_iptu,iptu.ano_ref,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.arquivo,cnd_imobiliaria.arquivo_pendencias,cnd_imobiliaria.data_vencto,cnd_imobiliaria.observacoes,cnd_imobiliaria.plano,cnd_imobiliaria.possui_cnd,imovel.nome as nome_im,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.data_vencto');
   $this -> db -> from('iptu');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarDataEmissao($id,$modulo){
	 
	$sql = "select data_emissao,DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br from cnd_data_emissao where id_cnd = ? and modulo =? order by data_emissao desc limit 1";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarCndTodosComFiltro($idContratante,$imovelExp,$estadoExp,$cnpjExp,$inscricaoExp,$statusExp,$data_vencto_final_exp,$data_vencto_ini_exp){
	 
	$sql = "SELECT 
	`cnd_imobiliaria`.`id` as id_cnd, `imovel`.`nome`, `iptu`.*, `iptu`.`id` as id_iptu,
	`informacoes_inclusas_iptu`.`descricao`, `status_iptu`.`descricao` as status_pref,
	`emitente`.`razao_social`, `cnd_imobiliaria`.`possui_cnd` as cnd, 
	`cnd_imobiliaria`.`data_vencto`, `cnd_imobiliaria`.`data_pendencias`, 
	`cnd_imobiliaria`.`plano`, `cnd_imobiliaria`.`observacoes` as obs_cnd, `emitente`.`cpf_cnpj`, `imovel`.`cidade`, `imovel`.`estado`,link,
	cnd_imobiliaria.possui_cnd	
	FROM (`cnd_imobiliaria`) 
	LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `iptu`.`nome_proprietario` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	LEFT JOIN `status_iptu` ON `status_iptu`.`id` = `iptu`.`status_prefeitura`
	LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `imovel`.`estado` 
	WHERE `cnd_imobiliaria`.`id_contratante` = ? ";

	if($statusExp <> '0'){
			$sql .= " and cnd_imobiliaria.possui_cnd = $statusExp " ;		
		}
		if($estadoExp <> '0'){
			$sql .=  " and imovel.estado ='$estadoExp'";
		}   
		if($imovelExp <> '0'){
			$sql .=  " and imovel.id ='$imovelExp'";
		}   
		if($cnpjExp <> '0'){
			$sql .=  " and emitente.cpf_cnpj ='$cnpjExp'";
		}   
		
		
		if($inscricaoExp <> '0'){
			$sql .=  " and iptu.inscricao = '$inscricaoExp'";
		}   
		if(!empty($data_vencto_ini_exp)){
		   $dataVenctoIniArr = explode("/",$data_vencto_ini_exp);
		   $dataVenctoIni = $dataVenctoIniArr[2].'-'.$dataVenctoIniArr[1].'-'.$dataVenctoIniArr[0];
		   $dataVenctoFinalArr = explode("/",$data_vencto_final_exp);
		   $dataVenctoFinal = $dataVenctoFinalArr[2].'-'.$dataVenctoFinalArr[1].'-'.$dataVenctoFinalArr[0];
		   
		   $sql .=  "and (cnd_imobiliaria.data_vencto between '$dataVenctoIni' and  '$dataVenctoFinal')";
		}
		
	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarCndTodos($idContratante){
	 
	$sql = "SELECT 
	`cnd_imobiliaria`.`id` as id_cnd, `imovel`.`nome`, `iptu`.*, `iptu`.`id` as id_iptu,
	`informacoes_inclusas_iptu`.`descricao`, `status_iptu`.`descricao` as status_pref,
	`emitente`.`razao_social`, `cnd_imobiliaria`.`possui_cnd` as cnd, 
	`cnd_imobiliaria`.`data_vencto`, `cnd_imobiliaria`.`data_pendencias`, 
	`cnd_imobiliaria`.`plano`, `cnd_imobiliaria`.`observacoes` as obs_cnd, `emitente`.`cpf_cnpj`, `imovel`.`cidade`, `imovel`.`estado`,link,
	cnd_imobiliaria.possui_cnd	
	FROM (`cnd_imobiliaria`) 
	LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `iptu`.`nome_proprietario` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	LEFT JOIN `status_iptu` ON `status_iptu`.`id` = `iptu`.`status_prefeitura`
	LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `imovel`.`estado` 
	WHERE `cnd_imobiliaria`.`id_contratante` = ? ";

	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarTodasTratativas($idContratante,$id,$modulo){
	 
	$sql = "select cnd_mob_tratativa.id,cnd_mob_tratativa.pendencia,
	DATE_FORMAT(data_inclusao_sis_ext,'%d/%m/%Y') as data_envio_voiza ,
	DATE_FORMAT(prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_voiza ,
	DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_bd ,
	DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao_bd ,
	status_chamado_sis_ext,
	status_demanda,
	status_demanda.descricao_etapa,
	status_chamado_interno_mobiliario.descricao,
	data_atualizacao as ultima_tratativa
	from cnd_mob_tratativa
	left join status_demanda on status_demanda.id = cnd_mob_tratativa.status_demanda
	left join status_chamado_interno_mobiliario on status_chamado_interno_mobiliario.id = cnd_mob_tratativa.status_chamado_sis_ext  
	where id_contratante = ? and id_cnd_mob = ? and cnd_mob_tratativa.modulo = ?
	order by cnd_mob_tratativa.id desc
	";

	$query = $this->db->query($sql, array($idContratante,$id,$modulo));
	
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarEsfera(){
   $this -> db -> select('*');
   $this -> db -> from('esfera');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 
   function listarStatusDemanda(){
   $this -> db -> select('*');
   $this -> db -> from('status_demanda');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 function listarPeriodoRenovacao(){
   $this -> db -> select('*');
   $this -> db -> from('periodo_renovacao_licenca');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
  function listarPeriodoTaxa(){
   $this -> db -> select('*');
   $this -> db -> from('periodo_taxas');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
   function listarTipoTaxa(){
   $this -> db -> select('*');
   $this -> db -> from('tipo_taxas');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
   function listarEtapa(){
   $this -> db -> select('*');
   $this -> db -> from('etapa');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 
 function listarInscricaoByImovel($idContratante,$id){
	 
	$sql = "SELECT 
	`cnd_imobiliaria`.`id` as id_cnd, `imovel`.`nome`, `iptu`.*, `iptu`.`id` as id_iptu,`informacoes_inclusas_iptu`.`descricao`, `status_iptu`.`descricao` as status_pref,`emitente`.`razao_social`, `cnd_imobiliaria`.`possui_cnd` as cnd, `cnd_imobiliaria`.`data_vencto`, `cnd_imobiliaria`.`data_pendencias`, 
	`cnd_imobiliaria`.`plano`, `cnd_imobiliaria`.`observacoes` as obs_cnd, `emitente`.`cpf_cnpj`, `imovel`.`cidade`, `imovel`.`estado`,link,
	imovel.rua,imovel.bairro,imovel.cidade,imovel.cep,imovel.numero,cnd_imobiliaria.possui_cnd	,regional.descricao,
	cnd_imobiliaria.arquivo,cnd_imobiliaria.arquivo_pendencias,DATE_FORMAT(cnd_imobiliaria.data_emissao,'%d/%m/%Y') as data_emissao_br
	,DATE_FORMAT(cnd_imobiliaria.data_vencto,'%d/%m/%Y') as data_vencto_br,cnd_imobiliaria.observacoes_extrato
	FROM (`cnd_imobiliaria`) 
	LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `iptu`.`nome_proprietario` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	LEFT JOIN `status_iptu` ON `status_iptu`.`id` = `iptu`.`status_prefeitura`
	LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `imovel`.`estado` 
	LEFT JOIN regional on regional.id = imovel.regional
	WHERE `cnd_imobiliaria`.`id_contratante` = ? and cnd_imobiliaria.id = ?";

	$query = $this->db->query($sql, array($idContratante,$id));
	//print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 function listarCnpj($idContratante){
	 
	$sql = "SELECT emitente.cpf_cnpj as cnpj
	FROM (`cnd_imobiliaria`) 
	LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `iptu`.`nome_proprietario` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	LEFT JOIN `status_iptu` ON `status_iptu`.`id` = `iptu`.`status_prefeitura`
	WHERE `cnd_imobiliaria`.`id_contratante` = ? ";

	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarImoveis($idContratante){
	 
	$sql = "SELECT imovel.id,imovel.nome
	FROM (`cnd_imobiliaria`) 
	LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `iptu`.`nome_proprietario` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	LEFT JOIN `status_iptu` ON `status_iptu`.`id` = `iptu`.`status_prefeitura`
	WHERE `cnd_imobiliaria`.`id_contratante` = ? ";

	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarInscricao($idContratante){
	 
	$sql = "SELECT iptu.inscricao
	FROM (`cnd_imobiliaria`) 
	LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `iptu`.`nome_proprietario` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	LEFT JOIN `status_iptu` ON `status_iptu`.`id` = `iptu`.`status_prefeitura`
	WHERE `cnd_imobiliaria`.`id_contratante` = ? ";

	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarEstados($idContratante){
	 
	$sql = "SELECT distinct imovel.estado
	FROM (`cnd_imobiliaria`) 
	LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
	LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
	LEFT JOIN `emitente` ON `emitente`.`id` = `iptu`.`nome_proprietario` 
	LEFT JOIN `informacoes_inclusas_iptu` ON `informacoes_inclusas_iptu`.`id` = `iptu`.`info_inclusas`
	LEFT JOIN `status_iptu` ON `status_iptu`.`id` = `iptu`.`status_prefeitura`
	WHERE `cnd_imobiliaria`.`id_contratante` = ? order by imovel.estado ";

	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarTodasDataEmissao($id,$modulo){
	 
	$sql = "select DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao  from cnd_data_emissao where id_cnd = ? and modulo =? order by data_emissao desc ";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarImovelByImovel($id_imovel,$tipo){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   if($id_imovel <> 0){
	$this -> db -> where('iptu.id_imovel', $id_imovel);   
   }
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);   
   }
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }

   
  function listarImovelByUf($estado,$tipo){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   $this -> db -> where('imovel.estado', $estado); 
   
   if($tipo <> 'X'){
	   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo); 
   }
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelByMunicipio($municipio,$tipo){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   if($tipo <> 'X'){
	   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);   
   }
   $this -> db -> where('imovel.cidade', $municipio);   

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
    function contaTodasCnd(){
	 
   $this -> db -> select('count(`cnd_imobiliaria`.`possui_cnd`) as total');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   
   $this -> db -> order_by('total');   

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
    function contaCnd($idContratante){
	 
	$sql = "SELECT count(`cnd_imobiliaria`.`possui_cnd`) as total, `possui_cnd` 
	FROM (`cnd_imobiliaria`) 		
	where cnd_imobiliaria.id_contratante = ? 
	GROUP BY `cnd_imobiliaria`.`possui_cnd` 
	 ";

	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function contaVigente($idContratante,$tipo,$statusVigente){
	 
	 $data = date("Y-m-d");
	 if($statusVigente == 2){
		 
		 $sql = "SELECT count(*) as total FROM (`cnd_imobiliaria`)  WHERE `cnd_imobiliaria`.`id_contratante` = ?  AND `cnd_imobiliaria`.`possui_cnd` = ?  and data_vencto <= ?";
		$query = $this->db->query($sql, array($idContratante,$tipo,$data));	
		 
	 }else{
		 
		 $sql = "SELECT count(*) as total FROM (`cnd_imobiliaria`)  WHERE `cnd_imobiliaria`.`id_contratante` = ?  AND `cnd_imobiliaria`.`possui_cnd` = ? and data_vencto > ?";
		$query = $this->db->query($sql, array($idContratante,$tipo,$data));	
	 }
	  	 
	 
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function contaSituacao($idContratante,$tipo,$situacao){
	   
	 if($tipo == 4){
		 $sql = "SELECT count(*) as total
		FROM `iptu` JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
		left join tipo_situacao on tipo_situacao.id = imovel.situacao
		WHERE   imovel.id_contratante = ? and iptu.id not in (select id_iptu from cnd_imobiliaria where cnd_imobiliaria.id_contratante = ?)
		 ";
		 $query = $this->db->query($sql, array($idContratante,$idContratante));
	 }else{
		$sql = "SELECT count(*) as total FROM (`cnd_imobiliaria`)  LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
		left join tipo_situacao on tipo_situacao.id = iptu.status_prefeitura WHERE `cnd_imobiliaria`.`id_contratante` = ?  AND `cnd_imobiliaria`.`possui_cnd` = ?   and tipo_situacao.id = ?";
		$query = $this->db->query($sql, array($idContratante,$tipo,$situacao));		 
	 }	 

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelPendente(){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   $this -> db -> where('cnd_imobiliaria.possui_cnd', '3');   

   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
}


?>