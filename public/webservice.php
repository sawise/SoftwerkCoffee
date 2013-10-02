<?php
require_once('../config.php');
?>
	
	<div class="row divbg">


	    <?php //TESTING

class Request {
		public $url_elements;
		public $verb;
		public $parameters;

		public function __construct() {
		    $this->verb = $_SERVER['REQUEST_METHOD'];
		    $this->url_elements = explode('/', $_SERVER['PATH_INFO']);
		      // initialise json as default format
		    $this->format = 'json';
		    if(isset($this->parameters['format'])) {
		        $this->format = $this->parameters['format'];
		    }
		    return true;
		}
		public function parseIncomingParams() {
		 $parameters = array();

		 // first of all, pull the GET vars
		 if (isset($_SERVER['QUERY_STRING'])) {
		     parse_str($_SERVER['QUERY_STRING'], $parameters);
		 }

		 // now how about PUT/POST bodies? These override what we got from GET
		 $body = file_get_contents("php://input");
		 $content_type = false;
		 if(isset($_SERVER['CONTENT_TYPE'])) {
		     $content_type = $_SERVER['CONTENT_TYPE'];
		 }
		 switch($content_type) {
		     case "application/json":
		         $body_params = json_decode($body);
		         if($body_params) {
		             foreach($body_params as $param_name => $param_value) {
		                 $parameters[$param_name] = $param_value;
		             }
		         }
		         $this->format = "json";
		         break;
		     case "application/x-www-form-urlencoded":
		         parse_str($body, $postvars);
		         foreach($postvars as $field => $value) {
		             $parameters[$field] = $value;

		         }
		         $this->format = "html";
		         break;
		     default:
		         // we could parse other supported formats here
		         break;
		 }
		 $this->parameters = $parameters;
		}
}
	    		/*function deliver_response($format, $api_response){
 
    // Define HTTP responses
    $http_response_code = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found'
    );
 
    // Set HTTP Response
    header('HTTP/1.1 '.$api_response['status'].' '.$http_response_code[ $api_response['status'] ]);
 
    // Process different content types
    if( strcasecmp($format,'json') == 0 ){
 
        // Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');
 
        // Format data into a JSON response
        $json_response = json_encode($api_response);
 
        // Deliver formatted data
        echo $json_response;
 
    }elseif( strcasecmp($format,'xml') == 0 ){
 
        // Set HTTP Response Content Type
        header('Content-Type: application/xml; charset=utf-8');
 
        // Format data into an XML response (This is only good at handling string data, not arrays)
        $xml_response = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
            '<response>'."\n".
            "\t".'<code>'.$api_response['code'].'</code>'."\n".
            "\t".'<data>'.$api_response['data'].'</data>'."\n".
            '</response>';
 
        // Deliver formatted data
        echo $xml_response;
 
    }else{
 
        // Set HTTP Response Content Type (This is only good at handling string data, not arrays)
        header('Content-Type: text/html; charset=utf-8');
 
        // Deliver formatted data
        echo $api_response['data'];
 
    }
 
    // End script process
    exit;
 
}
 
// Define whether an HTTPS connection is required
$HTTPS_required = FALSE;
 
// Define whether user authentication is required
$authentication_required = FALSE;
 
// Define API response codes and their related HTTP response
$api_response_code = array(
    0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
    1 => array('HTTP Response' => 200, 'Message' => 'Success'),
    2 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'),
    3 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'),
    4 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'),
    5 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
    6 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
);
 
// Set default HTTP response of 'ok'
$response['code'] = 0;
$response['status'] = 404;
$response['data'] = NULL;
 
// --- Step 2: Authorization
 
// Optionally require connections to be made via HTTPS
if( $HTTPS_required && $_SERVER['HTTPS'] != 'on' ){
    $response['code'] = 2;
    $response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
    $response['data'] = $api_response_code[ $response['code'] ]['Message']; 
 
    // Return Response to browser. This will exit the script.
    deliver_response($_GET['format'], $response);
}
 
// Optionally require user authentication
if( $authentication_required ){
 
    if( empty($_POST['username']) || empty($_POST['password']) ){
        $response['code'] = 3;
        $response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
        $response['data'] = $api_response_code[ $response['code'] ]['Message'];
    }
 
    // Return an error response if user fails authentication. This is a very simplistic example
    // that should be modified for security in a production environment
    elseif( $_POST['username'] != 'foo' && $_POST['password'] != 'bar' ){
        $response['code'] = 4;
        $response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
        $response['data'] = $api_response_code[ $response['code'] ]['Message'];
    }
 
}
 
// --- Step 3: Process Request
 
// Method A: Say Hello to the API
if( strcasecmp($_GET['method'],'hello') == 0){
    $response['code'] = 1;
    $response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
    $response['data'] = 'Hello World';  
}
 
// --- Step 4: Deliver Response
 
// Return Response to browser
deliver_response($_GET['format'], $response);

	    			/*$request = new RestRequest1('http://example.com/api/user/1', 'GET');
					$request->execute();

					echo '<pre>' . print_r($request, true) . '</pre>';*/

						/*$data = RestUtils::processRequest();
					switch($data->getMethod) {
							// this is a request for all users, not one in particular
							case 'get':
								$user_list = getUserList(); // assume this returns an array

								if($data->getHttpAccept == 'json')
								{
									RestUtils::sendResponse(200, json_encode($user_list), 'application/json');
								}
								else if ($data->getHttpAccept == 'xml')
								{
									// using the XML_SERIALIZER Pear Package
									$options = array
									(
										'indent' => '     ',
										'addDecl' => false,
										'rootName' => $fc->getAction(),
										XML_SERIALIZER_OPTION_RETURN_RESULT => true
									);
									$serializer = new XML_Serializer($options);

									RestUtils::sendResponse(200, $serializer->serialize($user_list), 'application/xml');
								}

								break;
							// new user create
							case 'post':
								$user = new User();
								$user->setFirstName($data->getData()->first_name);  // just for example, this should be done cleaner
								// and so on...
								$user->save();

								// just send the new ID as the body
								RestUtils::sendResponse(201, $user->getId());
								break;
						}*/?>

</div> 

<?php 

//GPIO draft 
//use PhpGpio\Gpio;
	/*$gpio = new GPIO(); 
	$gpio->setup(17, "out"); // Enable control for pin 17
	$gpioTurnon = $gpio->output(17, 1); //Turning on pin 17
	$gpioTurnoff = $gpio->output(17, 0); Turn off pin 17
	*/
 ?>
    

<?php require_once(ROOT_PATH.'/footer.php'); ?>
