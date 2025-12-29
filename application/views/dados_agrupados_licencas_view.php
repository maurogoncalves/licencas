<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Lojas X Licenças<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/licencas/dados_agrupados"><i class="fa fa-home"></i> Dados Agrupados</a></li>
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
							if($iptu['possui_cnd'] == 1){										
											$possui ='Vigente';				
											$arquivo = 'listarVigentes';		
										}else{										
											$possui ='Vencida';										
											$arquivo = 'listarVencidas';
										}
										$total = $total + $iptu['total'];							
					?>
                        <div class="col-sm-3 margin-b-30">
                            <div class="price-box">
                                <h3><?php echo $possui; ?> </h3>
                                <h4><?php echo $iptu['total']; ?></h4>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-tags"></i> At verso perso</li>
                                    <li><i class="fa fa-cogs"></i> Basic support</li>
                                    <li><i class="fa fa-heart"></i> accumbad nurso turso</li>
                                    <li><i class="fa fa-star"></i> consuct elit amet</li>
                                    <li><i class="fa fa-shopping-cart"></i> nota idlia aremd</li>
                                </ul>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna psum olor .
                                </p>
								<a href="<?php echo $this->config->base_url();?>index.php/<?php echo $modulo; ?>/<?php echo $arquivo; ?>"  class="btn btn-primary"><i class="fa fa-angle-right"></i> Ver Detalhado</a>
                            </div>
                        </div><!--col-->
                        <?php }} ?> 
                        
                        
                    </div>
                    
                </div> 
            </div>
