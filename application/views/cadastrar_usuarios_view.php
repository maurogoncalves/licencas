<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>    <script type="text/javascript">		$(document).ready(function(){			$('input').keypress(function (e) {				var code = null;				code = (e.keyCode ? e.keyCode : e.which);                				return (code == 13) ? false : true;			});			$('#form').submit(function(event){			  if (form.checkValidity()) {				send.attr('disabled', 'disabled');			  }			});});</script>      <div id="wrapper">                <div class="content-wrapper container">                    <div class="row">                        <div class="col-sm-12">                            <div class="page-title">                                <h1>Cadastrar Usu&aacute;rio<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/usuarios/listar"><i class="fa fa-home"></i>Listar Usu&aacute;rio</a></li>
                                    <li class="active">Cadastrar Usu&aacute;rio</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('usuarios/inserir', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group"><label class="col-lg-2 control-label">Nome</label>
                                    <div class="col-lg-10"><input type="text" name='nome'  placeholder="Nome" class="form-control" required=""> 
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10"><input type="email" name='email' id='email' placeholder="Email" class="form-control" required=""> 
                                    </div>
                                </div>
							
								 <div class="form-group"><label class="col-lg-2 control-label">Perfil de Usu&aacute;rio</label>
                                    <div class="col-lg-10">
									<select class="fancy-select form-control" name="tipoPerfil" id="tipoPerfil" required="">
									  <option value="0">Escolha</option>	
									  <?php foreach($perfil_usuario as $key => $emitente){ ?>
									  <option value="<?php echo $emitente->id ?>"><?php echo $emitente->nome_perfil?></option>	
									  <?php  }  ?>
									</select>
                                    </div>
                                </div>
								
								
								 <div class="form-group">									<label class="col-lg-2 control-label">Telefone</label>                                    <div class="col-lg-8"><input type="text" name='tel' class="form-control" required='' data-masked="" data-inputmask="'mask': '(99)9999-9999' "  value=''>                                       </div>                                </div>																<div class="form-group">									<label class="col-lg-2 control-label">Celular</label>                                    <div class="col-lg-4"><input type="text" name='cel' class="form-control" required='' data-masked="" data-inputmask="'mask': '(99)99999-9999' " value=''>   									WhatsApp? &nbsp;&nbsp;&nbsp; 																		<input type="radio" id="whats" name='whats' value="1" checked="" > Sim </label> &nbsp;&nbsp;&nbsp; 										<label> <input type="radio" id="whats" name='whats' value="2"> N&atilde;o</label>                                    </div>                                </div>
								
								
								
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($perfil_usu == 2){ ?>										<input type="hidden" name='op' id='op' placeholder="Email" class="form-control" required="" value=0>										<input type="hidden" name='id' id='id' required="" value='0'>
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
