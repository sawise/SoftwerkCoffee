
<?php
    require_once('../../config.php');

 //TESTING

            //require_once('json/json.php');
	//$app = new Phalcon\Mvc\Micro();

    /*$gpio = new GPIO(); 
    $gpio->setup(17, "out"); // Enable control for pin 17
    */


  
        if (isset($_GET['user']) && isset($_GET['pass']) && $_GET['user'] == USER && $_GET['pass'] == PASS){
                //$app->get('/', function ()  use ($app)  {
                    if(!isset($_GET['command'])){
                        echo "This is the webservice-page";
                    }
                //});

                //Direct output
                //$app->get('/turnOff', function () use ($app) {
                    
                    if(isset($_GET['command']) && $_GET['command'] == "turnOff"){
                        saveSession(0, 'php_session');  
                        echo "Turn off the Coffee machine";
                    }
                    //$gpioTurnoff = $gpio->output(17, 0); Turn off pin 17
                //});

                //$app->get('/saveSession/{percent}', function ($percent) use ($app) {
                     if(isset($_GET['command']) && isset($_GET['percent']) && $_GET['command'] == "saveSession"){
                        $percent = $_GET['percent'];
                        saveSession($percent, 'php_session');  
                        echo $percent;
                        //$gpioTurnoff = $gpio->output(17, 0); Turn off pin 17
                    }
                //});

                    //$app->get('/turnOn', function () use ($app) {
                    if(isset($_GET['command']) && $_GET['command'] == "turnOn"){
                        echo "Turn on the Coffee machine";
                        //$gpioTurnon = $gpio->output(17, 1); //Turning on pin 17
                    }
                //});

                //$app->get('/status', function () use ($app) {
                   if(isset($_GET['command']) && $_GET['command'] == "getSession"){
                    $progressSession = 0; 
                    if(file_exists(ROOT_PATH.'/tmp/php_session.txt')){
                        $progressSession = getSession('php_session'); 
                    }
                    echo $progressSession;
                    //$gpioTurnon = $gpio->output(17, 1); //Turning on pin 17
                }
                //});

                //$app->get('/getTime', function () use ($app) {
                    if(isset($_GET['command']) && $_GET['command'] == "getTime"){
                        $date = new DateTime();
                        $dateunix = $date->format("U");
                        echo $dateunix;
                    }
                //});

                /*$app->notFound(function () use ($app) {
                    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
                    echo 'This is crazy, but this page was not found!';
                });*/

                //echo phpinfo();

                //$app->handle();
        } else{
            echo 'wrong login...';
        }
    

?>


<?php 

//GPIO draft 
//use PhpGpio\Gpio;
	
 ?>