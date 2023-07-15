
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
            <th scope="col">FECHA</th>
            <th scope="col">CODIGO REC</th>
            <th scope="col">SEGMENTO</th>
            <th scope="col">EDIF</th>
            <th scope="col">VIV</th>
            <th scope="col">HOG</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">PAREN</th>
            <th scope="col">PERSONAS EN EL HOG</th>
            <td></td>
            <th scope="col">ACTIVIDAD</th>
            <th scope="col">PERSONAS-EMPRESA</th>
            <th scope="col">ARL</th>
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

/* ###############################  FIN ACTIVIDAD  ################################*/
$ACTI = $DOM->getElementsByTagName('Personas');
                            $datosact = array();

                        foreach ($ACTI as $actividad) {
                                $np_ch_p2 = $actividad->getElementsByTagName('NP_CH_P2')->item(0);

                                if ($np_ch_p2 && ($np_ch_p2->nodeValue == 1 || $np_ch_p2->nodeValue == 4)) {
                                    $np_ci_p1_s1_a1 = $actividad->getElementsByTagName('NP_CI_P1_S1_A1')->item(0);
                                    if ($np_ci_p1_s1_a1 && $np_ci_p1_s1_a1->nodeValue) {
                                        $datosact[] = $np_ci_p1_s1_a1->nodeValue;
                                } else {
                                        $datosact[] = "0"; // Llenar con cero si el elemento no tiene valor
                                        }   
                                } else {
                                $datosact[] = "0"; // Llenar con cero si el elemento no se encuentra
    }
}

/* ###############################  FIN ACTIVIDAD  ################################*/

$datos = new SimpleXMLElement($archivoFinal, null, true);

if (file_exists($ruta)) {
    $datos = new SimpleXMLElement($archivoFinal, null, true);
 
} else {
    exit('Error abriendo test.xml.');

}$CodRecole = substr($datos->NOM_ENCDOR, 3, 3);

$result = $datos->NV_MC_P1;

if($result == 1){

    $result_enc = "EC";
  
    
}elseif($result == 2){

    $result_enc = "V";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;
    
}elseif($result == 3){

    $result_enc = "OM";
    $result_enc = "V";
    $ocupados = 0;
    $desocupados = 0;
    $con_ina = 0;
    $menores10 = 0;
    $menores5a9 = 0;

}



$cadena = $cadena.'<tr style="font-size:80%;" align="center">
                <td>'.$datos->start_timedvp.'</td>
                <td>'.$CodRecole.'</td>
                <td>'.($datos->NV_CA_GIDEVIV->NP_CA_C15 ?? '0').'</td>
                <td>'.($datos->NV_CA_GIDEVIV->NV_CA_P12 ?? '0').'</td>
                <td>'.($datos->NV_CA_GIDEVIV->NV_CA_P13 ?? '0').'</td>
                <td>'.($datos->Hogares_count ?? '0').'</td>
                <td>'.($datos->Hogares->Personas->NP_CC_C2 ?? '0').'</td>
                <td>JEFE</td>
                <td>'.$con_pers.'</td>
                <td></td>
                <td>'.($datos->Hogares->Personas->NP_CI_GOCU->NP_CI_GEMPPRI->NP_CI_P1_S1_A1 ?? '0').'</td>
                <td>'.($datos->Hogares->Personas->NP_CI_GOCU->NP_CI_GTOTOCU->NP_CI_P56 ?? '0').'</td>
                <td>'.($datos->Hogares->Personas->NP_CI_GOCU->NP_CI_GTOTOCU->NP_CI_P63 ?? '0').'</td>
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