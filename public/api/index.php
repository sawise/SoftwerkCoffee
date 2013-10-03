<?php //TESTING

            //require_once('json/json.php');
	$app = new Phalcon\Mvc\Micro();


$app->get('/', function ()  use ($app)  {
    echo "Welcome Friendo..";
});

//Direct output
$app->get('/turnOff', function () use ($app) {
    echo "Turn off the Coffee machine";
});

//Direct output
$app->get('/turnOn', function () use ($app) {
    echo "Turn on the Coffee machine";
});

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'This is crazy, but this page was not found!';
});

//echo phpinfo();

$app->handle();

?>


<?php 

//GPIO draft 
//use PhpGpio\Gpio;
	/*$gpio = new GPIO(); 
	$gpio->setup(17, "out"); // Enable control for pin 17
	$gpioTurnon = $gpio->output(17, 1); //Turning on pin 17
	$gpioTurnoff = $gpio->output(17, 0); Turn off pin 17
	*/
 ?>