<?php


Class Cnd_Estadual_model extends CI_Model{

 function excluirTratativa($id){	
	$this->db->where('id', $id);	
	$this->db->delete('cnd_mob_tratativa_obs'); 	
	return true; 
} 

 function listarCNDEstCsvByEstado($id_contratante,$id,$tipo){
	
  if($tipo == "X"){
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob,`cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`estado` = ?	and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$id_contratante));
  }	else{
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob, `cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`estado` = ? AND `cnd_estadual`.`possui_cnd` = ? 
			and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$tipo,$id_contratante));
  }
	if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   } 
		
 }	
 
  function atualizar_tratativa($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_est_tratativa', $dados); 
	//print_r($this->db->last_query());exit;
	return true;
 }

 public function add_tratativa_est($detalhes = array()){
	if($this->db->insert('cnd_est_tratativa', $detalhes)) {

		$id = $this->db->insert_id();
		return $id;
	}
	return false;
}
	
	
  function listarEstados(){
	$this->db->distinct();
	$this -> db -> select('uf as uf','distinct');
	$this -> db -> from('uf_link_sefaz'); 
	$this -> db -> order_by('uf');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
 
 
 function listarMesesKPIFed(){	 
    if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }	
	 
	$sql = "select distinct  EXTRACT( YEAR_MONTH FROM data_emissao )  as data from $tabela where data_emissao <> '0000-00-00' order by data asc ";
	$query = $this->db->query($sql, array());
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarMesesKPIMob(){	 
	 if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }	
	 
	$sql = "select distinct  EXTRACT( YEAR_MONTH FROM data_emissao )  as data from ".$tabela." where data_emissao <> '1111-11-11' order by data asc ";
	
	$query = $this->db->query($sql, array());
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarMesesKPIEst(){	 
	$sql = "select distinct  EXTRACT( YEAR_MONTH FROM data_emissao )  as data from cnd_estadual where data_emissao <> '0000-00-00' order by data asc ";
	$query = $this->db->query($sql, array());
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarEstadualTrintaDiasVencer($idContratante,$ativo){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *,loja.cidade as cidade_loja, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, 
		`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
		`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_estadual`.`possui_cnd` as status_debito_fiscal, `link`,
		`cnd_estadual`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
		FROM (`cnd_estadual`) 
		LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
		LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
		LEFT JOIN regional on regional.id = loja.regional
		LEFT JOIN bandeira on bandeira.id = loja.bandeira
		  LEFT JOIN usuarios on usuarios.id = cnd_estadual.usuario_upload
		WHERE `cnd_estadual`.`id_contratante` = $idContratante and cnd_estadual.data_vencto between ? and ? and `cnd_estadual`.`possui_cnd` = 1 and cnd_estadual.ativo = ?";	     
   

  $query = $this->db->query($sql, array($data1,$data2,$ativo));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarMobQuinzeDiasVencer($idContratante,$ativo){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *, `cnd_mobiliaria`.`ativo` as status_insc, `cnd_mobiliaria`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_mobiliaria`.`possui_cnd` as status_debito_fiscal, `link`, `cnd_mobiliaria`.`data_vencto` ,loja.estado as estado_cnd,
			loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,loja.cidade as cidade_loja,usuarios.email
			FROM (`cnd_mobiliaria`) 
			LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`  
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira
			  LEFT JOIN usuarios on usuarios.id = cnd_mobiliaria.usuario_upload
			WHERE `cnd_mobiliaria`.`id_contratante` = $idContratante and cnd_mobiliaria.data_vencto between ? and ? and `cnd_mobiliaria`.`possui_cnd`  = 1 and cnd_mobiliaria.ativo = ?";	     
   

  $query = $this->db->query($sql, array($data1,$data2,$ativo));
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarMobTrintaDiasVencer($idContratante,$ativo){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_mobiliaria`.`ativo` as status_insc, `cnd_mobiliaria`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_mobiliaria`.`possui_cnd` as status_debito_fiscal, `link`, `cnd_mobiliaria`.`data_vencto` ,loja.estado as estado_cnd,
			loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,loja.cidade as cidade_loja,usuarios.email
			FROM (`cnd_mobiliaria`) 
			LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`  
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira
			  LEFT JOIN usuarios on usuarios.id = cnd_mobiliaria.usuario_upload
			WHERE `cnd_mobiliaria`.`id_contratante` = $idContratante and cnd_mobiliaria.data_vencto between ? and ? and `cnd_mobiliaria`.`possui_cnd`  = 1 and cnd_mobiliaria.ativo = ?";	     
   

  $query = $this->db->query($sql, array($data1,$data2,$ativo));
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarImobTrintaDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *, `cnd_imobiliaria`.`ativo` as status_insc, `cnd_imobiliaria`.`id` as id_cnd,  `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `iptu`.`inscricao`,
			`iptu`.`id` as id_loja, `cnd_imobiliaria`.`possui_cnd` as status_debito_fiscal, `link`,   `cnd_imobiliaria`.`data_vencto` ,imovel.estado as estado_cnd 
			FROM (`cnd_imobiliaria`) 
			LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id`   LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
			left join emitente_imovel on emitente_imovel.id_imovel = imovel.id   LEFT JOIN `emitente` ON `emitente`.`id` = `emitente_imovel`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `imovel`.`estado` = `uf_link_sefaz`.`uf`  WHERE `cnd_imobiliaria`.`id_contratante` = ? and cnd_imobiliaria.data_vencto between ? and ? and `cnd_imobiliaria`.`possui_cnd` = 1";	     
   

  $query = $this->db->query($sql, array($idContratante,$data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarImobQuinzeDiasVencidas($idContratante,$ativo){
	   
$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje)));
	
	$sql = "SELECT *,loja.cidade as cidade_loja, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, 
			`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_estadual`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_estadual`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
			FROM (`cnd_estadual`) 
			LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira 
			  LEFT JOIN usuarios on usuarios.id = cnd_estadual.usuario_upload
			WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.data_vencto between ? and ? and `cnd_estadual`.`possui_cnd` = 1 and cnd_estadual.ativo = ?";	     
   

  $query = $this->db->query($sql, array($idContratante,$data2,$data1,$ativo));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 function listarImobQuinzeDiasVencer($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *, `cnd_imobiliaria`.`ativo` as status_insc, `cnd_imobiliaria`.`id` as id_cnd,  `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `iptu`.`inscricao`,
			`iptu`.`id` as id_loja, `cnd_imobiliaria`.`possui_cnd` as status_debito_fiscal, `link`,   `cnd_imobiliaria`.`data_vencto` ,imovel.estado as estado_cnd 
			FROM (`cnd_imobiliaria`) 
			LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id`   LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
			left join emitente_imovel on emitente_imovel.id_imovel = imovel.id   LEFT JOIN `emitente` ON `emitente`.`id` = `emitente_imovel`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `imovel`.`estado` = `uf_link_sefaz`.`uf`  WHERE `cnd_imobiliaria`.`id_contratante` = ? and cnd_imobiliaria.data_vencto between ? and ? and `cnd_imobiliaria`.`possui_cnd` = 1";	     
   

  $query = $this->db->query($sql, array($idContratante,$data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarMob1QuinzeDiasVencer($idContratante,$ativo){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *, `cnd_mobiliaria`.`ativo` as status_insc, `cnd_mobiliaria`.`id` as id_cnd, 
				`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_mobiliaria`.`possui_cnd` as status_debito_fiscal, 
				`cnd_mobiliaria`.`data_vencto` ,loja.estado as estado_cnd,loja.cidade as cidade_loja, regional.descricao as empresa,bandeira.descricao_bandeira
				 FROM (`cnd_mobiliaria`)  
				 LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`  
				 LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel`  
				 LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
				 LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf`
				 LEFT JOIN regional on regional.id = loja.regional
				 LEFT JOIN bandeira on bandeira.id = loja.bandeira
				 WHERE `cnd_mobiliaria`.`id_contratante` = $idContratante and cnd_mobiliaria.data_vencto between ? and ? and cnd_mobiliaria.ativo = ?";	     
   
  $query = $this->db->query($sql, array($data1,$data2,$ativo));
   print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarImobTrintaDiasVencidas($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje)));
		$sql = "SELECT 
			*, `cnd_imobiliaria`.`ativo` as status_insc, `cnd_imobiliaria`.`id` as id_cnd,  `emitente`.`nome_fantasia` as raz_soc, 
			`emitente`.`cpf_cnpj` as cpf_cnpj_loja, `iptu`.`inscricao`,
			`iptu`.`id` as id_loja, `cnd_imobiliaria`.`possui_cnd` as status_debito_fiscal, 
			`cnd_imobiliaria`.`data_vencto` ,imovel.estado as estado_cnd 
			FROM (`cnd_imobiliaria`) 
			LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id`   LEFT JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
			left join emitente_imovel on emitente_imovel.id_imovel = imovel.id   LEFT JOIN `emitente` ON `emitente`.`id` = `emitente_imovel`.`id_emitente`
			 WHERE `cnd_imobiliaria`.`id_contratante` = ? and (cnd_imobiliaria.data_vencto <=?  and  cnd_imobiliaria.data_vencto <> '0000-00-00') and possui_cnd = 1 order by imovel.estado";	     
   
  $query = $this->db->query($sql, array($idContratante,$data2,$data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 

 function listarMobQuinzeDiasVencidas($idContratante,$ativo){
	   
		$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje)));
	
	    
   

   $sql = "SELECT *,loja.cidade as cidade_loja, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, 
			`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_estadual`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_estadual`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
			FROM (`cnd_estadual`) 
			LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira 		
			LEFT JOIN usuarios on usuarios.id = cnd_estadual.usuario_upload			
			WHERE `cnd_estadual`.`id_contratante` = $idContratante and cnd_estadual.data_vencto between ? and ? and cnd_estadual.possui_cnd = 1 and cnd_estadual.ativo = ?";	
			
  $query = $this->db->query($sql, array($data2,$data1,$ativo));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarMob1QuinzeDiasVencidas($idContratante,$ativo){
	   
		$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje)));
	
	    
   

  $sql = "SELECT *,loja.cidade as cidade_loja, `cnd_mobiliaria`.`ativo` as status_insc, `cnd_mobiliaria`.`id` as id_cnd, 
			`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_mobiliaria`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_mobiliaria`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
			FROM (`cnd_mobiliaria`) 
			LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira 			
			  LEFT JOIN usuarios on usuarios.id = cnd_mobiliaria.usuario_upload
			WHERE `cnd_mobiliaria`.`id_contratante` = $idContratante and cnd_mobiliaria.data_vencto between ? and ? and cnd_mobiliaria.possui_cnd = 1 and cnd_mobiliaria.ativo = ?";	
				
			
  $query = $this->db->query($sql, array($data2,$data1,$ativo));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarMob1TrintaDiasVencidas($idContratante,$ativo){
	$dataHoje = date('Y-m-d'); 	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 	
	 $sql = "SELECT *,loja.cidade as cidade_loja, `cnd_mobiliaria`.`ativo` as status_insc, `cnd_mobiliaria`.`id` as id_cnd, 
			`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_mobiliaria`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_mobiliaria`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
			FROM (`cnd_mobiliaria`) 
			LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira 			
			  LEFT JOIN usuarios on usuarios.id = cnd_mobiliaria.usuario_upload
			WHERE `cnd_mobiliaria`.`id_contratante` = $idContratante and (cnd_mobiliaria.data_vencto <=?  and  cnd_mobiliaria.data_vencto <> '0000-00-00')  and `cnd_mobiliaria`.`possui_cnd` = 1 and cnd_mobiliaria.ativo = ? ";	     
   

  $query = $this->db->query($sql, array($data1,$ativo));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarMobTrintaDiasVencidas($idContratante,$ativo){
	$dataHoje = date('Y-m-d'); 	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 	
	 $sql = "SELECT *,loja.cidade as cidade_loja, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, 
			`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_estadual`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_estadual`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
			FROM (`cnd_estadual`) 
			LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira 			
			  LEFT JOIN usuarios on usuarios.id = cnd_estadual.usuario_upload
			WHERE `cnd_estadual`.`id_contratante` = $idContratante and (cnd_estadual.data_vencto <=?  and  cnd_estadual.data_vencto <> '0000-00-00')  and `cnd_estadual`.`possui_cnd` = 1 and cnd_estadual.ativo = ? ";	     
   

  $query = $this->db->query($sql, array($data1,$ativo));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarEstadualQuinzeDiasVencer($idContratante,$ativo){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *,loja.cidade as cidade_loja, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, 
			`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_estadual`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_estadual`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
			FROM (`cnd_estadual`) 
			LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira 	
			LEFT JOIN usuarios on usuarios.id = cnd_estadual.usuario_upload			
			WHERE `cnd_estadual`.`id_contratante` = $idContratante and cnd_estadual.data_vencto between ? and ? and cnd_estadual.possui_cnd = 1 and cnd_estadual.ativo = ?";	     
   

  $query = $this->db->query($sql, array($data1,$data2,$ativo));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarEstadualQuinzeDiasVencidas($idContratante){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje)));
	
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_estadual`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_estadual`.`data_vencto` ,loja.estado as estado_cnd FROM (`cnd_estadual`) 
			LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`  LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			WHERE `cnd_estadual`.`id_contratante` = $idContratante and cnd_estadual.data_vencto between ? and ?";	     
   

  $query = $this->db->query($sql, array($data2,$data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarEstadualTrintaDiasVencidas($idContratante,$ativo){
	   
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *,loja.cidade as cidade_loja, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, 
			`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
			`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `cnd_estadual`.`possui_cnd` as status_debito_fiscal, `link`,
			`cnd_estadual`.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira ,usuarios.email
			FROM (`cnd_estadual`) 
			LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
			LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
			LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN bandeira on bandeira.id = loja.bandeira
			  LEFT JOIN usuarios on usuarios.id = cnd_estadual.usuario_upload
			WHERE `cnd_estadual`.`id_contratante` = $idContratante and (cnd_estadual.data_vencto <=?  and  cnd_estadual.data_vencto <> '0000-00-00') and `cnd_estadual`.`possui_cnd` = 1 and cnd_estadual.ativo = ?";	     
   

  $query = $this->db->query($sql, array($data1,$ativo));
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function contaCndEstadualByUfTrintaDiasVencer($id_contratante,$status,$tabela,$uf,$ativa){
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	if($tabela == 'estadual'){
		$sql = "select count(*) as total  from cnd_estadual left join loja on loja.id = cnd_estadual.id_loja where cnd_estadual.id_contratante = ? and cnd_estadual.possui_cnd = ? and cnd_estadual.data_vencto between ? and ? and loja.estado =? and cnd_estadual.ativo = ?";
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$data2,$uf,$ativa));	
		
	}elseif($tabela == 'mobiliaria'){	
		$sql = "select count(*) as total  from cnd_mobiliaria left join loja on loja.id = cnd_mobiliaria.id_loja where cnd_mobiliaria.id_contratante = ? and cnd_mobiliaria.possui_cnd = ? and cnd_mobiliaria.data_vencto between ? and ? and loja.estado =?  and cnd_mobiliaria.ativo = ?";
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$data2,$uf,$ativa));	
		
	}else{
		$sql = "select count(*) as total  from cnd_imobiliaria  left join iptu on iptu.id = cnd_imobiliaria.id_iptu left join imovel on imovel.id = iptu.id_imovel 	where cnd_imobiliaria.id_contratante = ? and cnd_imobiliaria.possui_cnd = ? and cnd_imobiliaria.data_vencto between ? and ? and imovel.estado =?";		
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$data2,$uf));	
	}		
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function contaCndEstadualByUfQuinzeDiasVencer($id_contratante,$status,$tabela,$uf,$ativa){
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	if($tabela == 'estadual'){
		$sql = "select count(*) as total  from cnd_estadual left join loja on loja.id = cnd_estadual.id_loja where cnd_estadual.id_contratante = ? and cnd_estadual.possui_cnd = ? and cnd_estadual.data_vencto between ? and ? and loja.estado =?  and cnd_estadual.ativo = ?";
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$data2,$uf,$ativa));
		
	}elseif($tabela == 'mobiliaria'){	
		$sql = "select count(*) as total  from cnd_mobiliaria left join loja on loja.id = cnd_mobiliaria.id_loja where cnd_mobiliaria.id_contratante = ? and cnd_mobiliaria.possui_cnd = ? and cnd_mobiliaria.data_vencto between ? and ? and loja.estado =? and cnd_mobiliaria.ativo = ? ";
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$data2,$uf,$ativa));
	}else{
		$sql = "select count(*) as total  from cnd_imobiliaria  left join iptu on iptu.id = cnd_imobiliaria.id_iptu left join imovel on imovel.id = iptu.id_imovel left join emitente_imovel on emitente_imovel.id_imovel = imovel.id  LEFT JOIN `emitente` ON `emitente`.`id` = `emitente_imovel`.`id_emitente` 	where cnd_imobiliaria.id_contratante = ? and cnd_imobiliaria.possui_cnd = ? and cnd_imobiliaria.data_vencto between ? and ? and imovel.estado =?";		
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$data2,$uf));
	}
	
	
		
	
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
   function contaCndEstadualByUfQuinzeDiasVencidas($id_contratante,$status,$tabela,$uf,$ativa){
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	$data1 = date('Y-m-d', strtotime("-1 days",strtotime($dataHoje))); 
	
	if($tabela == 'estadual'){
		$sql = "select count(*) as total  from cnd_estadual left join loja on loja.id = cnd_estadual.id_loja where cnd_estadual.id_contratante = ? and cnd_estadual.possui_cnd = ? and cnd_estadual.data_vencto between ? and ? and loja.estado =? and cnd_estadual.ativo = ?";
		$query = $this->db->query($sql, array($id_contratante,$status,$data2,$data1,$uf,$ativa));
		
	}elseif($tabela == 'mobiliaria'){	
		$sql = "select count(*) as total  from cnd_mobiliaria left join loja on loja.id = cnd_mobiliaria.id_loja where cnd_mobiliaria.id_contratante = ? and cnd_mobiliaria.possui_cnd = ? and cnd_mobiliaria.data_vencto between ? and ? and loja.estado =?  and cnd_mobiliaria.ativo = ?";
		$query = $this->db->query($sql, array($id_contratante,$status,$data2,$data1,$uf,$ativa));
	}else{
		$sql = "select count(*) as total  from cnd_imobiliaria  left join iptu on iptu.id = cnd_imobiliaria.id_iptu left join imovel on imovel.id = iptu.id_imovel left join emitente_imovel on emitente_imovel.id_imovel = imovel.id   LEFT JOIN `emitente` ON `emitente`.`id` = `emitente_imovel`.`id_emitente`  	where cnd_imobiliaria.id_contratante = ? and cnd_imobiliaria.possui_cnd = ? and cnd_imobiliaria.data_vencto between ? and ? and imovel.estado =?";		
		$query = $this->db->query($sql, array($id_contratante,$status,$data2,$data1,$uf));
	}
	
	
	
		
	
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function contaCndEstadualByUfTrintaDiasVencidas($id_contratante,$status,$tabela,$uf,$ativa){
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 
		
	if($tabela == 'estadual'){
		$sql = "select count(*) as total  from cnd_estadual left join loja on loja.id = cnd_estadual.id_loja  where cnd_estadual.id_contratante = ? and cnd_estadual.possui_cnd = ? and (cnd_estadual.data_vencto <=?  and  cnd_estadual.data_vencto <> '0000-00-00') and loja.estado = ? and cnd_estadual.ativo = ?";
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$uf,$ativa));
		//print_r($this->db->last_query());exit;
	}elseif($tabela == 'mobiliaria'){	
		$sql = "select count(*) as total  from cnd_mobiliaria left join loja on loja.id = cnd_mobiliaria.id_loja  where cnd_mobiliaria.id_contratante = ? and cnd_mobiliaria.possui_cnd = ? and (cnd_mobiliaria.data_vencto <=?  and  cnd_mobiliaria.data_vencto <> '0000-00-00') and loja.estado = ?  and cnd_mobiliaria.ativo = ?";
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$uf,$ativa));
	}else{
		$sql = "select count(*) as total  from cnd_imobiliaria  left join iptu on iptu.id = cnd_imobiliaria.id_iptu left join imovel on imovel.id = iptu.id_imovel 	left join emitente_imovel on emitente_imovel.id_imovel = imovel.id 	LEFT JOIN `emitente` ON `emitente`.`id` = `emitente_imovel`.`id_emitente` 	where cnd_imobiliaria.id_contratante = ? and cnd_imobiliaria.possui_cnd = ? and (cnd_imobiliaria.data_vencto <=?  and  cnd_imobiliaria.data_vencto <> '0000-00-00') and imovel.estado =?";				
		$query = $this->db->query($sql, array($id_contratante,$status,$data1,$uf));
	}	
	
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function verificaFechamentoMensal($id,$primeiroDia){	
	$sql = "SELECT count(*) as total FROM (`kpi`)  WHERE   regional= ?  and kpi.mes_competencia = ?  ;";
		
	$query = $this->db->query($sql, array($id,$primeiroDia));
	
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }
 }
 
 public function insere_serpac($detalhes = array()){
	if($this->db->insert('kpi', $detalhes)) {				
		$id = $this->db->insert_id();
		
		return $id;
	}
	return false;
}

 function buscarDadosKpiClientes($tipo,$cnpjCliente,$primeiroDia,$ultimoDia,$status){	 
	
	if($tipo == 'kpi_federal'){
		$tabela ='cnd_federal';	
	}elseif($tipo == 'kpi_estadual'){
		$tabela ='cnd_estadual';	
	}elseif($tipo == 'kpi_mobiliaria'){
		$tabela ='cnd_mobiliaria';				
	}
	
	if($status == 1){
			$sql = "select count(*) as total FROM $tabela c
			LEFT JOIN `loja` ON c.`id_loja` = `loja`.`id` 
			WHERE 	c.ativo = 0
			and loja.regional = ?
			and c.possui_cnd = ?
			and c.data_emissao between ? and ?";	
			$query = $this->db->query($sql, array($cnpjCliente,$status,$primeiroDia,$ultimoDia));			
		}elseif($status == 2){
			$sql = "
			select count(*) as total
			FROM $tabela c
			LEFT JOIN `loja` ON c.`id_loja` = `loja`.`id` 
			WHERE 	c.ativo = 0
			and loja.regional = ?
			and c.possui_cnd = ?";			
			$query = $this->db->query($sql, array($cnpjCliente,$status));	
			
		}else{
			$sql = "select count(*) as total
			FROM $tabela c
			LEFT JOIN `loja` ON `c`.`id_loja` = `loja`.`id` 
			WHERE 	c.ativo = 0
			and loja.regional = ?
			and c.possui_cnd = ?
			and c.data_pendencias between ? and ?";
			$query = $this->db->query($sql, array($cnpjCliente,$status,$primeiroDia,$ultimoDia));						
		}
		
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarRegional(){
   $this -> db -> select('id,cnpj,descricao');
   $this -> db -> from('regional');
 
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
 
  function listarTotalClientes($empresa,$mes){	
   if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }	  
	$sql = "select 	(sum(emitidas)  + sum(n_emitidas)) as total from kpi where regional = ? and mes_competencia = ? and modulo = $modulo order by mes_competencia ";
	$query = $this->db->query($sql, array($empresa,$mes));
	
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }

   
 }
 
  function buscarDadosKpiMeses($empresa,$inicio){	 
	$sql = "select kpi.cnpj, kpi.mes_competencia,kpi.emitidas,kpi.n_emitidas,kpi.pendentes,regional.descricao as nome_empresa,kpi.id_contratante from kpi left join regional on kpi.regional = regional.id 	where regional = ? and mes_competencia = ? order by mes_competencia ";
	$query = $this->db->query($sql, array($empresa,$inicio));

   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }
   
  }
  
  function listarResumoClientes($empresa,$mes){	 
   if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }
	$sql = "select 	* from kpi where regional = ? and mes_competencia = ? and modulo = $modulo order by mes_competencia ";
	$query = $this->db->query($sql, array($empresa,$mes));
	
   if($query -> num_rows() <> 0){
     return $query->result_array();
   }else{
     return 0;
   }

   
 }
 
  public function inserirNovoArquivo($detalhes = array()){
	if($this->db->insert('arquivo_tratativas', $detalhes)) {
		$id = $this->db->insert_id();
		return $id;
	}
	return false;

}

 
   function atualizar_tratativa_obs($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_mob_tratativa_obs', $dados); 
	return true;
 }
 
 function listarUltimaObsTratById($id,$modulo){
	 
	$sql = "select 	max(c.id) as id from cnd_mob_tratativa_obs c where c.id_cnd_trat = ? and modulo = ?";

	$query = $this->db->query($sql, array($id,$modulo));
	

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function contaCndEstadual($id_contratante,$status){
	$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) 	WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.`possui_cnd` = ? and ativo=0";
	$query = $this->db->query($sql, array($id_contratante,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function contaCndEstadualByUf($id_contratante,$status,$estado){
	$sql = "SELECT count(*) as total FROM (`cnd_estadual`) 
			left join loja on loja.id = cnd_estadual.id_loja
			WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.`possui_cnd` = ? and loja.estado  = ? and cnd_estadual.ativo=0";
	$query = $this->db->query($sql, array($id_contratante,$status,$estado));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function listarCNDEstCsvByMun($id_contratante,$id,$tipo){
	
  if($tipo == "X"){
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob,`cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`cidade` = ?	and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$id_contratante));
  }	else{
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob, `cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`cidade` = ? AND `cnd_estadual`.`possui_cnd` = ?' 
			and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$tipo,$id_contratante));
  }
//  print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   } 
		
 }	
 
 
 function listarArquivosEstadual($id){ 
	$sql = "select arquivo from arquivo_tratativas a where a.id_tratativas = ? and modulo = 3";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 public function addDataEmissao($detalhes = array()){
	if($this->db->insert('cnd_data_emissao', $detalhes)) {
		$id = $this->db->insert_id();
		return $id;
	}
	return false;

}
	
 function listarDataEmissao($id,$modulo){
	 
	$sql = "select data_emissao,DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br from cnd_data_emissao where id_cnd = ? and modulo =? order by id desc limit 1";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarCNDEstCsvById($id_contratante,$id){
	
  if($id == "0"){
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob,`cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and cnd_estadual.id_contratante = ?  	ORDER BY `cnd_estadual`.`possui_cnd`";
	$query = $this->db->query($sql, array($id_contratante,$id_contratante));
  }	else{
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob, `cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `cnd_estadual`.`id` = ? and cnd_estadual.id_contratante = ? ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$id_contratante));
  }
	if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   } 
		
 }	
 
 function listarLoja($id_contratante,$tipo){
   $this->db->distinct();
   $this -> db -> select('cnd_estadual.id,emitente.nome_fantasia as  nome');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }   
   $this -> db -> order_by('loja.id');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarEmitenteById($id){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social,emitente.cpf_cnpj,loja.id as id_loja,loja.ins_cnd_mob as inc_cnd_mob');

   $this -> db -> from('emitente');
   
   $this -> db -> join('loja','emitente.id = loja.id_emitente'); 

   $this -> db -> where('loja.id', $id);

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarCidadeEstadoById($id){
	
   $this -> db -> select('loja.id,loja.cidade,loja.estado ');
   $this -> db -> from('cnd_estadual');  
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_estadual.id', $id);   
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function regionais(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('regional');  
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 function listarInscricaoById($id){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> where('cnd_estadual.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarCNDById($id){
   $this -> db -> select('*');
   $this -> db -> from('cnd_estadual');
   $this -> db -> where('cnd_estadual.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 function atualizar($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_estadual', $dados); 
	//print_r($this->db->last_query());exit;
	return true;
 } 
 
   function buscarTratativas($id){ 
	$sql = "select c.id,c.pendencia,c.status_demanda,DATE_FORMAT(data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia from cnd_mob_tratativa c where c.id_cnd_mob = ? and c.modulo = 3 order by id asc limit 2 "; 
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function buscarTratativasEst($id){ 
	$sql = "select c.id as id_tra,c.auto,c.natureza,c.inscricao,c.processo,c.principal,c.multa,c.juros,c.valor_total,c.garantia,c.responsavel,c.contato,c.pasta,c.escritorio,c.sla,st.descricao,DATE_FORMAT(data_encerramento,'%d/%m/%Y') as data_encerramento, DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio,DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao  from cnd_est_tratativa c  left join status_chamado_interno_estadual st on c.status_tratativa = st.id where  c.id_cnd_mob = ? and c.modulo = 3 order by c.id asc  "; 
	$query = $this->db->query($sql, array($id));
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
function listarInscricaoByLoja($id){

  
  $sql = "SELECT *, 
  `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `cnd_estadual`.`inscricao` as ins_cnd_mob, 
  `loja`.`id` as id_loja, DATE_FORMAT(cnd_estadual.data_emissao, '%d/%m/%Y') as data_emissao_br,
  DATE_FORMAT(cnd_estadual.data_vencto, '%d/%m/%Y') as data_vencto_br  ,link,regional.descricao,
cnd_estadual.observacoes as obs_cnd,cnd_estadual.observacoes_extrato,cnd_estadual.possui_cnd as status
  FROM (`cnd_estadual`) JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
  LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel`
  LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
  LEFT JOIN uf_link_sefaz on uf_link_sefaz.uf = loja.estado
  LEFT JOIN regional on regional.id = loja.regional
  WHERE `cnd_estadual`.`id` = ?";
  $query = $this->db->query($sql, array($id));
  
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
  function listarTodasTratativasEst($idContratante,$id,$modulo){
	$sql = "select c.id,c.id_contratante,c.id_cnd_mob,c.tipo_tratativa,c.status_tratativa,c.id_sis_ext,c.auto,c.natureza,c.inscricao,c.processo,c.principal,c.multa,c.juros,c.valor_total,c.garantia,c.responsavel,c.pasta,c.contato,c.escritorio,DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_bd ,DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao_bd ,	DATE_FORMAT(data_encerramento,'%d/%m/%Y') as data_encerramento_bd ,	c.sla,c.modulo,c.data_atualizacao,st.descricao	from cnd_est_tratativa c left join status_chamado_interno_estadual st on c.status_tratativa = st.id 	where c.id_contratante = ? and c.id_cnd_mob = ? and c.modulo = ? 	order by c.data_atualizacao desc ";
	
	$query = $this->db->query($sql, array($idContratante,$id,$modulo));
	//print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 function listarTodasTratativasEstById($idContratante,$id){
	$sql = "select id,id_contratante,id_cnd_mob,tipo_tratativa,status_tratativa,id_sis_ext,auto,natureza,inscricao,processo,principal,multa,juros,valor_total,garantia,responsavel,pasta,contato,escritorio,		DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_bd ,DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao_bd ,	DATE_FORMAT(data_encerramento,'%d/%m/%Y') as data_encerramento_bd ,	sla,modulo,data_atualizacao
		from cnd_est_tratativa where id_contratante = ? and cnd_est_tratativa.id = ? order by cnd_est_tratativa.data_atualizacao desc";
	
	$query = $this->db->query($sql, array($idContratante,$id));
	//print_r($this->db->last_query());exit;

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
		status_chamado_interno_estadual.descricao,
		DATE_FORMAT(data_atualizacao,'%d/%m/%Y') as ultima_tratativa
		from cnd_mob_tratativa
		left join status_demanda on status_demanda.id = cnd_mob_tratativa.status_demanda
		left join status_chamado_interno_estadual on status_chamado_interno_estadual.id = cnd_mob_tratativa.status_chamado_sis_ext  
		where id_contratante = ? and id_cnd_mob = ? and cnd_mob_tratativa.modulo = ?
		order by cnd_mob_tratativa.data_atualizacao desc
		";
	
	$query = $this->db->query($sql, array($idContratante,$id,$modulo));
	//print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 
  function listarObsTratById($id,$modulo){ 
	$sql = "select DATE_FORMAT(c.data,'%d/%m/%Y') as data,c.hora,c.data_hora,u.email,u.nome_usuario,c.observacao,c.id,c.arquivo
		from cnd_mob_tratativa_obs c left join usuarios u on u.id = c.id_usuario where c.id_cnd_trat = ? and c.modulo = ? order by c.id desc";
	$query = $this->db->query($sql, array($id,$modulo));
	
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
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 

 function listarStatusInterno(){
   $this -> db -> select('*');
   $this -> db -> from('status_chamado_interno_estadual');
   $query = $this -> db -> get();
  if($query -> num_rows() <> 0){
     return $query->result();
  }else{
     return false;
   }
 }
 
 
 function listarStatusCnpj(){
   $this -> db -> select('*');
   $this -> db -> from('status_cnpj');
   $query = $this -> db -> get();
  if($query -> num_rows() <> 0){
     return $query->result();
  }else{
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
 
 public function add($detalhes = array()){

 

	if($this->db->insert('cnd_estadual', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
 function listarLojaByImovel($id_loja,$tipo){
	 
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual'); 
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
     
   if($id_loja <> 0){
	$this -> db -> where('loja.id', $id_loja);   
   }	
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
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
	 
	$this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   
   $this -> db -> where('loja.cidade', $municipio);  

   if($tipo <> 'X'){
	 $this -> db -> where('cnd_estadual.possui_cnd', $tipo);    
   }

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarImovelByCidade($id,$tipo){


	$this -> db ->distinct();
	$this -> db -> select('cnd_estadual.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_estadual.possui_cnd', $tipo);  
   }	
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarImovelByUf($estado,$tipo){
	 
	
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,loja.id as id_loja,cnd_estadual.inscricao as ins_cnd_mob');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('loja.estado', $estado);  
  
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }	
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarImovelByEstado($id){
   $this -> db ->distinct();	
   $this -> db -> select('emitente.id,emitente.nome_fantasia as nome');
   $this -> db -> from('cnd_estadual');   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('loja.estado', $id);   
   $this -> db -> order_by('emitente.id');
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
 function listarCnpjByEImovel($id){
   $this -> db ->distinct();	
   $this -> db -> select('emitente.id,emitente.cpf_cnpj as cnpj');
   $this -> db -> from('cnd_estadual');   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('emitente.id', $id);   
   $this -> db -> order_by('emitente.id');
   $query = $this -> db -> get();
	
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
 function listarCnpjByLoja($id){
   $this -> db ->distinct();	
   $this -> db -> select('emitente.id,emitente.cpf_cnpj as cnpj');
   $this -> db -> from('cnd_estadual');   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('loja.id', $id);   
   $this -> db -> order_by('emitente.id');
   $query = $this -> db -> get();

	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
 
  function listarCidadeByEstado($idContratante,$id,$tipo,$ativo){
	
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> where('loja.estado', $id);
	$this -> db -> where('cnd_estadual.ativo', $ativo);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return 0;
   }

 }
 
 function listarImoByCidade($idContratante,$id,$tipo,$ativo){
	
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> where('loja.estado', $id);
	$this -> db -> where('cnd_estadual.ativo', $ativo);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return 0;
   }

 }
 
 function listarInscrByCnpj($cnpj){
	$this->db->distinct();
	$this -> db -> select('cnd_estadual.inscricao as inscricao');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id','left');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
	$this -> db -> where('emitente.cpf_cnpj', $cnpj);	
	$this -> db -> order_by('cnd_estadual.inscricao');
	$query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
    if($query -> num_rows() <> 0) {
     return $query->result();
    }else{
     return false;
    }
   
  }
 
 function listarEstado($idContratante,$tipo,$ativo){
	$this->db->distinct();
	$this -> db -> select('loja.estado as uf');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id','left');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> where('cnd_estadual.ativo', $ativo);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	
	$this -> db -> order_by('loja.estado');
	$query = $this -> db -> get();
	
    if($query -> num_rows() <> 0) {
     return $query->result();
    }else{
     return false;
    }
   
  }
  
  function listarCnpj($idContratante,$tipo,$ativo){
	$this->db->distinct();
	$this -> db -> select('emitente.cpf_cnpj as cnpj');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id','left');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> where('cnd_estadual.ativo', $ativo);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('emitente.cpf_cnpj');
	$query = $this -> db -> get();
    if($query -> num_rows() <> 0) {
     return $query->result();
    }else{
     return false;
    }
   
  }
  
    function listarImovel($idContratante,$ativo){
	$this->db->distinct();
	$this -> db -> select('imovel.id,imovel.nome');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
	$this -> db -> join('emitente_imovel','emitente_imovel.id_emitente = emitente.id');
	$this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');
	
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);	
	$this -> db -> where('cnd_estadual.ativo', $ativo);	
	$this -> db -> order_by('imovel.nome');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarCndTodosComFiltro($idContratante,$imovelExp,$estadoExp,$cnpjExp,$inscricaoExp,$statusExp,$data_vencto_final_exp,$data_vencto_ini_exp,$ativo,$cidadeExp){
	 
	$sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `cnd_estadual`.`inscricao` as ins_cnd_mob, `loja`.`id` as id_loja,usuarios.email, bandeira.descricao_bandeira,regional.descricao as descricao_regional,status_cnpj.descricao_status as status_cnpj ,loja.estado as loja_estado
			FROM (`cnd_estadual`) 
			inner JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id`
			inner JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel`
			inner JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `loja`.`estado`
			LEFT JOIN usuarios on usuarios.id = cnd_estadual.usuario_upload 
			LEFT JOIN bandeira on loja.bandeira = bandeira.id
			LEFT JOIN regional on regional.id = loja.regional
			LEFT JOIN status_cnpj on status_cnpj.codigo = cnd_estadual.status_cnpj
			WHERE `cnd_estadual`.`id_contratante` = ?   and cnd_estadual.ativo = ?";

	if($statusExp <> '0'){
		$sql .= " and cnd_estadual.possui_cnd = $statusExp " ;		
	}
	if($estadoExp <> '0'){
		$sql .=  " and loja.estado ='$estadoExp'";
	}   
	
	if($cidadeExp <> '0'){
		$sql .=  " and loja.cidade ='$cidadeExp'";
	}   
	
	if($imovelExp <> '0'){
		$sql .=  " and loja.id ='$imovelExp'";
	}   
	if($cnpjExp <> '0'){
		$sql .=  " and emitente.cpf_cnpj ='$cnpjExp'";
	}   
		
	if($inscricaoExp <> '0'){
		$sql .=  " and cnd_estadual.inscricao = '$inscricaoExp'";
	}   
	if(!empty($data_vencto_ini_exp)){
	   $dataVenctoIniArr = explode("/",$data_vencto_ini_exp);
	   $dataVenctoIni = $dataVenctoIniArr[2].'-'.$dataVenctoIniArr[1].'-'.$dataVenctoIniArr[0];
	   $dataVenctoFinalArr = explode("/",$data_vencto_final_exp);
	   $dataVenctoFinal = $dataVenctoFinalArr[2].'-'.$dataVenctoFinalArr[1].'-'.$dataVenctoFinalArr[0];
	   
	   $sql .=  "and (cnd_estadual.data_vencto between '$dataVenctoIni' and  '$dataVenctoFinal')";
	}

	$query = $this->db->query($sql, array($idContratante,$ativo));
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
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
 
   function listarInscricao($idContratante,$ativo){
	$this->db->distinct();
	$this -> db -> select('cnd_estadual.inscricao');
	$this -> db -> from('cnd_estadual'); 	
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);	
	$this -> db -> where('cnd_estadual.ativo', $ativo);	
	$this -> db -> order_by('cnd_estadual.inscricao');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarCidade($idContratante,$tipo,$ativo){
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id','left');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> where('cnd_estadual.ativo', $ativo);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();
	
	   if($query -> num_rows() <> 0) {
		 return $query->result();
	   } else{
		 return false;
	   }
   
  }
  
  function listarCnd($id_contratante,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja,usuarios.email');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','inner');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','inner');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','inner');
   $this -> db -> join('uf_link_sefaz','uf_link_sefaz.uf = loja.estado','left');
   $this -> db -> join('usuarios','usuarios.id = cnd_estadual.usuario_upload','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
   function listarCndTipoMun($id_contratante,$cidade,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cidade);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
 function listarCndTipoReg($id_contratante,$regional,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('loja.regional', $regional);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //int_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
   
  function listarCndTipoEst($id_contratante,$estado,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $estado);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
  
  function listarCndTipoId($id_contratante,$id){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('cnd_estadual.id', $id);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
 function contaCnd($id_contratante,$ano){
	 $sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total, `possui_cnd` FROM (`cnd_estadual`) 
	left JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	left JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
	left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
	 WHERE `cnd_estadual`.`id_contratante` = ? GROUP BY `cnd_estadual`.`possui_cnd` 
	 union select count(*) as total, '99' from loja l
	left JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
	left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	left JOIN `regional` ON `regional`.`id` = l.`regional` 
	left JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
	 where l.id not in (select id_loja from cnd_estadual) and l.id_contratante = ?";
	$query = $this->db->query($sql, array($id_contratante,$id_contratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function contaCndRegional($id_contratante,$ano,$tipo,$regional_id){
	if($tipo == 0){
		$sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total FROM (`cnd_estadual`) 
	left JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	left JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
	left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
	WHERE `cnd_estadual`.`id_contratante` = ? and regional.id = ?
	 ";
	$query = $this->db->query($sql, array($id_contratante,$regional_id));
	}elseif($tipo == 4){
		$sql = "select count(*) as total from loja
				left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
				left JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
				left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
				WHERE `loja`.`id_contratante` = ? and regional.id = ?
				and loja.id not in (select cnd_estadual.id_loja from cnd_estadual where cnd_estadual.id_contratante = ?)
		";
		$query = $this->db->query($sql, array($id_contratante,$regional_id,$id_contratante));
		//print_r($this->db->last_query());exit;
	}else{
		$sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total FROM (`cnd_estadual`) 
		left JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.possui_cnd = ? and regional.id = ?
		";
		$query = $this->db->query($sql, array($id_contratante,$tipo,$regional_id));
	}	 
	

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function somarTodos($idContratante,$cidade,$estado){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
     if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_estadual.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
  

}


?>