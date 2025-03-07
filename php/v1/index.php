<?php 
date_default_timezone_set('Europe/Madrid');
/**
 *  
 * @About:      API Interface
 * @File:       index.php
 * @Date:       $Date:$ Nov-2021
 * @Version:    $Rev:$ 1.0.1
 * @Developer:  Raul Pardo (Goodidea Ingenieria Coop.V.)
 **/

/* Los headers permiten acceso desde otro dominio (CORS) a nuestro REST API o desde un cliente remoto via HTTP
 * Removiendo las lineas header() limitamos el acceso a nuestro RESTfull API a el mismo dominio
 * Nótese los métodos permitidos en Access-Control-Allow-Methods. Esto nos permite limitar los métodos de consulta a nuestro RESTfull API
 * Mas información: https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 **/
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

include_once '../includes/Config.php';
require_once '../includes/DbHandler.php';
require '../libs/Slim/Slim.php';
require '../includes/Cliente.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post('/get_productos','authenticate', function() use ($app){
	verifyRequiredParams(array('idcliente','red'));
	$param['idcliente'] = $app->request->post('idcliente');
    $param['red'] = $app->request->post('red');

	$cliente = new Cliente();
    $comments = $cliente->get_productos($param);
    if($comments[0]) {
	  $response["datos"] = $comments;
      echoResponse(200, $response);
    } else {
      $response["datos"] = $comments;
      echoResponse(200, $response);
   }	
});

$app->post('/get_producto','authenticate', function() use ($app){
	verifyRequiredParams(array('idprod'));
	$cliente = new Cliente();
    $comments = $cliente->get_productos($app->request->post('idprod'));
    if($comments[0]) {
	  $response["datos"] = $comments;
      echoResponse(200, $response);
    } else {
      $response["datos"] = $comments;
      echoResponse(200, $response);
   }	
});

$app->post('/get_total_prods','authenticate', function() use ($app){
	verifyRequiredParams(array('idcliente','red'));
	$param['idcliente'] = $app->request->post('idcliente');
    $param['red'] = $app->request->post('red');

	$cliente = new Cliente();
    $comments = $cliente->get_total_prods($param);
    if($comments[0]) {
	  $response["datos"] = $comments;
      echoResponse(200, $comments[1][0]['total']);
    } else {
      $response["datos"] = $comments;
      echoResponse(200, $response);
   }	
});

$app->post('/get_total_prods_hechos','authenticate', function() use ($app){
	verifyRequiredParams(array('idcliente','red'));
	$param['idcliente'] = $app->request->post('idcliente');
    $param['red'] = $app->request->post('red');

	$cliente = new Cliente();
    $comments = $cliente->get_total_prods_hechos($param);
    if($comments[0]) {
	  $response["datos"] = $comments;
      echoResponse(200, $comments[1][0]['si']);
    } else {
      $response["datos"] = $comments;
      echoResponse(200, $response);
   }	
});

$app->post('/get_total_prods_no_hechos','authenticate', function() use ($app){
	verifyRequiredParams(array('idcliente','red'));
	$param['idcliente'] = $app->request->post('idcliente');
    $param['red'] = $app->request->post('red');

	$cliente = new Cliente();
    $comments = $cliente->get_total_prods_no_hechos($param);
    if($comments[0]) {
	  $response["datos"] = $comments;
      echoResponse(200, $comments[1][0]['no']);
    } else {
      $response["datos"] = $comments;
      echoResponse(200, $response);
   }	
});

$app->post('/get_total_documentos','authenticate', function() use ($app){
	verifyRequiredParams(array('idcliente','red'));
	$param['idcliente'] = $app->request->post('idcliente');
    $param['red'] = $app->request->post('red');

	$cliente = new Cliente();
    $comments = $cliente->get_total_documentos($param);
    if($comments[0]) {
	  $response["datos"] = $comments;
      echoResponse(200, $comments[1]);
    } else {
      $response["datos"] = $comments;
      echoResponse(200, $response);
   }	
});

$app->post('/get_total_documentos_by_prod','authenticate', function() use ($app){
	verifyRequiredParams(array('idcliente','red'));
	$param['idcliente'] = $app->request->post('idcliente');
    $param['red'] = $app->request->post('red');

	$cliente = new Cliente();
    $comments = $cliente->get_total_documentos($param);
    if($comments[0]) {
	  $response["datos"] = $comments;
      echoResponse(200, $comments[1]);
    } else {
      $response["datos"] = $comments;
      echoResponse(200, $response);
   }	
});



/*********************** USEFULL FUNCTIONS **************************************/

/**
 * Verificando los parametros requeridos en el metodo o endpoint
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"]=true;
        $response["color"] = 'rojo';
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);

        $app->stop();
    }
}

/**
 * Validando parametro email si necesario; un Extra ;)
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["color"] = 'rojo';
        $response["message"] = 'Email address is not valid';
        echoResponse(400, $response);

        $app->stop();
    }
}

/**
 * Mostrando la respuesta en formato json al cliente o navegador
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

/**
 * Agregando un leyer intermedio e autenticación para uno o todos los metodos, usar segun necesidad
 * Revisa si la consulta contiene un Header "Authorization" para validar
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
	//echoResponse(200,$headers['Authorization']);
    // Verifying Authorization Header
    if ((isset($headers['Authorization'])) || (empty($headers['Authorization']) == false)) {
        $db = new DbHandler(); //utilizar para manejar autenticacion contra base de datos
        $token = $headers['Authorization'];
        $tokenDb = $db->checkToken($token);
        if (!$tokenDb[0]) {
            $response["color"] = 'rojo';
            $response["message"] = $tokenDb[1];
            echoResponse(401, $response);
            $app->stop(); //Detenemos la ejecución del programa al no validar

        } else {
           if($tokenDb[1][0]['validoHasta'] < date('Y-m-d')){
               $response["color"] = 'rojo';
               $response["message"] = "Token expirado, debe conseguir un token válido";
               echoResponse(401, $response);
               $app->stop(); //Detenemos la ejecución del programa al no validar
           }else{
               
           }
        }
    } else {
        // api key is missing in header
        $response["color"] = 'rojo';
        $response["message"] = "Falta token de autorización";
        echoResponse(400, $response);
        $app->stop();
    }
}
/* corremos la aplicación */
$app->run();

?>

  