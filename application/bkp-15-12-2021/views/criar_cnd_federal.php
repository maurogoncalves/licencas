<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>    <script type="text/javascript">		$(document).ready(function(){			$('input').keypress(function (e) {				var code = null;				code = (e.keyCode ? e.keyCode : e.which);                				return (code == 13) ? false : true;			});			
			$('#cnpjMatriz').blur(function(){
			   var cnpjMatriz = $("#cnpjMatriz").val();				   $.ajax({							url: "<?php echo $this->config->base_url(); ?>index.php/emitente/buscarCnpjEmitente?cnpjMatriz=" + cnpjMatriz,							type : 'get', /* Tipo da requisição */ 							contentType: "application/json; charset=utf-8",							dataType: 'json', /* Tipo de transmissão */							success: function(data){								$('#cnpjEmitente').html(data);							}						});	
				})
			 
		});

    </script>      
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Criar Cnd Federal<small></small></h1>
                                <ol class="breadcrumb">
                                    <li class="active">Criar Cnd Federal</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es do Emitente e CNPJ Matriz</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('cnd_brasil/cadastrar_cnd_fed', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                
								
								<div class="form-group" >									<label class="col-lg-2 control-label">CNPJ Matriz</label>                                    <div class="col-lg-10">										<select class="fancy-select form-control" name="cnpjMatriz" id="cnpjMatriz">									  <option value="0">Escolha</option>										  <?php foreach($cnpj_matriz as $key => $cnpj){ ?>									  <option value="<?php echo $cnpj->id ?>"><?php echo $cnpj->cnpj?></option>										  <?php  }  ?>									</select>									</div>                                </div>																<div class="form-group" >									<label class="col-lg-2 control-label">CNPJ Emitente</label>                                    <div class="col-lg-10">										<select class="form-control" name="cnpjEmitente" id="cnpjEmitente">									  <option value="0">Escolha</option>										</select>									</div>                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="submit">Cancelar</button>
                                        <button class="btn btn-primary" type="submit">Salvar</button>
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>
