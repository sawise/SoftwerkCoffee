
<?php
    require_once('../../config.php');

 //TESTING
  
        if (isset($_GET['user']) && isset($_GET['pass']) && $_GET['user'] == USER && $_GET['pass'] == PASS){
            //$crontab = new Ssh2_crontab_manager('dev.softwerk.se', '2222', 'pi', 'raspberry');
            $crontab = new Ssh2_crontab_manager('localhost', '22', 'sam', 'Jonsson91');

                if(!isset($_GET['command'])){
                    echo "This is the webservice-page";
                }

                   if(isset($_GET['command']) && $_GET['command'] == "toggleautoswitch"){
                    $autoswitch = getSession('autoswitch'); 
                    echo $autoswitch.'<br>';
                    echo strlen($autoswitch);
                    if(strlen($autoswitch) <= 0){
                        $croncommand =  '0 18 * * * curl http://localhost/api/?user='.USER.'&pass='.PASS.'&command=turnOff';
                        $coffeepowderStatus = saveSession( $croncommand, 'autoswitch'); 
                        $crontab->append_cronjob($croncommand);
                        echo "Toggle autoswitch";
                    } else {
                        $crontab->remove_crontab();
                        saveSession('', 'autoswitch'); 
                        echo "Untoggle autoswitch";
                    }
                }

                if(isset($_GET['command']) && $_GET['command'] == "turnOff"){
                    saveSession(0, 'php_session');  
                    $crontab->exec("sudo python /home/pi/coffee-off.py");
                    echo "Turn off the Coffee machine";
                }

                 if(isset($_GET['command']) && isset($_GET['percent']) && $_GET['command'] == "saveSession"){
                    $percent = $_GET['percent'];
                    saveSession($percent, 'php_session');  
                    echo $percent;
                }

                if(isset($_GET['command']) && $_GET['command'] == "turnOn"){
                    echo "Turn on the Coffee machine";
                    $crontab->exec("sudo python /home/pi/coffee-on.py");
                }

                if(isset($_GET['command']) && $_GET['command'] == "getSession"){
                    $progressSession = 0; 
                    $progressSession = getSession('php_session'); 
                    echo $progressSession;
                }

                if(isset($_GET['command']) && $_GET['command'] == "getTime"){
                    $date = new DateTime();
                    $dateunix = $date->format("U");
                    echo $dateunix;
                }
                 if(isset($_GET['command']) && $_GET['command'] == "toggleCoffeepowder"){
                     $coffeepowderStatus = getSession('coffeepowderstatus'); 
                    if($coffeepowderStatus <= 0){
                        $coffeepowderStatus = saveSession( "1", 'coffeepowderstatus'); 
                        echo "Coffee is loaded";
                    } else {
                        saveSession('', 'coffeepowderstatus'); 
                    echo "Coffee is not loaded";
                    }
                }

        } else{
            echo 'wrong login...';
        }
    

?>
