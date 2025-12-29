					<?php $base = $this->config->base_url().'index.php';?><nav class="navbar-aside navbar-static-side" role="navigation">
                <div class="sidebar-collapse nano">
                    <div class="nano-content">
                        <ul class="nav metismenu" id="side-menu">
                            <li class="nav-header">
                                <div class="dropdown side-profile text-left"> 
                                    <span style="display: block;">
                                        <img alt="image" class="img-circle" src="<?php echo $this->config->base_url(); ?>assets/images/logo.jpg" width="40">
                                    </span>
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                        <span class="clear" style="display: block;"> <span class="block m-t-xs"> <strong class="font-bold"> 
										<?php 
											$session_data = $_SESSION['loginTeste'];
											echo($session_data['email']); 
											?>       
											<b class="caret"></b></strong>
                                            </span></span> </a>
                                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                        <li><a href="<?php echo $this->config->base_url(); ?>index.php/home/perfil"><i class="fa fa-user"></i>Meu Perfil</a></li>

										
                                    </ul>
                                </div>
                            </li>							
							<li id='dash'>
                                <a href="<?php echo $this->config->base_url(); ?>index.php/home"><i class="fa fa-map-marker"></i> <span class="nav-label">Cockpit </span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">									 <li><a href="<?php echo $this->config->base_url(); ?>index.php/home/grafico">Gráficos </a></li>									 <li><a href="<?php echo $this->config->base_url(); ?>index.php/home/mapa">Cockpit </a></li>									 <li><a href="<?php echo $this->config->base_url(); ?>index.php/home/cnd_status">Cnd's / status </a></li>									 <li><a href="<?php echo $this->config->base_url(); ?>index.php/home/tratativa_pendencia">Tratativas / pendência </a></li>
                                </ul>
                            </li>		                    																					<li id='cnd'>							                                <a href="#"><i class="fa fa-file-pdf-o"></i> <span class="nav-label">CND </span><span class="fa arrow"></span></a>                                <ul class="nav nav-second-level collapse">																		 <li>                                        <a href="#" style='font-weight:bold!important'>Mobiliária <span class="fa arrow"></span></a>                                       <ul class="nav nav-third-level collapse">											<!--                                             <li>                                                <a href="<?php echo $base?>/cnd_brasil/cnd_mob_mapa">&nbsp;Status Mapa </a>                                            </li>											-->																						<li>                                                <a href="<?php echo $base?>/cnd_brasil/limpar_filtro">&nbsp;Inscrições Ativas </a>												<a href="<?php echo $base?>/cnd_brasil/cnd_mobiliaria_lista_inativa">&nbsp;Inscrições Inativas </a>                                            </li>																																                                        </ul>                                    </li>									                                </ul>                            </li>
                           
                        </ul>

                    </div>
                </div>
            </nav>