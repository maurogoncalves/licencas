        <section class="page">
            <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Usuários <small> </small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Usuários</li>
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-card ">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Lista de Usuários 
									&nbsp;&nbsp; 
									<a href="<?php echo $this->config->base_url();?>index.php/usuarios/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Usuário</a>
									</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style='width:25%'> Email</th>
                                                <th style='width:25%'>Nome </th>
												<th style='width:30%'>Perfil</th>
												<th style='width:10%'>Status</th>
                                                <th style='width:10%'>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
												<th style='width:25%'> Email</th>
                                                <th style='width:25%'>Nome </th>
												<th style='width:30%'>Perfil</th>
												<th style='width:10%'>Status</th>
                                                <th style='width:10%'>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 	
								
								$isArray =  is_array($usuarios) ? '1' : '0';			
								if($isArray == 0){ ?>
								<tr>
								  <td colspan='6'>N&atilde;o H&aacute Registros</td>
								  </tr>
								
								<?php 	
								 }else{								 
								 foreach($usuarios as $key => $emitente){ 	

									if($emitente->perfil == 1){
										$perfil = "Usuário Operacional";
									}elseif($emitente->perfil == 2){
										$perfil = "Usuário Operacional Permite Exclusão";
									}elseif($emitente->perfil == 3){
										$perfil = "Gerente";
									}elseif($emitente->perfil == 4){
										$perfil = "CEO";
									}
									
									if($emitente->status == 0){
										$status='Ativo';
									}else{
										$status='Inativo';
									}	
									
								 ?>
								  <tr>
                                     <td><?php echo $emitente->nome_usuario; ?></td>
                                     <td><?php echo $emitente->email; ?></td>
									 <td><?php echo $perfil; ?></td>
									 <td><?php echo $status; ?></td>
                                     <td>
										<?php if($perfil_usu == 2){ 										
											if($emitente->status == 0){
										?>	
											<a href="<?php echo $this->config->base_url();?>index.php/usuarios/excluir?id=<?php echo $emitente->id; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>
											
										<?php	
											}else{
										?>		
											<a href="<?php echo $this->config->base_url();?>index.php/usuarios/ativar?id=<?php echo $emitente->id; ?>" class="btn btn-success btn-xs" alt='Ativar' title='Ativar' ><i class="fa fa-check "></i></a>													
										<?php }	?>																					
										<a href="<?php echo $this->config->base_url();?>index.php/usuarios/resetar?id=<?php echo $emitente->id; ?>" class="btn btn-warning btn-xs" title='Resetar Senha'><i class="fa fa-wrench"></i></a>
										<?php } ?>													
										<a href="<?php echo $this->config->base_url();?>index.php/usuarios/editar?id=<?php echo $emitente->id; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
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
        </section>