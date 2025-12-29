<?php


Class Cnd_Mobiliaria_model extends CI_Model{

	function excluirFisicamente($id){
		$this->db->where('id', $id);
		$this->db->delete('cnd_mobiliaria'); 
		return true;
	 } 
	 
  function contaCndMob($id_contratante,$status){
	 
	$sql = "SELECT count(*) as total  FROM (`cnd_mobiliaria`) 	WHERE `cnd_mobiliaria`.`id_contratante` = ? and cnd_mobiliaria.`possui_cnd` = ? and ativo = 0";
	$query = $this->db->query($sql, array($id_contratante,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 function listarArquivosMobiliaria($id){ 
	$sql = "select arquivo from arquivo_tratativas a where a.id_tratativas = ? and modulo = 1";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function buscarTratativas($id){ 
	$sql = "select c.id,c.pendencia,c.status_demanda,DATE_FORMAT(data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia from cnd_mob_tratativa c where c.id_cnd_mob = ? and c.modulo = 1 order by id asc limit 2 "; 
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function buscarObservacoes($id){ 
	$sql = "select observacao from cnd_mob_tratativa_obs c where c.id_cnd_trat = ?"; 
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function contaCndMobByUf($id_contratante,$status,$estado){
	$sql = "SELECT count(*) as total FROM (`cnd_mobiliaria`) 
			left join loja on loja.id = cnd_mobiliaria.id_loja
			WHERE `cnd_mobiliaria`.`id_contratante` = ? and cnd_mobiliaria.`possui_cnd` = ? and loja.estado  = ? and cnd_mobiliaria.ativo = 0";
		$query = $this->db->query($sql, array($id_contratante,$status,$estado));
	
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function listarEstado($idContratante,$tipo,$status){
	$this->db->distinct();
	$this -> db -> select('loja.estado as uf');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	 if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
		$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
		if($tipo <> 'X'){
			$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
		}
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
		$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);
		if($tipo <> 'X'){
			$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
		}
	 }else{
		 $this -> db -> join('cnd_federal','cnd_federal.id_loja = loja.id');
		$this -> db -> where('cnd_federal.id_contratante', $idContratante);
		if($tipo <> 'X'){
			$this -> db -> where('cnd_federal.possui_cnd', $tipo);
		}
	 }	
	 
	
	
	$this -> db -> where('loja.ativo', $status);
	
	$this -> db -> order_by('loja.estado');
	$query = $this -> db -> get();
	//print_r($this->db->last_query());exit;

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function listarCnpj($idContratante,$status){
	$this->db->distinct();
	$this -> db -> select('emitente.cpf_cnpj as cnpj');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	
	if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
		$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
		$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);
	 }else{
		$this -> db -> join('cnd_federal','cnd_federal.id_loja = loja.id');
		$this -> db -> where('cnd_federal.id_contratante', $idContratante);
	 }	
	 

	
	$this -> db -> where('loja.ativo', $status);	
	$this -> db -> order_by('emitente.cpf_cnpj');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function listarImovel($idContratante){
	$this->db->distinct();
	$this -> db -> select('imovel.id,imovel.nome');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
	$this -> db -> join('emitente_imovel','emitente_imovel.id_emitente = emitente.id');
	$this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');
	
	$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);	
	$this -> db -> order_by('imovel.nome');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function listarInscricao($idContratante,$status){
	$this->db->distinct();
	$this -> db -> select('trim(loja.ins_cnd_mob) as ins_cnd_mob');
	$this -> db -> from('loja'); 
	$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
	$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);	
	$this -> db -> where('loja.ativo', $status);	
	//$this -> db -> order_by('loja.ins_cnd_mob');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
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
  
    function listarCidade($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
	$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarChamados($id_contratante){	 
	$sql = "SELECT data_envio,data_retorno,arquivo_envio,arquivo_retorno FROM  chamados_big WHERE `id_contratante` = ? order by data_envio ";	
	$query = $this->db->query($sql, array($id_contratante));
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return 0;
	}

 }
 
  function listarChamadosByData($data){	 
	$sql = "SELECT count(*) as tem,id FROM  chamados_big WHERE  data_envio = ?";	
	$query = $this->db->query($sql, array($data));
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return 0;
	}
 }
 


  function listarCndPendencia($id_contratante,$pendencia,$cnpj,$estado,$area_focal,$valor_pendencia){
	 
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
	 
	$sql = "SELECT area_focal.descricao_area_focal,natureza_raiz.descricao_natureza_raiz,cnd_mob_tratativa.id,cnd_mob_tratativa.area_focal,cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio, '%d/%m/%Y') as data_envio,emitente.cpf_cnpj,
			(select DATE_FORMAT(data_hora, '%d/%m/%Y %H:%i')  from cnd_mob_tratativa_obs where id_cnd_trat = cnd_mob_tratativa.id order by id desc limit 1) as data_observacao,
			(select observacao  from cnd_mob_tratativa_obs where id_cnd_trat = cnd_mob_tratativa.id order by id desc limit 1) as observacao,$tabela.id as id_cnd,loja.estado,
			cnd_mob_tratativa.valor_pendencia,(select sum(c.valor_pendencia)  from cnd_mob_tratativa c where c.id_cnd_mob = $tabela.id and status_chamado_sis_ext <> 2) as valor_total
			FROM  cnd_mob_tratativa left join $tabela on cnd_mob_tratativa.id_cnd_mob = $tabela.id 
			LEFT JOIN `loja` ON $tabela.`id_loja` = `loja`.`id` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			LEFT JOIN natureza_raiz on cnd_mob_tratativa.id_natureza_raiz = natureza_raiz.codigo 
			LEFT JOIN area_focal on cnd_mob_tratativa.id_area_focal = area_focal.codigo 
			WHERE $tabela.`id_contratante` = ? and status_chamado_sis_ext <> 2 and `$tabela`.`ativo` = 0  and cnd_mob_tratativa.modulo = $modulo";
			
	if($pendencia <> '1'){
		$sql .= " and cnd_mob_tratativa.id_natureza_raiz = $pendencia " ;		
	}
	if($cnpj <> '0'){
		$sql .=  " and emitente.cpf_cnpj ='$cnpj'";
	}   
	if($estado <> '0'){
		$sql .=  " and loja.estado ='$estado'";
	}   
	
	if($area_focal <> '1'){
		$sql .=  " and cnd_mob_tratativa.id_area_focal ='$area_focal'";
	}   
	
	if($valor_pendencia <> '0'){
		$sql .=  " and cnd_mob_tratativa.valor_pendencia <= '$valor_pendencia' and cnd_mob_tratativa.valor_pendencia > '0' ";
	}   
	
	$query = $this->db->query($sql, array($id_contratante));
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return 0;
	}

 }
 
 function contarAreaFocal($tipo){
	 
	$sql = "select count(*) as total ,c.etapa as resp from cnd_mob_tratativa c  union  select count(*) as total ,c.responsavel_pagamento as resp from cnd_mob_tratativa c group by resp order by resp";		
	
	$query = $this->db->query($sql, array($tipo));
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return 0;
	}

 }
 
 function listarPendenciaByCnpj($id_contratante,$cnpj){
	 
	$sql = "SELECT  distinct natureza_raiz.codigo,natureza_raiz.descricao_natureza_raiz
			FROM  cnd_mob_tratativa 
			left join cnd_mobiliaria on cnd_mob_tratativa.id_cnd_mob = cnd_mobiliaria.id 
			LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			LEFT JOIN natureza_raiz on cnd_mob_tratativa.id_natureza_raiz = natureza_raiz.codigo 
			WHERE `cnd_mobiliaria`.`id_contratante` = ? and emitente.cpf_cnpj = ? and status_chamado_sis_ext <> 2";
			
	
	$query = $this->db->query($sql, array($id_contratante,$cnpj));
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return 0;
	}

 }
 
 function listarCnpjPendencia($id_contratante,$estado){
	 
	$sql = "SELECT distinct emitente.cpf_cnpj
			FROM  cnd_mob_tratativa 
			left join cnd_mobiliaria on cnd_mob_tratativa.id_cnd_mob = cnd_mobiliaria.id 
			LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
			LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			LEFT JOIN natureza_raiz on cnd_mob_tratativa.id_natureza_raiz = natureza_raiz.codigo 
			WHERE `cnd_mobiliaria`.`id_contratante` = ? and loja.estado = ? and status_chamado_sis_ext <> 2 order by emitente.cpf_cnpj ";
			
	
	$query = $this->db->query($sql, array($id_contratante,$estado));
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return 0;
	}

 }
 
 function listarCndPendenciaEstado($id_contratante,$pendencia,$estado){
	 
	$sql = "SELECT natureza_raiz.descricao_natureza_raiz,cnd_mob_tratativa.id,cnd_mob_tratativa.area_focal,cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio, '%d/%m/%Y') as data_envio,emitente.cpf_cnpj,
			(select DATE_FORMAT(data_hora, '%d/%m/%Y %H:%i')  from cnd_mob_tratativa_obs where id_cnd_trat = cnd_mob_tratativa.id order by id desc limit 1) as data_observacao,
			(select observacao  from cnd_mob_tratativa_obs where id_cnd_trat = cnd_mob_tratativa.id order by id desc limit 1) as observacao,cnd_mobiliaria.id as id_cnd,loja.estado
			FROM  cnd_mob_tratativa left join cnd_mobiliaria on cnd_mob_tratativa.id_cnd_mob = cnd_mobiliaria.id 
			LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			LEFT JOIN natureza_raiz on cnd_mob_tratativa.id_natureza_raiz = natureza_raiz.codigo 
			WHERE `cnd_mobiliaria`.`id_contratante` = ? and status_chamado_sis_ext <> 2";
			
	if($pendencia <> '1'){
		$sql .= " and cnd_mob_tratativa.id_natureza_raiz = $pendencia " ;		
	}
	if($estado <> '0'){
		$sql .=  " and loja.estado ='$estado'";
	}   
	$query = $this->db->query($sql, array($id_contratante));
	if($query -> num_rows() <> 0){
		return $query->result();
	}else{
		return 0;
	}

 }
 
    function listarCndTodosComFiltro($id_contratante,$imovelExp,$estadoExp,$cidadeExp,$cnpjExp,$inscricaoExp,$statusExp,$data_vencto_final_exp,$data_vencto_ini_exp,$status){
	 
	  if($_SESSION['loginTeste']['tipo_cnd'] == 2){
		  $sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `link`,bandeira.descricao_bandeira,regional.descricao as regional,usuarios.email,(select count(*) from arquivo_cnd a where a.id_cnd = `cnd_estadual`.`id` and a.modulo = 2)  as tem_arquivo,
		(select sum(c.valor_pendencia)  from cnd_mob_tratativa c where c.id_cnd_mob = `cnd_estadual`.`id` and status_chamado_sis_ext <> 2 and c.modulo = 2) as valor_total
		FROM (`cnd_estadual`) 
		LEFT JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `loja`.`estado` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
		LEFT JOIN `usuarios` ON `usuarios`.`id` = `cnd_estadual`.`usuario_upload` 
		WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.ativo = ?";
		
		if($statusExp <> '0'){
			$sql .= " and cnd_estadual.possui_cnd = $statusExp " ;		
		}
		
		if(!empty($data_vencto_ini_exp)){
		   $dataVenctoIniArr = explode("/",$data_vencto_ini_exp);
		   $dataVenctoIni = $dataVenctoIniArr[2].'-'.$dataVenctoIniArr[1].'-'.$dataVenctoIniArr[0];
		   $dataVenctoFinalArr = explode("/",$data_vencto_final_exp);
		   $dataVenctoFinal = $dataVenctoFinalArr[2].'-'.$dataVenctoFinalArr[1].'-'.$dataVenctoFinalArr[0];
		   
		   $sql .=  " and (cnd_estadual.data_vencto between '$dataVenctoIni' and  '$dataVenctoFinal')";
		}
		
		
      }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		  
		  $sql = "SELECT *, `cnd_mobiliaria`.`ativo` as status_insc, `cnd_mobiliaria`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `link`,bandeira.descricao_bandeira,regional.descricao as regional,usuarios.email,(select count(*) from arquivo_cnd a where a.id_cnd = `cnd_mobiliaria`.`id` and a.modulo = 1)  as tem_arquivo,
		(select sum(c.valor_pendencia)  from cnd_mob_tratativa c where c.id_cnd_mob = `cnd_mobiliaria`.`id` and status_chamado_sis_ext <> 2 and c.modulo = 1) as valor_total
		FROM (`cnd_mobiliaria`) 
		LEFT JOIN `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `loja`.`estado` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
		LEFT JOIN `usuarios` ON `usuarios`.`id` = `cnd_mobiliaria`.`usuario_upload` 
		WHERE `cnd_mobiliaria`.`id_contratante` = ? and cnd_mobiliaria.ativo = ?";
		
		if($statusExp <> '0'){
			$sql .= " and cnd_mobiliaria.possui_cnd = $statusExp " ;		
		}
		
		if(!empty($data_vencto_ini_exp)){
		   $dataVenctoIniArr = explode("/",$data_vencto_ini_exp);
		   $dataVenctoIni = $dataVenctoIniArr[2].'-'.$dataVenctoIniArr[1].'-'.$dataVenctoIniArr[0];
		   $dataVenctoFinalArr = explode("/",$data_vencto_final_exp);
		   $dataVenctoFinal = $dataVenctoFinalArr[2].'-'.$dataVenctoFinalArr[1].'-'.$dataVenctoFinalArr[0];
		   
		   $sql .=  " and (cnd_mobiliaria.data_vencto between '$dataVenctoIni' and  '$dataVenctoFinal')";
		}
		
		
	  }else{
		   $sql = "SELECT *, `cnd_federal`.`ativo` as status_insc, `cnd_federal`.`id` as id_cnd, `emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, `loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, `link`,bandeira.descricao_bandeira,regional.descricao as regional,usuarios.email,(select count(*) from arquivo_cnd a where a.id_cnd = `cnd_federal`.`id` and a.modulo = 3)  as tem_arquivo,
		(select sum(c.valor_pendencia)  from cnd_mob_tratativa c where c.id_cnd_mob = `cnd_federal`.`id` and status_chamado_sis_ext <> 2 and c.modulo = 3) as valor_total
		FROM (`cnd_federal`) 
		LEFT JOIN `loja` ON `cnd_federal`.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		LEFT JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `loja`.`estado` 
		LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
		LEFT JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
		LEFT JOIN `usuarios` ON `usuarios`.`id` = `cnd_federal`.`usuario_upload` 
		WHERE `cnd_federal`.`id_contratante` = ? and cnd_federal.ativo = ?";
		
		if($statusExp <> '0'){
			$sql .= " and cnd_federal.possui_cnd = $statusExp " ;		
		}
		
		if(!empty($data_vencto_ini_exp)){
		   $dataVenctoIniArr = explode("/",$data_vencto_ini_exp);
		   $dataVenctoIni = $dataVenctoIniArr[2].'-'.$dataVenctoIniArr[1].'-'.$dataVenctoIniArr[0];
		   $dataVenctoFinalArr = explode("/",$data_vencto_final_exp);
		   $dataVenctoFinal = $dataVenctoFinalArr[2].'-'.$dataVenctoFinalArr[1].'-'.$dataVenctoFinalArr[0];
		   
		   $sql .=  " and (cnd_federal.data_vencto between '$dataVenctoIni' and  '$dataVenctoFinal')";
		}
	
		  
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
			$sql .=  " and loja.ins_cnd_mob = '$inscricaoExp'";
		}   
		
	
	$query = $this->db->query($sql, array($id_contratante,$status));
	//print_r($this->db->last_query());exit;
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
 
 function listarNaturezaRaiz(){
   $this -> db -> select('*');
   $this -> db -> from('natureza_raiz');
   $this -> db -> order_by('codigo');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarTipoAplicacao(){
   $this -> db -> select('*');
   $this -> db -> from('tipo_aplicacao');
   $this -> db -> order_by('codigo');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarAreaFocal(){
   $this -> db -> select('*');
   $this -> db -> from('area_focal');
   $this -> db -> order_by('codigo');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
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
 
 public function add_tratativa($detalhes = array()){
	if($this->db->insert('cnd_mob_tratativa', $detalhes)) {		
		$id = $this->db->insert_id();
		return $id;
	}
	
	return false;
}

function listarTratativaMobById($idContratante,$id){
	 
	$sql = "select cnd_mob_tratativa.id,
			cnd_mob_tratativa.tipo_tratativa,
			cnd_mob_tratativa.pendencia,
			cnd_mob_tratativa.esfera,cnd_mob_tratativa.etapa,
			esfera.descricao_esfera,etapa.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia,
			cnd_mob_tratativa.id_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_encerramento_sis_ext,'%d/%m/%Y') as data_encerramento_sis_ext,
			status_chamado_interno.descricao as desc_chamado_int,
			cnd_mob_tratativa.status_chamado_sis_ext,
			cnd_mob_tratativa.sla_sis_ext,
			cnd_mob_tratativa.usu_inc,
			cnd_mob_tratativa.area_focal,
			cnd_mob_tratativa.sub_area_focal,
			cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio,'%d/%m/%Y') as data_envio,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao,'%d/%m/%Y') as prazo_solucao,
			DATE_FORMAT(cnd_mob_tratativa.data_retorno,'%d/%m/%Y') as data_retorno,
			cnd_mob_tratativa.sla,
			cnd_mob_tratativa.status_demanda,
			status_demanda.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_um,'%d/%m/%Y') as esc_data_prazo_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_um,'%d/%m/%Y') as esc_data_retorno_um,
			cnd_mob_tratativa.esc_status_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_dois,
			cnd_mob_tratativa.esc_status_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_tres,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_tres,
			cnd_mob_tratativa.esc_status_tres
			from cnd_mob_tratativa 
			left join esfera on esfera.id = cnd_mob_tratativa.esfera
			left join etapa on etapa.id = cnd_mob_tratativa.etapa
			left join status_chamado_interno on status_chamado_interno.id = cnd_mob_tratativa.status_chamado_sis_ext
			left join status_demanda on status_demanda.id = cnd_mob_tratativa.id
		where cnd_mob_tratativa.id_contratante = ? and cnd_mob_tratativa.id = ?";

	$query = $this->db->query($sql, array($idContratante,$id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function contarPendenciasTratativas($idContratante){
	 if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$sql = "select count(*) as total,natureza_raiz.descricao_natureza_raiz,natureza_raiz.codigo ,natureza_raiz.cor  from cnd_mob_tratativa 	  left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz  left join cnd_estadual on cnd_estadual.id = cnd_mob_tratativa.id_cnd_mob   where cnd_mob_tratativa.id_contratante = ? and cnd_mob_tratativa.status_chamado_sis_ext <> 2 	and cnd_estadual.ativo = 0  and cnd_mob_tratativa.modulo = 2 group by natureza_raiz.descricao_natureza_raiz  order by descricao_natureza_raiz";
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $sql = "select count(*) as total,natureza_raiz.descricao_natureza_raiz,natureza_raiz.codigo ,natureza_raiz.cor from cnd_mob_tratativa 	 left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz  left join cnd_mobiliaria on cnd_mobiliaria.id = cnd_mob_tratativa.id_cnd_mob  where cnd_mob_tratativa.id_contratante = ? and cnd_mob_tratativa.status_chamado_sis_ext <> 2 	and cnd_mobiliaria.ativo = 0 and cnd_mob_tratativa.modulo = 1 group by natureza_raiz.descricao_natureza_raiz  order by descricao_natureza_raiz";
	 }else{
		 $sql = "select count(*) as total,natureza_raiz.descricao_natureza_raiz,natureza_raiz.codigo ,natureza_raiz.cor  from cnd_mob_tratativa   left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz  left join cnd_federal on cnd_federal.id = cnd_mob_tratativa.id_cnd_mob   where cnd_mob_tratativa.id_contratante = ? and cnd_mob_tratativa.status_chamado_sis_ext <> 2 	and cnd_federal.ativo = 0  and cnd_mob_tratativa.modulo = 3 group by natureza_raiz.descricao_natureza_raiz order by descricao_natureza_raiz";
	 }	
	
	$query = $this->db->query($sql, array($idContratante));
	//print_r($this->db->last_query());exit;
	   if($query -> num_rows() <> 0){
		 return $query->result();
	   }else{
		 return 0;
	   }
	   
  }	  
  
    function contarTipoLicencas(){
	$sql = "select count(*) as total ,n.descricao_natureza_raiz,n.cor from cnd_mob_tratativa c  left join natureza_raiz n on n.codigo = c.id_natureza_raiz where c.tipo_tratativa = 1  group by c.id_natureza_raiz order by n.descricao_natureza_raiz";
	$query = $this->db->query($sql, array());
	//print_r($this->db->last_query());exit;
	   if($query -> num_rows() <> 0){
		 return $query->result();
	   }else{
		 return 0;
	   }
	   
  }	 
  
  function contarTipoTaxa(){
	$sql = "select count(*) as total ,n.descricao,n.cor from cnd_mob_tratativa c  left join tipo_taxas n on n.id = c.tipo_taxa   where c.tipo_tratativa = '2' group by n.descricao order by n.descricao";
	$query = $this->db->query($sql, array());
	//print_r($this->db->last_query());exit;
	   if($query -> num_rows() <> 0){
		 return $query->result();
	   }else{
		 return 0;
	   }
	   
  }	 
 function listarTratativaById($idContratante,$id){
	$modulo =1;
	$tabela = "cnd_mobiliaria";
	$sql = "select cnd_mob_tratativa.id,
			cnd_mob_tratativa.tipo_tratativa,
			cnd_mob_tratativa.pendencia,
			cnd_mob_tratativa.esfera,cnd_mob_tratativa.etapa,
			esfera.descricao_esfera,etapa.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia,
			cnd_mob_tratativa.id_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_encerramento_sis_ext,'%d/%m/%Y') as data_encerramento_sis_ext,
			status_chamado_interno.descricao as desc_chamado_int,
			cnd_mob_tratativa.status_chamado_sis_ext,
			cnd_mob_tratativa.sla_sis_ext,
			cnd_mob_tratativa.usu_inc,
			cnd_mob_tratativa.area_focal,
			cnd_mob_tratativa.sub_area_focal,
			cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio,'%d/%m/%Y') as data_envio,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao,'%d/%m/%Y') as prazo_solucao,
			DATE_FORMAT(cnd_mob_tratativa.data_retorno,'%d/%m/%Y') as data_retorno,
			cnd_mob_tratativa.sla,
			cnd_mob_tratativa.status_demanda,
			status_demanda.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_um,'%d/%m/%Y') as esc_data_prazo_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_um,'%d/%m/%Y') as esc_data_retorno_um,
			cnd_mob_tratativa.esc_status_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_dois,
			cnd_mob_tratativa.esc_status_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_tres,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_tres,
			cnd_mob_tratativa.esc_status_tres,natureza_raiz.codigo as codigo_natureza_raiz,area_focal.codigo as codigo_area_focal,
			cnd_mob_tratativa.valor_pendencia,			
			cnd_mob_tratativa.senha,
			cnd_mob_tratativa.regra_taxa,
			cnd_mob_tratativa.competencia,
			cnd_mob_tratativa.org_resp,
			cnd_mob_tratativa.modo_emissao,		
			cnd_mob_tratativa.observacao,		
			cnd_mob_tratativa.periodo_taxas,
			cnd_mob_tratativa.periodo_renovacao,
			cnd_mob_tratativa.responsavel_pagamento,				
			cnd_mob_tratativa.mes_pagamento,
			cnd_mob_tratativa.tipo_taxa,
			DATE_FORMAT(cnd_mob_tratativa.data_vencto,'%d/%m/%Y') as data_vencto
			from cnd_mob_tratativa 
			left join esfera on esfera.id = cnd_mob_tratativa.esfera
			left join etapa on etapa.id = cnd_mob_tratativa.etapa
			left join status_chamado_interno on status_chamado_interno.id = cnd_mob_tratativa.status_chamado_sis_ext
			left join status_demanda on status_demanda.id = cnd_mob_tratativa.id
			left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz  
			left join area_focal on area_focal.codigo = cnd_mob_tratativa.id_area_focal
			left join periodo_taxas on periodo_taxas.id = cnd_mob_tratativa.periodo_taxas
		where cnd_mob_tratativa.id_contratante = ? and cnd_mob_tratativa.id = ? and cnd_mob_tratativa.modulo = ?";

	$query = $this->db->query($sql, array($idContratante,$id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
function listarTratativasIdCnd($idCnd){
	 
	$sql = "select cnd_mob_tratativa.id,cnd_mob_tratativa.pendencia,
			cnd_mob_tratativa.esfera,cnd_mob_tratativa.etapa,
			esfera.descricao_esfera,etapa.descricao_etapa,
			DATE_FORMAT(cnd_mob_tratativa.data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia,
			cnd_mob_tratativa.id_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext,
			cnd_mob_tratativa.prazo_solucao_sis_ext,
			DATE_FORMAT(cnd_mob_tratativa.data_encerramento_sis_ext,'%d/%m/%Y') as data_encerramento_sis_ext,
			status_chamado_interno.descricao as desc_chamado_int,
			cnd_mob_tratativa.status_chamado_sis_ext,
			cnd_mob_tratativa.sla_sis_ext,
			cnd_mob_tratativa.usu_inc,
			cnd_mob_tratativa.area_focal,
			cnd_mob_tratativa.sub_area_focal,
			cnd_mob_tratativa.contato,
			DATE_FORMAT(cnd_mob_tratativa.data_envio,'%d/%m/%Y') as data_envio,
			DATE_FORMAT(cnd_mob_tratativa.prazo_solucao,'%d/%m/%Y') as prazo_solucao,
			DATE_FORMAT(cnd_mob_tratativa.data_retorno,'%d/%m/%Y') as data_retorno,
			cnd_mob_tratativa.sla,
			cnd_mob_tratativa.status_demanda,
			status_demanda.descricao_etapa as desc_demanda,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_um,'%d/%m/%Y') as esc_data_prazo_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_um,'%d/%m/%Y') as esc_data_retorno_um,
			cnd_mob_tratativa.esc_status_um,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_dois,
			cnd_mob_tratativa.esc_status_dois,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_tres,
			DATE_FORMAT(cnd_mob_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_tres,
			cnd_mob_tratativa.esc_status_tres,tipo_tratativa,natureza_raiz.descricao_natureza_raiz,area_focal.descricao_area_focal
			from cnd_mob_tratativa 
			left join esfera on esfera.id = cnd_mob_tratativa.esfera
			left join etapa on etapa.id = cnd_mob_tratativa.etapa
			left join status_chamado_interno on status_chamado_interno.id = cnd_mob_tratativa.status_chamado_sis_ext
			left join status_demanda on status_demanda.id = cnd_mob_tratativa.id
			left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz 
			left join area_focal on area_focal.codigo = cnd_mob_tratativa.id_area_focal
		where cnd_mob_tratativa.id_cnd_mob = ? and modulo = 1 order by cnd_mob_tratativa.id desc";

	$query = $this->db->query($sql, array($idCnd));
	

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 function addObsTrat($detalhes = array()){ 
	if($this->db->insert('cnd_mob_tratativa_obs', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	return false;
 }
 
 function listarObsTratById($id){ 
	$sql = "select DATE_FORMAT(c.data,'%d/%m/%Y') as data,c.hora,c.data_hora,u.email,u.nome_usuario,c.observacao,c.id,c.arquivo
		from cnd_mob_tratativa_obs c left join usuarios u on u.id = c.id_usuario where c.id_cnd_trat = ? order by c.id desc";
	$query = $this->db->query($sql, array($id));
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function atualizar_tratativa_obs($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_mob_tratativa_obs', $dados); 
	return true;
 }
 
  function atualizar_tratativa($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_mob_tratativa', $dados); 

	return true;
 }
 
 function listarTodasTratativas($idContratante,$id,$modulo,$tipo){
	 
	$sql = "select cnd_mob_tratativa.id,cnd_mob_tratativa.mes_pagamento,cnd_mob_tratativa.pendencia,
	DATE_FORMAT(data_inclusao_sis_ext,'%d/%m/%Y') as data_envio_voiza ,
	DATE_FORMAT(prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_voiza ,
	DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_bd ,
	DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao_bd ,
	DATE_FORMAT(data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia_bd ,
	DATE_FORMAT(data_vencto,'%d/%m/%Y') as data_vencto_bd ,
	status_chamado_sis_ext,
	status_demanda,
	status_demanda.descricao_etapa,
	status_chamado_interno_mobiliario.descricao,
	periodo_taxas.descricao as periodo_taxas,
	DATE_FORMAT(data_atualizacao,'%d/%m/%Y') as ultima_tratativa,area_focal,contato, natureza_raiz.descricao_natureza_raiz, area_focal.descricao_area_focal,
	tipo_aplicacao.descricao_tipo_aplicacao,
	esfera.descricao_esfera,
	etapa.descricao_etapa,
	et.descricao_etapa as resp_pagto,
	periodo_renovacao_licenca.descricao as periodo_renovacao_licenca,
	tipo_taxas.descricao as tipo_taxas,
	cnd_mob_tratativa.etapa,
	cnd_mob_tratativa.responsavel_pagamento
	from cnd_mob_tratativa
	left join status_demanda on status_demanda.id = cnd_mob_tratativa.status_demanda
	left join status_chamado_interno_mobiliario on status_chamado_interno_mobiliario.id = cnd_mob_tratativa.status_chamado_sis_ext  
	left join natureza_raiz on natureza_raiz.codigo = cnd_mob_tratativa.id_natureza_raiz  
	left join area_focal on area_focal.codigo = cnd_mob_tratativa.id_area_focal
	left join tipo_aplicacao on tipo_aplicacao.codigo = cnd_mob_tratativa.pendencia
	left join esfera on esfera.id = cnd_mob_tratativa.esfera
	left join etapa on etapa.id = cnd_mob_tratativa.etapa
	left join etapa et on et.id = cnd_mob_tratativa.responsavel_pagamento
	left join periodo_taxas on periodo_taxas.id = cnd_mob_tratativa.periodo_taxas
	left join tipo_taxas on tipo_taxas.id = cnd_mob_tratativa.tipo_taxa
	left join periodo_renovacao_licenca on periodo_renovacao_licenca.id = cnd_mob_tratativa.periodo_renovacao
	where id_contratante = ? and id_cnd_mob = ? and cnd_mob_tratativa.modulo = ? and tipo_tratativa = ?
	order by cnd_mob_tratativa.data_atualizacao desc
	";

	$query = $this->db->query($sql, array($idContratante,$id,$modulo,$tipo));
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
 
  function listarCndTodos($id_contratante,$status){
  
   if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		 $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,loja.id as id_loja,link,imovel.id as id_imovel,bandeira.descricao_bandeira,regional.descricao as regional,usuarios.email');
		   $this -> db -> from('cnd_estadual'); 
		   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
		   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
		   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
		   $this -> db -> join('uf_link_sefaz','uf_link_sefaz.uf = loja.estado','left');
		   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
		   $this -> db -> join('regional','regional.id = loja.regional','left');
		   $this -> db -> join('usuarios','usuarios.id = cnd_estadual.usuario_upload','left');
		   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
		   $this -> db -> where('cnd_estadual.ativo', $status);
		   
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,loja.id as id_loja,link,imovel.id as id_imovel,bandeira.descricao_bandeira,regional.descricao as regional,usuarios.email');
		   $this -> db -> from('cnd_mobiliaria'); 
		   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id','left');
		   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
		   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
		   $this -> db -> join('uf_link_sefaz','uf_link_sefaz.uf = loja.estado','left');
		   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
		   $this -> db -> join('regional','regional.id = loja.regional','left');
		   $this -> db -> join('usuarios','usuarios.id = cnd_mobiliaria.usuario_upload','left');
		   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
		   $this -> db -> where('cnd_mobiliaria.ativo', $status);
	 }else{
	 
		 $this -> db -> select('*,cnd_federal.ativo as status_insc,cnd_federal.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,loja.id as id_loja,link,imovel.id as id_imovel,bandeira.descricao_bandeira,regional.descricao as regional,usuarios.email');
		   $this -> db -> from('cnd_federal'); 
		   $this -> db -> join('loja','cnd_federal.id_loja = loja.id','left');
		   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
		   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
		   $this -> db -> join('uf_link_sefaz','uf_link_sefaz.uf = loja.estado','left');
		   $this -> db -> join('bandeira','bandeira.id = loja.bandeira','left');
		   $this -> db -> join('regional','regional.id = loja.regional','left');
		   $this -> db -> join('usuarios','usuarios.id = cnd_federal.usuario_upload','left');
		   $this -> db -> where('cnd_federal.id_contratante', $id_contratante);
		   $this -> db -> where('cnd_federal.ativo', $status);
		   
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
 
  function listarCndTipoMun($id_contratante,$cidade,$tipo ){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cidade);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
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
 
  function listarCndTipoId($id_contratante,$id,$tipo){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_mobiliaria.id', $id);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarCndTipoEst($id_contratante,$estado,$tipo ){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.razao_social as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	}
   $this -> db -> where('loja.estado', $estado);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarCndTipoReg($id_contratante,$regional,$tipo ){
	 
	if($tipo == 5){	
	   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
	   $this -> db -> from('cnd_mobiliaria'); 
	   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
	   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
	   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
	   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
	   $this -> db -> where('loja.regional', $regional);
	   $this -> db -> order_by('emitente.nome_fantasia');
		
	}else{
	   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
	   $this -> db -> from('cnd_mobiliaria'); 
	   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
	   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
	   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
	   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
	   $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	   $this -> db -> where('loja.regional', $regional);
	   $this -> db -> order_by('emitente.nome_fantasia');
	}


   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
  function listarCndTipo($id_contratante,$tipo ){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');  
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }


 }

  function listarCnd($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){


   $this -> db ->limit( $_limit, $_start ); 	


   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');


   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');


   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   
   if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
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

 function contaCndRegional($id_contratante,$ano,$tipo,$reg){
	 if($tipo == 0){
		 $sql = "SELECT count(`cnd_mobiliaria`.`possui_cnd`) as total FROM (`cnd_mobiliaria`) 
		left JOIN  `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`  JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `cnd_mobiliaria`.`id_contratante` = ? and regional.id = ?
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$reg));
	 }elseif($tipo <> 4){
		 $sql = "SELECT count(`cnd_mobiliaria`.`possui_cnd`) as total FROM (`cnd_mobiliaria`) 
		left JOIN  `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`  JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `cnd_mobiliaria`.`id_contratante` = ? and cnd_mobiliaria.possui_cnd = ? and regional.id = ?
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$tipo,$reg));	
	 }else{
		 
		  $sql = "SELECT count(*) as total FROM (`loja`) 
		JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  
		JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `loja`.`id_contratante` = ? and regional.id = ?
		 and loja.id not in (select id_loja from cnd_mobiliaria where id_contratante = ?)
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$reg,$id_contratante));	
		 
	 }
	 
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
 
 function contaCnd($id_contratante,$ano){


 $sql = "SELECT count(`cnd_mobiliaria`.`possui_cnd`) as total, `possui_cnd` FROM (`cnd_mobiliaria`) 
left JOIN 
`loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
 WHERE `cnd_mobiliaria`.`id_contratante` = ? GROUP BY `cnd_mobiliaria`.`possui_cnd` 
 union select count(*) as total, '99' from loja l
 JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
JOIN `regional` ON `regional`.`id` = l.`regional` 
JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
 where l.id not in (select id_loja from cnd_mobiliaria) and l.id_contratante = ?";
	$query = $this->db->query($sql, array($id_contratante,$id_contratante));
	
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
 
 function listarIptuCsv($id_contratante,$tipo){


 
 $this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');

   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');
   
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);  
	$this -> db -> order_by('loja.id'); 	
	
   }else{
	$this -> db -> order_by('cnd_mobiliaria.possui_cnd');  
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
 
  function listarIptuCsvByCidade($id,$tipo){

	$this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   	$this -> db -> order_by('loja.id');

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
 
 function getStatusInscricaoLojaByEstado($id){


   $this -> db -> select('ins_cnd_mob');

   $this -> db -> from('loja');
   
   $this -> db -> where('loja.estado', $id);
      	

   $query = $this -> db -> get();

  print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarIptuCsvByEstado($id,$tipo){


   $this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.estado', $id);
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   	$this -> db -> order_by('loja.id');

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
 
 function listarTodasCidades(){

   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel'); 
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_iptu = iptu.id');   
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
 
 function listarEmitenteById($id){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social,emitente.cpf_cnpj,loja.id as id_loja,loja.ins_cnd_mob as inc_cnd_mob');

   $this -> db -> from('emitente');
   
   $this -> db -> join('loja','emitente.id = loja.id_emitente'); 

   $this -> db -> where('loja.id', $id);

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
 
 function listarEmitentes($id_contratante){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social');

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
 
 function listarCidadeByEstado($idContratante,$id,$tipo){
	
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
	$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);
	$this -> db -> where('loja.estado', $id);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
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
 
 function listarIptuCsvById($id,$tipo){
 
   $this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.id', $id);
   
    if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   $this -> db -> order_by('loja.id');
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 

 }

 function somarTodos($idContratante,$cidade,$estado){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
     if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }

   function somarTodosTipo($idContratante,$cidade,$estado,$tipo){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
   if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);   
 
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
 
  function listarLoja($id_contratante,$tipo){
   $this->db->distinct();
   $this -> db -> select('cnd_mobiliaria.id,emitente.nome_fantasia as  nome');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   $this -> db -> order_by('loja.id');

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
 
 function listarImovelByEstado($id,$tipo){
   $this -> db ->distinct();
	
   $this -> db -> select('emitente.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.estado', $id);
   if($tipo<>'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
   }
   $this -> db -> order_by('emitente.id');
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
function listarImovelByCidade($id,$tipo){


	$this -> db ->distinct();
	$this -> db -> select('cnd_mobiliaria.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);  
   }	
	$query = $this -> db -> get();

  //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarImovelByCidadeEstado($id,$tipo,$uf){


	$this -> db ->distinct();
	$this -> db -> select('cnd_mobiliaria.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.cidade', $id);
   $this -> db -> where('loja.estado', $uf);
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);  
   }	
	$query = $this -> db -> get();

  //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
  public function add($detalhes = array()){

 

	if($this->db->insert('cnd_mobiliaria', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
	 function listarCNDById($id){
   $this -> db -> select('*');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> where('cnd_mobiliaria.id', $id);   
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
	
	 if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$this->db->update('cnd_estadual', $dados); 
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $this->db->update('cnd_mobiliaria', $dados); 
	 }else{
		 $this->db->update('cnd_federal', $dados); 
	 }	
	
	
	//print_r($this->db->last_query());exit;
	return true;
 } 

function atualizar_arquivo_chamado($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('chamados_big', $dados); 
	//print_r($this->db->last_query());exit;
	return true;
 } 
 
public function add_arquivo_chamado($detalhes = array()){
	if($this->db->insert('chamados_big', $detalhes)) {		
		$id = $this->db->insert_id();
		return $id;
	}
	return false;
}
 
 function atualizar_loja($inscricao,$id){
		$dados = array(
			'ins_cnd_mob' => $inscricao
		);
	$this->db->where('id', $id);
	$this->db->update('loja', $dados); 
	//print_r($this->db->last_query());exit;
	return true;
 } 

 
 function listarCidadeEstadoById($id){
	
  $this -> db -> select('loja.id,loja.cidade,loja.estado ');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   

   $this -> db -> where('cnd_mobiliaria.id', $id);   


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
 
 function listarInscricaoByLoja($id){
	 
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
	 
	  $sql = "SELECT *,
				 count(*) as total,$tabela.`ativo` as status_insc, $tabela.`id` as id_cnd, `loja`.`ins_cnd_mob` as ins_cnd_mob, 
				`loja`.`id` as id_loja, `regional`.`descricao` as regional, `descricao_bandeira`, `link` ,
				DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br,DATE_FORMAT(data_vencto,'%d/%m/%Y') as data_vencto_br,DATE_FORMAT(data_pendencias,'%d/%m/%Y') as data_pendencia_br,
				(select sum(c.valor_pendencia)  from cnd_mob_tratativa c where c.id_cnd_mob = $id and status_chamado_sis_ext <> 2) as valor_total,
				`loja`.cidade,`loja`.estado,`loja`.cnpj,`loja`.nome_loja
	  FROM $tabela
	  LEFT JOIN `loja` ON $tabela.`id_loja` = `loja`.`id` 
	  LEFT JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
	  LEFT JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
	  LEFT  JOIN `uf_link_sefaz` ON `uf_link_sefaz`.`uf` = `loja`.`estado` WHERE loja.`id` = ? ";
	 $query = $this->db->query($sql, array($id));	
	 
	 //print_r($this->db->last_query());exit;
	 if($query -> num_rows() <> 0){
		return $query->result();
	 }else{
		return false;
	 }

 }
 
 
 
	function listarInscricaoById($id){
	
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   

   $this -> db -> where('cnd_mobiliaria.id', $id);   


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
 
 function listarLojaByImovel($id_loja,$tipo){
	 
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
     
   if($id_loja <> 0){
	$this -> db -> where('loja.id', $id_loja);   
   }	
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
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
	 
	
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('loja.estado', $estado);  
  
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }	
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelPendente(){
	 
	
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('cnd_mobiliaria.possui_cnd', '3');  
  
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelByMunicipio($municipio,$tipo){
	 
	$this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   
   $this -> db -> where('loja.cidade', $municipio);  

   if($tipo <> 'X'){
	 $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);    
   }

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarTrintaDiasVencer($idContratante){
	 
	 if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] ==1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }	
	
	
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("+0 days",strtotime($dataHoje))); 
	$data2 = date('Y-m-d', strtotime("+30 days",strtotime($dataHoje))); 
	
	$sql = "SELECT *,loja.cidade as cidade_loja, $tabela.`ativo` as status_insc, $tabela.`id` as id_cnd, 
		`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
		`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, $tabela.`possui_cnd` as status_debito_fiscal, `link`,
		$tabela.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
		FROM ($tabela) 
		LEFT JOIN `loja` ON $tabela.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
		LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
		LEFT JOIN regional on regional.id = loja.regional
		LEFT JOIN bandeira on bandeira.id = loja.bandeira
		  LEFT JOIN usuarios on usuarios.id = $tabela.usuario_upload
		WHERE $tabela.`id_contratante` = $idContratante and $tabela.data_vencto between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarQuinzeDiasVencer($idContratante){
	 
	  if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] ==1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }	
	 
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("+15 days",strtotime($dataHoje))); 
	$data1 = $dataHoje; 
	
	$sql = "SELECT *,loja.cidade as cidade_loja, $tabela.`ativo` as status_insc, $tabela.`id` as id_cnd, 
		`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
		`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, $tabela.`possui_cnd` as status_debito_fiscal, `link`,
		$tabela.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
		FROM ($tabela) 
		LEFT JOIN `loja` ON $tabela.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
		LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
		LEFT JOIN regional on regional.id = loja.regional
		LEFT JOIN bandeira on bandeira.id = loja.bandeira
		  LEFT JOIN usuarios on usuarios.id = $tabela.usuario_upload
		WHERE $tabela.`id_contratante` = $idContratante and $tabela.data_vencto between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data1,$data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarAcimaTrintaDiasVencer($idContratante){
	 
	  if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] ==1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }	
	 
	$dataHoje = date('Y-m-d'); 
	$data2 = date('Y-m-d', strtotime("30 days",strtotime($dataHoje))); 
	
	
	$sql = "SELECT *,loja.cidade as cidade_loja, $tabela.`ativo` as status_insc, $tabela.`id` as id_cnd, 
		`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
		`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, $tabela.`possui_cnd` as status_debito_fiscal, `link`,
		$tabela.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
		FROM ($tabela) 
		LEFT JOIN `loja` ON $tabela.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
		LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
		LEFT JOIN regional on regional.id = loja.regional
		LEFT JOIN bandeira on bandeira.id = loja.bandeira
		  LEFT JOIN usuarios on usuarios.id = $tabela.usuario_upload
		WHERE $tabela.`id_contratante` = $idContratante and $tabela.data_vencto > ?  ";	     
   

  $query = $this->db->query($sql, array($data2));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarQuinzeDiasVencida($idContratante){
	 
	$dataHoje = date('Y-m-d'); 
	
	$data2 = date('Y-m-d', strtotime("-15 days",strtotime($dataHoje))); 
	

	 
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
		WHERE `cnd_mobiliaria`.`id_contratante` = $idContratante and cnd_mobiliaria.data_vencto between ? and ? ";	     
   

  $query = $this->db->query($sql, array($data2,$dataHoje));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }

function listartrintaDiasVencida($idContratante){
	 
	  if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$tabela = "cnd_estadual";
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] ==1){
		 $tabela = "cnd_mobiliaria";
		 $modulo = 1;
	 }else{
		 $tabela = "cnd_federal";
		 $modulo = 3;
	 }	
	 
	$dataHoje = date('Y-m-d'); 
	
	$data1 = date('Y-m-d', strtotime("-16 days",strtotime($dataHoje))); 
	 
	$sql = "SELECT *,loja.cidade as cidade_loja, $tabela.`ativo` as status_insc, $tabela.`id` as id_cnd, 
		`emitente`.`nome_fantasia` as raz_soc, `emitente`.`cpf_cnpj` as cpf_cnpj_loja, 
		`loja`.`ins_cnd_mob`, `loja`.`id` as id_loja, $tabela.`possui_cnd` as status_debito_fiscal, `link`,
		$tabela.`data_vencto` ,loja.estado as estado_cnd,regional.descricao as descricao_regional,bandeira.descricao_bandeira,usuarios.email
		FROM ($tabela) 
		LEFT JOIN `loja` ON $tabela.`id_loja` = `loja`.`id` 
		LEFT JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` 
		LEFT JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`
		LEFT JOIN `uf_link_sefaz` ON `loja`.`estado` = `uf_link_sefaz`.`uf` 
		LEFT JOIN regional on regional.id = loja.regional
		LEFT JOIN bandeira on bandeira.id = loja.bandeira
		  LEFT JOIN usuarios on usuarios.id = $tabela.usuario_upload
		WHERE $tabela.`id_contratante` = $idContratante  and $tabela.data_vencto < ?  ";	     
   

  $query = $this->db->query($sql, array($data1));
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
}


?>