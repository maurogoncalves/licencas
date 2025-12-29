<?php
function anos(){

  $ano = array(
				"2019" => '2019',
				"2018" => '2018',
				"2017" => '2017',
                "2016" => '2016',
				"2015" => '2015',
				"2014" => '2014',
				"2013" => '2013'
                );
  return $ano;

}

function meses($m){

  
switch ($m) {
    case 1:
        $mes='Janeiro';
    break;
    case 2:
        $mes='Fevereiro';
    break;
    case 3:
        $mes='Março';
    break;	
	case 4:
        $mes='Abril';
    break;
	case 5:
        $mes='Maio';
    break;
	case 6:
        $mes='Junho';
    break;
	case 7:
        $mes='Julho';
    break;
	case 8:
        $mes='Agosto';
    break;
	case 9:
        $mes='Setembro';
    break;
	case 10:
        $mes='Outubro';
    break;
	case 11:
        $mes='Novembro';
    break;	
	case 12:
        $mes='Dezembro';
    break;
	default:
        $mes='Nada Consta';
    break;
}

  return $mes;

}
?>