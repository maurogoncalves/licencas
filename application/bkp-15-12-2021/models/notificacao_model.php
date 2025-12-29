<?php
Class Notificacao_model extends CI_Model{
	

  function listarTodos($id_contratante,$cidade,$estado){
   $sql = "select notificacao.*,imovel.nome,imovel.cidade,imovel.estado,
			esfera.descricao_esfera,alerta_no_prazo.descricao as alerta_prazo,prioridade_ocorrencia.descricao as prioridade_demanda,
			risco.descricao as risco_atuacao,status_notificacao.descricao,notificacao.id as id_notif,DATE_FORMAT(data_ciencia_notificacao,'%d/%m/%Y') as data_ciencia_notificacao_br, DATE_FORMAT(data_prazo_atendimento,'%d/%m/%Y') as data_prazo_atendimento_br, 
			DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_br,  DATE_FORMAT(data_atendimento,'%d/%m/%Y') as data_atendimento_br,  DATE_FORMAT(data_encerr,'%d/%m/%Y') as data_encerr_br, 
			DATE_FORMAT(data_receb_term_encerr,'%d/%m/%Y') as data_receb_term_encerr_br
			from notificacao
			left join loja on notificacao.id_loja = loja.id
			left join imovel on imovel.id = loja.id_imovel
			left join esfera on esfera.id = notificacao.id_esfera
			left join alerta_no_prazo on alerta_no_prazo.id = notificacao.alerta_prazo_atendimento
			left join prioridade_ocorrencia on prioridade_ocorrencia.id = notificacao.prioridade
			left join prioridade_ocorrencia as risco on risco.id = notificacao.risco_atuacao
			left join status_notificacao on status_notificacao.id = notificacao.`status`
			where notificacao.id_contratante = ? ";
 $query = $this->db->query($sql, array($id_contratante));
      
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
  function calcularDias($dt1,$dt2){
	  $sql = "SELECT DATEDIFF(?,?) AS dias";
	  $query = $this->db->query($sql, array($dt1,$dt2));
	  $array = $query->result(); 
      return($array);
  }
   function listarTodasNotificacaoByEstadoCidade($id_contratante,$id,$op){
   if($op==1){
	    $sql = "select notificacao.*,imovel.nome,imovel.cidade,imovel.estado,
			esfera.descricao_esfera,alerta_no_prazo.descricao as alerta_prazo,prioridade_ocorrencia.descricao as prioridade_demanda,
			risco.descricao as risco_atuacao,status_notificacao.descricao,notificacao.id as id_notif,DATE_FORMAT(data_ciencia_notificacao,'%d/%m/%Y') as data_ciencia_notificacao_br, DATE_FORMAT(data_prazo_atendimento,'%d/%m/%Y') as data_prazo_atendimento_br, 
			DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_br,  DATE_FORMAT(data_atendimento,'%d/%m/%Y') as data_atendimento_br,  DATE_FORMAT(data_encerr,'%d/%m/%Y') as data_encerr_br, 
			DATE_FORMAT(data_receb_term_encerr,'%d/%m/%Y') as data_receb_term_encerr_br
			from notificacao
			left join loja on notificacao.id_loja = loja.id
			left join imovel on imovel.id = loja.id_imovel
			left join esfera on esfera.id = notificacao.id_esfera
			left join alerta_no_prazo on alerta_no_prazo.id = notificacao.alerta_prazo_atendimento
			left join prioridade_ocorrencia on prioridade_ocorrencia.id = notificacao.prioridade
			left join prioridade_ocorrencia as risco on risco.id = notificacao.risco_atuacao
			left join status_notificacao on status_notificacao.id = notificacao.`status`
			where notificacao.id_contratante = ? and loja.cidade = ?";
   }elseif($op==2){
	    $sql = "select notificacao.*,imovel.nome,imovel.cidade,imovel.estado,
			esfera.descricao_esfera,alerta_no_prazo.descricao as alerta_prazo,prioridade_ocorrencia.descricao as prioridade_demanda,
			risco.descricao as risco_atuacao,status_notificacao.descricao,notificacao.id as id_notif,DATE_FORMAT(data_ciencia_notificacao,'%d/%m/%Y') as data_ciencia_notificacao_br, DATE_FORMAT(data_prazo_atendimento,'%d/%m/%Y') as data_prazo_atendimento_br, 
			DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_br,  DATE_FORMAT(data_atendimento,'%d/%m/%Y') as data_atendimento_br,  DATE_FORMAT(data_encerr,'%d/%m/%Y') as data_encerr_br, 
			DATE_FORMAT(data_receb_term_encerr,'%d/%m/%Y') as data_receb_term_encerr_br
			from notificacao
			left join loja on notificacao.id_loja = loja.id
			left join imovel on imovel.id = loja.id_imovel
			left join esfera on esfera.id = notificacao.id_esfera
			left join alerta_no_prazo on alerta_no_prazo.id = notificacao.alerta_prazo_atendimento
			left join prioridade_ocorrencia on prioridade_ocorrencia.id = notificacao.prioridade
			left join prioridade_ocorrencia as risco on risco.id = notificacao.risco_atuacao
			left join status_notificacao on status_notificacao.id = notificacao.`status`
			where notificacao.id_contratante = ? and loja.estado = ?";

   }else{
	    $sql = "select notificacao.*,imovel.nome,imovel.cidade,imovel.estado,
			esfera.descricao_esfera,alerta_no_prazo.descricao as alerta_prazo,prioridade_ocorrencia.descricao as prioridade_demanda,
			risco.descricao as risco_atuacao,status_notificacao.descricao,notificacao.id as id_notif,DATE_FORMAT(data_ciencia_notificacao,'%d/%m/%Y') as data_ciencia_notificacao_br, DATE_FORMAT(data_prazo_atendimento,'%d/%m/%Y') as data_prazo_atendimento_br, 
			DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_br,  DATE_FORMAT(data_atendimento,'%d/%m/%Y') as data_atendimento_br,  DATE_FORMAT(data_encerr,'%d/%m/%Y') as data_encerr_br, 
			DATE_FORMAT(data_receb_term_encerr,'%d/%m/%Y') as data_receb_term_encerr_br
			from notificacao
			left join loja on notificacao.id_loja = loja.id
			left join imovel on imovel.id = loja.id_imovel
			left join esfera on esfera.id = notificacao.id_esfera
			left join alerta_no_prazo on alerta_no_prazo.id = notificacao.alerta_prazo_atendimento
			left join prioridade_ocorrencia on prioridade_ocorrencia.id = notificacao.prioridade
			left join prioridade_ocorrencia as risco on risco.id = notificacao.risco_atuacao
			left join status_notificacao on status_notificacao.id = notificacao.`status`
			where notificacao.id_contratante = ? and loja.id = ?";
   }
		$query = $this->db->query($sql, array($id_contratante,$id));
      
   
   $array = $query->result(); 
   
   return($array);
   

 }
 
 function listarNotById($id){
   $sql = "select notificacao.*, DATE_FORMAT(data_ciencia_notificacao,'%d/%m/%Y') as data_ciencia_notificacao_br, DATE_FORMAT(data_prazo_atendimento,'%d/%m/%Y') as data_prazo_atendimento_br, 
			DATE_FORMAT(data_envio,'%d/%m/%Y') as data_envio_br,  DATE_FORMAT(data_atendimento,'%d/%m/%Y') as data_atendimento_br,  DATE_FORMAT(data_encerr,'%d/%m/%Y') as data_encerr_br, 
			DATE_FORMAT(data_receb_term_encerr,'%d/%m/%Y') as data_receb_term_encerr_br, imovel.nome,imovel.cidade, imovel.estado, notificacao.id as id_notif,notificacao.arquivo  from notificacao  left join loja on notificacao.id_loja = loja.id  
			left join imovel on imovel.id = loja.id_imovel  where notificacao.id = ? ";
	$query = $this->db->query($sql, array($id));
   $array = $query->result();    
   return($array);
  
 }
 
  function listarPrioridade(){
   $this -> db -> select('*');
   $this -> db -> from('prioridade_ocorrencia');
 
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
 
  function listarStatus(){
   $this -> db -> select('*');
   $this -> db -> from('status_notificacao');
 
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
  
 function listarAlerta(){
   $this -> db -> select('*');
   $this -> db -> from('alerta_no_prazo');
 
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
 
 
  function atualizar($dados,$id){ 
  
	$this->db->where('id', $id);
	$this->db->update('notificacao', $dados); 

	return true;  
 } 
 
  function buscaEstado($idContratante,$id){	
  
	$sql = "select distinct loja.estado as uf from loja  left join notificacao on loja.id = notificacao.id_loja  where notificacao.id_contratante = ? order by loja.estado";
	$query = $this->db->query($sql, array($idContratante));
  
	$array = $query->result(); 
    return($array);

 }
 
   function listarTodasNotificacao($idContratante,$id,$op){	
  
    if($id <> '0'){
		if($op=='1'){
			$sql = "SELECT distinct loja.id,`emitente`.`nome_fantasia` as razao_social  FROM  notificacao left join `loja` on notificacao.id_loja = loja.id
			JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`   WHERE `loja`.`id_contratante` = ? and loja.estado = ? ORDER BY `emitente`.`nome_fantasia`";
		}else{
			$sql = "SELECT distinct loja.id,`emitente`.`nome_fantasia` as razao_social  FROM  notificacao left join `loja` on notificacao.id_loja = loja.id
			JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`   WHERE `loja`.`id_contratante` = ? and loja.cidade = ? ORDER BY `emitente`.`nome_fantasia`";
		}
		
		$query = $this->db->query($sql, array($idContratante,$id));
	
	}else{

		$sql = "SELECT distinct loja.id,`emitente`.`nome_fantasia` as razao_social  FROM  notificacao left join `loja` on notificacao.id_loja = loja.id
			JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente`   WHERE `loja`.`id_contratante` = ?  ORDER BY `emitente`.`nome_fantasia`";
		$query = $this->db->query($sql, array($idContratante));
		
	}
	
  
	$array = $query->result(); 
    return($array);

 }
 
   function buscaCidade($idContratante,$id){	
   
    if($id == '0'){		
		$sql = "select distinct loja.cidade from loja  left join notificacao on loja.id = notificacao.id_loja  where notificacao.id_contratante = ? order by loja.cidade";		
		$query = $this->db->query($sql, array($idContratante));
	}else{
		$sql = "select distinct loja.cidade from loja  left join notificacao on loja.id = notificacao.id_loja  where notificacao.id_contratante = ? and loja.estado = ? order by loja.cidade";
		$query = $this->db->query($sql, array($idContratante,$id));	
	}
	
  
	$array = $query->result(); 
    return($array);

 }
 
 function buscaLojaByCidade($idContratante,$id){	
	$sql = "SELECT distinct loja.id as id_loja,`emitente`.`nome_fantasia` as razao_social 
			FROM (`loja`) left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			WHERE `loja`.`id_contratante` = ?
			AND `loja`.`cidade` = ? 
			ORDER BY `emitente`.`nome_fantasia` ";
	$query = $this->db->query($sql, array($idContratante,$id));
  
	$array = $query->result(); 
    return($array);

 }
 
 
  function buscaTodasLojasNotificacao($idContratante){	
	$sql = "SELECT distinct loja.id as id_loja,`emitente`.`nome_fantasia` as razao_social 
			FROM (`loja`) left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			WHERE `loja`.`id_contratante` = ?
			ORDER BY `emitente`.`nome_fantasia` ";
	$query = $this->db->query($sql, array($idContratante));
  
	$array = $query->result(); 
    return($array);

 }
 
 
  function buscaTodasObservacoes($id){	
	$sql = "SELECT DATE_FORMAT(data,'%d/%m/%Y') as data,hora,observacao,usuarios.email
			FROM (`notificacao_observacao`) 	
			left join usuarios on usuarios.id = notificacao_observacao.id_usuario
			WHERE `notificacao_observacao`.`id_not` = ?
			ORDER BY `notificacao_observacao`.`data` ";
			
	$query = $this->db->query($sql, array($id));
  
	$array = $query->result(); 
    return($array);

 }
 
 
 public function add($detalhes = array()){ 
	if($this->db->insert('notificacao', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	
	
	public function addObs($detalhes = array()){ 
	if($this->db->insert('notificacao_observacao', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	
}

 
 
?>