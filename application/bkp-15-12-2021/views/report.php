<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 
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
		
		
});   
 </script>
 
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Usuários Online<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/home/"><i class="fa fa-home"></i> Voltar</a></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Usuários Online</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								
                                <div class="panel-body">
                                 <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											<th>Email</th>
											<th>IP</th>
											<th>Último acesso</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
											<th>Email</th>
											<th>IP</th>
											<th>Data</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

										<?php 		
										$isArray =  is_array($result) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
										}else{								 
											 foreach($result as $key => $res){ 												

											 ?>
												 <tr>
												  <td ><?php echo $res->email; ?></td>	
												  <td ><?php echo $res->ip; ?></td>	
												  <td ><?php echo $res->data; ?></td>												  
												</tr>
											  <?php
											}//fim foreach
										  }//fim if
										  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>
