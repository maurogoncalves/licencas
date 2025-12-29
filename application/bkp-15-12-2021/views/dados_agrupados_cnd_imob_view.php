<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1><?php echo $nome_modulo; ?> <small></small></h1>
                                <ol class="breadcrumb">
                                    <li>										<a href="<?php echo $this->config->base_url();?>index.php/<?php echo $modulo; ?>/dados_agrupados"><i class="fa fa-home"></i> Dados Agrupados</a>																			</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                   <div class="row">
				   	<?php 	
					$total = 0;
					$isArray = is_array($iptus) ? '1' : '0';								
					if($isArray == 1){								
						foreach($iptus as $key => $iptu){							
							if($iptu->possui_cnd == 1){										
								$possui ='Sim';				
								$arquivo = 'listarPorTipoSim';	
								$totalProprioP = $situacaoSim[1]['total'];
								$totalProprio = $situacaoSim[2]['total'];
								$totalAlugado = $situacaoSim[3]['total'];
							}elseif($iptu->possui_cnd == 2){										
								$possui ='Não';										
								$arquivo = 'listarPorTipoNao';
								$totalProprioP = $situacaoNao[1]['total'];
								$totalProprio = $situacaoNao[2]['total'];
								$totalAlugado = $situacaoNao[3]['total'];
							
							}elseif($iptu->possui_cnd == 3){										
								$possui ='Pendência';			
								$arquivo = 'listarPorTipoPendencia';
								$totalProprioP = $situacaoPend[1]['total'];
								$totalProprio = $situacaoPend[2]['total'];
								$totalAlugado = $situacaoPend[3]['total'];								
							}
							//$total = $total + $iptu->total;;							
					?>
                        <div class="col-sm-4 margin-b-30">
                            <div class="price-box">
                                <h3><?php echo $possui; ?> </h3>
                                <h4><?php echo $iptu->total; ?></h4>
								 <h3>Situação </h3>

                                <ul class="list-unstyled">									<?php  if($iptu->possui_cnd == 1){ ?>									<li><i class="fa fa-calendar-plus-o"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarVigentes?situacao=1" >Vigentes </a> : <?php echo  $vigentes[0]->total ?></li>
                                    <li><i class="fa fa-calendar-times-o"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarVigentes?situacao=2" >Vencidas </a> : <?php echo  $naoVigentes[0]->total ?></li>									<?php }else{		?>									<li><BR></li>									<li><BR></li>									<?php }?>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarPorSituacao?tipo=<?php echo $iptu->possui_cnd ?>&situacao=2" >Próprio </a>: <?php echo  $totalProprio ?></li>
									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarPorSituacao?tipo=<?php echo $iptu->possui_cnd ?>&situacao=1" >Próprio Parcial </a> : <?php echo $totalProprioP ?></li>									<li><i class="fa fa-cogs"></i> <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/listarPorSituacao?tipo=<?php echo $iptu->possui_cnd ?>&situacao=3" >Alugado </a> : <?php echo $totalAlugado ?></li>

                                </ul>

								<a href="<?php echo $this->config->base_url();?>index.php/<?php echo $modulo; ?>/<?php echo $arquivo; ?>"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Ver Detalhado</a>
                            </div>
                        </div><!--col-->
                        <?php }} ?> 
                        
                        
                    </div>
                    
                </div> 
            </div>
