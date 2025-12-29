<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  
</script>								  
<?php
	
	$temAdm = strpos($perfilGrafico[0]->perfil, '1');
	$temCnd = strpos($perfilGrafico[0]->perfil, '2');
	$temLinc = strpos($perfilGrafico[0]->perfil, '3');

	
	
?>	  
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> DashBoard</h3>
			<?php 
				if(($temAdm <> 0) || ($temCnd <> 0) || ($temLinc <> 0)){			
				//if(($temAdm <> 0) ||  ($temLinc <> 0)){			
			?>
          	<div class="row mt">
          		<div class="col-lg-12">
          		          		
                      <!-- CHART PANELS -->
                      <div class="row">
                      	<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart"  style='height:470px'  >
                      			<div class="grey-header">
						  			<h5>Im&oacute;veis por Estado</h5>
                      			</div>
								<script type="text/javascript">
								   google.charts.setOnLoadCallback(drawChart);  
								  function drawChart() {
								  
									var data = google.visualization.arrayToDataTable([
									  ['Estado','Link', '%'],
										<?php
										$base = $this->config->base_url();										
										foreach ($estados as $est) {											
											$url = $base.'index.php/imovel/listarComParametro?uf='.$est->estado;
											echo "['$est->estado - $est->porcentagem %','$url',$est->total],";
										}
										?>									  
									  
									  
									]);
									
									var view = new google.visualization.DataView(data);
									view.setColumns([0, 2]);

									var options = {
									  title: '',
									  pieHole: 0.4,
									  pieSliceText: '',
										legend: {
											position: 'right',											
										},
										colors: [<?php
										foreach ($estados as $est) {
											echo "'$est->cor',";
										}
										?>],
									  is3D: true,
									  chartArea:{left:30,top:0,width:"100%",height:"80%"}
									};
																	
								  var chart = new google.visualization.PieChart( 
								  document.getElementById('donutchart'));
								  chart.draw(view, options);

								  var selectHandler = function(e) {
										 window.location = data.getValue(chart.getSelection()[0]['row'], 1 );
									}
									// Add our selection handler.
									google.visualization.events.addListener(chart, 'select', selectHandler);
	
									
								  }
								</script>
								
								<div id="donutchart" style='text-align:center;height:500px'></div>
	                      	</div>
                      	</div>
                      	
						<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart" style='height:470px'>
                      			<div class="grey-header">
						  			<h5>Im&oacute;veis por Situa&ccedil;&atilde;o</h5>
                      			</div>
								
								<script type="text/javascript">
								 google.charts.setOnLoadCallback(drawChart1);  
								  function drawChart1() {
								  
									var data1 = google.visualization.arrayToDataTable([
									  ['Situacao','Link', '%'],
										<?php
										foreach ($imSituacao as $im) {
											$url = $base.'index.php/grafico/situacao_estado?id='.$im->id;
											echo "['$im->descricao = $im->porc','$url',$im->total],";
										}
										?>									  

									]);
									
									var view1 = new google.visualization.DataView(data1);
									view1.setColumns([0, 2]);
									var options1 = {
									  title: '',
									  pieHole: 0.4,
									  pieSliceText: '',
										legend: {
											position: 'right',											
										},
										colors: ['#FF1493','#191970','#8B795E'],
									  is3D: true,
									  chartArea:{left:30,top:0,width:"100%",height:"80%"}
									};
									
								var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
								chart.draw(view1, options1);
								var selectHandler = function(e) {
									 window.location = data1.getValue(chart.getSelection()[0]['row'], 1 );
								}
								google.visualization.events.addListener(chart, 'select', selectHandler);
							  }
								</script>
								
								

								<div id="donutchart1" style='text-align:center;height:500px'></div>
	
	                      	</div>
                      	</div>

						
                      	</div>
                    </div>
                    
					

					
          		</div>
		<?php 
			}
		?>		
  		<br><BR>
		<?php 
			if(($temAdm <> 0) || ($temCnd <> 0) ){	
			
		?>
		<div class="row mt">
          		<div class="col-lg-12">
          		          		
                      <!-- CHART PANELS -->
                      <div class="row">
                      	<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart" style='height:470px'>
                      			<div class="grey-header">
						  			<h5>Iptu por Estado - <?php echo $anoAtual?></h5>
                      			</div>
								
								<script type="text/javascript">
								
						
								  google.charts.setOnLoadCallback(drawChart2);
								  function drawChart2() {
								  
									var data2 = google.visualization.arrayToDataTable([
									  ['Estado','Link', '%'],
										<?php
										foreach ($iptuEstadoAtual as $ip) {
											$url = $base.'index.php/iptu/listarComParametro?uf='.$ip->estado;
											echo "['$ip->estado - $ip->porcentagem %','$url',$ip->total],";
										}
										?>									  
									  
									  
									]);
									var view2 = new google.visualization.DataView(data2);
									view2.setColumns([0, 2]);
									var options2 = {
									  title: '',
									  pieHole: 0.4,
									  is3D: true,
									  pieSliceText: '',
										legend: {
											position: 'right',											
										},
										colors: [<?php
										foreach ($iptuEstadoAtual as $ip) {
											echo "'$ip->cor',";
										}
										?>	],
									  chartArea:{left:30,top:0,width:"100%",height:"80%"}
									};
								
									var chart2 = new google.visualization.PieChart(document.getElementById('donutchart2'));
									chart2.draw(view2, options2);
									var selectHandler = function(e) {
										window.location = data2.getValue(chart2.getSelection()[0]['row'], 1 );
									}
									google.visualization.events.addListener(chart2, 'select', selectHandler);									
								  }
								</script>
								
								<div id="donutchart2" style='text-align:center;height:500px'></div>

	                      	</div>
                      	</div>
                      	
						<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart" style='height:470px'>
                      			<div class="grey-header">
						  			<h5>Iptu por Estado - <?php echo $anoPassado?></h5>
                      			</div>
								
								<script type="text/javascript">
								
						
								  google.charts.setOnLoadCallback(drawChart2);
								  function drawChart2() {
								  
									var data2 = google.visualization.arrayToDataTable([
									  ['Estado','Link', '%'],
										<?php
										foreach ($iptuEstadoPassado as $ip) {
											$url = $base.'index.php/iptu/listarComParametro?uf='.$ip->estado;
											echo "['$ip->estado - $ip->porcentagem %','$url',$ip->total],";
										}
										?>									  
									  
									  
									]);
									var view2 = new google.visualization.DataView(data2);
									view2.setColumns([0, 2]);
									var options2 = {
									  title: '',
									  pieHole: 0.4,
									  is3D: true,
									  pieSliceText: '',
										legend: {
											position: 'right',											
										},
										colors: [<?php
										foreach ($iptuEstadoPassado as $ip) {
											echo "'$ip->cor',";
										}
										?>],
									  chartArea:{left:30,top:0,width:"100%",height:"80%"}
									};

									var chart2 = new google.visualization.PieChart(document.getElementById('donutchart21'));
									chart2.draw(view2, options2);
									var selectHandler = function(e) {
										window.location = data2.getValue(chart2.getSelection()[0]['row'], 1 );
									}
									google.visualization.events.addListener(chart2, 'select', selectHandler);			
									}
								</script>
								
								<div id="donutchart21"  style='text-align:center;height:500px'></div>
	                      	</div>
                      	</div>

                      	</div>
                    </div>

          		</div>
				
				<br><BR>
				
		<div class="row mt" style='height:450px'>
			<div class="col-lg-12" style='height:450px' >
				<div class="row" style='height:450px'>
					<div class="col-md-6 col-sm-4 mb" style='height:450px' >
							<div class="grey-panel pn donut-chart" style='height:450px'>
                      			<div class="grey-header">
						  			<h5>Iptu por Ano/Estado - <a  href="<?php echo $this->config->base_url(); ?>index.php/grafico/iptu_estado_ano_inteiro">Abrir em Outra Janela</a></h5>
                      			</div>
								<table class="table table-striped">
								<thead>
								  <tr>
								  <?php
										echo "<th></th>";
										foreach ($anos as $ano) {
											echo "<th>$ano</th>";
										}
								  ?>		
								  </tr>
								</thead>
								  <tbody>
								  <?php
									$isArray = is_array($iptuByAnoUm) ? '1' : '0';
									if($isArray == 1){
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][0]->cor."'>".$iptuByAnoUm[0][0]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][0]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][1]->cor."'>".$iptuByAnoUm[0][1]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][1]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][2]->cor."'>".$iptuByAnoUm[0][2]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][2]->primeiro, 2, ',', '.')."</th>";
									
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][3]->cor."'>".$iptuByAnoUm[0][3]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][3]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][4]->cor."'>".$iptuByAnoUm[0][4]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][4]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][5]->cor."'>".$iptuByAnoUm[0][5]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][5]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][6]->cor."'>".$iptuByAnoUm[0][6]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][6]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][7]->cor."'>".$iptuByAnoUm[0][7]->estado."</th>";
									echo "<th >".number_format($iptuByAnoUm[0][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][7]->primeiro, 2, ',', '.')."</th>";
									
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][8]->cor."'>".$iptuByAnoUm[0][8]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][8]->primeiro, 2, ',', '.')."</th>";
									
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoUm[0][9]->cor."'>".$iptuByAnoUm[0][9]->estado."</th>";
									echo "<th>".number_format($iptuByAnoUm[0][9]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[1][9]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[2][9]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[3][9]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoUm[4][9]->primeiro, 2, ',', '.')."</th>";
									
									echo"</tr>";									
									
									$total11 = $iptuByAnoUm[0][0]->primeiro + 	$iptuByAnoUm[0][1]->primeiro + $iptuByAnoUm[0][2]->primeiro + $iptuByAnoUm[0][3]->primeiro +	$iptuByAnoUm[0][4]->primeiro + $iptuByAnoUm[0][5]->primeiro + $iptuByAnoUm[0][6]->primeiro + $iptuByAnoUm[0][7]->primeiro + $iptuByAnoUm[0][8]->primeiro + $iptuByAnoUm[0][9]->primeiro; 
									$total22 = $iptuByAnoUm[1][0]->primeiro + 	$iptuByAnoUm[1][1]->primeiro + $iptuByAnoUm[1][2]->primeiro + $iptuByAnoUm[1][3]->primeiro +	$iptuByAnoUm[1][4]->primeiro + $iptuByAnoUm[1][5]->primeiro + $iptuByAnoUm[1][6]->primeiro + $iptuByAnoUm[1][7]->primeiro + $iptuByAnoUm[1][8]->primeiro + $iptuByAnoUm[1][9]->primeiro; 
									$total33 = $iptuByAnoUm[2][0]->primeiro + 	$iptuByAnoUm[2][1]->primeiro + $iptuByAnoUm[2][2]->primeiro + $iptuByAnoUm[2][3]->primeiro +	$iptuByAnoUm[2][4]->primeiro + $iptuByAnoUm[2][5]->primeiro + $iptuByAnoUm[2][6]->primeiro + $iptuByAnoUm[2][7]->primeiro + $iptuByAnoUm[2][8]->primeiro + $iptuByAnoUm[2][9]->primeiro; 
									$total44 = $iptuByAnoUm[3][0]->primeiro + 	$iptuByAnoUm[3][1]->primeiro + $iptuByAnoUm[3][2]->primeiro + $iptuByAnoUm[3][3]->primeiro +	$iptuByAnoUm[3][4]->primeiro + $iptuByAnoUm[3][5]->primeiro + $iptuByAnoUm[3][6]->primeiro + $iptuByAnoUm[3][7]->primeiro + $iptuByAnoUm[3][8]->primeiro + $iptuByAnoUm[3][9]->primeiro; 
									$total55 = $iptuByAnoUm[4][0]->primeiro + 	$iptuByAnoUm[4][1]->primeiro + $iptuByAnoUm[4][2]->primeiro + $iptuByAnoUm[4][3]->primeiro +	$iptuByAnoUm[4][4]->primeiro + $iptuByAnoUm[4][5]->primeiro + $iptuByAnoUm[4][6]->primeiro + $iptuByAnoUm[4][7]->primeiro + $iptuByAnoUm[4][8]->primeiro + $iptuByAnoUm[4][9]->primeiro; 
									
									}	
								  ?>		

								  
								</tbody>
							  </table>
	                      	</div>
                      	</div>
						
					<div class="col-md-6 col-sm-4 mb" style='height:450px'>
						<div class="grey-panel pn donut-chart" style='height:450px'>
                   			<div class="grey-header">
					  			<h5>Iptu por Ano/Estado - <a  href="<?php echo $this->config->base_url(); ?>index.php/grafico/iptu_estado_ano_inteiro">Abrir em Outra Janela</a></h5>
                   			</div>
						
							<table class="table table-striped">
								<thead>
								  <tr>
								  <?php
										echo "<th></th>";
										foreach ($anos as $ano) {
											echo "<th>$ano</th>";
										}
								  ?>		
								  </tr>
								</thead>
								  <tbody>
								  <?php
									$isArray = is_array($iptuByAnoDois) ? '1' : '0';
									if($isArray == 1){
									
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][0]->cor."'>".$iptuByAnoDois[0][0]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][0]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][0]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][1]->cor."' >".$iptuByAnoDois[0][1]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][1]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][1]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][2]->cor."'>".$iptuByAnoDois[0][2]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][2]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][2]->primeiro, 2, ',', '.')."</th>";
									
									echo"</tr>";
									echo"<tr>";
									echo "<th>".$iptuByAnoDois[0][3]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][3]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][3]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][4]->cor."'>".$iptuByAnoDois[0][4]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][4]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][4]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][5]->cor."'>".$iptuByAnoDois[0][5]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][5]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][5]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][6]->cor."'>".$iptuByAnoDois[0][6]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][6]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][6]->primeiro, 2, ',', '.')."</th>";
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][7]->cor."'>".$iptuByAnoDois[0][7]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][7]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][7]->primeiro, 2, ',', '.')."</th>";
									
									echo"</tr>";
									echo"<tr>";
									echo "<th style='color:".$iptuByAnoDois[0][8]->cor."'>".$iptuByAnoDois[0][8]->estado."</th>";
									echo "<th>".number_format($iptuByAnoDois[0][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[1][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[2][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[3][8]->primeiro, 2, ',', '.')."</th>";
									echo "<th>".number_format($iptuByAnoDois[4][8]->primeiro, 2, ',', '.')."</th>";
									
									echo"</tr>";
									$total1 = $total11 + $iptuByAnoDois[0][0]->primeiro + 	$iptuByAnoDois[0][1]->primeiro + $iptuByAnoDois[0][2]->primeiro + $iptuByAnoDois[0][3]->primeiro +	$iptuByAnoDois[0][4]->primeiro + $iptuByAnoDois[0][5]->primeiro + $iptuByAnoDois[0][6]->primeiro + $iptuByAnoDois[0][7]->primeiro + $iptuByAnoDois[0][8]->primeiro; 
									$total2 = $total22 + $iptuByAnoDois[1][0]->primeiro + 	$iptuByAnoDois[1][1]->primeiro + $iptuByAnoDois[1][2]->primeiro + $iptuByAnoDois[1][3]->primeiro +	$iptuByAnoDois[1][4]->primeiro + $iptuByAnoDois[1][5]->primeiro + $iptuByAnoDois[1][6]->primeiro + $iptuByAnoDois[1][7]->primeiro + $iptuByAnoDois[1][8]->primeiro; 
									$total3 = $total33 + $iptuByAnoDois[2][0]->primeiro + 	$iptuByAnoDois[2][1]->primeiro + $iptuByAnoDois[2][2]->primeiro + $iptuByAnoDois[2][3]->primeiro +	$iptuByAnoDois[2][4]->primeiro + $iptuByAnoDois[2][5]->primeiro + $iptuByAnoDois[2][6]->primeiro + $iptuByAnoDois[2][7]->primeiro + $iptuByAnoDois[2][8]->primeiro; 
									$total4 = $total44 + $iptuByAnoDois[3][0]->primeiro + 	$iptuByAnoDois[3][1]->primeiro + $iptuByAnoDois[3][2]->primeiro + $iptuByAnoDois[3][3]->primeiro +	$iptuByAnoDois[3][4]->primeiro + $iptuByAnoDois[3][5]->primeiro + $iptuByAnoDois[3][6]->primeiro + $iptuByAnoDois[3][7]->primeiro + $iptuByAnoDois[3][8]->primeiro; 
									$total5 = $total55 + $iptuByAnoDois[4][0]->primeiro + 	$iptuByAnoDois[4][1]->primeiro + $iptuByAnoDois[4][2]->primeiro + $iptuByAnoDois[4][3]->primeiro +	$iptuByAnoDois[4][4]->primeiro + $iptuByAnoDois[4][5]->primeiro + $iptuByAnoDois[4][6]->primeiro + $iptuByAnoDois[4][7]->primeiro + $iptuByAnoDois[4][8]->primeiro; 
									
									
									
									}	
								  ?>	
								  
								  <tr style='font-weight:bold;color:#000'>
								  <th>Total</th>
								  <th><?php echo number_format($total1, 2, ',', '.') ?></th>
								  <th><?php echo number_format($total2, 2, ',', '.') ?></th>
								  <th><?php echo number_format($total3, 2, ',', '.') ?></th>
								  <th><?php echo number_format($total4, 2, ',', '.') ?></th>
								  <th><?php echo number_format($total5, 2, ',', '.') ?></th>
								  
								  </tr>
								  
								</tbody>
							  </table>
								</tbody>
							  </table>	                      	</div>
                      	</div>
				</div>	
			</div>	
		</div>
		
		<div class="row mt">
          		<div class="col-lg-12">
          		          		
                      <!-- CHART PANELS -->
                      <div class="row">
                      	
                      	
					<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>CND Mobili&aacute;ria por Situa&ccedil;&atilde;o</h5>
                      			</div>
								
								<script type="text/javascript">
								
						
								  google.charts.setOnLoadCallback(drawChart3);
								  function drawChart3() {
								  
									var data3 = google.visualization.arrayToDataTable([
									  ['Tipo','Link', '%'],
										<?php
										foreach ($cndMobiliaria as $mob) {
											
											$tipo = utf8_encode($mob['tipo']);
											$porc = $mob['porc'];
											$total = $mob['total'];
											if($tipo == 'Sim'){
												$url = $base.'index.php/cnd_mob/listarPorTipoSim';
											}elseif($tipo == 'Não'){
												$url = $base.'index.php/cnd_mob/listarPorTipoNao';
											}elseif($tipo == 'Pendente'){
												$url = $base.'index.php/cnd_mob/listarPorTipoPendencia';	
											}else{
												$url = $base.'index.php/cnd_mob/listarLoja';
											}
											echo "['$tipo - $porc %','$url',$total],";
										}
										?>									  
									  
									  
									]);
									var view3 = new google.visualization.DataView(data3);
									view3.setColumns([0, 2]);
									var options3 = {
									  title: '',
									  pieHole: 0.6,
									  pieSliceText: '',
										legend: {
											position: 'right',											
										},		
										colors: ['#0066CC','#FF0000','#FFFF33','#FF1493'],								
										is3D: true,
									  chartArea:{left:30,top:0,width:"100%",height:"80%"}
									};

									
									var chart3 = new google.visualization.PieChart(document.getElementById('donutchart3'));
									chart3.draw(view3, options3);
									var selectHandler = function(e) {
										window.location = data3.getValue(chart3.getSelection()[0]['row'], 1 );
									}
									google.visualization.events.addListener(chart3, 'select', selectHandler);										
								  }
								</script>
								
								<div id="donutchart3" ></div>
	                      	</div>
                      	</div>

						<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>CND Imobili&aacute;ria por Situa&ccedil;&atilde;o</h5>
                      			</div>
								
								<script type="text/javascript">
								
						
								  google.charts.setOnLoadCallback(drawChart4);
								  function drawChart4() {
								  
									var data4 = google.visualization.arrayToDataTable([
									  ['Tipo','Link', '%'],
										<?php
										foreach ($cndImobiliaria as $imob) {
											
											$tipo = $imob['tipo'];
											$porc = $imob['porc'];
											$total = $imob['total'];
											$url = $base.'index.php/cnd_imob/listarComParam?tipo='.$tipo;
											echo "['$tipo - $porc %','$url', $total],";
										}
										?>									  
									  
									  
									]);
									var view4 = new google.visualization.DataView(data4);
									view4.setColumns([0, 2]);
									var options4 = {
									  title: '',
									  pieHole: 0.6,
									  pieSliceText: '',
										legend: {
											position: 'right',											
										},	
										colors: ['#0066CC','#FF0000','#FFFF33','#FF1493'],	
									  is3D: true,
									  chartArea:{left:30,top:0,width:"100%",height:"80%"}
									};

									//var formatter = new google.visualization.NumberFormat({pattern:'###.###'} );
									//formatter.format(data2, 1);
									
									var chart4 = new google.visualization.PieChart(document.getElementById('donutchart4'));
									chart4.draw(view4, options4);
									var selectHandler = function(e) {
										window.location = data4.getValue(chart4.getSelection()[0]['row'], 1 );
									}
									google.visualization.events.addListener(chart4, 'select', selectHandler);
								  }
								</script>
								
								<div id="donutchart4" ></div>
	                      	</div>
                      	</div>
                      	</div>
                    </div>
                    
					

					
         </div>
			<?php 
			}
		?>		
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
     