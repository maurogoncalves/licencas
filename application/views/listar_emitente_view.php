        <section class="page">
            <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Emitentes <small> <?php echo utf8_encode($mensagemEmitente);?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Emitentes</li>
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-card ">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Lista de Emitentes 
									&nbsp;&nbsp; 
									<a href="<?php echo $this->config->base_url();?>index.php/emitente/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Emitente</a>
									&nbsp;&nbsp; 
									<a href="<?php echo $this->config->base_url();?>index.php/emitente/export"> <i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Export</a>
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
                                                <th style='width:25%'> Raz&atilde;o Social</th>
                                                <th style='width:25%'>Nome Fantasia</th>
												<th style='width:20%'>Cpf/Cnpj</th>
                                                <th style='width:10%'>Tipo de Emitente</th>
                                                <th style='width:10%'>Ativo</th>
                                                <th style='width:10%'>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
											  <th style='width:25%'> Raz&atilde;o Social</th>
                                                <th style='width:25%'>Nome Fantasia</th>
												<th style='width:20%'>Cpf/Cnpj</th>
                                                <th style='width:10%'>Tipo de Emitente</th>
                                                <th style='width:10%'>Ativo</th>
                                                <th style='width:10%'>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 	
								
								$isArray =  is_array($emitentes) ? '1' : '0';			
								if($isArray == 0){ ?>
								<tr>
								  <td colspan='6'>N&atilde;o H&aacute Registros</td>
								  </tr>
								
								<?php 	
								 }else{								 
								 foreach($emitentes as $key => $emitente){ 	

								if($emitente->ativo == 1){
									$ativo = "Sim";
								}else{
									$ativo = "N&atilde;o";
								}
									
								 ?>
								  <tr>
                                                <td><?php echo substr($emitente->razao_social,0,40); ?></td>
                                                <td><?php echo substr($emitente->nome_fantasia,0,40); ?></td>
												<td><?php echo ($emitente->cpf_cnpj); ?></td>
                                                <td><?php echo $emitente->descricao; ?></td>
                                                <td><?php echo $ativo; ?></td>
                                                <td>
													<?php if($visitante == 0){ ?>
													<a href="<?php echo $this->config->base_url();?>index.php/emitente/ativar?id=<?php echo $emitente->id; ?>" class="btn btn-success btn-xs" alt='Ativar' title='Ativar' ><i class="fa fa-check "></i></a>
													
													<a href="<?php echo $this->config->base_url();?>index.php/emitente/excluir?id=<?php echo $emitente->id; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>
													<?php } ?>
													
													<a href="<?php echo $this->config->base_url();?>index.php/emitente/editar?id=<?php echo $emitente->id; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
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