<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Web Gestor CND's</title>

        <!-- Bootstrap -->
        <link href="<?php echo $this->config->base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/waves.min.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>assets/css/nanoscroller.css">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/menu-light.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet">
		<link href="<?php echo $this->config->base_url(); ?>assets/css/chartist.min.css" type="text/css" rel="stylesheet">
        <link href="<?php echo $this->config->base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Static navbar -->

        <?php include('header_include.php');?>
        <section class="page">

            <?php 
			if($_SESSION['loginTeste']['primeiro_acesso'] == 1){
				
				switch ($_SESSION['loginTeste']['adm']) {
					case 1:
						include('sidebar_um.php');
						break;
					case 2:
						include('sidebar.php');
						break;
					case 3:
						include('sidebar_tres.php');
						break;
					case 4:
						include('sidebar.php');
						break;	
				}	
			}
			?>

            <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Dashboard <small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-card ">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-12" >
										<h3 class="panel-title" style='color:#002060;font-size:20px' > CNDs <?php echo $tipo_cnd?> Ativas por Inscrição - Vencimento</h3>
										<BR>
									</div>							
								</div>
								<div class="row">
									
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - mais de 30 dias &nbsp; Acima de  <?php echo $acimaTrintaVencer?>
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/exportMobAcimaTrintaDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
											
										</div>
										<div class="panel-body text-center">
											<div>
												<?php  if($dadosEmitidasEstadualTotalAcimaTrintaDiasVencer <> '0'){ ?>
													<div id="entreZeroQuinzeVencer" style="width: 900px; height: 300px;"></div>
													<BR><BR><BR><BR>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
													
												<?php }?>
											</div>

										</div>
									</div>
									
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>A vencer - 30 a 0 dias &nbsp; Período: <?php echo $iniTrintaVencer.' à '.$fimTrintaVencer?>
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/exportMobTrintaDiasVencer"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
										</div>
										<div class="panel-body text-center">
											<div>
												<?php  if($dadosEmitidasEstadualTotalTrintaDiasVencer <> '0'){ ?>
													<div id="entreQuinzeTrintaVencer" style="width: 900px; height: 300px;"></div>
													<BR><BR><BR><BR>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
												<?php }?>
											</div>

										</div>
									</div>
								</div>
								<div class="row"><div class="col-sm-12"> </div> </div> 
								<div class="row">
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - 1 a 15 dias &nbsp; Período: <?php echo $iniQuinzeVenci.' à '.$fimQuinzeVenci?>
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/exportMobQuinzeDiasVencidas"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
											<div class="panel-actions">
												
											</div>
										</div>
										<div class="panel-body text-center">
											<div>
												<?php  if($dadosEmitidasEstadualTotalQuinzeDiasVencidas <> '0'){ ?>
													<div id="entreZeroQuinzeVencida" style="width: 900px; height: 300px;"></div>
													<BR><BR><BR><BR>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
												<?php }?>
											</div>

										</div>
									</div>
									<div class="col-sm-6">
										<!-- Start .panel -->
										<div class="panel-heading">
											<h3 class="panel-title" style='color:#000;text-align:center;text-transform:none'>Vencidas - a partir 16 dias &nbsp; Abaixo de <?php echo $fimQuinzeVenci?>
												<a id='export' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/exportMobTrintaDiasVencidas"><i style='color:#01A2FF' class="fa fa-file-excel-o"></i> </a>
											</h3>
											<div class="panel-actions">
												
											</div>
										</div>
										<div class="panel-body text-center">
											<div>
											 
												<?php  if($dadosEmitidasEstadualTotalMaiorQuinzeDiasVencidas <> 0){ ?>
													<div id="entreMaiorQuinzeVencida" style="width: 900px; height: 300px;"></div>
												<?php  }else{ ?>
													<BR><BR><BR>Sem dados para exibir!<BR><BR><BR><br><BR><BR><BR><BR>
												<?php }?>
											</div>

										</div>
									</div>
								</div>
								<div class="row"><div class="col-sm-12"> </div> </div>
								
								<BR>
																<div class="row"><div class="col-sm-12"> <br> </div> </div>
								
									
								</div>
								
							</div>
							</div>	
							
						</div>
					</div>
					
										
				</div><!-- end wrapper-->
			</div><!-- end content-wrapper container-->	
			
			 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			
			<script type="text/javascript">
					google.charts.load("current", {packages:['corechart']});
					
					<?php if($dadosEmitidasEstadualTotalTrintaDiasVencer <> '0'){?> 
						google.charts.setOnLoadCallback(drawChartTDVence);
						function drawChartTDVence() {
						var data1 = google.visualization.arrayToDataTable([
							["Estado", "Total", { role: "style" } ],						
							<?php
							$i=1;
							$count  = count($dadosEmitidasEstadualTotalTrintaDiasVencer);
							foreach ($dadosEmitidasEstadualTotalTrintaDiasVencer as $est) {	
								if($i <> $count){
									echo "['$est->estado',$est->total,'#01a8fe'],";
								}else{
									echo "['$est->estado',$est->total,'#01a8fe']";
								}										
								$i++;
							}
							?>	
						  ]);
						  var view = new google.visualization.DataView(data1);
						  view.setColumns([0, 1,
										   { calc: "stringify",
											 sourceColumn: 1,
											 type: "string",
											 role: "annotation" },
										   2]);

						  var options = {
							title: "",
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						  };
						  var chart = new google.visualization.ColumnChart(document.getElementById("entreQuinzeTrintaVencer"));
						  chart.draw(view, options);
					  };
				  <?php }?> 
				  
				  <?php if($dadosEmitidasEstadualTotalQuinzeDiasVencer <> '0'){?> 
				  google.charts.setOnLoadCallback(drawChartQDVence);
					function drawChartQDVence() {
					var data2 = google.visualization.arrayToDataTable([
						["Estado", "Total", { role: "style" } ],						
						<?php
						//inicio TrintaDiasVencer
							$i=1;
							$count  = count($dadosEmitidasEstadualTotalQuinzeDiasVencer);
							foreach ($dadosEmitidasEstadualTotalQuinzeDiasVencer as $est) {	
								if($i <> $count){
									echo "['$est->estado',$est->total,'#01a8fe'],";
								}else{
									echo "['$est->estado',$est->total,'#01a8fe']";
								}										
								$i++;
							}
						?>	
					  ]);

					  var view = new google.visualization.DataView(data2);
					  view.setColumns([0, 1,
									   { calc: "stringify",
										 sourceColumn: 1,
										 type: "string",
										 role: "annotation" },
									   2]);

					  var options = {
						title: "",
						width: 600,
						height: 400,
						bar: {groupWidth: "95%"},
						legend: { position: "none" },
					  };
					  var chart = new google.visualization.ColumnChart(document.getElementById("entreZeroQuinzeVencer"));
					  chart.draw(view, options);
				  };
				  <?php }?> 
				  
				  <?php if($dadosEmitidasEstadualTotalAcimaTrintaDiasVencer <> '0'){?>				
					  google.charts.setOnLoadCallback(drawChartQDVenci);
					  function drawChartQDVenci() {
						var data3 = google.visualization.arrayToDataTable([
							["Estado", "Total", { role: "style" } ],						
							<?php	
								$count  = count($dadosEmitidasEstadualTotalAcimaTrintaDiasVencer);
								$i=1;
								foreach ($dadosEmitidasEstadualTotalAcimaTrintaDiasVencer as $est) {	
									if($i <> $count){
										echo "['$est->estado',$est->total,'#01a8fe'],";
									}else{
										echo "['$est->estado',$est->total,'#01a8fe']";
									}										
									$i++;
								}
							?>	
						  ]);
						  var view = new google.visualization.DataView(data3);
						  view.setColumns([0, 1,
										   { calc: "stringify",
											 sourceColumn: 1,
											 type: "string",
											 role: "annotation" },
										   2]);
						  var options = {
							title: "",
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						  };
						  var chart = new google.visualization.ColumnChart(document.getElementById("entreZeroQuinzeVencer"));
						  chart.draw(view, options);
					  };
				   <?php
				   }
				 ?>	

					<?php if($dadosEmitidasEstadualTotalMaiorQuinzeDiasVencidas <> '0'){?>				
					  google.charts.setOnLoadCallback(drawChartQDVencida);
					  function drawChartQDVencida() {
						var data3 = google.visualization.arrayToDataTable([
							["Estado", "Total", { role: "style" } ],						
							<?php	
								$count  = count($dadosEmitidasEstadualTotalMaiorQuinzeDiasVencidas);
								$i=1;
								foreach ($dadosEmitidasEstadualTotalMaiorQuinzeDiasVencidas as $est) {	
									if($i <> $count){
										echo "['$est->estado',$est->total,'#01a8fe'],";
									}else{
										echo "['$est->estado',$est->total,'#01a8fe']";
									}										
									$i++;
								}
							?>	
						  ]);
						  var view = new google.visualization.DataView(data3);
						  view.setColumns([0, 1,
										   { calc: "stringify",
											 sourceColumn: 1,
											 type: "string",
											 role: "annotation" },
										   2]);
						  var options = {
							title: "",
							width: 600,
							height: 400,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						  };
						  var chart = new google.visualization.ColumnChart(document.getElementById("entreMaiorQuinzeVencida"));
						  chart.draw(view, options);
					  };
				   <?php
				   }
				 ?>	
				 
				  </script>
			
			
			
			
			</script>			