<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>

<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>

<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 


<style>


.table-fixed thead {
  width: 97%;
}
.table-fixed tbody {
  height: 250px;
  overflow-y: auto;
  width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;
}
#loader_img {
    width: 120px;   /* ajuste aqui */
    height: 120px;  /* opcional */
}

#loading_cnds {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    z-index: 9999;
    display: none;
}

#loading_cnds img {
    width: 140px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>

<script type="text/javascript">

var mask = {		 
	money: function() {			
	var el = this			,exec = function(v) {			
		v = v.replace(/\D/g,"");			
		v = new String(Number(v));			
		var len = v.length;			
			if (1== len)			
					v = v.replace(/(\d)/,"0.0$1");			
			else if (2 == len)			
				v = v.replace(/(\d)/,"0.$1");			
			else if (len > 2) {			
				v = v.replace(/(\d{2})$/,'.$1');			
			}			
			return v;			
		
		};			
		setTimeout(function(){			
			el.value = exec(el.value);			
		},1);
	}}

$(document).ready(function(){	 
	
	$(document).on('click','.verArquivos',function() {	
		var idTrat = $(this).attr('id');
		$.ajax({
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/listaArquivosEst?id="+idTrat,
			type : 'GET', /* Tipo da requisição */ 				
			contentType: "application/json; charset=utf-8",	        	
			dataType: 'json', /* Tipo de transmissão */	
			success: function(data){
				$('#conteudo_arquivos_cnds').html(data);
			}	
		});
		$('#mostrarArquivosCnds').modal('show');				
	});
	
	$('#valorTotal').bind('keypress',mask.money);
	$('#valorPendencia').bind('keypress',mask.money);
	
	$.fn.datepicker.dates['pt-BR'] = {
		days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
		daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
		daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa"],
		months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
		monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
		today: "Hoje",
		monthsTitle: "Meses",
		clear: "Limpar",
		format: "dd/mm/yyyy"
	};
	
	$('#data_vencto').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
	});
	
	$('#data_emissao').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
	});

	
	$('#data_criacao').datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
	});
	
	
	$(document).on('click','.mostrar-texto',function() {									
		$('#mostrarTexto').modal('show');		 
	});

	$("#titulo_area_ext").show();
	$("#titulo_area_int").hide();
	
	$(document).on('click','.ver_arquivo',function() {	
		var idTrat = $(this).attr('id');
		$.ajax({
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/listaArquivosMob?id="+idTrat,
			type : 'GET', /* Tipo da requisição */ 				
			contentType: "application/json; charset=utf-8",	        	
			dataType: 'json', /* Tipo de transmissão */	
			success: function(data){
				$('#conteudo_arquivos').html(data);
			}	
		});		
		$('#mostrarArquivos').modal('show');	
			
	});
	
	
	
		
		
		
	$('input').keypress(function (e) {			

		var code = null;			

		code = (e.keyCode ? e.keyCode : e.which);                			

		return (code == 13) ? false : true;	   

	});	 

	$("#detalhe-tratativa").hide();
	$("#area_interna").hide();
	$("#voiza").hide();
	$('#data-encerramento').hide();	
	$('#data_encerramento_sis_ext').css('');
	
	
	
	
	$('#tipo_tratativa').change(function(){
		var valor = $('#tipo_tratativa').val();
		if(valor == 1){
			$("#titulo_area_ext").show();
			$("#titulo_area_int").hide();
			
		}else{
			$("#titulo_area_ext").hide();
			$("#titulo_area_int").show();
		}
		
		
		
	});	
	$('#status_demanda').change(function(){

			var dtEncerra = $('#data_retorno').val();
			var valor = $('#status_demanda').val();

			if(valor==5){
				if((dtEncerra == '00/00/0000') || (dtEncerra == '')){					
					$('#salvar').hide();				
					$('#data-encerramento').show();	
					$('#data_retorno').css('border', '1px solid black');	
				}else{
					$('#salvar').show();
					$('#data-encerramento').hide();				
				}	
				alert('Tem certeza que deseja cancelar/encerrar essa tratativa?');
				
			}else if(valor==7){
				if((dtEncerra == '00/00/0000') || (dtEncerra == '')){					
					$('#salvar').hide();				
					$('#data-encerramento').show();	
					$('#data_retorno').css('border', '1px solid black');					
				}else{
					$('#salvar').show();
					$('#data-encerramento').hide();				
				}	
				alert('Tem certeza que deseja cancelar/encerrar essa tratativa?');
			}else if(valor==8){
				if((dtEncerra == '00/00/0000') || (dtEncerra == '')){							
					$('#salvar').hide();				
					$('#data-encerramento').show();	
					$('#data_retorno').css('border', '1px solid black');					
				}else{
					$('#salvar').show();
					$('#data-encerramento').hide();				
				}	
				alert('Tem certeza que deseja cancelar/encerrar essa tratativa?');
			}else if(valor==9){
				if((dtEncerra == '00/00/0000') || (dtEncerra == '')){							
					$('#salvar').hide();				
					$('#data-encerramento').show();	
					$('#data_retorno').css('border', '1px solid black');					
				}else{
					$('#salvar').show();
					$('#data-encerramento').hide();				
				}	
				alert('Tem certeza que deseja cancelar/encerrar essa tratativa?');
			}

		
	});		
	
		
	$('#uploadObservacao').click(function(){
		var id_tratativa = $("#id_tratativa").val();
		
		$.ajax({	
				url: "<?php echo $this->config->base_url(); ?>index.php/licencas/listaObsTratCheck?id="+id_tratativa,					
				type : 'GET', /* Tipo da requisição */ 				
				contentType: "application/json; charset=utf-8",	        	
				dataType: 'json', /* Tipo de transmissão */	
				success: function(data){
					$('#observacoesUpload').html(data);

				}
		});
	});
	
	
		
	$('#nova-tratativa').click(function(){
		$('#detalhe-tratativa').show();
		$('#id_tratativa').val('');
		$('#id_natureza_raiz').val('0');
		$('#periodo_renovacao').val('0');	
		$('#id_esfera').val('0');
		$('#id_etapa').val('');
		$('#data_emissao').val('');
		$('#data_criacao').val('');
		$('#id_pendencia').val('0');
		$('#acao').val('1');
		
		$([document.documentElement, document.body]).animate({
			scrollTop: $("#fim").offset().top
		}, 2000);
	});	
	
	
	$('#nova-taxa').click(function(){
		$('#detalhe-taxa').show();
		$('#id_tratativa').val('');
		$('#tipo_taxa').val('0');
		$('#periodo_taxas').val('0');
		$('#responsavel_pagamento').val('0');
		$('#mes_pagamento').val('0');
		$('#data_vencto').val('');
		$('#modo_emissao').val('');
		$('#observacao').val('');
		$('#acao_taxa').val('1');
		$([document.documentElement, document.body]).animate({
			scrollTop: $("#fim_taxa").offset().top
		}, 2000);
	});	
	
	$('.abrir-detalhe').click(function(){

			$("#detalhe-tratativa").show();
			var idTrat = $(this).attr('id');
			$('.abrir-detalhe').children('td, th').css('color','#666');
			$('#'+idTrat).children('td, th').css('color','red');
			
			$('#acao').val('2');
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/licencas/listarTratativaMobById?id="+idTrat,					
				type : 'GET', /* Tipo da requisição */ 				
				contentType: "application/json; charset=utf-8",	        	
				dataType: 'json', /* Tipo de transmissão */	
				beforeSend: function () {
				$('#loading_cnds').show(); // 🔄 mostra loader
				},								
				success: function(data){
						$('#id_tratativa').val(data.id);
						$('#tipo_tratativa').val(data.tipo_tratativa);
						$('#tipo_tratativa_bd').val(data.tipo_tratativa);
						$('#id_pendencia').val(data.pendencia);
						$('#id_esfera').val(data.esfera);
						$('#id_etapa').val(data.etapa);
						$('#data_informe_pendencia2').val(data.data_informe_pendencia);
						$('#id_sis_ext').val(data.id_sis_ext);
						$('#prazo_solucao_sis_ext').val(data.prazo_solucao_sis_ext);
						if(data.data_encerramento_sis_ext !== '11/11/1111'){
							$('#data_encerramento_sis_ext').val(data.data_encerramento_sis_ext);
						}
						if(data.data_inclusao_sis_ext !== '11/11/1111'){
							$('#data_vencto').val(data.data_inclusao_sis_ext);
						}
						if(data.prazo_solucao_sis_ext !== '11/11/1111'){
							$('#data_emissao').val(data.prazo_solucao_sis_ext);
						}
						if(data.data_informe_pendencia !== '11/11/1111'){
							$('#data_criacao').val(data.data_informe_pendencia);
						}
						
						
						$('#status_chamado_sis_ext').val(data.status_chamado_sis_ext);	
						$('#statusChamado').val(data.status_chamado_sis_ext);		
						$('#id_sla_sis_ext').val(data.id_sla_sis_ext);						
						$('#usu_inc').val(data.usu_inc);
						$('#area_focal').val(data.area_focal);
						$('#sub_area_focal').val(data.sub_area_focal);
						$('#contato').val(data.contato);						
						
						if(data.data_envio !== '11/11/1111'){
							$('#data_expiracao').val(data.data_envio);
						}
						
						$('#prazo_solucao').val(data.prazo_solucao);
						
						$('#data_retorno').val(data.data_retorno);
						$('#sla').val(data.sla);
						$('#status_demanda').val(data.status_demanda);
						$('#esc_data_prazo_um').val(data.esc_data_prazo_um);
						$('#esc_data_retorno_um').val(data.esc_data_retorno_um);
						$('#esc_status_um').val(data.esc_status_um);
						
						$('#esc_data_prazo_dois').val(data.esc_data_prazo_dois);
						$('#esc_data_retorno_dois').val(data.esc_data_retorno_dois);
						$('#esc_status_dois').val(data.esc_status_dois);
						
						$('#esc_data_prazo_tres').val(data.esc_data_prazo_tres);
						$('#esc_data_retorno_tres').val(data.esc_data_retorno_tres);
						$('#esc_status_tres').val(data.esc_status_tres);
						$('#id_natureza_raiz').val(data.codigo_natureza_raiz);
						$('#id_pendencia').val(data.pendencia);
						
						$('#id_area_focal').val(data.codigo_area_focal);
						$('#valorPendencia').val(data.valor_pendencia);
						
						$('#periodo_renovacao').val(data.periodo_renovacao);
						$('#mes_pagamento_trat').val(data.mes_pagamento);
						
						
						
						
						
						$("#salvar").show();
						
						$([document.documentElement, document.body]).animate({
							scrollTop: $("#fim").offset().top
						}, 2000);
	
							
				},
				complete: function () {
				$('#loading_cnds').hide(); // ✅ esconde loader
				},

				error: function (xhr) {
				console.log(xhr.responseText);
				alert('Erro ao carregar a tratativa');
				}
	});	
	
		// $.ajax({	
				// url: "<?php echo $this->config->base_url(); ?>index.php/licencas/listaObsTratEst?id="+idTrat+"&modulo=1",					
				// type : 'GET', /* Tipo da requisição */ 				
				// contentType: "application/json; charset=utf-8",	        	
				// dataType: 'json', /* Tipo de transmissão */	
				// success: function(data){
					// if(data == '0'){
						// $("#uploadObservacao").hide();
						// $(".mostrar-texto").hide();
						// $('#cnd_mob_trat_obs').html('');						
					// }else{
						// $('#cnd_mob_trat_obs').html(data);
						// $("#uploadObservacao").show();
						// $(".mostrar-texto").show();
					// }
					
				// }		
		// });	//fim segundo ajax

	});//fim click
	
	$('.abrir-taxa').click(function(){

			$("#detalhe-taxa").show();
			var idTrat = $(this).attr('id');
			$('.abrir-taxa').children('td, th').css('color','#666');
			$('#'+idTrat).children('td, th').css('color','red');
			
			$('#acao').val('2');
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/licencas/listarTratativaMobById?id="+idTrat,					
				type : 'GET', /* Tipo da requisição */ 				
				contentType: "application/json; charset=utf-8",	        	
				dataType: 'json', /* Tipo de transmissão */	
				beforeSend: function () {
				$('#loading_cnds').show(); // 🔄 mostra loader
				},
				success: function(data){
						$('#id_tratativa_taxa').val(data.id);
						$('#tipo_tratativa').val(data.tipo_tratativa);
						$('#tipo_tratativa_bd').val(data.tipo_tratativa);
						$('#id_pendencia').val(data.pendencia);
						$('#id_esfera').val(data.esfera);
						$('#id_etapa').val(data.etapa);
						$('#data_informe_pendencia2').val(data.data_informe_pendencia);
						$('#id_sis_ext').val(data.id_sis_ext);
						$('#prazo_solucao_sis_ext').val(data.prazo_solucao_sis_ext);
						if(data.data_encerramento_sis_ext !== '11/11/1111'){
							$('#data_encerramento_sis_ext').val(data.data_encerramento_sis_ext);
						}
						if(data.data_vencto !== '11/11/1111'){
							$('#data_vencto').val(data.data_vencto);
						}
						if(data.data_informe_pendencia !== '11/11/1111'){
							$('#data_criacao').val(data.data_informe_pendencia);
						}
						
						if(data.data_informe_pendencia !== '11/11/1111'){
							$('#data_criacao').val(data.data_informe_pendencia);
						}
						$('#status_chamado_sis_ext').val(data.status_chamado_sis_ext);	
						$('#statusChamado').val(data.status_chamado_sis_ext);		
						$('#id_sla_sis_ext').val(data.id_sla_sis_ext);						
						$('#usu_inc').val(data.usu_inc);
						$('#area_focal').val(data.area_focal);
						$('#sub_area_focal').val(data.sub_area_focal);
						$('#contato').val(data.contato);						
						
						if(data.data_envio !== '11/11/1111'){
							$('#data_expiracao').val(data.data_envio);
						}
						
						$('#prazo_solucao').val(data.prazo_solucao);
						
						$('#data_retorno').val(data.data_retorno);
						$('#sla').val(data.sla);
						$('#status_demanda').val(data.status_demanda);
						$('#esc_data_prazo_um').val(data.esc_data_prazo_um);
						$('#esc_data_retorno_um').val(data.esc_data_retorno_um);
						$('#esc_status_um').val(data.esc_status_um);
						
						$('#esc_data_prazo_dois').val(data.esc_data_prazo_dois);
						$('#esc_data_retorno_dois').val(data.esc_data_retorno_dois);
						$('#esc_status_dois').val(data.esc_status_dois);
						
						$('#esc_data_prazo_tres').val(data.esc_data_prazo_tres);
						$('#esc_data_retorno_tres').val(data.esc_data_retorno_tres);
						$('#esc_status_tres').val(data.esc_status_tres);
						$('#id_natureza_raiz').val(data.codigo_natureza_raiz);
						$('#id_pendencia').val(data.pendencia);
						
						$('#id_area_focal').val(data.codigo_area_focal);
						$('#valorPendencia').val(data.valor_pendencia);
						
						$('#periodo_taxas').val(data.periodo_taxas);
						$('#periodo_renovacao').val(data.periodo_renovacao);
						
						$('#responsavel_pagamento').val(data.responsavel_pagamento);
						$('#mes_pagamento').val(data.mes_pagamento);
						
						
						
						$('#modo_emissao').val(data.modo_emissao);
						$('#observacao').val(data.observacao);
						$('#tipo_taxa').val(data.tipo_taxa);
						
						
						$("#salvar").show();
						
						$([document.documentElement, document.body]).animate({
							scrollTop: $("#fim_taxa").offset().top
						}, 2000);
	
							
				},
				complete: function () {
				$('#loading_cnds').hide(); // ✅ esconde loader
				},

				error: function (xhr) {
				console.log(xhr.responseText);
				alert('Erro ao carregar a tratativa');
				}	
	});	
	
		// $.ajax({	
				// url: "<?php echo $this->config->base_url(); ?>index.php/licencas/listaObsTratEst?id="+idTrat+"&modulo=1",					
				// type : 'GET', /* Tipo da requisição */ 				
				// contentType: "application/json; charset=utf-8",	        	
				// dataType: 'json', /* Tipo de transmissão */	
				// success: function(data){
					// if(data == '0'){
						// $("#uploadObservacao").hide();
						// $(".mostrar-texto").hide();
						// $('#cnd_mob_trat_obs').html('');						
					// }else{
						// $('#cnd_mob_trat_obs').html(data);
						// $("#uploadObservacao").show();
						// $(".mostrar-texto").show();
					// }
					
				// }		
		// });	//fim segundo ajax

	});//fim click
	
			$( "#data_encerramento_sis_ext" ).blur(function() {
				var dtEncerra = $("#data_encerramento_sis_ext").val();					
				var dtInc = $('#data_envio').val();	
					if(dtEncerra == 0){					
						alert('Digite a Data de Encerramento');	
					}
					if(dtInc == 0){					
						alert('Digite a Data de Envio');					
						$('#data_encerramento_sis_ext').css('');
							
					}
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/licencas/calcularDias?dtAtendi=" + dtEncerra +'&dataEnvio='+dtInc ,					
					type : 'GET', /* Tipo da requisição */ 					
					contentType: "application/json; charset=utf-8",					
					dataType: 'json', /* Tipo de transmissão */					
					success: function(data){							
						if (data == undefined ) {							
							console.log('Undefined');						
						} else {							
							if(data.status == 1){
								alert('Data de encerramento da tratativa não pode ser menor que a data de envio.');
							}else{
								$('#id_sla_sis_ext').val(data.dias);								
								
							}						
						}												
					}				 
				}); 
			var statusChamado = $("#statusChamado").val();
			$("#salvar").show();
			if((statusChamado!=1) && (statusChamado!=0)){
				$("#salvar").hide();	
			}
			$('#data-encerramento').hide();	
			$('#data_retorno').css('');
		});	
});	


		$(document).on('click','.excluirTratativa',function() {	
			var answer = confirm("Deseja incluir esse item?"); 				
				if (answer){
					var idTrat = $(this).attr('id');
					$.ajax({
						url: "<?php echo $this->config->base_url(); ?>index.php/licencas/excluirTratativa?id="+idTrat,
						type : 'GET', /* Tipo da requisição */ 				
						contentType: "application/json; charset=utf-8",	        	
						dataType: 'json', /* Tipo de transmissão */	
						success: function(data){
							alert('A tratativa foi apagada');
							window.location.reload();
						}	
					});		
				}
	});
				
    </script>      

    <div id="wrapper">
	<div class="content-wrapper container">
	<div class="row">
    <div class="col-sm-12">
        <div class="page-title">
            <h1>Editar Licença</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo $this->config->base_url();?>index.php/lojas/listar"><i class="fa fa-home"></i> Listar Lojas/Licenças</a></li>
                <li class="active">Editar Licença </li>
            </ol>
        </div>
    </div>
	</div><!-- end .page title-->
	<div class="row">    
	<div class="col-md-12">
    <div class="panel panel-card margin-b-30"> 
	<div class="panel-body">	
	<h4 class="panel-title" style='color:#002060'> Dados da Loja
<span style='float:right' > 
<a  class="btn btn-primary" style='color:#fff' href="<?php echo $this->config->base_url(); ?>index.php/loja/listar"> Tela de Pesquisa </a> 
&nbsp;&nbsp;
<a  class="btn btn-warning" style='color:#fff' href="<?php echo $this->config->base_url(); ?>index.php/home/mapa">Voltar ao cockpit </a> 
</span>
</h4>
<BR>
<div class="form-group">
	<div class="col-lg-2">
		&nbsp;&nbsp;&nbsp;Estado
	</div>								
	<div class="col-lg-4">
		&nbsp;&nbsp;&nbsp;Cidade
	</div>	
	<div class="col-lg-4">
		&nbsp;&nbsp;&nbsp;Endereço
	</div>	
	<div class="col-lg-2">
		&nbsp;&nbsp;&nbsp;Unidade
	</div>		
</div>
<div class="form-group">
	<div class="col-lg-2">
		<input type="text" readonly='yes' class="form-control"  style='color:#002060;font-weight:bold' value='<?php echo $imovel[0]->estado;?>'>                              
	</div>
	<div class="col-lg-4">
		<input type="text" readonly='yes' class="form-control"  style='color:#002060;font-weight:bold' value='<?php echo $imovel[0]->cidade;?>'> 
	</div>
	<div class="col-lg-4">
		<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->endereco;?>'>                              
	</div>
	<div class="col-lg-2">
		<input type="text" readonly='yes' class="form-control"  style='color:#002060;font-weight:bold' value='<?php echo $imovel[0]->unidade;?>'>                              
	</div>	
</div>
<div class="form-group">
	<div class="col-lg-3">
		&nbsp;&nbsp;&nbsp;Loja
	</div>	
	<div class="col-lg-3">
		&nbsp;&nbsp;&nbsp;CNPJ
	</div>
	<div class="col-lg-3">
		&nbsp;&nbsp;&nbsp;Regional
	</div>
	<div class="col-lg-3">
		&nbsp;&nbsp;&nbsp;Bandeira
	</div>
</div>
<div class="form-group">
	<div class="col-lg-3">
		<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->nome_loja;?>'>                              
	</div>
	<div class="col-lg-3">
		<input type="text" readonly='yes' class="form-control"  style='color:#002060;font-weight:bold' value='<?php echo $imovel[0]->cnpj;?>'>   
	</div>
	<div class="col-lg-3">
		<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->regional;?>'>                              
	</div>
	<div class="col-lg-3">
		<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->descricao_bandeira;?>'>                              
	</div>
	
</div>
	
</div>


<?php include("licencas.php")?>

<br>

<?php include("taxas.php")?>



</div>





</div>

									
	</div>
	</div>					
	</div>					
	</div>
 	</div> 
	</div>

<!-- Modal - enviar email -->
				<div id="enviarEmail" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Envio de Email</h4>
					  </div>
					   <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart($controller.'/enviar_email', $attributes); 
						?>
					  <div class="modal-body">
						<p>Escolher responsável que receberá o email.</p>
						<input type='hidden' value='<?php echo $id_cnd ?>' id='id-cnd-mob' name='id-cnd-mob' />
						<?php foreach($respExterno as $key => $respExt){ ?>
							  <div class="i-checks"><label> <input type="checkbox" name="email[]" value='<?php echo$respExt->id ?>' ><i></i> &nbsp; <?php echo $respExt->nome_usuario.' - '.$respExt->email ?> </label></div>
						 <?php
						  }								  
						?>

						<button type="submit" class="btn btn-primary">Enviar</button>	
					  </div>
					  
					  </form>	  	
					  <div class="modal-footer">
					  </div>
					</div>

				  </div>
				</div>
				
				
				<!-- Modal - upload -->
				<div id="uploadArquivo" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Upload Arquivo</h4>
					  </div>
					   <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('cnd_brasil/upload_obs', $attributes); 
						?>
					  <div class="modal-body" >
						<p>Escolha o arquivo.</p>
						<input type="file" name="userfile" >
						<p></p>
						<p>Escolha a observação que terá o arquivo.</p>
						<div id='observacoesUpload'> </div>
						<input type="hidden" name="id_cnd_mob" value='<?php echo $id_cnd?>'>
						<input type="hidden" name="modulo" value='<?php echo $modulo?>'>
						<button type="submit" class="btn btn-primary">Enviar</button>	
					  </div>
						
					  </form>	  	
					  <div class="modal-footer">
					  </div>
					</div>

				  </div>
				</div>
				
				<!-- Modal - enviar email -->
				<div id="mostrarTexto" class="modal fade" role="dialog">
				
					
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Como anexar um documento na observação criada. </h4>
					  </div>
					  <div class="modal-body"  >							
							<p id='tela'> Para realizar o upload de um documento, crie primeiramente a observação e depois anexe o documento desejado a esta.</p>
					  </div>
					  <div class="modal-footer">
					  </div>
					</div>

				  </div>
				</div>	
				

<!-- Modal - enviar email -->
				<div id="mostrarArquivos" class="modal fade" role="dialog">
				
					
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Lista de Arquivos </h4>
					  </div>
					  <div class="modal-body"  >							
							<p id='conteudo_arquivos'>
							</p>
					  </div>
					  <div class="modal-footer">
					  </div>
					</div>

				  </div>
				</div>	
				
				<!-- Modal - upload -->
				<div id="uploadExtrato" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Upload Extrato</h4>
					  </div>
					   <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('cnd_brasil/enviar', $attributes); 
						?>
					  <div class="modal-body" >
						<p>Escolha o arquivo.</p>
						<input type="file" name="userfile" >
						<p></p>
						<p>Digite a observação para esse arquivo.</p>						
						<input type="text" name="observacao" value='' style='width:500px!important'>
						<input type="hidden"  name="id_cnd_mob" value='<?php echo $id_cnd?>'>
						<input type="hidden"  name="tipo" value='2'>
						<BR>
						<BR>
						<button type="submit" class="btn btn-primary">Enviar</button>	
					  </div>
						
					  </form>	  	
					  <div class="modal-footer">
					  </div>
					</div>

				  </div>
				</div>
				
				<div id="mostrarArquivosCnds" class="modal fade" role="dialog">
				
					
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Lista de Arquivos </h4>
					  </div>
					  <div class="modal-body"  >							
							<p id='conteudo_arquivos_cnds'>
							</p>
					  </div>
					  <div class="modal-footer">
					  </div>
					</div>

				  </div>
				</div>	
				
				<div id="uploadCnd" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Upload Cnd</h4>
					  </div>
					   <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('cnd_brasil/enviar', $attributes); 
						?>
					  <div class="modal-body" >
						<p>Escolha o arquivo.</p>
						<input type="file" name="userfile" >
						<p></p>
						<p>Digite a observação para esse arquivo.</p>						
						<input type="text" name="observacao" value='' style='width:500px!important'>
						<input type="hidden"  name="tipo" value='1'>
						<input type="hidden"  name="id_cnd_mob" value='<?php echo $id_cnd?>'>
						<BR>
						<BR>
						<button type="submit" class="btn btn-primary">Enviar</button>	
					  </div>
						
					  </form>	  	
					  <div class="modal-footer">
					  </div>
					</div>

				  </div>
				</div>
				<div id="loading_cnds" style="display:none; margin:10px 0;">
				  <img src="<?php echo $this->config->base_url(); ?>assets/images/loader.gif" id="loader_img">
				</div>