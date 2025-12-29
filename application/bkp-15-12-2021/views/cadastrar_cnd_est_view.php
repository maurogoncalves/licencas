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
		
		$('#insc').blur(function(){				
			var insc = $("#insc").val();				
			var emitente = $("#emitente").val();												 
				if(insc !== ''){				 					
					$.ajax({							
						url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaInscricao?inscricao=" + insc +"&emitente="+emitente,							
						type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 							
						contentType: "application/json; charset=utf-8",							
						dataType: 'json', /* Tipo de transmiss&atilde;o */							
						success: function(data){								
							if(data.total !== '0'){																		
								alert('Esse n\u00famero de inscri\u00e7\u00e3o, j\u00e1 existe para essa loja');									
								$("#insc").focus();								
							}							
						}						
					});				 				 
				}								
		});						
		$('#cep').blur(function(){			   
			var cep = $("#cep").val();				   
			if(cep != '__.___-___'){						
			$.ajax({							
				url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaCep?cep=" + cep,							
				type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 							
				contentType: "application/json; charset=utf-8",							
				dataType: 'json', /* Tipo de transmiss&atilde;o */							
				success: function(data){								
					if(data !== 0){																		
					$("#logradouro").val(data.logradouro);									
					$("#bairro").val(data.bairro);									
					$("#cidade").val(data.cidade);									
					$("#estado").val(data.uf);								
					}							
					}						
				});					
			}						
		});							
		
		$( "#emitente" ).change(function() {				
			var emitente = $('#emitente').val();								
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/loja/busca?emitente=" + emitente,					
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
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCPFCNPJ?emitente=" + emitente,
					type : 'GET', /* Tipo da requisição */ 					
					contentType: "application/json; charset=utf-8",					
					dataType: 'json', /* Tipo de transmissão */					
					success: function(data){							
						if (data == 0 ) {							
							$('#cpf_cnpj').val('CPF/CNPJ n\u00e3o foi cadastrado');						
						} else {							
							$('#cpf_cnpj').val(data);						
						}												
					}				 
				}); 				 				 				 			
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
			
			$.ajax({					
				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaEmitente?id_estado=" + id_estado,
				type : 'GET', /* Tipo da requisição */ 					
				contentType: "application/json; charset=utf-8",					
				dataType: 'json', /* Tipo de transmissão */					
					success: function(data){							
						if (data == undefined ) {							
							console.log('Undefined');						
						} else {							
							$('#emitente').html(data);						
						}												
					}				 
			}); 						
		});			
		 
		$( "#id_cidade" ).change(function() {	
			
				var id_cidade = $('#id_cidade').val();		
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaEmitenteByCidade?id_cidade=" + id_cidade,
					type : 'GET', /* Tipo da requisição */ 					
					contentType: "application/json; charset=utf-8",					
					dataType: 'json', /* Tipo de transmissão */					
						success: function(data){							
							if (data == undefined ) {							
								console.log('Undefined');						
							} else {							
								$('#emitente').html(data);						
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
                                <h1>Cadastrar Inscri&ccedil;&atilde;o Estadual<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_brasil/cnd_est_lista"><i class="fa fa-home"></i>Listar Cnd Estadual</a></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Inscri&ccedil;&atilde;o Estadual</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('cnd_brasil/cadastrar_cnd_estadual', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Loja</label>
                                    <div class="col-lg-10">
										<select name="id_loja" id="id_loja" required=""  class='custom-select select2' style='width:100%'>
											 <option value="0">Escolha</option>										  
											 <?php foreach($todas_lojas as $key => $loja){?>									 
											 <option value="<?php echo $loja->id; ?>"><?php echo $loja->cpf_cnpj.'-'.$loja->razao_social; ?></option>
											 <?php									  
											 }								  									 
											 ?>									
											 </select>     
                                    </div>
															
                                </div>
                                
								 <div class="form-group">
										<label class="col-sm-2 control-label">Inscri&ccedil;&atilde;o Estadual - Nº</label>
                                    <div class="col-lg-10">
											<input type="number" name='insc' id='insc'  class="form-control"  required=""> 
										</div>									
                                </div>
								<div class="form-group">
										<label class="col-sm-2 control-label">Coletiva ou Individual</label>
										
										 <div class="col-lg-10">
										<label> <input type="radio" id="tipoCND" name='tipoCND' value="1"  > Coletiva </label> &nbsp;&nbsp;&nbsp; 
										<label> <input type="radio" id="tipoCND" name='tipoCND' value="0" checked=""> Individual</label>
										</div>		
										
                                  					
                                </div>
	
                                </div>
								
                                
								
								
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
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
