<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/loader.js"></script>
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> DashBoard</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
          		          		
                      <!-- CHART PANELS -->
                      <div class="row">
                      	<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>Im&oacute;veis por Estado</h5>
                      			</div>
							
								<script type="text/javascript">
								
						
								  google.charts.load("current", {packages:["corechart"]});
								  
								  
								  google.charts.setOnLoadCallback(drawChart);
								  
								  function drawChart() {
								  
									var data = google.visualization.arrayToDataTable([
									  ['Estado', '%'],
										<?php
										foreach ($estados as $est) {
											echo "['$est->estado',$est->total],";
										}
										?>									  
									  
									  
									]);

									var options = {
									  title: '',
									  pieHole: 0.4,
									  legend:'none',
									  is3D: true,
									  chartArea:{left:0,top:0,width:"100%",height:"80%"}
									};

									var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
									chart.draw(data, options);
								  }
								</script>
								
								<div id="donutchart"></div>
	                      	</div>
                      	</div>
                      	
						<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>Im&oacute;veis por Situa&ccedil;&atilde;o</h5>
                      			</div>
								
								<script type="text/javascript">
								
						
								  google.charts.setOnLoadCallback(drawChart1);
								  function drawChart1() {
								  
									var data1 = google.visualization.arrayToDataTable([
									  ['Situacao', '%'],
										<?php
										foreach ($imSituacao as $im) {
											echo "['$im->descricao',$im->total],";
										}
										?>									  
									  
									  
									]);

									var options1 = {
									  title: '',
									  pieHole: 0.4,
									  legend:'none',
									  is3D: true,
									  chartArea:{left:0,top:0,width:"100%",height:"80%"}
									};

									var chart1 = new google.visualization.PieChart(document.getElementById('donutchart1'));
									chart1.draw(data1, options1);
								  }
								</script>
								
								<div id="donutchart1"></div>
								<?php
									$isArray = is_array($imSituacao) ? '1' : '0';
									if($isArray == 1){
										foreach ($imSituacao as $im) {
									?>
										<a  href="<?php echo $this->config->base_url(); ?>index.php/grafico/situacao_estado?id=<?php echo $im->id?>"><?php echo $im->descricao?></a>
										<br>
									<?php
									}
									}
								?>		
	                      	</div>
                      	</div>

						
                      	</div>
                    </div>
                    
					

					
          		</div>
  		<br><BR>
		<div class="row mt">
          		<div class="col-lg-12">
          		          		
                      <!-- CHART PANELS -->
                      <div class="row">
                      	<div class="col-md-6 col-sm-4 mb">
                      		<div class="grey-panel pn donut-chart">
                      			<div class="grey-header">
						  			<h5>Iptu por Estado</h5>
                      			</div>
								
								<script type="text/javascript">
								
						
								  google.charts.setOnLoadCallback(drawChart2);
								  function drawChart2() {
								  
									var data2 = google.visualization.arrayToDataTable([
									  ['Estado', '%'],
										<?php
										foreach ($iptuEstado as $ip) {
											echo "['$ip->estado',$ip->total],";
										}
										?>									  
									  
									  
									]);

									var options2 = {
									  title: '',
									  pieHole: 0.4,
									  legend:'none',
									  is3D: true,
									  chartArea:{left:0,top:0,width:"100%",height:"80%"}
									};

									//var formatter = new google.visualization.NumberFormat({pattern:'###.###'} );
									//formatter.format(data2, 1);
									
									var chart2 = new google.visualization.PieChart(document.getElementById('donutchart2'));
									chart2.draw(data2, options2);
								  }
								</script>
								
								<div id="donutchart2" ></div>
	                      	</div>
                      	</div>
                      	

                      	</div>
                    </div>

          		</div>
				
				<br><BR>
		<div class="row mt" style='height:400px'>
			<div class="col-lg-12" style='height:400px' >
				<div class="row" style='height:400px'>
					<div class="col-md-6 col-sm-4 mb" style='height:400px' >
							<div class="grey-panel pn donut-chart" style='height:400px'>
                      			<div class="grey-header">
						  			<h5>Iptu por Ano/Estado - <a  href="<?php echo $this->config->base_url(); ?>index.php/grafico/iptu_estado_ano_inteiro">Abrir em Outra Janela</a></h5>
                      			</div>
								<table class="table table-striped">
								<thead>
								  <tr>
								  <?php
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
										foreach ($iptuByAnoUm as $um) {
											echo"<tr>";
											echo "<th>$um->estado</th>";
											echo "<th>".number_format($um->primeiro, 2, ',', '.')."</th>";
											echo "<th>".number_format($um->segundo, 2, ',', '.')."</th>";
											echo "<th>".number_format($um->terceiro, 2, ',', '.')."</th>";
											echo "<th>".number_format($um->quarto, 2, ',', '.')."</th>";
											echo "<th>".number_format($um->quinto, 2, ',', '.')."</th>";
											echo"</tr>";
										}
									}	
								  ?>		
								  
								  
								</tbody>
							  </table>
	                      	</div>
                      	</div>
						
					<div class="col-md-6 col-sm-4 mb" style='height:400px'>
						<div class="grey-panel pn donut-chart" style='height:400px'>
                   			<div class="grey-header">
					  			<h5>Iptu por Ano/Estado - <a  href="<?php echo $this->config->base_url(); ?>index.php/grafico/iptu_estado_ano_inteiro">Abrir em Outra Janela</a></h5>
                   			</div>
						
							<table class="table table-striped">
								<thead>
								  <tr>
								  <?php
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
										foreach ($iptuByAnoDois as $dois) {
											echo"<tr>";
											echo "<th>$dois->estado</th>";
											echo "<th>".number_format($dois->primeiro, 2, ',', '.')."</th>";
											echo "<th>".number_format($dois->segundo, 2, ',', '.')."</th>";
											echo "<th>".number_format($dois->terceiro, 2, ',', '.')."</th>";
											echo "<th>".number_format($dois->quarto, 2, ',', '.')."</th>";
											echo "<th>".number_format($dois->quinto, 2, ',', '.')."</th>";
											echo"</tr>";
										}
									}	
								  ?>		
								  
								  
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
									  ['Tipo', '%'],
										<?php
										foreach ($cndMobiliaria as $mob) {
											echo "['$mob->tipo',$mob->total],";
										}
										?>									  
									  
									  
									]);

									var options3 = {
									  title: '',
									  pieHole: 0.6,
									  legend:'none',
									  is3D: true,
									  chartArea:{left:0,top:0,width:"100%",height:"80%"}
									};

									//var formatter = new google.visualization.NumberFormat({pattern:'###.###'} );
									//formatter.format(data2, 1);
									
									var chart3 = new google.visualization.PieChart(document.getElementById('donutchart3'));
									chart3.draw(data3, options3);
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
									  ['Tipo', '%'],
										<?php
										foreach ($cndImobiliaria as $imob) {
											echo "['$imob->tipo',$imob->total],";
										}
										?>									  
									  
									  
									]);

									var options4 = {
									  title: '',
									  pieHole: 0.6,
									  legend:'none',
									  is3D: true,
									  chartArea:{left:0,top:0,width:"100%",height:"80%"}
									};

									//var formatter = new google.visualization.NumberFormat({pattern:'###.###'} );
									//formatter.format(data2, 1);
									
									var chart4 = new google.visualization.PieChart(document.getElementById('donutchart4'));
									chart4.draw(data4, options4);
								  }
								</script>
								
								<div id="donutchart4" ></div>
	                      	</div>
                      	</div>
                      	</div>
                    </div>
                    
					

					
         </div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
     