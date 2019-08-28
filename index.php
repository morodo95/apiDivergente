<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Andreani\Andreani;
use Andreani\Requests\CotizarEnvio;
use Andreani\Requests\ConfirmarCompra;
use Andreani\Requests\ConsultarSucursales;

require 'vendor/autoload.php';
$app = new \Slim\App;

$app->post('/cotizarEnvio', function (Request $request, Response $response) {
        $data = json_decode($request->getBody(), true);
        $CPDestino = $data['CPDestino'];
        $Peso = $data['Peso'];
        $Volumen = $data['Volumen'];
        $ValorDeclarado = $data['ValorDeclarado'];

        $request = new CotizarEnvio();
        $request->setCodigoDeCliente('CL0003750');
        $request->setNumeroDeContrato('400006709');
        $request->setCodigoPostal($CPDestino);
        $request->setPeso($Peso);
        $request->setVolumen($Volumen);
        $request->setValorDeclarado($ValorDeclarado);
    
        $andreani = new Andreani('eCommerce_Integra','passw0rd','test');
        $response = $andreani->call($request);
        if($response->isValid()){
            $tarifa = $response->getMessage()->CotizarEnvioResult->Tarifa;
            echo $tarifa;
            
        } else {
            echo $response->getMessage();
        }
});

$app->post('/generarEnvio', function (Request $request, Response $response){
    $data = json_decode($request->getBody(), true);
    $request = new GenerarEnvioConDatosDeImpresionYRemitente();
});


$app->post('/altaEnvio', function (Request $request, Response $response) {
    $data = json_decode($request->getBody(), true);
  
    

    $request = new ConfirmarCompra();
    $request->setDatosDetino($provincia,$localidad, $codigoPostal, $calle, $numero, $piso, $departamento, $codigoDeSucursal, $sucursalCliente);
    $request->setDatosDestinatario($nombreYApellido,$nombreYApellidoAlternativo,$tipoDeDocumento,$numeroDeDocumento,$email,$numeroDeCelular,$numeroDeTelefono);
    $request->setCodigoPostal($codigoPostal);
    $request->setCodigoDeSucursal($codigoDeSucursal);
    $request->setDatosTransaccion($numeroDeContrato, $numeroDe);
    $request->setDatosEnvio($peso, $volumen);


    $andreani = new Andreani('eCommerce_Integra','passw0rd','test');
    $response = $andreani->call($request);
    if($response->isValid()){
        $resultado= $response->getMessage()->ConfirmarCompraResult->NumeroAndreani;
        echo $resultado;
    } else {
        echo $response->getMessage();
    }
});


$app->post('consultarLocalidades', function (Request $request, Response $response){
    $data = json_decode($request->getBody(), true);
    
});

$app->post('/consultarSucursales', function (Request $request, Response $response) {
    $data = json_decode($request->getBody(), true);
        $CPDestino = $data['CPDestino'];
        $Localidad = $data['Localidad'];
        
        $Provincia = $data['Provincia'];
        $request = new ConsultarSucursales();
        
        $request->setCodigoPostal($CPDestino);
        $request->setLocalidad($Localidad);
        $request->setProvincia($Provincia);
        
        $andreani = new Andreani('eCommerce_Integra','passw0rd','test');
        $response = $andreani->call($request);
        if($response->isValid()){
            $resultado= $response->getMessage()->ConsultarSucursalesResult->ResultadoConsultarSucursales;
            $resultado = Return_Values($resultado);
            $resultado =json_decode(json_encode($resultado[0], true));
            
            if (is_object($resultado)) {
                $resultado = get_object_vars($resultado);
            }
            print_r($resultado["Sucursal"]);

        } else {
            echo $response->getMessage();
        }
});






function Return_Values($array) 
{ 
    return (array_values($array)); 
} 

$app->run();