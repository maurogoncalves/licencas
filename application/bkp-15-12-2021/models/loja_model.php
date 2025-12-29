<?php
Class Loja_model extends CI_Model{
	
  function excluirFisicamente($id){

	$this->db->where('id', $id);
	$this->db->delete('loja'); 
	return true;

 } 
 
 function contarCndByEstado($id_contratante,$estado ){
    $sql = "SELECT loja.estado,emitente.cpf_cnpj, emitente.nome_fantasia,loja.ins_cnd_mob,loja.cidade, c.possui_cnd,DATE_FORMAT(c.data_emissao,'%d/%m/%Y') as emissao_br	,
	DATE_FORMAT(c.data_pendencias,'%d/%m/%Y') as pendencia_br,c.id as id_cnd,(select sum(cmob.valor_pendencia)  from cnd_mob_tratativa cmob where cmob.id_cnd_mob = c.`id` and status_chamado_sis_ext <> 2) as valor_total  FROM `loja` LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  left join cnd_mobiliaria c on c.id_loja = loja.id WHERE `loja`.`id_contratante` = ? and loja.estado = ? and c.ativo = 0  order by loja.cidade";
	$query = $this->db->query($sql, array($id_contratante,$estado));   
	$array = $query->result();    
	return($array);
 }
 
  function contarCndByEst($id_contratante,$estado ){

	if($estado <> 'BR'){
		$sql = "select cn.id,l.estado,l.cidade,l.cnpj,n.descricao_natureza_raiz,DATE_FORMAT(cnt.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext	,DATE_FORMAT(cnt.data_inclusao_sis_ext,'%m') as mes_vencto,DATE_FORMAT(cnt.data_inclusao_sis_ext,'%Y') as ano_vencto from cnd_mob_tratativa cnt left join cnd_mobiliaria cn on cnt.id_cnd_mob = cn.id left join loja l on l.id = cn.id_loja left join natureza_raiz n on n.codigo = cnt.id_natureza_raiz where l.estado=? and l.id_contratante = ?  order by l.cidade";
		$query = $this->db->query($sql, array($estado,$id_contratante));   
	}else{
		$sql = "select cn.id,l.estado,l.cidade,l.cnpj,n.descricao_natureza_raiz,DATE_FORMAT(cnt.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext	,DATE_FORMAT(cnt.data_inclusao_sis_ext,'%m') as mes_vencto,DATE_FORMAT(cnt.data_inclusao_sis_ext,'%Y') as ano_vencto  from cnd_mob_tratativa cnt left join cnd_mobiliaria cn on cnt.id_cnd_mob = cn.id left join loja l on l.id = cn.id_loja left join natureza_raiz n on n.codigo = cnt.id_natureza_raiz where l.id_contratante = ?  order by l.cidade";
		$query = $this->db->query($sql, array($id_contratante));   

	}	
    //print_r($this->db->last_query());
	$array = $query->result();    
	return($array);
 }
 
 
  function contarCndByEstadoVencto($id_contratante,$estado,$dataIni,$dataFim ){
	  
	 if($estado == '0') {
		$sql = "SELECT emitente.nome_fantasia,loja.ins_cnd_mob,loja.cidade, c.possui_cnd,DATE_FORMAT(c.data_emissao,'%d/%m/%Y') as emissao_br	,
		DATE_FORMAT(c.data_pendencias,'%d/%m/%Y') as pendencia_br, DATE_FORMAT(c.data_vencto,'%d/%m/%Y') as data_vencto_br FROM `loja` LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  left join cnd_mobiliaria c on c.id_loja = loja.id WHERE `loja`.`id_contratante` = ? and c.ativo = 0  and c.data_vencto between ? and ? order by data_vencto,loja.cidade";
		$query = $this->db->query($sql, array($id_contratante,$dataIni,$dataFim));    
	 }else{
		$sql = "SELECT emitente.nome_fantasia,loja.ins_cnd_mob,loja.cidade, c.possui_cnd,DATE_FORMAT(c.data_emissao,'%d/%m/%Y') as emissao_br	,
		DATE_FORMAT(c.data_pendencias,'%d/%m/%Y') as pendencia_br, DATE_FORMAT(c.data_vencto,'%d/%m/%Y') as data_vencto_br FROM `loja` LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  left join cnd_mobiliaria c on c.id_loja = loja.id WHERE `loja`.`id_contratante` = ? and loja.estado = ? and c.ativo = 0 and c.data_vencto between ? and ?  order by loja.cidade";
		$query = $this->db->query($sql, array($id_contratante,$estado,$dataIni,$dataFim));    
	 }
	$array = $query->result();    
	return($array);
 }
 
  function contarCndByStatusVencto($id_contratante,$estado,$status ){
	  
	if($estado == 'BR'){
		$sql = "SELECT count(*) as total,c.possui_cnd FROM `loja` LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  left join cnd_mobiliaria c on c.id_loja = loja.id WHERE `loja`.`id_contratante` = ? and c.ativo = 0  and c.possui_cnd =?";
		$query = $this->db->query($sql, array($id_contratante,$status));    
	}else{
		$sql = "SELECT count(*) as total,c.possui_cnd FROM `loja` LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  left join cnd_mobiliaria c on c.id_loja = loja.id WHERE `loja`.`id_contratante` = ? and loja.estado = ? and c.ativo = 0  and c.possui_cnd =?";
		$query = $this->db->query($sql, array($id_contratante,$estado,$status));   
	}	 
    
	
	$array = $query->result();    
	//print_r($this->db->last_query());exit;
	return($array);
 }
 
 function contarCndByStatus($id_contratante,$estado,$status ){
	 
	 if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $tabela = "cnd_mobiliaria";
	 }else{
		 $tabela = "cnd_federal";
	 }	
	 
	if($estado == 'BR'){
		$sql = "SELECT count(*) as total,c.possui_cnd FROM `loja` LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  left join ".$tabela." c on c.id_loja = loja.id WHERE `loja`.`id_contratante` = ? and c.ativo = 0  and c.possui_cnd =?";
		$query = $this->db->query($sql, array($id_contratante,$status));    
	}else{
		$sql = "SELECT count(*) as total,c.possui_cnd FROM `loja` LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`  left join ".$tabela." c on c.id_loja = loja.id WHERE `loja`.`id_contratante` = ? and loja.estado = ? and c.ativo = 0  and c.possui_cnd =?";
		$query = $this->db->query($sql, array($id_contratante,$estado,$status));   
	}	 
    
	
	$array = $query->result();    
	//print_r($this->db->last_query());exit;
	return($array);
 }
 
  function listarLoja($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){
   if($cidade){
   $sql = "SELECT `loja`.*, `emitente`.`nome_fantasia` as razao_social, `emitente`.`cpf_cnpj`, `tipo_emitente`.`descricao`, `emitente`.`nome_resp`, `possui_cnd` as cnd, `cnd_mobiliaria`.`id` as id_cnd, `bandeira`.`descricao_bandeira` as bandeira, `cnd_mobiliaria`.`data_vencto`, `cnd_mobiliaria`.`data_pendencias` FROM (`loja`) JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente`
 JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
  LEFT JOIN `cnd_mobiliaria` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`
  WHERE `loja`.`id_contratante` = ?
  AND (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) 
  and `loja`.`cidade` = ? and `loja`.`estado` = ?
 ORDER BY `emitente`.`nome_fantasia` limit $_start,$_limit ";
 $query = $this->db->query($sql, array($id_contratante,$cidade,$estado));

   }else{
   $sql = "SELECT `loja`.*, `emitente`.`nome_fantasia` as razao_social, `emitente`.`cpf_cnpj`, `tipo_emitente`.`descricao`, `emitente`.`nome_resp`, `possui_cnd` as cnd, `cnd_mobiliaria`.`id` as id_cnd, `bandeira`.`descricao_bandeira` as bandeira, `cnd_mobiliaria`.`data_vencto`, `cnd_mobiliaria`.`data_pendencias` FROM (`loja`) JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente`
 JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
  LEFT JOIN `cnd_mobiliaria` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`
  WHERE `loja`.`id_contratante` = ?
  AND (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) 
 ORDER BY `emitente`.`nome_fantasia` limit $_start,$_limit";
 $query = $this->db->query($sql, array($id_contratante));

   }
      
   
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
 function buscaCNDEstById($id_loja){
    $sql = "SELECT  id,possui_cnd from cnd_estadual where id_loja = ? ";

   $query = $this->db->query($sql, array($id_loja));
   
   $array = $query->result_array(); 
   return($array);
   
   $query = $this -> db -> get();
	
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaInscricaoCSV($id_loja){
    $sql = "SELECT  inscricao from cnd_estadual where id_loja = ? ";

   $query = $this->db->query($sql, array($id_loja));
	
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
  function buscaCNDEstByIdCSV($id_loja){
    $sql = "SELECT  id,possui_cnd,inscricao from cnd_estadual where id_loja = ? ";

   $query = $this->db->query($sql, array($id_loja));
   
   $array = $query->result_array(); 
   return($array);
   


 }
 
  function buscaCNDMobById($id_loja){
    $sql = "SELECT  count(*)as total,id,possui_cnd,data_vencto,data_pendencias from cnd_mobiliaria where id_loja = ? ";

   $query = $this->db->query($sql, array($id_loja));
   
   $array = $query->result_array(); 
   return($array);
   


 }
  function listarTodasLoja($id_contratante ){
	  
	$sql = "SELECT `loja`.*,  `bandeira`.`descricao_bandeira`,regional.descricao as bandeira  FROM (`loja`)   
	left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`   
	left JOIN `regional` ON `regional`.`id` = `loja`.`regional`  
	WHERE `loja`.`id_contratante` = ?   ORDER BY loja.nome_loja;";	
	$query = $this->db->query($sql, array($id_contratante));
	
    $array = $query->result();    
	
	return($array);   
 }
 
 function listarAcomp($idContratante,$id){
$sql = "select loja.id as id_loja,emitente.nome_fantasia,emitente.cpf_cnpj,acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao,acomp_cnd.arquivo,projetos_acomp_cnd.descricao as proj_desc,
				tipo_debito.descricao as desc_tipo_deb 
				from loja left join acomp_cnd on loja.id = acomp_cnd.id_loja
				left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
				left join tipo_debito on tipo_debito.id = acomp_cnd.tipo_debito
				where loja.id_contratante = ? and loja.id = ? ";

   $query = $this->db->query($sql, array($idContratante,$id));
	   
   $array = $query->result(); 
   return($array);
 }
 
 function listarAcompById($id_acomp,$id_loja){
$sql = "select loja.id as id_loja,emitente.nome_fantasia,emitente.cpf_cnpj,acomp_cnd.id as id_acomp, emitente.id as id_emitente, emitente.nome_fantasia,loja.cidade,loja.ins_cnd_mob, 
				areas_acomp_cnd.id as id_area,etapa_sub_area.sigla as sigla_sub_area,etapa_sub_area.nome as nome_etapa, acomp_cnd.tipo_debito,acomp_cnd.data_envio,acomp_cnd.sla,emitente.cpf_cnpj,
				DATE_FORMAT(acomp_cnd.entrada_cadin,'%d/%m/%Y') as entrada_cadin_br	,
				DATE_FORMAT(acomp_cnd.data_envio,'%d/%m/%Y') as data_envio_br,acomp_cnd.tipo_acomp,acomp_cnd.obs,acomp_cnd.id_subarea,acomp_cnd.id_etapa,areas_acomp_cnd.nome_area,acomp_cnd.id_subarea,acomp_cnd.id_etapa,tipo_acomp.descricao,subarea.id_subarea,tipo_acomp.id as id_tipo_acomp,acomp_cnd.arquivo,projetos_acomp_cnd.descricao as proj_desc,projetos_acomp_cnd.id as id_proj					
				from loja left join acomp_cnd on loja.id = acomp_cnd.id_loja
				left join subarea on subarea.id_subarea = acomp_cnd.id_subarea
				left join areas_acomp_cnd on areas_acomp_cnd.id = subarea.id_area
				left join etapa_sub_area on acomp_cnd.id_etapa = etapa_sub_area.id_etapa
				left join emitente on loja.id_emitente = emitente.id  
				left join tipo_acomp on acomp_cnd.tipo_acomp = tipo_acomp.id
				left join projetos_acomp_cnd on projetos_acomp_cnd.id = acomp_cnd.id_projeto
				where acomp_cnd.id = ? and loja.id = ? ";

   $query = $this->db->query($sql, array($id_acomp,$id_loja));
	   
   $array = $query->result(); 
   return($array);
 }
 function listarEstado($id_contratante){
	$this->db->distinct();
	$this -> db -> select('estado as uf');
	$this -> db -> from('loja'); 
	$this -> db -> where('loja.id_contratante', $id_contratante);
	$this -> db -> order_by('loja.estado');
	$query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarCidade($id_contratante){
	$this->db->distinct();
	$this -> db -> select('cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> where('loja.id_contratante', $id_contratante);
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
    function listarTodasLojas($id_contratante){
		$sql = "SELECT `loja`.*,  `bandeira`.`descricao_bandeira`,regional.descricao as bandeira  FROM (`loja`)   JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`   JOIN `regional` ON `regional`.`id` = `loja`.`regional`   WHERE `loja`.`id_contratante` = ?  ORDER BY loja.nome_loja;";
		$query = $this->db->query($sql, array($id_contratante));
		
		$array = $query->result(); 
		return($array);
	}
 
 
    function listarTodasLojasSemCndEstadual($id_contratante){
		$sql = "SELECT `loja`.*, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj
				FROM (`loja`) 
				JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
				JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 				
				WHERE `loja`.`id_contratante` = ? 
				AND (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 15) 
				and loja.id not in (select id_loja from cnd_estadual where id_contratante = ?) 	ORDER BY `emitente`.`nome_fantasia`;";
   $query = $this->db->query($sql, array($id_contratante,$id_contratante));
	   
   $array = $query->result(); 
   return($array);
 }
 
 
 
  function buscaInscricao($inscricao,$emitente){
	 $this -> db -> select('count(*) as total');
	 $this -> db -> from('loja');
	 $this -> db -> where('loja.ins_cnd_mob', $inscricao);
	 $this -> db -> where('loja.id_emitente', $emitente);
	 $query = $this -> db -> get(); 
	 
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return false;
	}
  }
  
  function listarLojaById($id_loja){
   $this -> db -> select('loja.*');
   $this -> db -> from('loja');
   $this -> db -> where('loja.id', $id_loja);
 
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
 
   function listarCidadeEstadoLojaById($id_loja){
   $this -> db -> select('loja.id,loja.cidade,loja.estado');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('loja.id', $id_loja);
 
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
 
  
   function listarCidadeEstadoLojaByIdLic($id){
   $this -> db -> select('loja.id,loja.cidade,loja.estado');
   $this -> db -> from('loja');
   $this -> db -> join('lojas_licencas','lojas_licencas.id_loja = loja.id');
   $this -> db -> where('lojas_licencas.id_licenca', $id);
 
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
 function listarLicencaLoja($id_loja,$id_licenca){
	/*
   $this -> db -> select('emitente.nome_fantasia,emitente.cpf_cnpj,loja.ins_cnd_mob,tipo_licenca_taxa.descricao as desc_licenca,lojas_licencas.*,DATE_FORMAT(lojas_licencas.entrada_cadin,"%d/%m/%Y") as entrada_cadin_br');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('lojas_licencas','lojas_licencas.id_loja = loja.id');
   $this -> db -> join('tipo_licenca_taxa','tipo_licenca_taxa.id = lojas_licencas.tipo_licenca_taxa');
   $this -> db -> where('loja.id', $id_loja);
 */
   if($id_licenca == 0){
   $sql = "SELECT emitente.nome_fantasia,emitente.cpf_cnpj,loja.ins_cnd_mob,tipo_licenca_taxa.descricao as desc_licenca,lojas_licencas.*,
	DATE_FORMAT(lojas_licencas.data_vencimento,'%d/%m/%Y') as data_vencimento_br,loja.id as id_loja FROM (`loja`) 
	left join emitente on emitente.id = loja.id_emitente
	left JOIN `lojas_licencas` ON `lojas_licencas`.`id_loja` = `loja`.`id`
	left join tipo_licenca_taxa on tipo_licenca_taxa.id = lojas_licencas.tipo_licenca_taxa
	 WHERE `loja`.`id` = ?
	";
	$query = $this->db->query($sql, array($id_loja));
   }else{
   $sql = "SELECT emitente.nome_fantasia,emitente.cpf_cnpj,loja.ins_cnd_mob,tipo_licenca_taxa.descricao as desc_licenca,lojas_licencas.*,
	DATE_FORMAT(lojas_licencas.data_vencimento,'%d/%m/%Y') as data_vencimento_br,loja.id as id_loja FROM (`loja`) 
	left join emitente on emitente.id = loja.id_emitente
	left JOIN `lojas_licencas` ON `lojas_licencas`.`id_loja` = `loja`.`id`
	left join tipo_licenca_taxa on tipo_licenca_taxa.id = lojas_licencas.tipo_licenca_taxa
	 WHERE `loja`.`id` = ? and lojas_licencas.id_licenca = ?
	";
	$query = $this->db->query($sql, array($id_loja,$id_licenca));
   }
   
   
   if($query -> num_rows() <> 0){
     return $query->result();
   } else {
     return false;
   }
   
 }
 
 function listarLojaByTipo($idContratante,$tipo){
   $this -> db -> select('loja.id,emitente.nome_fantasia');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('emitente.tipo_emitente', $tipo);
   $this -> db -> where('loja.id_contratante', $idContratante);
   $this -> db -> order_by('emitente.nome_fantasia');

   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarTodosEmitentes($id_contratante){
   $this -> db -> select('emitente.id,emitente.nome_fantasia');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente'); 
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);   
   $this -> db -> or_where('emitente.tipo_emitente', 15);   
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){

     return $query->result();

   } else {

     return false;

   }

 }
 
 function listarEmitentes($id_contratante){
$sql = "SELECT `emitente`.`id`, `emitente`.`nome_fantasia`  FROM (`emitente`) JOIN `tipo_emitente`  ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		WHERE `id_contratante` = ?  and (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 15)
		and emitente.id not in (select id_emitente from loja) order by `emitente`.`nome_fantasia` ";

	$query = $this->db->query($sql, array($id_contratante));
   /*
   $this -> db -> select('emitente.id,emitente.nome_fantasia');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente'); 
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);   
   $this -> db -> or_where('emitente.tipo_emitente', 15);   
   $query = $this -> db -> get();
   */
   
   if($query -> num_rows() <> 0){

     return $query->result();

   } else {

     return false;

   }

 }
 
  function buscaEmitenteByCidade($idContratante,$id){

   $this -> db -> distinct();
   $this -> db -> select('emitente.id,emitente.nome_fantasia');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente.id_contratante', $idContratante);
   
   $this -> db -> where('imovel.cidade', $id);

   
   $this -> db -> order_by('imovel.cidade');
  
   $query = $this -> db -> get();
    //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaEmitente($idContratante,$id){

   $this -> db -> distinct();
   $this -> db -> select('emitente.id,emitente.nome_fantasia');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente.id_contratante', $idContratante);
   
   $this -> db -> where('imovel.estado', $id);

   
   $this -> db -> order_by('imovel.cidade');
   
   $query = $this -> db -> get();
   

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCidade($idContratante,$id,$ativo){

   $this -> db -> distinct();
   $this -> db -> select('loja.cidade');
   $this -> db -> from('loja');
   $this -> db -> where('loja.estado', $id);
   $this -> db -> order_by('loja.cidade');
  
   $query = $this -> db -> get();
	
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCidadeImByEstado($idContratante,$id){
	
   $this -> db -> distinct();
   $this -> db -> select('id,upper(uf) as uf,upper(nome) as nome');
   $this -> db -> from('cidades');      
   $this -> db -> where('cidades.uf', $id);
   $this -> db -> order_by('cidades.nome');
  
   $query = $this -> db -> get();
	
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCidadeByEstadoTipo($idContratante,$id,$tipo){
    $sql = "
	SELECT  distinct loja.cidade as cidade
	from loja
	left join emitente on emitente.id = loja.id_emitente
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and `emitente`.`tipo_emitente` = ? 
	ORDER BY `loja`.`cidade`
	 ";

   $query = $this->db->query($sql, array($idContratante, $id,$tipo));
   
   $array = $query->result_array(); 
   return($array);
   
   

 }
 
 function buscaLojaByEstadoTipo($idContratante,$id,$tipo){
    $sql = "
	SELECT  loja.id,emitente.nome_fantasia
	from loja
	left join emitente on emitente.id = loja.id_emitente
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`estado` = ? 
	and `emitente`.`tipo_emitente` = ? 
	ORDER BY `loja`.`cidade`
	 ";

   $query = $this->db->query($sql, array($idContratante, $id,$tipo));
   
   $array = $query->result_array(); 
   return($array);
   
   

 }
 
 function buscaLojaByCidadeTipo($idContratante,$id,$tipo){
    $sql = "
	SELECT  loja.id,emitente.nome_fantasia
	from loja
	left join emitente on emitente.id = loja.id_emitente
	WHERE `loja`.`id_contratante` = ? 
	AND `loja`.`cidade` = ? 
	and `emitente`.`tipo_emitente` = ? 
	ORDER BY `loja`.`cidade`
	 ";

   $query = $this->db->query($sql, array($idContratante, $id,$tipo));
   
   $array = $query->result_array(); 
   return($array);
   
   

 }
 
 function buscaLojaByEstado($idContratante,$id,$status,$tabela){	
	$sql = "SELECT `loja`.*,  `bandeira`.`descricao_bandeira`,regional.descricao as bandeira  FROM (`loja`)   
	LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`  LEFT JOIN `regional` ON `regional`.`id` = `loja`.`regional`   
	WHERE `loja`.`id_contratante` = ?  AND `loja`.`estado` = ? ORDER BY loja.nome_loja;";
	$query = $this->db->query($sql, array($idContratante, $id));	
	//print_r($this->db->last_query());exit;
	$array = $query->result(); 
	return($array);
 }
 
 function buscaLojaByBandeira($idContratante,$id,$estado,$municipio,$imovel){
	
    $sql = "
	SELECT `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
	JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
	WHERE `loja`.`id_contratante` = ? 	
	 ";
	
	if($imovel <> '0'){
		$sql .= 'AND `loja`.`bandeira` = ? AND `loja`.`id` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) ORDER BY `emitente`.`nome_fantasia`';
		$query = $this->db->query($sql, array($idContratante, $id,$imovel));	
	}else{
		if($municipio <> '0'){
			$sql .= 'AND `loja`.`bandeira` = ? AND `loja`.`cidade` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id,$municipio));		
		}elseif($estado <> '0'){
			$sql .= 'AND `loja`.`bandeira` = ?  AND `loja`.`estado` = ? 
			and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
			ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id,$estado));
		}else{
			$sql .= 'AND `loja`.`bandeira` = ? 
			and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
			ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id));
 
		}
	}
	
   
  
   $array = $query->result_array(); 
   return($array);
   


 }
 
 function buscaLojaStatus($idContratante,$status){
	 
	 if($status == 4){
		
		$sql = "SELECT distinct `loja`.*, loja.id as id_loja,99 as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,'Nada Consta' as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 )
		and loja.id not in (select id_loja from cnd_mobiliaria where id_contratante = ?)
		ORDER BY `emitente`.`nome_fantasia`
		 ";
		$query = $this->db->query($sql, array($idContratante, $idContratante));
	}else if($status == 0){
		 
		 $sql = "SELECT distinct `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
		ORDER BY `emitente`.`nome_fantasia`
		 ";
		$query = $this->db->query($sql, array($idContratante, $status));
			
	}else{
		
		$sql = "SELECT distinct `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 
		and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
		and cnd_mobiliaria.possui_cnd = ?
		ORDER BY `emitente`.`nome_fantasia`
		 ";
			$query = $this->db->query($sql, array($idContratante, $status));
	}
    

   
   
  $array = $query->result(); 
   return($array);
	 
 }	 
 function buscaLojaByStatus($idContratante,$id,$estado,$municipio,$imovel){
	
	if($id == 4){	
		$sql = "
		SELECT `loja`.*, loja.id as id_loja,loja.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,4 as cnd FROM (`loja`) 
		JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? 	and loja.id not in (select id_loja from cnd_mobiliaria)
		 ";
	
		if($imovel <> '0'){
			$sql .= 'AND `loja`.`id` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $imovel));	
		}else{
			if($municipio <> '0'){
				$sql .= 'AND `loja`.`cidade` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $municipio));		
			}elseif($estado <> '0'){
				$sql .= 'AND `loja`.`estado` = ? and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $estado));
			}else{
				$sql .= ' and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante));
	 
			}
		}
	
	}else{
		
		$sql = "
		SELECT `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
		JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
		WHERE `loja`.`id_contratante` = ? 	
		 ";
	
		if($imovel <> '0'){
			$sql .= 'AND `cnd_mobiliaria`.`possui_cnd` = ? AND `loja`.`id` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) ORDER BY `emitente`.`nome_fantasia`';
			$query = $this->db->query($sql, array($idContratante, $id,$imovel));	
		}else{
			if($municipio <> '0'){
				$sql .= 'AND `cnd_mobiliaria`.`possui_cnd` = ? AND `loja`.`cidade` = ?   and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7) ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $id,$municipio));		
			}elseif($estado <> '0'){
				$sql .= 'AND `cnd_mobiliaria`.`possui_cnd`= ?  AND `loja`.`estado` = ? 
				and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
				ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $id,$estado));
			}else{
				$sql .= ' AND `cnd_mobiliaria`.`possui_cnd`= ? 
				and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7)
				ORDER BY `emitente`.`nome_fantasia`';
				$query = $this->db->query($sql, array($idContratante, $id));
	 
			}
		}
	
	}
    

  
   $array = $query->result_array(); 
   return($array);
   


 }
 function buscaLojaSemCndEst($idContratante){
	$sql = "SELECT distinct `loja`.*, loja.id as id_loja,cnd_mobiliaria.id as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,possui_cnd as cnd FROM (`loja`) 
	left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	LEFT JOIN cnd_mobiliaria ON cnd_mobiliaria.id_loja = loja.id
	WHERE `loja`.`id_contratante` = ? 	
	and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 ) 
	AND `loja`.`id` not in (select id_loja from cnd_estadual where id_contratante = ?) 
	ORDER BY `emitente`.`nome_fantasia`
	 ";
	$query = $this->db->query($sql, array($idContratante,$idContratante));
	$array = $query->result(); 
   return($array);
		
 }	 
 function buscaLojaById($idContratante,$id,$status,$tabela){
	 
	$sql = "SELECT `loja`.*,  `bandeira`.`descricao_bandeira`,regional.descricao as bandeira  FROM (`loja`)   
	LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`  LEFT JOIN `regional` ON `regional`.`id` = `loja`.`regional`   
	WHERE `loja`.`id_contratante` = ?  AND `loja`.`id` = ? ORDER BY loja.nome_loja;";	
	$query = $this->db->query($sql, array($idContratante, $id));
	$array = $query->result(); 
	return($array);   
 }
 
 function buscaLojaByCidade($idContratante,$id,$status,$tabela){	
	$sql = "SELECT `loja`.*,  `bandeira`.`descricao_bandeira`,regional.descricao as bandeira  FROM (`loja`)   
	LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` LEFT  JOIN `regional` ON `regional`.`id` = `loja`.`regional`   
	WHERE `loja`.`id_contratante` = ?  AND `loja`.`cidade` = ? ORDER BY loja.nome_loja;";	
	$query = $this->db->query($sql, array($idContratante, $id)); 
	
	$array = $query->result(); 
	return($array);
 }
 
  function buscaLojaByCidadeEstadoFiltro($idContratante,$id,$estado){
	
	$sql = "SELECT distinct `loja`.*, loja.id as id_loja,99 as id_cnd, `emitente`.`nome_fantasia` as razao_social,emitente.cpf_cnpj,tipo_emitente.descricao as tipo_emitente,bandeira.descricao_bandeira,'Nada Consta' as cnd FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? AND `loja`.`cidade` = ? AND `loja`.`estado` = ? and (`emitente`.`tipo_emitente` = 2 OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 7 )
		ORDER BY `emitente`.`nome_fantasia` ";
	 $query = $this->db->query($sql, array($idContratante, $id));
    

   
   
  $array = $query->result(); 
   return($array);


 }
 
 function buscaLojaByCidadeFiltro($idContratante,$id){
	
	$sql = "SELECT distinct `loja`.*
		FROM (`loja`) 
		left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		WHERE `loja`.`id_contratante` = ? AND `loja`.`cidade` = ? 		";
	 $query = $this->db->query($sql, array($idContratante, $id));
    

   
   
  $array = $query->result(); 
   return($array);


 }
 
 function buscaCidades($idContratante){

   $this -> db -> distinct();
   $this -> db -> select('id,upper(uf) as uf,upper(nome) as nome');
   $this -> db -> from('cidades');   
   $this -> db -> order_by('nome');   
   $query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCnpj($idContratante,$imovel,$cidade,$estado,$ativo){

   $this -> db -> distinct();
   $this -> db -> select('emitente.cpf_cnpj');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');
   $this -> db -> join('loja','loja.id_emitente = emitente.id');
   $this -> db -> join('cnd_mobiliaria','loja.id = cnd_mobiliaria.id_loja');
   $this -> db -> where('emitente.id_contratante', $idContratante);
   $this -> db -> where('loja.id', $imovel);
   $this -> db -> where('loja.cidade', $cidade);
   $this -> db -> where('loja.estado', $estado);
   $this -> db -> where('cnd_mobiliaria.ativo', $ativo);
   /*
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);
   $this -> db -> or_where('emitente.tipo_emitente', 15);
   $this -> db -> order_by('emitente.cpf_cnpj');   
   */
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaEstado($idContratante){
   $this -> db -> distinct();
   $this -> db -> select('id,upper(uf) as uf,upper(nome) as nome');
   $this -> db -> from('estados');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
  function buscaCPFCNPJ($emitente){

   $this -> db -> select('*');

   $this -> db -> from('emitente');

   $this -> db -> where('emitente.id', $emitente);
   
   $query = $this -> db -> get();

  

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaImovel($emitente){

   $this -> db -> select('imovel.id,imovel.nome');

   $this -> db -> from('imovel');

   $this -> db -> join('emitente_imovel','imovel.id = emitente_imovel.id_imovel');

   $this -> db -> where('emitente_imovel.id_emitente', $emitente);

  
   $query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
		
     return $query->result();

   }else{

     return false;

   }

 }
 
  function listarEmitentesNaoInclusos($id_contratante,$idImovel){

  $this -> db -> select('group_concat(id_emitente) as ids');  
  $this -> db -> from('emitente_imovel');
  $this -> db -> where('id_imovel', $idImovel);
  
  $query = $this -> db -> get();
  
  
  if($query -> num_rows() <> 0){
     $array =  $query->result();
  }else{
    $array = 0;
   }
  
   $sql = "SELECT `emitente`.`id`, `emitente`.`razao_social` FROM (`emitente`) JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
			WHERE `id_contratante` = ?
			AND `emitente`.`id`  NOT IN 
			(select id_emitente from emitente_imovel where id_imovel = ?)";

   $query = $this->db->query($sql, array($id_contratante, $idImovel));
   $array = $query->result_array(); 
   return($array);
  
   

 }
 
 function somarTodos($idContratante,$cidade,$estado){
 
   $this -> db -> select('count(*) as total');
   $this -> db -> from('loja');
   $this -> db -> where('id_contratante', $idContratante);   
	  if($cidade){
			$this -> db -> where('loja.cidade', $cidade);
			$this -> db -> where('loja.estado', $estado);   
	   }
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
   
 }
 
  function buscaCnd($id_contratante,$cnpj){
	 
	$sql = "SELECT trim(loja.ins_cnd_mob) as ins_cnd_mob
		FROM (`cnd_mobiliaria`) 
		LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `loja`.`estado` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
		LEFT JOIN `usuarios` ON `usuarios`.`id` = `cnd_mobiliaria`.`usuario_upload` 
		WHERE `cnd_mobiliaria`.`id_contratante` = ? and emitente.cpf_cnpj=?";

	$query = $this->db->query($sql, array($id_contratante,$cnpj));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 function listarBandeiraById($id){
   $this -> db -> select('*');
   $this -> db -> from('bandeira');
   $this -> db -> where('id', $id);   
 
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
function listarBandeira(){
   $this -> db -> select('*');
   $this -> db -> from('bandeira');
 
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
 
function listarRegional(){
   $this -> db -> select('*');
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
 
  function listarImovelById($id){
   $this -> db -> select('*');
   $this -> db -> from('imovel');
   $this -> db -> where('imovel.id', $id);   

   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarEmitenteById($id_contratante,$id){
   $this -> db -> select('emitente.*');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> where('emitente.id', $id);   

 
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
 
 function listarLojaCsv($id_contratante,$id_status){
 if($id_status == 0){
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante); 
   $this -> db -> order_by('loja.id');
   $query = $this -> db -> get();
 }else if($id_status == 4){
   $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.id not in (select id_loja from cnd_mobiliaria)');  
    $this -> db -> order_by('loja.id');
   $query = $this -> db -> get(); 
 }else{
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> join('regional','regional.id = loja.regional');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('cnd_mobiliaria.possui_cnd', $id_status);
   $query = $this -> db -> get(); 
 }
   
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 
  function listarLojaCsvEst($id_contratante,$est,$id_status){
  if($id_status == 0){
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $est);
   $this -> db -> order_by('loja.id');
   $query = $this -> db -> get();
  }else if($id_status == 4){
	  
	   $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $est);
   $this -> db -> where('loja.id not in (select id_loja from cnd_mobiliaria)'); 
	$this -> db -> order_by('loja.id');   
   $query = $this -> db -> get();
	  
  }else{
	  
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $est);
   $this -> db -> where('cnd_mobiliaria.possui_cnd', $id_status);
   $query = $this -> db -> get();
  }
	  
 
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 function listarLojaCsvById($id_contratante,$id){
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.id', $id);
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 function listarLojaCsvByEmitente($id_contratante,$id){
  $this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> join('regional','regional.id = loja.regional');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.id_emitente', $id);
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarLojaCsvMun($id_contratante,$cid,$id_status){
	 
   if($id_status == 0){
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cid);
   $this -> db -> order_by('loja.id');   
   }else if($id_status == 4){
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,bandeira.descricao_bandeira,');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cid);         
   $this -> db -> where('loja.id not in (select id_loja from cnd_mobiliaria)');  
   $this -> db -> order_by('loja.id');   
   }else{
	$this -> db -> select('loja.*,loja.id as id_loja,emitente.nome_fantasia as nome,emitente.cpf_cnpj,tipo_emitente.descricao,emitente.nome_resp,ins_cnd_mob as cnd,regional.descricao as regional,cnd_mobiliaria.possui_cnd,bandeira.descricao_bandeira,cnd_mobiliaria.data_vencto,cnd_mobiliaria.data_pendencias');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente','left');
   $this -> db -> join('regional','regional.id = loja.regional','left');
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id','left');
   $this -> db -> where('loja.id_contratante', $id_contratante);
    $this -> db -> where('cnd_mobiliaria.possui_cnd', $id_status);
   $this -> db -> where('loja.cidade', $cid);
   }
   
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 function excluir($id){
 
	$data = array('ativo' => 2);

	$this->db->where('id', $id);
	$this->db->update('loja', $data); 
	
	return true;
  
 } 
 
 function excluir_loja_licenca($id){
 
	$this->db->delete('lojas_licencas', array('id_licenca' => $id));
	
	return true;
  
 } 
 
  function ativar($id){
 
	$data = array('ativo' => 1);

	$this->db->where('id', $id);
	$this->db->update('loja', $data); 
	
	return true;
  
 }
 
 function atualizar($dados,$id){ 
	$this->db->where('id', $id);
	$this->db->update('loja', $dados); 
		//print_r($this->db->last_query());exit;
	return true;  
 } 
 
 function atualizar_arquivo_acomp($dados,$id,$loja){ 
	$this->db->where('id', $id);
	$this->db->where('id_loja', $loja);
	$this->db->update('acomp_cnd', $dados); 
		
	return true;  
 } 

 function atualiza_licenca($dados,$id){
	$this->db->where('id_licenca', $id);
	$this->db->update('lojas_licencas', $dados); 
		
	return true;
 } 
 
 function verificaCPF($cpf,$tipo_pessoa){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('cpf_cnpj', $cpf);
   $this -> db -> where('tipo_pessoa', $tipo_pessoa);

 
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
 
 function verificaEmail($email){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('email_resp', $email);
   

 
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
 
	if($this->db->insert('loja', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}
	
 public function addCnd($detalhes = array()){
 
	if($this->db->insert('cnd_mobiliaria', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	

 public function addCndEst($detalhes = array()){
 
	if($this->db->insert('cnd_estadual', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	

 public function addCndFed($detalhes = array()){
 
	if($this->db->insert('cnd_federal', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}		
 public function add_licenca($detalhes = array()){
 
	if($this->db->insert('lojas_licencas', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	
}
?>