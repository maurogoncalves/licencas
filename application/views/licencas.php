
<hr style="background-color:#002060!important;">
<h4 class="panel-title" style='color:#002060'> Lista das Licenças&nbsp;&nbsp;
<a class="btn btn-success" style='color:#fff' href="<?php echo $this->config->base_url(); ?>index.php/cnd_brasil/export_tratativas_ext?id=<?php echo $id_cnd?>" > <i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Exportar</a>
<span  class="btn btn-primary" style='float:right;background-color:#002060!important;border: 1px solid #002060 !important' id='nova-tratativa'>Nova Licença</span>
</h4>
<BR>

<div class="form-group" >
<span id='fim'></span>
<table class="table table-bordered"  cellspacing="0" width="100%" >
<thead>
<tr style='font-size:10px!important;text-align:center'>
	<th style='width:15%;text-align:center'>Tipo da Licença</th>
	<th style='width:20%;text-align:center'>Tipo da aplicação</th>
	<th style='width:15%;text-align:center'>Renovação de licença</th>
	<th style='width:30%;text-align:center'>Resp. Renovação </th>
	<th style='width:15%;text-align:center'>Data de Validade</th>
</tr>	
</thead>
<tbody>
<?php 		
$isArray =  is_array($tratativas) ? '1' : '0';			
if($isArray == 0){ ?>
<?php 	
}else{			
	foreach($tratativas as $key => $tra){
		$cor='#fff';
?>
<tr  id=<?php echo $tra->id; ?> class='abrir-detalhe' style="cursor: pointer;">
<td style='width:15%;font-size:10px!important;background-color:<?php echo $cor; ?>' class="col-sm-2">&nbsp;<?php echo $tra->descricao_natureza_raiz;  ?></td>
<td style='width:20%;font-size:10px!important;background-color:<?php echo $cor; ?>'class="col-sm-2">&nbsp;<?php echo $tra->descricao_tipo_aplicacao; ?></td>
<td style='width:15%;font-size:10px!important;background-color:<?php echo $cor; ?>'class="col-sm-2">&nbsp;<?php echo $tra->periodo_renovacao_licenca; ?> </td>
<td style='width:30%;font-size:10px!important;background-color:<?php echo $cor; ?>' class="col-sm-2">&nbsp;<?php echo $tra->etapa ?></td>				
<td style='width:15%;font-size:10px!important;background-color:<?php echo $cor; ?>' class="col-sm-2">&nbsp;<?php echo $tra->data_informe_pendencia_bd  == '11/11/1111' ? "-" : $tra->data_informe_pendencia_bd; ?></td>				
</tr>
<?php
}//fim foreach
}//fim if
?>
</tbody>
</table>

</div>

	

<?php
$attributes = array('class' => 'form-horizontal style-form','id'=>'form');
echo form_open_multipart('licencas/atualizar_cnd_mob_tratativa_unica', $attributes); 
?>

<input type="hidden" readonly='yes' name='modulo' id='modulo'  value='<?php echo $modulo ?>'>
<input type="hidden" readonly='yes' name='id' id='id'  value='<?php echo $id_cnd ?>'>
<input type="hidden" readonly='yes' name='statusChamado' id='statusChamado' value='1' >
<input type="hidden" readonly='yes' name='tipo_tratativa' id='tipoTratativa' value='1' >
<input type="hidden" readonly='yes' name='ultimoIdTratativa' id='ultimoIdTratativa'  value='<?php echo $idTratativa?>'>	


<div id='detalhe-tratativa'>
	<div class="form-group">

<h4 class="panel-title" style='color:#002060'>&nbsp;&nbsp;&nbsp;&nbsp; Detalhes da Licença  </h4>
<BR>							
	<div class="col-lg-3">Tipo da Licença</div>
	<div class="col-lg-3">Tipo da aplicação</div>
	<div class="col-lg-3">Categoria da Licença</div>	
	<div class="col-lg-3">Responsável pela renovação</div>
</div>

<div class="form-group">
<input type="hidden" readonly='yes' name='acao' id='acao'  value=''>
<input type="hidden" id='id_tratativa' readonly='yes'  name='id_tratativa' class="form-control"  value='' placeholder="ID">
<input type="hidden" id='data_informe_pendencia2' name='data_informe_pendencia'  value='11/11/1111' >    
<input type="hidden" id='prazo_solucao' name='prazo_solucao' class="form-control"  value='11/11/1111'  >  
<input type="hidden" id='id_sla_sis_ext' name='id_sla' class="form-control"  value='' placeholder="SLA">  								

<div class="col-lg-3">
<select name="id_natureza_raiz" id="id_natureza_raiz" required=""  class='custom-select' style='height:30px;width:200px'>
<option value="0">Escolha</option>		
<?php foreach($natureza_raiz as $key => $etapa){ ?>								 
<option value="<?php echo $etapa->codigo ?>"><?php echo $etapa->descricao_natureza_raiz?></option>	
<?php } ?>
</select>                                  
</div>
<div class="col-lg-3">
<select name="id_pendencia" id="id_pendencia" required=""  class='custom-select' style='height:30px;width:200px'>
<option value="0">Escolha</option>		
<?php foreach($tipo_aplicacao as $key => $etapa){ ?>								 
<option value="<?php echo $etapa->codigo ?>"><?php echo $etapa->descricao_tipo_aplicacao?></option>	
<?php } ?>
</select>       
</div>
<div class="col-lg-3">
<select name="id_esfera" id="id_esfera" required=""  class='custom-select' style='height:30px;width:200px'>	
<option value="0">Escolha</option>	
<?php foreach($esferas as $key => $esfera){ ?>								 
<option value="<?php echo $esfera->id ?>"><?php echo $esfera->descricao_esfera?></option>	
<?php }?>								
</select>   
</div>
<div class="col-lg-3">
<input type="text" id='id_etapa' name='id_etapa' class="form-control"  value='' placeholder="Responsável Renovação"  style='width:160px' >                                


</div>
</div>

<div class="form-group">
<BR>
	<div class="col-lg-3">Renovação da Licença</div>
	<div class="col-lg-3">Data da Emissão </div>	
	<div class="col-lg-3">Data de Validade</div>
	<div class="col-lg-3">Mês de pagamento</div>
</div>

<div class="form-group">
<div class="col-lg-3">

<select name="periodo_renovacao" id="periodo_renovacao" required=""  class='custom-select' style='width:200px;height:30px'>	
			<option value="0">Escolha</option>								  
			<?php foreach($periodoRenovacao as $key => $stInt){ ?>								 
			<option value="<?php echo $stInt->id ?>"><?php echo $stInt->descricao?></option>	
			<?php								  
			}								  							 
			?>								
		</select>
</div>


<div class="col-lg-3">

<input type="text" id='data_emissao' name='data_emissao' class="form-control"  value='' placeholder="Data Emissão" data-masked="" data-inputmask="'mask': '99/99/9999' " style='width:160px' >                                
<input type="hidden" id='status_chamado_sis_ext' name='status_chamado_sis_ext' value='0' >                                


</div>
<div class="col-lg-3">
<input type="text" id='data_criacao' name='data_criacao' class="form-control"  value='' placeholder="Data Validade" data-masked="" data-inputmask="'mask': '99/99/9999' " style='width:160px' >                                
</div>
<div class="col-lg-3">
<select name="mes_pagamento" id="mes_pagamento_trat" required=""  class='custom-select' style='width:200px;height:30px'>	
	<option value="0">Escolha</option>		
 <?php
for ($i = 1; $i <= 12; $i++) {?>
    <option value="<?php echo $i ?>"><?php echo meses($i)?></option>	
<?php } ?> 
			
</select> 
</div>
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