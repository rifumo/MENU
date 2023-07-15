
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
   <!--<link rel="stylesheet" href="css/styles.css"> -->
    <script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>
    <?php 

$ruta = $_POST['ruta'];
$c = 0;
$hoy = date("Ymd");
$fecha=date("d/m/Y");

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
            <th scope="col">ETA</th>
            <th scope="col">MUN</th>
            <th scope="col">REC</th>
            <th scope="col">NOMB</th>
            <th scope="col">SEG</th>
            <th scope="col">SECT_URB</th>
            <th scope="col">SECC_URB</th>
            <th scope="col">SECT_RUR</th>
            <th scope="col">SECC_RUR</th>
            <th scope="col">MZ</th>
            <th scope="col">EDIF</th>
            <th scope="col">VIV</th>
            <th scope="col">HOG</th>
            <th scope="col">PER</th>
            <th scope="col">RES</th>
            <th scope="col">OCU</th>
            <th scope="col">DES</th>
            <th scope="col">INA</th>
            <th scope="col">MEN_10</th>
            <th scope="col">MEN_5_9</th> 
            <th scope="col">MICRO</th>
            <th scope="col">ESTR</th>
            <th scope="col">BARR</th>
            <th scope="col">DIR</th>
            <th scope="col">TEL</th>
            <th scope="col">NOM_J</th>
            <th scope="col">ASA</th>
            <th scope="col">IND</th>
            <th scope="col">TR_S_R</th>
            <th scope="col">JOR</th>
            <th scope="col">OTRO</th>
          
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
        $con_pers = $con_pers+ 1;
    }
}

/* ###############################  FIN PERSONAS  ################################*/

/* ############################  INICIO OCUPADOS  ################################*/

$ocu = $DOM->getElementsByTagName('NP_CI_GOCU');
$con_ocu = 0;
foreach($ocu as $ocupados) {
    if($ocupados != ""){
        $con_ocu = $con_ocu+ 1;
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

$men_5_ocu = $DOM->getElementsByTagName('NP_CQ1_P2');
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


$result = $datos->NV_MC_P1;
$resultAT=$datos->NV_MC_P2;
$CodRecole = substr($datos->NOM_ENCDOR, 3, 3);  // devuelve el codigo del recolector
$NomRecole  = explode("-",$datos->NOM_ENCDOR); // devuelve el nombre del recolector
$insta = substr($archivo2, 14,2);
$Etapa = substr($datos->NV_CA_GIDEVIV->NP_CA_C19, 3,4);

/* ############################  INICIO INSTANCE  ################################*/

$INSTANCE = $DOM->getElementsByTagName('NP_CA_C7');

foreach($INSTANCE as $men) {
if ($men->nodeValue  !=  001 ) {
    $con_men="instance_".$insta."_".$hoy."_".$CodRecole;
          }
            else{
              $con_men = "instance_44001_".$hoy."_".$CodRecole; 
            }
}

/* ###############################  FIN INSTANCE  ################################*/


/* ############################  INICIO RURAL/URBANO  ################################*/

$RUR_URB = $DOM->getElementsByTagName('csuptmp');

foreach($RUR_URB as $men) {
if ($men->nodeValue  == 1 OR $men->nodeValue ==2) {
    $tr_re = "URBANA";
          }
            else{
                $ru_ur = "RURAL";
            }
}

/* ###############################  FIN RURAL/URBANO  ################################*/

/* ############################  INICIO ASALARIADO  ################################*/
$ASA = $DOM->getElementsByTagName('NP_CI_P14');
$con_t_r_r= 0;
$asala= 0;
$indep= 0;
foreach($ASA as $asal) {
if ($asal->nodeValue == 1 || $asal->nodeValue == 2||$asal->nodeValue == 3 ) {
       $asala = $asala + 1;
    }
}
/* ###############################  FIN ASALARIADO   ################################*/

/* ############################  INICIO TRABAJADOR SIN REMUNERACION ################################*/
$tr_s_r = $DOM->getElementsByTagName('NP_CI_P14');
$con_t_r_r= 0;

foreach($tr_s_r as $tr_s) {
if ($tr_s->nodeValue == 6) {
       $con_t_r_r = $con_t_r_r + 1;
            }
}

/* ###############################  FIN TRABAJADOR SIN REMUNERACION   ################################*/

/* ############################  INICIO INDEPENDIENTE  ################################*/
$INDE = $DOM->getElementsByTagName('NP_CI_P14');
$indep= 0;
foreach($INDE as $indepe) {
if ($indepe->nodeValue == 4) {
       $indep = $indep + 1;
            }
}

/* ###############################  FIN INDEPENDIENTE  ################################*/


/* ############################  INICIO JORNALERO  ################################*/
$jorna = $DOM->getElementsByTagName('NP_CI_P14');
$jormanelo= 0;
foreach($jorna as $peon) {
if ($peon->nodeValue == 7) {
       $jormanelo = $jormanelo + 1;
            }
}

/* ###############################  FIN JORNALERO  ################################*/

/* ############################  INICIO OTRO  ################################*/
$OTRO = $DOM->getElementsByTagName('NP_CI_P14');
$otros_cual= 0;
foreach($OTRO as $otros) {
if ($otros->nodeValue == 8) {
       $otros_cual = $otros_cual + 1;
            }
}

/* ###############################  FIN OTRO  ################################*/
if($result == 1){

    $result_enc = "EC";
    $ocupados = $con_ocu;
    $desocupados = $con_des;
    $con_ina =  $con_pers-$con_des-$con_ocu-$con_men_10;
    $menores10 = $con_men_10;
    $menores5a9 = $con_men_5_9;
   /* $menosres10_ocu = $con_men_5_9_ocu;*/
}elseif($result == 2){

    $result_enc = "V";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
  /*  $menosres10_ocu = 0;*/
}elseif($result == 3){

    $result_enc = "OM";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
 /*   $menosres10_ocu = 0;*/
}

if($resultAT == 2 ){
    $result_enc = "AT";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
  /*  $menosres10_ocu = 0;*/
}


$cadena = $cadena.'<tr style="font-size:80%;" align="center">
                <td>'.$Etapa.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C6.''.$datos->NV_CA_GIDEVIV->NP_CA_C7.'</td>
                <td>'.$CodRecole.'</td>
                <td>'.$NomRecole[1].'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C15.'</td> 
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C12.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C13.'</td>  
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C9.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C10.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NP_CA_C14.'</td> 
                <td>'.$datos->NV_CA_GIDEVIV->NV_CA_P12.'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NV_CA_P13.'</td>
                <td>'.$datos->Hogares_count.'</td>
                <td>'.$con_pers.'</td>
                <td>'.$result_enc.'</td>
                <td>'.$ocupados.'</td>
                <td>'.$desocupados.'</td>
                <td>'.$con_ina.'</td>
                <td>'.$menores10.'</td>
                <td>'.$menores5a9.'</td>
                <td>'.$con_micro.'</td>
                <td>'.($datos->NV_CB_DAT_VIV->NV_CB_P4->NV_CB_P4_S1_A1 ?? '0').'</td>
                <td>'.$datos->NV_CA_GIDEVIV->NV_CA_P14.'</td>
                <td>'.$datos->p_3_direccion_grupo->p_3_direccion_otro.'</td>
                <td>'.($datos->NV_CA_P16_S1 ?? '0').'</td>
                <td>'.($datos->Hogares->Registro->NP_CAL_UNION2 ?? '0').'</td>
                <td>'.$asala.'</td>
                <td>'.$indep.'</td>
                <td>'.$con_t_r_r.'</td>
                <td>'.$jormanelo.'</td>
                <td>'.$otros_cual.'</td>
             
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