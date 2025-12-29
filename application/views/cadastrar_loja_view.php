<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 
<script type="text/javascript">
jQuery(function($) {    
	$('.auto').autoNumeric('init');	});
</script>    
<script>		
	var mask = {		
		money: function() {			
		var el = this,
			exec = function(v) {			
			v = v.replace(/\D/g,"");			
			v = new String(Number(v));			
			var len = v.length;			
				if (1== len)			
					v = v.replace(/(\d)/,"0.0$1");			
				else if (2 == len)			
						v = v.replace(/(\d)/,"0.$1");			
				else if (len > 2) {			
					v = v.replace(/(\d{2})$/,'.$1');			
				}			
			return v;			
			};			
	setTimeout(function(){			
	el.value = exec(el.value);			
	},1);		
	}
}	
</script>	
<script>		
	$(document).ready(function(){				
		$('input').keypress(function (e) {        
			var code = null;        
			code = (e.keyCode ? e.keyCode : e.which);                        
			return (code == 13) ? false : true;		
		});				
		
		$('#form').submit(function(event){		  
			if (form.checkValidity()) {			
				send.attr('disabled', 'disabled');		  
			}		
		});		

		$( "#id_estado" ).change(function() {				
			var id_estado = $('#id_estado').val();									
			$.ajax({					
				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCidadeImByEstado?id_estado=" + id_estado,
				type : 'GET', /* Tipo da requisição */ 					
				contentType: "application/json; charset=utf-8",					
				dataType: 'json', /* Tipo de transmissão */					
				success: function(data){							
					if (data == undefined ) {							
						console.log('Undefined');						
					} else {							
						$('#id_cidade').html(data);						
					}
				}				 
			}); 				 				 						
		});			
		
							
			
});   
 </script>
 
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Cadastrar Loja<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/loja/listar"><i class="fa fa-home"></i>Listar Loja</a></li>
                                    <li class="active">Cadastrar Loja</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Loja</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('loja/cadastrar_loja', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Estado</label>
                                    <div class="col-lg-4">
										<select name="id_estado" id="id_estado" required=""  class='custom-select select2' style='width:350px;height:30px'>
											 <option value="0">Escolha</option>										  
											 <?php foreach($estados as $key => $estado){ ?>									 
											 <option value="<?php echo $estado->uf ?>"><?php echo $estado->uf?></option>
											 <?php									  
											 }								  									 
											 ?>									
											 </select>     
                                    </div>
									<label class="col-lg-2 control-label">Cidade</label>
                                    <div class="col-lg-4">
										<select name="id_cidade" id="id_cidade" required=""  class='custom-select select2' style='width:320px;height:30px'>	
											<option value="0">Escolha</option>										
											<?php foreach($cidades as $key => $cidade){ ?>									 
											<option value="<?php echo $cidade->nome ?>"><?php echo $cidade->nome?></option>	
											<?php									  
											}								  									  
											?>								
											</select>      
										</div>									
                                </div>
								<div class="form-group">
								<label class="col-sm-2 control-label">CNPJ da Loja</label>
                                    <div class="col-lg-4">
										<input type="hidden" name='cc' id='cc'   value=0 >
										<input type="hidden" name='cod2' id='cod2'  value=0> 
										<input type="hidden" name='cod1' id='cod1'  value=0>
										<input type="hidden" name='id_emitente' id='id_emitente' value=0   >
										<input type="hidden" name='imovel' id='imovel'  value=0  >
                                      	<input type="text"  data-masked="" data-inputmask="'mask': '99.999.999/9999-99' " name='cpf_cnpj' id='cpf_cnpj' class="form-control"  required=""> 
                                    </div>
								<label class="col-sm-2 control-label">Unidade</label>	
								<div class="col-lg-4"><input id='unidade' name='unidade' class="form-control" maxlength="4"  >      
                                    </div>	
									
                                </div>
								
                                <div class="form-group">
									<label class="col-lg-2 control-label">Regional</label>
                                    <div class="col-lg-4">
									<select name="regional" id="regional" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($regionais as $key => $regional){ ?>								 
									<option value="<?php echo $regional->id ?>"><?php echo $regional->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
                                    </div>
									<label class="col-lg-2 control-label">Bandeira</label>
                                    <div class="col-lg-4">
									<select name="bandeira" id="bandeira" required=""  class='form-control' style='width:320px;height:30px'>
										<option value="0" selected>Escolha</option>								  
										<?php foreach($bandeiras as $key => $bandeira){ ?>									
										<option value="<?php echo $bandeira->id ?>"><?php echo $bandeira->descricao_bandeira?></option>	
										<?php								  
										}								  							 
										?>								
									</select>		
                                    </div>
									
                                </div>	

								<!--
                                <div class="form-group">
									<label class="col-lg-2 control-label">CEP</label>
                                    <div class="col-lg-4"><input type="text" id='cep' name='cep' class="form-control"  data-masked="" data-inputmask="'mask': '99.999-999' ">      
                                    </div>
									<label class="col-lg-2 control-label">N&uacute;mero</label>
                                    <div class="col-lg-4"><input type="text" name='numero' class="form-control"  >   
                                    </div>
                                </div>
								-->
								
								
								<div class="form-group">
									
									<label class="col-lg-2 control-label">Endere&ccedil;o</label>
                                    <div class="col-lg-4"><input type="text" name='logradouro' id='logradouro' class="form-control" > 
                                    </div>
									<label class="col-lg-2 control-label">Nome da Loja</label>
                                    <div class="col-lg-4"><input type="text" name='nome_loja' id='nome_loja' class="form-control" > 
                                    </div>
									<!--
									<label class="col-lg-2 control-label">Bairro</label>
                                    <div class="col-lg-3"><input type="text" name='bairro' id='bairro' class="form-control" >   
                                    </div>
									-->
                                </div>
								
								
								
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
											<input type="hidden" name='op' id='op' value='0' > 
											<input type="hidden" name='id' id='id' value='0' > 
											<button class="btn btn-white" type="submit">Cancelar</button>
											<button class="btn btn-primary" type="submit">Salvar</button>
										<?php } ?>
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>
