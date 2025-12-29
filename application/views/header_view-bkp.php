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

            <?php include('sidebar.php');?>

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
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="widget-box clearfix">
                                <div class="pull-left">
                                    <h4>Quantidade de Upload CND</h4>
                                    <h2><?php echo$cndAtual[0]['total']; ?> </h2>
                                </div>
                                <div class="text-right">

                                    <span id="sparkline8"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
    
                                <div class="col-md-4">
                                    <div class="widget-box clearfix">
                                        <div>
                                            <h4>Tot. Inscrições Mobiliárias</h4>
                                            <h2><?php echo $totalCNDM ?> <i class="fa fa-files-o pull-right"></i></h2>
                                        </div>
                                    </div>
                                </div>
								                            <div class="col-md-3">
                                    <div class="widget-box clearfix">
                                        <div>
                                            <h4>Tot. Inscrições Imobiliárias</h4>
                                            <h2><?php echo $totalCNDIm ?> <i class="fa fa-files-o pull-right"></i></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="widget-box clearfix">
                                        <div>
                                            <h4>Tot. Inscrições Estaduais</h4>
                                            <h2><?php echo $totalCNDE ?> <i class="fa fa-home pull-right"></i></h2>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>



                    <div class="row">
					<style type="text/css">
						.chart-legend ul li { list-style:none; }
						.chart-legend li span{
						display: inline-block;
						width: 10px;
						height: 10px;
						margin-right: 5px;
						border-radius: 4px;
						}
					 </style>
						<div class="col-sm-4">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">CND Mobili&aacute;ria por Situa&ccedil;&atilde;o</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartMob" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>

                                </div>
                            </div><!-- End .panel --> 
                        </div>					
                         <div class="col-sm-4">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">CND Imobili&aacute;ria por Situa&ccedil;&atilde;o</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartImob" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>

                                </div>
                            </div><!-- End .panel --> 
                        </div>
                        <div class="col-sm-4">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">CND Estadual por Situa&ccedil;&atilde;o</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="doughnutChartEst" height="150"></canvas>
										<div id="js-legend" class="chart-legend"></div>
                                    </div>


                                </div>
                            </div><!-- End .panel --> 
                        </div>
                    </div>
					
					<div class="row">
					<div class="col-sm-12">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> 
									IPTU &nbsp;&nbsp;
									<span style='background-color:#80FF80'> &nbsp;&nbsp;  </span><strong><?php echo '&nbsp; '.$anoAtual ?></strong>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<span style='background-color:#B3E2FB'> &nbsp;&nbsp;  </span><strong><?php echo '&nbsp; '.$anoPassado ?></strong>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body text-center">
                                    <div>
                                        <canvas id="barChart" height="110"></canvas>
                                    </div>

                                </div>
                            </div><!-- End .panel --> 
                        </div>
					</div>
                   
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">Controle de CND's Imobiliária por Usuário</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
													<th>Total Geral</th>
                                                    <th>Total</th>
                                                    <th>Possui CND</th>
                                                    <th>Email</th>
													<th>UF's</th>
                                                    <th>%</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											<?php
												$i=0;
												foreach ($cndImobiliariaUFS as $mobUF) {
														$tipo = utf8_encode($mobUF->tipo);
														$totalPossui = ($mobUF->total_possui);
														$email = ($mobUF->email);
														$total = utf8_encode($mobUF->total);
														$porc = round((($totalPossui / $total) * 100),2) ;

														echo"
														<tr>
														<td>$total</td>
														<td>$totalPossui</td>
														<td>$tipo</td>														
														<td>$email</td>
														<td>$mobUF->ufs</td>
														<td><div class='sparklineImob$i'><canvas width='17' height='17' style='display: inline-block; width: 17px; height: 17px; vertical-align: top;'></canvas></div> </td>
														<td><a href='#' class='btn btn-default btn-xs'>View</a></td>
														</tr>";
														$i++;  
													
													}
																									
												?>	
				
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- End .panel --> 
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-card recent-activites">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">Controle de CND's Mobiliária por Usuário</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
													<th>Total Geral</th>
                                                    <th>Total</th>
                                                    <th>Possui CND</th>
                                                    <th>Email</th>
													<th>UF's</th>
                                                    <th>%</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											<?php
												$i=0;
												foreach ($cndMobiliariaUFS as $mobUF) {
														$tipo = utf8_encode($mobUF->tipo);
														$totalPossui = ($mobUF->total_possui);
														$email = ($mobUF->email);
														$total = utf8_encode($mobUF->total);
														$porc = round((($totalPossui / $total) * 100),2) ;

														echo"
														<tr>
														<td>$total</td>
														<td>$totalPossui</td>
														<td>$tipo</td>														
														<td>$email</td>
														<td>$mobUF->ufs</td>
														<td><div class='sparklineMob$i'><canvas width='17' height='17' style='display: inline-block; width: 17px; height: 17px; vertical-align: top;'></canvas></div> </td>
														<td><a href='#' class='btn btn-default btn-xs'>View</a></td>
														</tr>";
														$i++;  
													
													}
																									
												?>	
				
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- End .panel --> 
                        </div>
                    </div>
                </div> 
            </div>
        </section>