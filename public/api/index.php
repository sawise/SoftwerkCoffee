
<?php
    require_once('../../config.php');

 //TESTING

            //require_once('json/json.php');
	$app = new Phalcon\Mvc\Micro();

    /*$gpio = new GPIO(); 
    $gpio->setup(17, "out"); // Enable control for pin 17
    */


$app->get('/', function ()  use ($app)  {
    echo "This is the webservice-page";
});

//Direct output
$app->get('/turnOff', function () use ($app) {
    if(file_exists(ROOT_PATH.'/tmp/php_session1.txt') && file_exists(ROOT_PATH.'/tmp/php_session.txt')){
        saveSession(0, 'php_session');  
        saveSession(0, 'php_session1'); 
    }
    echo "Turn off the Coffee machine";
    //$gpioTurnoff = $gpio->output(17, 0); Turn off pin 17
});

$app->get('/saveSession/{percent}', function ($percent) use ($app) {
    if(file_exists(ROOT_PATH.'/tmp/php_session1.txt') && file_exists(ROOT_PATH.'/tmp/php_session.txt')){
        saveSession($percent, 'php_session');  
        saveSession($percent, 'php_session1'); 
    }
    echo "Turn off the Coffee machine";
    //$gpioTurnoff = $gpio->output(17, 0); Turn off pin 17
});

//Direct output
$app->get('/turnOn', function () use ($app) {
    echo "Turn on the Coffee machine";
    //$gpioTurnon = $gpio->output(17, 1); //Turning on pin 17
});

$app->get('/status', function () use ($app) {
    $progressSession = 0; 
    if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
        $progressSession = getSession('php_session'); 
    }
    echo $progressSession;
    //$gpioTurnon = $gpio->output(17, 1); //Turning on pin 17
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
	
 ?>