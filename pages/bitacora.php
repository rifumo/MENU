
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
  
</head>
<body>
    <?php 

$ruta = $_POST['ruta'];
$c = 0;
$hoy = date("Ymd");
if (empty($ruta)) {
    $errorMessage = 'No digitó la ruta de los archivos!';
    $errorImage = 'image/9u7v.gif';
} else if (!is_dir($ruta)) {
    $errorMessage = 'No se encontró la ruta especificada!';
    $errorImage = 'image/y7.gif';
} else {
 
    
    
    $cadena = '<table class="table table-sm" align="center" style="width:80%;">

    <thead class="bg-success" style="Color:#FFFFFF;font-size:80%;" align="center">
        <tr>
            <th scope="col">MUN</th>
            <th scope="col">SUP</th>
            <th scope="col">REC</th>
            <th scope="col">SEG</th>
            <th scope="col">MZ</th>
            <th scope="col">EDIF</th>
            <th scope="col">VIV</th>
            <th scope="col">HOG</th>
            <th scope="col">PER</th>
            <th scope="col">RES</th>
            <th scope="col">XML</th>
            <th scope="col">OCU</th>
			<th scope="col">DES</th>
			<th scope="col">INA</th>
            <th scope="col">MEN_10</th>
            <th scope="col">MEN_5_9</th>
            <th scope="col">MEN_5_9_OCU</th> 
            <th scope="col">MICRO</th>
            <th scope="col">ESTRATO</th>
        </tr>
    </thead>';
 
$directorio = opendir($ruta); //ruta actual


while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (is_dir($archivo))//verificamos si es o no un directorio
    {
        
        //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
        

    }
    else
    {
$subdir = opendir($ruta.'\\'.$archivo);


        while ($archivo2 = readdir($subdir)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (is_dir($archivo2))//verificamos si es o no un directorio
            {
                //echo "[".$archivo2 . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
            }
            else
            {
        

                $info = new SplFileInfo($archivo2);
                $extension = $info->getExtension();

                $contar_extension = 0;

                if ($extension == "xml"){

                    $contar_extension = $contar_extension + 1;
                    $c = $c + 1;

                $archivoFinal = $ruta.'\\'.$archivo.'\\'.$archivo2;


$xml = file_get_contents($archivoFinal);
$DOM = new DOMDocument('1.0', 'utf-8');
$DOM->loadXML($xml);


/* ############################  INICIO PERSONAS  ################################*/

$pers = $DOM->getElementsByTagName('posicionP');

$con_pers = 0;


foreach($pers as $personas) {

    if($personas != ""){
        $con_pers = $con_pers + 1;
    }
}

/* ###############################  FIN PERSONAS  ################################*/

/* ############################  INICIO OCUPADOS  ################################*/

$ocu = $DOM->getElementsByTagName('NP_CI_GOCU');

$con_ocu = 0;


foreach($ocu as $ocupados) { 

    if($ocupados != ""){
        $con_ocu = $con_ocu + 1;
    }
}

/* ###############################  FIN OCUPADOS  ################################*/



/* ############################  INICIO MICRONEGOCIOS  ################################*/

$micro = $DOM->getElementsByTagName('NP_CN_GMIC');

$con_micro = 0;

foreach($micro as $micronegocios) {

if($micronegocios != ""){
    $con_micro = $con_micro + 1;
}

}


/* ###############################  FIN MICRONEGOCIOS  ################################*/
/* ############################  INICIO DESOCUPADOS  ################################*/

$des = $DOM->getElementsByTagName('NP_CJ_P2');

$con_des = 0;

foreach($des as $desocupado) {

if($desocupado != ""){
    $con_des = $con_des + 1;
}

}


/* ###############################  FIN DESOCUPADOS  ################################*/

/* ############################  INICIO INACTIVOS  ################################*/

$inac = $DOM->getElementsByTagName('NP_CJ_P8');

$con_inac = 0;

foreach($inac as $inactivos) {

if($inactivos != ""){
    $con_inac = $con_inac + 1;
}

}


/* ###############################  FIN DESOCUPADOS  ################################*/

/* ############################  INICIO MENORES 10  ################################*/

$men_10 = $DOM->getElementsByTagName('NP_CE_P4');

$con_men_10 = 0;


foreach($men_10 as $menores) {

if ($menores->nodeValue < 10) {
       $con_men_10 = $con_men_10 + 1;
            }
      
}


/* ###############################  FIN MENORES 10  ################################*/

/* ############################  INICIO MENORES 9 OCUPADOS  ################################*/

$men_5_ocu = $DOM->getElementsByTagName('NP_CQ1_P5');
$con_men_5_9_ocu= 0;
foreach($men_5_ocu as $menores5_ocu) {
if ($menores5_ocu->nodeValue == 1 ) {
       $con_men_5_9_ocu = $con_men_5_9_ocu + 1;
            }
}


 /*###############################  FIN MENORES 9 OCUPADOS ################################*/

/* ############################  INICIO MENORES 5  ################################*/

$men_5 = $DOM->getElementsByTagName('NP_CE_P4');

$con_men_5_9= 0;

foreach($men_5 as $menores5) {

if ($menores5->nodeValue <=9 && $menores5->nodeValue >= 5 ) {
       $con_men_5_9 = $con_men_5_9 + 1;
            }
      
}

/* ###############################  FIN MENORES 5  ################################*/
$datos = new SimpleXMLElement($archivoFinal, null, true);

if (file_exists($ruta)) {
    $datos = new SimpleXMLElement($archivoFinal, null, true);
 
} else {
    exit('Error abriendo test.xml.');
}

$CodRecole = substr($datos->NOM_ENCDOR, 3, 3);
$result = $datos->NV_MC_P1;
$resultAT=$datos->Titulo_16->NV_MC_P2_S1;
$menosres10_ocu = $con_men_5_9_ocu;


if($result == 1){
    $result_enc = "EC";
    $ocupados = $con_ocu;
    $desocupados = $con_des;
    $con_ina =  $con_pers-$con_ocu-$con_des-$con_men_10 ;
    $menores10 = $con_men_10;
    $menores5a9 = $con_men_5_9;
    $estrato = $datos->NV_CB_DAT_VIV->NV_CB_P4->NV_CB_P4_S1_A1;
}elseif($result == 2){

    $result_enc = "V";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
    $estrato = 0;
 }elseif($result == 3){

    $result_enc = "OM";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
    $estrato = 0;
 }

if($resultAT == 1 ){
    $result_enc = "AT";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
    $estrato = 0;
}

if($resultAT == 2 ){
    $result_enc = "R";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
    $estrato = 0;
}

if($resultAT == 3 ){
    $result_enc = "NH";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
    $estrato = 0;
}

if($resultAT == 4 ){
    $result_enc = "OC";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
    $estrato = 0;
}

$cadena = $cadena.'<tr style="font-size:80%;" align="center">
               
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C6.''.$datos->NV_CA_GIDEVIV->NP_CA_C7.'</td>
                <td>'.$datos->csuptmp.'</td>
                <td>'.$CodRecole.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C15.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C14.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NV_CA_P12.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NV_CA_P13.'</td>
                <td>'.$datos->Hogares_count.'</td>
                <td>'.$con_pers.'</td>
                <td>'.$result_enc.'</td>
                <td>'.$archivo2.'</td>             
                <td>'.$ocupados.'</td>
                <td>'.$desocupados.'</td>
                <td>'.$con_ina.'</td>
                <td>'.$menores10.'</td>
                <td>'.$menores5a9.'</td>
                <td>'.$menosres10_ocu.'</td>
                <td>'.$con_micro.'</td>
				<td>'.$estrato.'</td>
            </tr>';
        }else{

            $contar_extension = 0;
            
        }
            }  
             
        }

        // $archivo . "<br />";
    }
}

$cadena = $cadena.'</table>';

if ($contar_extension > 0){
    echo '';
}else{
    echo '<div class="alert alert-danger" role="alert" style="width:20rem; margin: 0;top: 50%;left: 10%;-ms-transform: translateY(-50%);transform: translateY(-50%);">
           No se encuentran archivos XML!
          </div>';
}
echo $cadena;
}

    ?>
<?php if (isset($errorMessage) && isset($errorImage)): ?>
    <div class="alert alert-danger" role="alert" style="width: 20rem; margin: 0 auto; top: 50%; left: 10%; -ms-transform: translateY(-50%); transform: translateY(-50%);">
        <img src="<?php echo $errorImage; ?>" alt="loading" width="277" height="100"><br>
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>




</body>
</html>