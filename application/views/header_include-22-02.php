<nav class="navbar navbar-default yamm navbar-fixed-top">
            <div class="container-fluid">
                <button type="button" class="navbar-minimalize minimalize-styl-2  pull-left "><i class="fa fa-bars"></i></button>
                <span class="search-icon"><i class="fa fa-search"></i></span>
                <div class="search" style="display: none;">
                    <form role="form">
                        <input type="text" class="form-control" autocomplete="off" placeholder="Write something and press enter">
                        <span class="search-close"><i class="fa fa-times"></i></span>
                    </form>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Walmart</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle button-wave" data-toggle="dropdown" aria-expanded="true">Acesso DashBoard<span class="caret"></span></a>
                            <ul class="dropdown-menu mega-dropdown-menu" style="width: 900px;">
                                <li>
                                    <div class="yamm-content">
                                        <div class="row ">
                                            <div class="col-sm-4 ">

                                                <h3 class="yamm-category">DashBoard</h3>
                                                <ul class="list-unstyled ">
													<li><a href="<?php echo $this->config->base_url(); ?>index.php/imovel/dashboard">Im&oacute;vel</a></li>
                                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php/loja/dashboard">Loja</a></li>
                                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php/cnd_mob/dashboard">Cnd Mobili&aacute;ria</a></li>

                                                </ul>
                                            </div>
                                            
                                            <div class="col-sm-4 ">

                                                <h3 class="yamm-category">DashBoard</h3>
                                                <ul class="list-unstyled ">
													<li><a href="<?php echo $this->config->base_url(); ?>index.php/imovel/dashboard">Im&oacute;vel</a></li>
                                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php/iptu/dashboard">IPTU</a></li>
                                                    <li><a href="<?php echo $this->config->base_url(); ?>index.php/cnd_imob/dashboard">Cnd Imobili&aacute;ria</a></li>
                                                </ul>
                                            </div>
                                            
											
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle button-wave" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Acesso M&oacute;dulos<span class="caret"></span></a>
                            <ul class="dropdown-menu">
							<?php  
														$base = $this->config->base_url().'index.php';
														$modulosFilhos = $_SESSION['loginTeste']['perfilFilho'];
														$modulos =  $_SESSION['loginTeste']['perfil']; 
														foreach($modulos as $modulo){
															$id_modulo = $modulo['id_modulo'];
															$link_pagina = $modulo['pagina'];
															$nome_pagina = $modulo['nome'];							
															$controller = $modulo['controller'];
															
												
															$icone = $modulo['icone'];
															$temFilho = $modulo['tem_filho'];
															$base = $this->config->base_url().'index.php';
															if($this->uri->segment(1) == $link_pagina){
																//echo"<li class='active' >";
															}	
															
																if($temFilho == 1){
																echo" ";
																	print"<li><a href='$base/$link_pagina/$controller'>$nome_pagina</a></li>";
																		foreach($modulosFilhos as $filho){												
																			$pai = $filho['pai'];
																			$link_pagina_filho = $filho['pagina'];
																			$nome_pagina_filho = $filho['nome'];							
																			$controller_filho = $filho['controller'];	
																			
																			if($pai == $id_modulo){
																				print"<li><a href='$base/$link_pagina_filho/$controller_filho'>$nome_pagina_filho</a></li>";
																			}else{
																				//print"<li><a href='$link_pagina'>$nome_pagina</a></li>";
																			}
																			
																		}	
																}else{
																	print"<li><a href='$base/$link_pagina/$controller'>$nome_pagina</a></li>";
																	
																}
																	
															echo"</li>";
									
														}
													?>
													
        
                            </ul>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right navbar-top-drops">
                        <li class="dropdown"><a href="#" class="dropdown-toggle button-wave" data-toggle="dropdown"><i class="fa fa-envelope"></i> <span class="badge badge-xs badge-info">6</span></a>

                            <ul class="dropdown-menu dropdown-lg">
                                <li class="notify-title">
                                    3 New messages                                </li>
                                <li class="clearfix">
                                    <a href="#">
                                        <span class="pull-left">
                                            <img src="images/avtar-1.jpg" alt="" class="img-circle" width="30">                                        </span>
                                        <span class="block">
                                            <?php 
											$session_data = $_SESSION['loginTeste'];
											echo($session_data['email']); 
											?>                                       
											</span>
                                        <span class="media-body">
                                            Lorem ipsum dolor sit amet
                                            <em>28 minutes ago</em>                                        </span>                                    </a>                                </li>
                                <li class="clearfix">
                                    <a href="#">
                                        <span class="pull-left">
                                            <img src="images/avtar-2.jpg" alt="" class="img-circle" width="30">                                        </span>
                                        <span class="block">
                                            <?php 
											$session_data = $_SESSION['loginTeste'];
											echo($session_data['email']); 
											?>                                          
											</span>
                                        <span class="media-body">
                                            Lorem ipsum dolor sit amet
                                            <em>28 minutes ago</em>                                        </span>                                    </a>                                </li>
                                <li class="clearfix">
                                    <a href="#">
                                        <span class="pull-left">
                                            <img src="images/avtar-3.jpg" alt="" class="img-circle" width="30">                                        </span>
                                        <span class="block">
                                             <?php 
											$session_data = $_SESSION['loginTeste'];
											echo($session_data['email']); 
											?>     
											</span>
                                        <span class="media-body">
                                            Lorem ipsum dolor sit amet
                                            <em>28 minutes ago</em>                                        
										</span>                                   
										</a>                              
								</li>
                                <li class="read-more"><a href="#">View All Messages <i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle button-wave" data-toggle="dropdown"><i class="fa fa-bell"></i> <span class="badge badge-xs badge-warning">6</span></a>

                            <ul class="dropdown-menu dropdown-lg">
                                <li class="notify-title">
                                    3 New messages                                </li>
                                <li class="clearfix">
                                    <a href="#">
                                        <span class="pull-left">
                                            <i class="fa fa-envelope"></i>                                        </span>

                                        <span class="media-body">
                                            15 New Messages
                                            <em>20 Minutes ago</em>                                        </span>                                    </a>                                </li>
                                <li class="clearfix">
                                    <a href="#">
                                        <span class="pull-left">
                                            <i class="fa fa-twitter"></i>                                        </span>

                                        <span class="media-body">
                                            13 New Followers
                                            <em>2 hours ago</em>                                        </span>                                    </a>                                </li>
                                <li class="clearfix">
                                    <a href="#">
                                        <span class="pull-left">
                                            <i class="fa fa-download"></i>                                        </span>

                                        <span class="media-body">
                                            Download complete
                                            <em>2 hours ago</em>                                        </span>                                    </a>                                </li>
                                <li class="read-more"><a href="#">View All Alerts <i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </li>

                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>