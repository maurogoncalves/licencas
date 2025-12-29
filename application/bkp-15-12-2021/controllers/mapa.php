<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapa extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('mapa_model','',TRUE);	
   $this->load->model('sublocacao_model','',TRUE);	
   $this->load->model('log_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
   $this->load->model('loja_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
   $this->db->cache_on();
  
 }
 
 function index()
 {
   if($this->session->userdata('logged_in'))
   {
	
     $session_data = $this->session->userdata('logged_in');
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
     $this->load->view('home_view', $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

 function inicio(){	


 if($this->session->userdata('logged_in')) {
   
	$session_data = $this->session->userdata('logged_in');
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$idContratante = $session_data['id_contratante'];
	 
	$data['estados'] = $this->mapa_model->buscaCNDEstado($idContratante); 
	$data['cidadesMob'] = $this->mapa_model->buscaCNDMobCidade($idContratante); 
	//print_r($data);exit;
	//$this->load->view('header_view',$data);
    $this->load->view('mapa_brasil_view', $data);
	
	//$this->load->view('footer_view');
   } else {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }

    
   
	
}
function buscaDados(){
	$base = $this->config->base_url();
	$base .='index.php';
	$bandeiras= $this->mapa_model->todasBandeiras(); 
	$bandeirasTotal= $this->mapa_model->totalBandeiras(); 
	$retorno = '';	
	$retorno .= '<table class="table table-striped header-fixed" style="background-color:#dedede;text-align:center">';
	$retorno .="<thead style='text-align:center'>";
	$retorno .="<tr>";
	$retorno .="<td > </td>";
	$retorno .="<td colspan='3'  >CND I </td>";
	$retorno .="<td colspan='3' >CND M </td>";
	$retorno .="<td colspan='".$bandeirasTotal[0]->total."' >Loja por Bandeira </td>";
	$retorno .="</tr>";
	
	$retorno .="<tr>";
	$retorno .="<td > Cidade - Estado </td>";
	$retorno .="<td > S </td>";
	$retorno .="<td > N </td>";
	$retorno .="<td > P </td>";
	$retorno .="<td > S </td>";
	$retorno .="<td > N </td>";
	$retorno .="<td > P </td>";	
	foreach($bandeiras as $bandeira){
		$retorno .="<td >".$bandeira->descricao_bandeira."</td>";	
	}
	$retorno .="</thead>";
	$retorno .="</tr>";
		
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $session_data['id_contratante'];
	
	$estado = strtoupper(substr($this->input->get('estado'),1,2));
	
	$cidades= $this->mapa_model->todasCidadesDoEstado($idContratante,$estado); 
	$total = 0;
	foreach($cidades as $cidade){
		$cndImobSim = $this->mapa_model->buscaCNDImob($idContratante,$cidade->cidade,$estado,1); 
		$cndImobNao = $this->mapa_model->buscaCNDImob($idContratante,$cidade->cidade,$estado,2); 
		$cndImobPend = $this->mapa_model->buscaCNDImob($idContratante,$cidade->cidade,$estado,3); 
		$cndMobSim = $this->mapa_model->buscaCNDMob($idContratante,$cidade->cidade,$estado,1); 
		$cndMobNao = $this->mapa_model->buscaCNDMob($idContratante,$cidade->cidade,$estado,2); 
		$cndMobPend = $this->mapa_model->buscaCNDMob($idContratante,$cidade->cidade,$estado,3);
		


		 //print_r($this->db->last_query());exit;
		//print_r($cndImobSim);exit;
		$retorno .="<tr>";
		$retorno .="<td style='font-weight:bold;'>".$cidade->cidade.' '.$estado."</td>";
		if($cndImobSim[0]->total <> 0){
			$cndISimCor = '#FF0303';
			$retorno .="<td style='color:$cndISimCor'><a href='$base/cnd_imob/listarComParametro?cidade=$cidade->cidade&uf=$estado' target='_blank'> ".$cndImobSim[0]->total."</a></td>";
		}else{
			$cndISimCor = '#000';
			$retorno .="<td style='color:$cndISimCor'>".$cndImobSim[0]->total."</td>";
		}
		$total = $total + $cndImobSim[0]->total;
		if($cndImobNao[0]->total <> 0){
			$cndINaoCor = '#FF0303';
			$retorno .="<td style='color:$cndINaoCor'><a href='$base/cnd_imob/listarComParametro?cidade=$cidade->cidade&uf=$estado' target='_blank'> ".$cndImobNao[0]->total."</a></td>";
		}else{
			$cndINaoCor = '#000';
			$retorno .="<td style='color:$cndINaoCor'>".$cndImobNao[0]->total."</td>";
		}
		$total = $total + $cndImobNao[0]->total;
		if($cndImobPend[0]->total <> 0){
			$cndIPendCor = '#FF0303';
			$retorno .="<td style='color:$cndIPendCor'><a href='$base/cnd_imob/listarComParametro?cidade=$cidade->cidade&uf=$estado' target='_blank'> ".$cndImobPend[0]->total."</a></td>";
		}else{
			$cndIPendCor = '#000';
			$retorno .="<td style='color:$cndIPendCor'>".$cndImobPend[0]->total."</td>";
		}
		$total = $total + $cndImobPend[0]->total;
		if($cndMobSim[0]->total <> 0){
			$cndMSimCor = '#2403FF';
			$retorno .="<td style='color:$cndMSimCor'><a href='$base/cnd_mob/listarComParametro?cidade=$cidade->cidade&uf=$estado' target='_blank'> ".$cndMobSim[0]->total."</a></td>";
		}else{
			$cndMSimCor = '#000';
			$retorno .="<td style='color:$cndMSimCor'>".$cndMobSim[0]->total."</td>";
		}
		$total = $total + $cndMobSim[0]->total;
		if($cndMobNao[0]->total <> 0){
			$cndMNaoCor = '#2403FF';
			$retorno .="<td style='color:$cndMNaoCor'><a href='$base/cnd_mob/listarComParametro?cidade=$cidade->cidade&uf=$estado' target='_blank'> ".$cndMobNao[0]->total."</a></td>";
		}else{
			$cndMNaoCor = '#000';
			$retorno .="<td style='color:$cndMNaoCor'>".$cndMobNao[0]->total."</td>";
		}
		$total = $total + $cndMobNao[0]->total;
		if($cndMobPend[0]->total <> 0){
			$cndMPendCor = '#2403FF';
			$retorno .="<td style='color:$cndMPendCor'><a href='$base/cnd_mob/listarComParametro?cidade=$cidade->cidade&uf=$estado' target='_blank'> ".$cndMobPend[0]->total."</a></td>";
		}else{
			$cndMPendCor = '#000';
			$retorno .="<td style='color:$cndMPendCor'>".$cndMobPend[0]->total."</td>";
		}
		$total = $total + $cndMobPend[0]->total;
		
		foreach($bandeiras as $bandeira){		
			$band = $this->mapa_model->buscaLojaBandeira($idContratante,$cidade->cidade,$estado,$bandeira->id); 
			if($band[0]->total <> 0){				
				$retorno .="<td style='color:#DE11BF'><a href='$base/loja/listarComParametro?cidade=$cidade->cidade&uf=$estado' target='_blank'> ".$band[0]->total."</a></td>";
			}else{
				$retorno .="<td >".$band[0]->total."</td>";
			}
			$total = $total + $band[0]->total;
		}
		$retorno .="</tr>";
		
	}

	//exit;
//print_r($todos);exit;

	//$data['cidades'] = $this->mapa_model->buscaCNDCidade1($idContratante); 
	
	//print$retorno;
	echo json_encode($retorno);

}
function inicio2(){	


 if($this->session->userdata('logged_in')) {
   
	$session_data = $this->session->userdata('logged_in');
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$idContratante = $session_data['id_contratante'];
	$data['estados'] = $this->mapa_model->buscaTodosEstados($idContratante);  
	$data['cidades'] = $this->mapa_model->buscaCNDCidade1($idContratante); 

	//print_r($data);exit;
	//$this->load->view('header_view',$data);
    $this->load->view('mapa_view', $data);
	
	//$this->load->view('footer_view');
   } else {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }

    
   
	
}

function inicio1(){	


 if($this->session->userdata('logged_in')) {
   
	$session_data = $this->session->userdata('logged_in');
    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$idContratante = $session_data['id_contratante'];
	 
	$data['estados'] = $this->mapa_model->buscaCNDEstado($idContratante); 
	$data['cidades'] = $this->mapa_model->buscaCNDCidade1($idContratante); 

	//print_r($data);exit;
	//$this->load->view('header_view',$data);
    $this->load->view('mapa_brasil_um_view', $data);
	
	//$this->load->view('footer_view');
   } else {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }

    
   
	
}

function total(){	

	$base = $this->config->base_url();
	require_once 'assets/mapa/gmaps.class.php';
	$gmaps = new gMaps;

	# Carregar de  XML
	//$gmaps->loadFromXML("markers.xml");
	//$gmaps->getMarkers();exit;

	# Adicionar pin/icons 
	$base = $this->config->base_url();
	
	$gmaps->addIcon( "imovel", $base."assets/icons/pin.png", "45", "45" );

	$session_data = $this->session->userdata('logged_in');
	$idContratante = $session_data['id_contratante'];
	
	$estados = $this->mapa_model->buscaCNDEstado($idContratante);
	
	foreach($estados as $key => $est){
		
		$gmaps->addMarker($est->lat1,$est->lat2,"<p>".$est->estado.'<BR>'.utf8_decode($est->total).' CNDS Mobiliárias'."</p>","imovel");	
	
	}

	$gmaps->getMarkers();
	
}

 
}
 
?>