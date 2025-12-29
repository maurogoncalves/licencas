<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-editable.min.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/moment-with-locales.min.js"></script>		


<script type="text/javascript">	
$(document).ready(function(){
			 
$( "#estado" ).change(function() {

		var estado = $('#estado').val();	
		
		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCidadeByEstado?estado=" + estado,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#municipio').html(data);
					}
						
				}
			 }); 		
						 
				
			
	});
	
$( "#municipio" ).change(function() {
		var status = $('#status').val();
		var municipio = $('#municipio').val();
		var municipio = $( "#municipio option:selected" ).text();
		
		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaLojaByCidade?id=" + municipio,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#imovel').html(data);
					}
						
				}
			 }); 	

				 
				
				 
				
			
	});

	
	
	
	$( "#limpar" ).click(function() {
		$("#limpar_filtro").submit();
	});
	
	$( "#export" ).click(function() {
		var id_loja = $('#imovel').val();	
		var municipio = $('#municipio').val();	
		var estado = $('#estado').val();
		var status = $('#status').val();	
		var tabela = $('#tab').val();	
		
			
		if((id_loja == '0') && (municipio == '0') && (estado == '0'))  {
			$("#id_imovel_export").val(id_loja);
			$("#id_status").val(status);
			$("#tabela_est").val(tabela);
			$("#tabela_mun").val(tabela);
			$("#tabela_im").val(tabela);
			$("#export_imovel").submit();
			
		}else{		
			if(id_loja != '0'){
				$("#id_imovel_export").val(id_loja);
				$("#id_status").val(status);
				$("#tabela_est").val(tabela);
				$("#tabela_mun").val(tabela);
				$("#tabela_im").val(tabela);
				
				$("#export_imovel").submit();
				
			}else{
				if(municipio == '0'){	
					$("#id_estado_export").val(estado);
					$("#id_status_est").val(status);
					$("#tabela_est").val(tabela);
					$("#tabela_mun").val(tabela);
					$("#tabela_im").val(tabela);
					
					$( "#export_estado" ).submit();
				}else{
					$("#id_mun_export").val(municipio);
					$("#id_status_mun").val(status);
					$("#tabela_est").val(tabela);
					$("#tabela_mun").val(tabela);
					$("#tabela_im").val(tabela);
					
					$( "#export_mun" ).submit();
				}
			}
		}
	});
	
	var cidadeBD = $('#cidadeBD').val();			
	var estadoBD = $('#estadoBD').val();			
	var idLojaBD = $('#idLojaBD').val();
	$('#estado').val(estadoBD);		
	
	if(estadoBD !=='0'){
		$.ajax({		
				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCidadeByEstado?estado=" + estadoBD,		
				type : 'GET', /* Tipo da requisição */ 		
				contentType: "application/json; charset=utf-8",       	
				dataType: 'json', /* Tipo de transmissão */			
				success: function(data){					
					if (data == undefined ) {					
						console.log('Undefined');				
					} else {					
						$('#municipio').html(data);
						$('#municipio').val(cidadeBD);							
					}								
				}	 
			}); 			
			$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaLojaByEstado?id=" + estadoBD,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#imovel').html(data);
						$('#imovel').val(idLojaBD);	
					}
						
				}
			 }); 
	}
	
	if(cidadeBD !=='0'){
		
		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaLojaByCidade?id=" + cidadeBD+"&status="+status,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#imovel').html(data);
						$('#imovel').val(idLojaBD);	
					}
						
				}
			 }); 
		
	}	
		

});		
</script>
        

		<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Lojas <small>	
								<?php if($this->session->flashdata('messagemLoja')){?>
											<span style='color:#FF0000;'> <?php echo $this->session->flashdata('messagemLoja');?></span>
											<?php }?>
								</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/dados_agrupados"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Lojas</li>
									
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-card ">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> 
									<a href="<?php echo $this->config->base_url();?>index.php/loja/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nova Loja</a> 
									&nbsp;				  									
									<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<input type='hidden' id='cidadeBD' name='cidadeBD' value='<?php echo$cidadeBD ?>'>	
									<input type='hidden' id='estadoBD' name='estadoBD' value='<?php echo$estadoBD ?>'>	
									<input type='hidden' id='idLojaBD' name='idLojaBD' value='<?php echo$idLojaBD ?>'>
									<br>
									<?php
									
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('loja/listar', $attributes); 
									?>
									<select name="estadoListar" id="estado" class='procuraImovel'>				 
										<option value="0" selected>Escolha um estado</option>						
										<?php foreach($estados as $key => $estado){ ?>					 
										<option value="<?php echo $estado->uf ?>"><?php echo $estado->uf?></option>					   
										<?php					
										}								    				  
										?>				 
									</select>	
									 &nbsp;	
									<select name="municipioListar" id="municipio" class='procuraImovel'>				  
										<option value="0" selected>Escolha uma Cidade</option>	
										<?php foreach($cidades as $key => $cidade){ ?>					 
										<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>					   
										<?php					
										}								    				  
										?>												
									</select>
									<br><br>									

									<select name="idImovelListar" id="imovel" class='procuraImovel'>				 
									<option value="0" selected>Todos</option>
										<?php foreach($todas_lojas as $key => $loja){ ?>					 
										<option value="<?php echo $loja->id ?>"><?php echo $loja->razao_social?></option>					   
										<?php					
										}								    				  
										?>											
									</select>
								
								  
								  <br> 	<br>				   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
								<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/loja/export' method='post'>							
								  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>	
								  <input type='hidden' id='id_status' name='id_status' >		
									<input type='hidden' id='tabela_im' name='tabela' value=''>				  						  		  						  
								 </form>												
								 <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/loja/export_mun' method='post'>	
								  <input type='hidden' id='id_mun_export' name='id_mun_export'>
									<input type='hidden' id='id_status_mun' name='id_status' >
									<input type='hidden' id='tabela_mun' name='tabela' value=''>				  						  
								 </form>												
								 <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/loja/export_est' method='post'>
									  <input type='hidden' id='id_estado_export' name='id_estado_export'>	
									<input type='hidden' id='id_status_est' name='id_status' >				  						  
									<input type='hidden' id='tabela_est' name='tabela' value=''>				  						  
								 </form>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                 <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											<th > Nome</th>												  
											<th > CPF/CNPJ</th>
											<th > Cidade</th>
											<th > Estado</th>
											<th > Status</th>
											<th > A&ccedil;&otilde;es</th>									  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
											<th > Nome</th>												  
											<th > CPF/CNPJ</th>
											<th > Estado</th>
											<th > Cidade</th>											
											<th > Status</th>
											<th > A&ccedil;&otilde;es</th>										  
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($emitentes) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
										}else{			
											 foreach($emitentes as $key => $emitente){ 	
												if($emitente->ativo == 0){
													$status='Ativo';
												}else{
													$status='Inativo';
												}	
											 ?>
												 <tr>
												 <td ><?php echo $emitente->nome_loja; ?></td>
												  <td ><?php echo $emitente->cnpj; ?></td>
												  <td ><?php echo $emitente->estado; ?></td>
												  <td ><?php echo $emitente->cidade; ?></td>
												  <td ><?php echo $status; ?></td>												  
												  <td >
												  <a href="<?php echo $this->config->base_url();?>index.php/loja/editar?id=<?php echo $emitente->id; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
												  <?php if($visitante == 0){ ?>
													  <a href="<?php echo $this->config->base_url();?>index.php/loja/ativar?id=<?php echo $emitente->id; ?>" class="btn btn-success btn-xs" title='Ativar'><i class="fa fa-check"></i></a>													  
													  <a href="<?php echo $this->config->base_url();?>index.php/loja/excluir?id=<?php echo $emitente->id; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>
													  <a href="<?php echo $this->config->base_url();?>index.php/licencas/visao_interna_cnd_mob?id=<?php echo $emitente->id; ?>" class="btn btn-warning btn-xs" title='Licen&ccedil;as'><i class="fa fa-file-o "></i></a>
													  
												<?php } ?>	  												  
												</td>							  										
												</tr>

											  <?php
											}//fim foreach
										  }//fim if
										  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- End .panel -->  
                        </div><!--end .col-->
                    </div><!--end .row-->

									

                </div> 
            </div>

 <script type="text/javascript">

(function(window, document, $, undefined){
    
    $(function(){
		
		 $('#fruits').editable({
           pk: 1,
           limit: 3,
           source: [
            {value: 1, text: 'banana'},
            {value: 2, text: 'peach'},
            {value: 3, text: 'apple'},
            {value: 4, text: 'watermelon'},
            {value: 5, text: 'orange'}
           ]
        });
	});

})(window, document, window.jQuery);
</script>