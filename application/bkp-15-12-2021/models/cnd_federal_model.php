<?php
Class Cnd_Federal_model extends CI_Model{
	
	public function add($detalhes = array()){
		if($this->db->insert('cnd_federal', $detalhes)) {			
			$id = $this->db->insert_id();
			return $id;
		}
		return false;
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
 
 function listarArquivosById($id){ 
	$sql = "select id_arquivo,arquivo,observacao,tipo from arquivo_cnd  where id_arquivo = ? ";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function apagarArquivoCnd($id){	
	$this->db->where('id_arquivo', $id);	
	$this->db->delete('arquivo_cnd'); 	
	return true; 
} 

   function listarArquivos($id,$tipo){ 
   
    if($_SESSION['loginTeste']['tipo_cnd'] == 2){  
		$modulo = 2;
	 }elseif($_SESSION['loginTeste']['tipo_cnd'] == 1){
		 $modulo = 1;
	 }else{
		 $modulo = 3;
	 }	
	 
	$sql = "select id_arquivo,arquivo,observacao,tipo,
	case tipo 
	when 1 then 'assets/cnd_pend/'
	when 2 then 'assets/cnds_mob/'
	end as caminho
	from arquivo_cnd a where a.id_cnd = ? and tipo = ? and modulo =$modulo";
	$query = $this->db->query($sql, array($id,$tipo));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   public function add_cnd($detalhes = array()){
	if($this->db->insert('arquivo_cnd', $detalhes)) {			
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
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
   function contaCndFederal($id_contratante,$status){
	$sql = "SELECT count(*) as total  FROM (`cnd_federal`) 	WHERE `cnd_federal`.`id_contratante` = ? and cnd_federal.`possui_cnd` = ? ";
	$query = $this->db->query($sql, array($id_contratante,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
 
  function contaCndFederalByUf($id_contratante,$status,$estado){
	$sql = "SELECT count(*) as total FROM (`cnd_federal`) 	
		left join emitente on cnd_federal.id_emitente = emitente.id
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		WHERE `cnd_federal`.`id_contratante` = ? and cnd_federal.`possui_cnd` = ?  and imovel.estado = ?
	";
	$query = $this->db->query($sql, array($id_contratante,$status,$estado));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function listarObsTratById($id){ 
	$sql = "select DATE_FORMAT(c.data,'%d/%m/%Y') as data,c.hora,c.data_hora,u.email,u.nome_usuario,c.observacao,c.id,c.arquivo
		from cnd_fed_tratativa_obs c left join usuarios u on u.id = c.id_usuario where c.id_cnd_trat = ? order by c.id desc";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function listarArquivosFederal($id){ 
	$sql = "select arquivo from arquivo_tratativas a where a.id_tratativas = ? and modulo = 4";
	$query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function contaCndEstadual($id_contratante,$status,$tabela){
	$sql = "SELECT count(*) as total  FROM (`cnd_estadual`) LEFT JOIN $tabela ON `cnd_estadual`.`id` = $tabela.`id_cnd_est` 
		WHERE `cnd_estadual`.`id_contratante` = ? and $tabela.`status` = ? ";
	$query = $this->db->query($sql, array($id_contratante,$status));
	
	if($query -> num_rows() <> 0) {
		return $query->result();
	}else{
		return false;
	}
 }
 
  function atualizar($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_federal', $dados); 
	//print_r($this->db->last_query());exit;
	return true;
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
 
 
 function listarInscricaoByLoja($id){

  
  $sql = "SELECT  *, `cnd_federal`.`id` as id_cnd, `cnd_federal`.`inscricao` as ins_cnd_mob,  DATE_FORMAT(cnd_federal.data_emissao, '%d/%m/%Y') as data_emissao_br, DATE_FORMAT(cnd_federal.data_vencto, '%d/%m/%Y') as data_vencto_br , cnd_federal.observacoes as obs_cnd,cnd_federal.observacoes_extrato,cnd_federal.possui_cnd as status, imovel.estado,link,regional.descricao
		FROM (`cnd_federal`) 
		left join `emitente` ON `emitente`.`id` = `cnd_federal`.`id_emitente`
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		left join uf_link_sefaz on uf_link_sefaz.uf = imovel.estado 
		left join regional on regional.id = imovel.regional
		WHERE `cnd_federal`.`id` = ?";
  $query = $this->db->query($sql, array($id));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
  function listarCnd($id){

  
  $sql = "SELECT  *, `cnd_federal`.`id` as id_cnd, `cnd_federal`.`inscricao` as ins_cnd_mob,  DATE_FORMAT(cnd_federal.data_emissao, '%d/%m/%Y') as data_emissao_br, DATE_FORMAT(cnd_federal.data_vencto, '%d/%m/%Y') as data_vencto_br , cnd_federal.observacoes as obs_cnd,cnd_federal.observacoes_extrato,cnd_federal.possui_cnd as status, imovel.estado,link,regional.descricao
		FROM (`cnd_federal`) 
		left join `emitente` ON `emitente`.`id` = `cnd_federal`.`id_emitente`
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		left join uf_link_sefaz on uf_link_sefaz.uf = imovel.estado 
		left join regional on regional.id = imovel.regional
		WHERE `cnd_federal`.`id_contratante` = ?";
		
		
  $query = $this->db->query($sql, array($id));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarCndTodosComFiltro($idContratante,$imovelExp,$estadoExp,$cnpjExp,$inscricaoExp,$statusExp,$data_vencto_final_exp,$data_vencto_ini_exp){

  
  $sql = "SELECT  *, `cnd_federal`.`id` as id_cnd, `cnd_federal`.`inscricao` as ins_cnd_mob,  DATE_FORMAT(cnd_federal.data_emissao, '%d/%m/%Y') as data_emissao_br, DATE_FORMAT(cnd_federal.data_vencto, '%d/%m/%Y') as data_vencto_br , cnd_federal.observacoes as obs_cnd,cnd_federal.observacoes_extrato,cnd_federal.possui_cnd as status, imovel.estado,link,regional.descricao
		FROM (`cnd_federal`) 
		left join `emitente` ON `emitente`.`id` = `cnd_federal`.`id_emitente`
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		left join uf_link_sefaz on uf_link_sefaz.uf = imovel.estado 
		left join regional on regional.id = imovel.regional
		WHERE `cnd_federal`.`id_contratante` = ?";
		
			if($statusExp <> '0'){
			$sql .= " and cnd_federal.possui_cnd = $statusExp " ;		
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
			$sql .=  " and cnd_federal.inscricao = '$inscricaoExp'";
		}   
		if(!empty($data_vencto_ini_exp)){
		   $dataVenctoIniArr = explode("/",$data_vencto_ini_exp);
		   $dataVenctoIni = $dataVenctoIniArr[2].'-'.$dataVenctoIniArr[1].'-'.$dataVenctoIniArr[0];
		   $dataVenctoFinalArr = explode("/",$data_vencto_final_exp);
		   $dataVenctoFinal = $dataVenctoFinalArr[2].'-'.$dataVenctoFinalArr[1].'-'.$dataVenctoFinalArr[0];
		   
		   $sql .=  "and (cnd_federal.data_vencto between '$dataVenctoIni' and  '$dataVenctoFinal')";
		}
		
  $query = $this->db->query($sql, array($idContratante));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
function listarEstado($id){
 $sql = "SELECT distinct imovel.estado as uf
		FROM (`cnd_federal`) 
		left join `emitente` ON `emitente`.`id` = `cnd_federal`.`id_emitente`
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		left join uf_link_sefaz on uf_link_sefaz.uf = imovel.estado 
		left join regional on regional.id = imovel.regional
		WHERE `cnd_federal`.`id_contratante` = ?";
  $query = $this->db->query($sql, array($id));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 
 function listarCnpj($id){
 $sql = "SELECT distinct emitente.cpf_cnpj as cnpj
		FROM (`cnd_federal`) 
		left join `emitente` ON `emitente`.`id` = `cnd_federal`.`id_emitente`
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		left join uf_link_sefaz on uf_link_sefaz.uf = imovel.estado 
		left join regional on regional.id = imovel.regional
		WHERE `cnd_federal`.`id_contratante` = ?";
  $query = $this->db->query($sql, array($id));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarInscricao($id){
 $sql = "SELECT distinct inscricao
		FROM (`cnd_federal`) 
		left join `emitente` ON `emitente`.`id` = `cnd_federal`.`id_emitente`
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		left join uf_link_sefaz on uf_link_sefaz.uf = imovel.estado 
		left join regional on regional.id = imovel.regional
		WHERE `cnd_federal`.`id_contratante` = ?";
  $query = $this->db->query($sql, array($id));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarImovel($id){
 $sql = "SELECT imovel.id,imovel.nome
		FROM (`cnd_federal`) 
		left join `emitente` ON `emitente`.`id` = `cnd_federal`.`id_emitente`
		left join emitente_imovel on emitente_imovel.id_emitente = emitente.id
		left join imovel on imovel.id = emitente_imovel.id_imovel
		left join uf_link_sefaz on uf_link_sefaz.uf = imovel.estado 
		left join regional on regional.id = imovel.regional
		WHERE `cnd_federal`.`id_contratante` = ?";
  $query = $this->db->query($sql, array($id));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarCnpjs($idContratante,$cnpjString){
 //$sql = "SELECT distinct emitente.id,emitente.cpf_cnpj as cnpj	FROM `emitente`  left join cnd_federal on emitente.cpf_cnpj  = cnd_federal.cnpj_matriz WHERE `emitente`.`id_contratante` = ? and cnd_federal.id = ? order by cpf_cnpj asc ";
 $sql="select distinct emitente.id,emitente.cpf_cnpj as cnpj from emitente   where emitente.id_contratante = ? and cpf_cnpj like '$cnpjString%' and LENGTH(cpf_cnpj) =18 order by cpf_cnpj";
  $query = $this->db->query($sql, array($idContratante));
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
  function listarTodasTratativas($idContratante,$id){
	 
	$sql = "select cnd_fed_tratativa.id,cnd_fed_tratativa.pendencia,
	DATE_FORMAT(data_inclusao_sis_ext,'%d/%m/%Y') as data_envio_voiza ,
	DATE_FORMAT(prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_voiza ,
	DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_bd ,
	DATE_FORMAT(prazo_solucao,'%d/%m/%Y') as prazo_solucao_bd ,
	status_chamado_sis_ext,
	status_demanda,
	status_demanda.descricao_etapa,
	status_chamado_interno.descricao,
	(select DATE_FORMAT(data,'%d/%m/%Y') as data  from cnd_mob_tratativa_obs o where o.id_cnd_trat = cnd_fed_tratativa.id order by data desc limit 1 ) as ultima_tratativa,
	inscricao_divida_ativa,processo,debito_cobranca_rfb,debito_cobranca_pgfn,descricao_pendencia,valor_pendencia,
	emitente.cpf_cnpj as cnpj_pendencia,origem_pendencia,natureza_pendencia,agrupamento,contato,area_focal_federal.descricao_area_focal
	from cnd_fed_tratativa
	left join status_demanda on status_demanda.id = cnd_fed_tratativa.status_demanda
	left join status_chamado_interno on status_chamado_interno.id = cnd_fed_tratativa.status_chamado_sis_ext  
	left join cnd_federal on cnd_federal.id = cnd_fed_tratativa.id_cnd_mob
	left join emitente on emitente.id = cnd_fed_tratativa.cnpj_pendencia
	left join area_focal_federal on area_focal_federal.codigo = cnd_fed_tratativa.area_focal
	where cnd_fed_tratativa.id_contratante = ? and id_cnd_mob = ? 
	order by cnd_fed_tratativa.data_atualizacao desc
	";

	$query = $this->db->query($sql, array($idContratante,$id));
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
	if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarOrigemPendemcia(){
   $this -> db -> select('*');
   $this -> db -> from('origem_pendencia');
   $query = $this -> db -> get();
	if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
   public function add_tratativa($detalhes = array()){
	if($this->db->insert('cnd_fed_tratativa', $detalhes)) {			
		$id = $this->db->insert_id();
		return $id;
	}
	return false;
}

 function listarTratativaById($idContratante,$id){
	 

	$sql = "select 
			cnd_fed_tratativa.id, 
			cnd_fed_tratativa.id as id_tratativa, 
			cnd_fed_tratativa.tipo_tratativa, 
			cnd_fed_tratativa.pendencia, 
			cnd_fed_tratativa.esfera,cnd_fed_tratativa.etapa, esfera.descricao_esfera,etapa.descricao_etapa,
			DATE_FORMAT(cnd_fed_tratativa.data_informe_pendencia,'%d/%m/%Y') as data_informe_pendencia, 
			cnd_fed_tratativa.id_sis_ext, DATE_FORMAT(cnd_fed_tratativa.data_inclusao_sis_ext,'%d/%m/%Y') as data_inclusao_sis_ext, 
			DATE_FORMAT(cnd_fed_tratativa.prazo_solucao_sis_ext,'%d/%m/%Y') as prazo_solucao_sis_ext, 
			DATE_FORMAT(cnd_fed_tratativa.data_encerramento_sis_ext,'%d/%m/%Y') as data_encerramento_sis_ext, 
			status_chamado_interno.descricao as desc_chamado_int, cnd_fed_tratativa.status_chamado_sis_ext, 
			cnd_fed_tratativa.sla_sis_ext, cnd_fed_tratativa.usu_inc, cnd_fed_tratativa.area_focal, 
			cnd_fed_tratativa.sub_area_focal, cnd_fed_tratativa.contato, DATE_FORMAT(cnd_fed_tratativa.data_envio,'%d/%m/%Y') as data_envio, 
			DATE_FORMAT(cnd_fed_tratativa.prazo_solucao,'%d/%m/%Y') as prazo_solucao,
			DATE_FORMAT(cnd_fed_tratativa.data_retorno,'%d/%m/%Y') as data_retorno, 
			cnd_fed_tratativa.sla, cnd_fed_tratativa.status_demanda,
			status_demanda.descricao_etapa, DATE_FORMAT(cnd_fed_tratativa.esc_data_prazo_um,'%d/%m/%Y') as esc_data_prazo_um,
			DATE_FORMAT(cnd_fed_tratativa.esc_data_retorno_um,'%d/%m/%Y') as esc_data_retorno_um, 
			cnd_fed_tratativa.esc_status_um, DATE_FORMAT(cnd_fed_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_dois, 
			DATE_FORMAT(cnd_fed_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_dois, cnd_fed_tratativa.esc_status_dois, 
			DATE_FORMAT(cnd_fed_tratativa.esc_data_prazo_dois,'%d/%m/%Y') as esc_data_prazo_tres, 
			DATE_FORMAT(cnd_fed_tratativa.esc_data_retorno_dois,'%d/%m/%Y') as esc_data_retorno_tres, 
			cnd_fed_tratativa.esc_status_tres,cnpj_pendencia,
			origem_pendencia,natureza_pendencia,agrupamento,origem_pendencia.descricao_origem,
			natureza_pendencia_federal.descricao_natureza,agrupamento_federal.descricao_agrupamento,
			inscricao_divida_ativa,processo, debito_cobranca_rfb,debito_cobranca_pgfn,descricao_pendencia,valor_pendencia,descricao_area_focal	
			from cnd_fed_tratativa
			left join esfera on esfera.id = cnd_fed_tratativa.esfera 
			left join etapa on etapa.id = cnd_fed_tratativa.etapa 
			left join status_chamado_interno on status_chamado_interno.id = cnd_fed_tratativa.status_chamado_sis_ext 
			left join status_demanda on status_demanda.id = cnd_fed_tratativa.id 
			left join origem_pendencia on origem_pendencia.codigo = cnd_fed_tratativa.origem_pendencia
			left join natureza_pendencia_federal on natureza_pendencia_federal.codigo = cnd_fed_tratativa.natureza_pendencia
			left join agrupamento_federal on agrupamento_federal.codigo = cnd_fed_tratativa.agrupamento
			left join area_focal_federal on area_focal_federal.codigo = cnd_fed_tratativa.area_focal
			where cnd_fed_tratativa.id_contratante = ? and cnd_fed_tratativa.id = ?";

	$query = $this->db->query($sql, array($idContratante,$id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function addObsTrat($detalhes = array()){ 
	if($this->db->insert('cnd_fed_tratativa_obs', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	return false;
 }
 
  function atualizar_tratativa($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_fed_tratativa', $dados); 
	return true;
 }

 function listarNaturezaPendencia(){
   $this -> db -> select('*');
   $this -> db -> from('natureza_pendencia');
   $query = $this -> db -> get();
	if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarNaturezaPendenciaFederal(){
   $this -> db -> select('*');
   $this -> db -> from('natureza_pendencia_federal');
   $query = $this -> db -> get();

	if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
  function listarStatusFederal(){
   $this -> db -> select('*');
   $this -> db -> from('status_federal');
   $query = $this -> db -> get();
  if($query -> num_rows() <> 0){
     return $query->result();
  }else{
     return false;
   }
 }
 
   function listarAreaFocalFederal(){
   $this -> db -> select('*');
   $this -> db -> from('area_focal_federal');
   $query = $this -> db -> get();
  if($query -> num_rows() <> 0){
     return $query->result();
  }else{
     return false;
   }
 }
  
 function listarAgrupamentoFederal(){
   $this -> db -> select('*');
   $this -> db -> from('agrupamento_federal');
   $query = $this -> db -> get();
	if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarAgrupamento(){
   $this -> db -> select('*');
   $this -> db -> from('agrupamento');
   $query = $this -> db -> get();
	if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarStatusInterno(){
   $this -> db -> select('*');
   $this -> db -> from('status_chamado_interno');
 
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
	
}
?>