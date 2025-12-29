<script src="<?php echo $this->config->base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url();?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    #svg-map text { fill:#000; font:12px Arial-BoldMT, sans-serif; cursor:pointer }
    #svg-map a{ text-decoration:none }
    #svg-map a:hover { cursor:pointer; text-decoration:none }
    #svg-map a:hover path{ fill:#dedede !important }
    #svg-map .circle { fill:#66ccff }
    #svg-map a:hover .circle { fill:#dedede !important; cursor:pointer }
	
	
.input-sm{
	border-color:#002060!important;
	color:#000!important;	
}

.tabela{
	font-size:11px;
	width:40px;
	background-color:#dedede;
	text-align:center;
	color:#002060;
	
}

.tabela1{
	font-size:11px;
	width:100px;
	background-color:#dedede;
	text-align:center;
	color:#002060;
	
}

.tabelaPorc{
	font-size:11px;
	width:50px;
	background-color:#dedede;
	text-align:center;
	color:#002060;
	
}
</style>
<script type="text/javascript">
	
	
	$(document).ready(function(){		
		
		$("#geral").click(function(){
			$('#estadoFiltro').val('BR');	
			$( "#formMapa" ).submit();	
		});
	
		$(".estado").click(function(){			
			var estado = $(this).attr('id');	
			$('#estadoFiltro').val(estado);	
			$( "#formMapa" ).submit();					
		});
		
			
		$("#export").click(function(){			
			var estado = $("#ufEscolhida").val();
			$('#estadoFiltro').val(estado);	
			$( "#formExportMapa" ).submit();					
		});
	

	});
</script>     
	
<div id="wrapper">

				<div class="row">
						<div class="col-md-12">
							<div class="col-md-12" style='font-weight:bold;text-align:center;font-size:28px;'>
								Cockpit - Licenças
								<BR><BR><BR>
							</div>
						</div>
                   </div><!--col-->    
				
                
				    
				   
                   <div class="row">
						<div class="col-md-12">
							<div class="col-md-3" style='text-align:left;font-weight:bold'>
									
									<span id='geral'>Clique no Mapa, para ver o relatório</span>
									<BR>
								<BR>
								<BR>
								<BR>								
								<BR>
								<BR>
								<BR>								
								<BR>
								<BR>
								<BR>								
								<BR>
	
								<table class="table" cellspacing="0" border="0" width="60%" style='font-size:12px;border:1px solid #000!important;'>								
								<tbody>
									<tr >
										<th colspan=3 
										style='line-height:12px!important;text-align:CENTER;background-color:#002060;color:#fff!important;vertical-align:middle;font-weight:bold'>Licenças por mês/vencimento
										</th>
									</tr>
									<?php foreach($licencasEstados as $val){?>
									<tr >
										<th  style='line-height:10px!important;text-align:right;font-weight:bold;vertical-align:middle'> <?php echo meses($val->mes_vencto)?></th>
										<th  id='' style='line-height:12px!important;text-align:right;font-weight:bold;vertical-align:middle'>  <input type='text' readonly='yes' class='tabela' id='ufEscolhida'  value='<?php echo $val->total?>'> </th>
										<th   style='line-height:12px!important;text-align:right;font-weight:bold;vertical-align:middle'><input type='hidden'  >  </th>
									</tr>
									<?php }?>

								
								</tbody>
								</table>
								<br>
								<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	<br>
							</div>
							<div class="col-md-6">
								  <?php include("mapa.php");?>								 
							</div>
							
							<div class="col-md-3" style='text-align:right'>
							<BR>
								<BR>
								<BR>
								<BR>								
								<BR>
								<BR>
								<BR>								
								<BR>
								<BR>
								<BR>								
								<BR>
								<!-- <table class="table" cellspacing="0" border="0" width="60%" style='font-size:12px;border:1px solid #000!important;'>								
								<tbody>
									<tr >
										<th colspan=3 style='line-height:12px!important;text-align:CENTER;background-color:#002060;color:#fff!important;vertical-align:middle;font-weight:bold'>Legenda
										</th>
									</tr>

									<tr >
										<th style='line-height:10px!important;text-align:CENTER;font-weight:bold;vertical-align:middle;'> &nbsp; </th>
										<th style='line-height:10px!important;text-align:CENTER;font-weight:bold;vertical-align:middle;background-color:#01a8fe'> &nbsp; </th>
										<th style='line-height:10px!important;text-align:CENTER;font-weight:bold;vertical-align:middle'> Possui Inscrição</th>
										

									</tr>
									<tr >
									
										<th style='line-height:10px!important;text-align:CENTER;font-weight:bold;vertical-align:middle;'> &nbsp; </th>
										<th style='line-height:10px!important;text-align:CENTER;font-weight:bold;vertical-align:middle;background-color:#dedede'> &nbsp; </th>
										<th style='line-height:10px!important;text-align:CENTER;font-weight:bold;vertical-align:middle'> Não Possui Inscrição</th>
										
									</tr>
								
								
								</tbody>
								</table> -->
							
														
							</div>
						</div>
				   

                   </div><!--col-->
					<div class="row">
					<form  id='formMapa' action='<?php echo $this->config->base_url(); ?>index.php/home/mapa_taxas' method='post'>	
					<input type='hidden' id='estadoFiltro' name='estadoFiltro' >	
					</form>	
					<form  id='formExportMapa' action='<?php echo $this->config->base_url(); ?>index.php/home/exportMapa' method='post'>	
					<input type='hidden' id='estadoFil' name='estadoFil' value='<?php echo $grafEstado?>'>	
					</form>	
						<div class="col-md-12">
							<div class="col-md-12">
								<BR><Br>
								<table id="basic-datatables" class="table table-bordered table-striped " cellspacing="0" width="100%" style='font-size:12px;'>
									  <thead>
									<tr style='background-color:#002060;color:#fff!important;'>
									<td style='width:5%!important;text-align:center;border:1px solid #002060;'>UF</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>Cidade</td>
									<td style='width:15%!important;text-align:center;border:1px solid #002060;'>CNPJ</td>
									<td style='width:45%!important;text-align:center;border:1px solid #002060;'>Tipo de taxa</td>
									<td style='width:5%!important;text-align:center;border:1px solid #002060;'>Mês Vencimento</td>
									<td style='width:5%!important;text-align:center;border:1px solid #002060;'>Data Vencimento</td>
									<td style='width:10%!important;text-align:center;border:1px solid #002060;'></td>
									</tr>
									  </thead>
									<?php
									$total =0;
									$base = base_url();
									foreach($todasCnds as $res){	
										
										if($res->data_inclusao_sis_ext == '11/11/1111'){
											$res->mes_vencto='-';
											$res->ano_vencto='-';
										}else{
											$mes = meses($res->mes_vencto);
										}
										
										$linkTratativas = "<a style='color:inherit;' href=".$base."index.php/licencas/visao_interna_cnd_mob?id=".$res->id." target='_blank'>  Link para taxas</a>";																					
										print "<tr style='font-weight:bold!important'>
										<td style='text-align:center;border:1px solid #002060;font-weight:bold!important'>".$res->estado."</td>
										<td style='text-align:center;border:1px solid #002060;font-weight:bold!important'>".$res->cidade."</td>
										<td style='text-align:center;border:1px solid #002060;font-weight:bold!important'>".$res->cnpj."</td>				
										<td style='text-align:center;border:1px solid #002060;font-weight:bold!important'>".$res->descricao_natureza_raiz."</td>				
										<td style='text-align:center;border:1px solid #002060;font-weight:bold!important'>".$res->mes_vencto."</td>
										<td style='text-align:center;border:1px solid #002060;font-weight:bold!important'>".$res->data_vencto_br ."</td>
										<td style='text-align:center;border:1px solid #002060;font-weight:bold!important'>".$linkTratativas."</td>
										</tr>
										";
									}
									?>
								</table>
							</div>
						</div>
				   
                           

                   </div><!--col-->
                  
 
                        

                        

                    </div>

                    

                </div> 

            </div>

