<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script><script type="text/javascript">$(document).ready(function(){	$( ".mudaCnd" ).click(function() {		var id = $(this).attr('id');		if(id == 1){			window.location.href = "<?php echo $this->config->base_url(); ?>index.php/home/mudarCnd?id=1";			}else if(id == 2){			window.location.href = "<?php echo $this->config->base_url(); ?>index.php/home/mudarCnd?id=2";			}else{			window.location.href = "<?php echo $this->config->base_url(); ?>index.php/home/mudarCnd?id=3";			}				});});</script> <nav class="navbar navbar-default yamm navbar-fixed-top">
            <div class="container-fluid">
                <button type="button" class="navbar-minimalize minimalize-styl-2  pull-left "><i class="fa fa-bars"></i></button>

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">BdServiços</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                  
				<ul class="nav navbar-nav">                                                                  </ul>															
                    <ul class="nav navbar-nav navbar-right navbar-top-drops">
                        <li class="dropdown">							<a href="<?php echo $this->config->base_url(); ?>index.php/home/logout" class="dropdown-toggle button-wave" >								Sair</a>

                        </li>
                       

                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>