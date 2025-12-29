
<hr style="background-color:#002060!important;">
<h4 class="panel-title" style='color:#002060'> Lista das Taxas&nbsp;&nbsp;
<a class="btn btn-success" style='color:#fff' href="<?php echo $this->config->base_url(); ?>index.php/cnd_brasil/export_tratativas_ext?id=<?php echo $id_cnd?>" > <i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Exportar</a>
<span  class="btn btn-primary" style='float:right;background-color:#002060!important;border: 1px solid #002060 !important' id='nova-taxa'>Nova Taxa</span>
</h4>
<BR>

<div class="form-group" >

<table class="table table-bordered"  cellspacing="0" width="100%" >
<thead>
<tr style='font-size:10px!important;text-align:center'>
	<th style='width:20%;text-align:center'>Tipo das taxas</th>
	<th style='width:20%;text-align:center'>Periocidade das taxas</th>	
	<th style='width:30%;text-align:center'>Resp. pagamento</th>
	<th style='width:20%;text-align:center'>Mês pagamento</th>
	<th style='width:20%;text-align:center'>Vencimento</th>
</tr>	
</thead>
<tbody>
<?php 		
$isArray =  is_array($taxas) ? '1' : '0';			
if($isArray == 0){ ?>
<?php 	
}else{			
	foreach($taxas as $key => $tra){
		$cor='#fff';
?>
<tr  id=<?php echo $tra->id; ?> class='abrir-taxa' style="cursor: pointer;">
<td style='width:30%;font-size:10px!important;background-color:<?php echo $cor; ?>'class="col-sm-2">&nbsp;<?php echo $tra->tipo_taxas; ?></td>
<td style='width:20%;font-size:10px!important;background-color:<?php echo $cor; ?>' class="col-sm-2">&nbsp;<?php echo $tra->periodo_taxas;  ?></td>
<td style='width:30%;font-size:10px!important;background-color:<?php echo $cor; ?>'class="col-sm-2">&nbsp;<?php echo $tra->responsavel_pagamento; ?></td>
<td style='width:20%;font-size:10px!important;background-color:<?php echo $cor; ?>'class="col-sm-2">&nbsp;<?php echo meses($tra->mes_pagamento); ?> </td>
<td style='width:20%;font-size:10px!important;background-color:<?php echo $cor; ?>' class="col-sm-2">&nbsp;<?php echo $tra->data_vencto_bd  == '11/11/1111' ? "-" : $tra->data_vencto_bd; ?></td>				
</tr>
<?php
}//fim foreach
}//fim if
?>
</tbody>
</table>

</div>

	<span id='fim_taxa'></span>

<?php
$attributes = array('class' => 'form-horizontal style-form','id'=>'form');
echo form_open_multipart('licencas/atualizar_cnd_mob_tratativa_unica', $attributes); 
?>

<input type="hidden" readonly='yes' name='modulo' id='modulo'  value='<?php echo $modulo ?>'>
<input type="hidden" readonly='yes' name='id' id='id'  value='<?php echo $id_cnd ?>'>
<input type="hidden" readonly='yes' name='statusChamado' id='statusChamado' value='1' >
<input type="hidden" readonly='yes' name='tipo_tratativa' id='statusChamado' value='2' >
<input type="hidden" readonly='yes' name='ultimoIdTratativa' id='ultimoIdTratativa'  value='<?php echo $idTratativa?>'>	


<div id='detalhe-taxa' style='display:none'>
	<div class="form-group">
<h4 class="panel-title" style='color:#002060'>&nbsp;&nbsp;&nbsp;&nbsp; Taxas  </h4>
<Br>
<div class="col-lg-3">Tipo das taxas</div>
<div class="col-lg-3">Periocidade das taxas</div>
<div class="col-lg-3">Responsável pelo pagamento</div>
<div class="col-lg-3">Mês de pagamento</div>
</div>



<div class="form-group">
<input type="hidden" readonly='yes' name='acao' id='acao_taxa'  value=''>
<input type="hidden" id='id_tratativa_taxa' readonly='yes'  name='id_tratativa' class="form-control"  value='' placeholder="ID">
<input type="hidden" id='data_informe_pendencia2' name='data_informe_pendencia'  value='11/11/1111' >    
<input type="hidden" id='prazo_solucao' name='prazo_solucao' class="form-control"  value='11/11/1111'  >  
<input type="hidden" id='id_sla_sis_ext' name='id_sla' class="form-control"  value='' placeholder="SLA">  								
<input type="hidden" id='tipo_tratativa' name='tipo_tratativa' class="form-control"  value='2' placeholder="SLA">  								
<div class="col-lg-3">
<select name="tipo_taxa" id="tipo_taxa" required=""  class='custom-select' style='width:200px;height:30px'>	
			<option value="0">Escolha</option>								  
			<?php foreach($tipoTaxa as $key => $etapa){ ?>								 
			<option value="<?php echo $etapa->id ?>"><?php echo $etapa->descricao?></option>	
			<?php }?>								
		</select> 
</div>
<div class="col-lg-3">
<select name="periodo_taxas" id="periodo_taxas" required=""  class='custom-select' style='width:200px;height:30px'>	
			<option value="0">Escolha</option>								  
			<?php foreach($periodoTaxa as $key => $stInt){ ?>								 
			<option value="<?php echo $stInt->id ?>"><?php echo $stInt->descricao?></option>	
			<?php								  
			}								  							 
			?>								
		</select>  
</div>


<div class="col-lg-3">
<input type="text" id='responsavel_pagamento' name='responsavel_pagamento' class="form-control"  value='' placeholder="Responsável Pagto"  style='width:160px' >                                
</div>

<div class="col-lg-3">
<select name="mes_pagamento" id="mes_pagamento" required=""  class='custom-select' style='width:200px;height:30px'>	
	<option value="0">Escolha</option>		
 <?php
for ($i = 1; $i <= 12; $i++) {?>
    <option value="<?php echo $i ?>"><?php echo meses($i)?></option>	
<?php } ?> 
			
</select> 
</div>


</div>


<div class="form-group">
<div class="col-lg-4">Vencimento</div>	
<div class="col-lg-4">Modo de emissão das taxas</div>
<div class="col-lg-4">Observação</div>	
</div>

<div class="form-group">

<div class="col-lg-4">
<input type="text" id='data_vencto' name='data_vencto' class="form-control"  value='' placeholder="Data Vencimento" data-masked="" data-inputmask="'mask': '99/99/9999' "  style='width:140px'>                                							
</div>

<div class="col-lg-4">
<input type="text" id='modo_emissao' name='modo_emissao' class="form-control"  value='' placeholder="Modo de emissão" >                                                             
</div>


<div class="col-lg-4">
<input type="text" id='observacao' name='observacao' class="form-control"  value='' placeholder="Observação" >                                                             
</div>

<input type="hidden" id='senha' name='senha' class="form-control"  value='' placeholder="Senha" style='width:250px'>                                                             
<input type="hidden" id='regra_taxa' name='regra_taxa' class="form-control"  value='' placeholder="Senha" style='width:140px'>  
<input type="hidden" id='competencia' name='competencia' class="form-control"  value='' placeholder="Competência" style='width:180px'>  
<input type="hidden" id='org_resp' name='org_resp' class="form-control"  value='' placeholder="Orgão Responsável" style='width:160px'>  

</div>
 


<!--
<div class="form-group" >
<div class="col-lg-12">
<BR>
</div>
                                    <h4 class="panel-title" style='color:#002060'>&nbsp;&nbsp;&nbsp;&nbsp; Observações  </h4>
<BR>
<div class="col-lg-12">
	<div class="col-lg-3">
		Inserir Nova Observação 
	</div>
	<div class="col-lg-9">
		<input type="text" id='nova_tratativa' name='nova_tratativa' class="form-control"  value='' placeholder="Observações">                          
	</div>
</div>
<BR><BR>
<div class="col-lg-12">
	<div class="col-lg-3">
	</div>
	<div class="col-lg-9">
		<?php if(($adm == 1) or ($adm == 2)){ ?>	
		<span class="btn btn-primary" id='uploadObservacao' style='background-color:#002060!important;border: 1px solid #002060 !important;float:left'  data-toggle="modal" data-target="#uploadArquivo" >Upload Arquivo Observação </span> &nbsp;&nbsp;&nbsp;<span style='color:#00B0F0;font-weight:bold;font-size:30px' class='mostrar-texto' id='2' > ? </span>
		<?php } ?>
	</div>
</div>
<BR><BR>
<div class="col-lg-12">
	<div class="col-lg-4" >
		Histórico : Observações/Tratativas                         
	</div>
	<div class="col-lg-8" id='cnd_mob_trat_obs'>
	</div>
</div>
<BR><BR>
-->
<div class="form-group">
    <div class="col-sm-12 ">
<?php if(($adm == 1) or ($adm == 2)){ ?>	
    <button class="btn btn-primary" id='salvar' style='background-color:#002060!important;border: 1px solid #002060 !important' type="submit">Salvar</button>
<?php } ?>
    </div>
</div>			

</form>

</div>