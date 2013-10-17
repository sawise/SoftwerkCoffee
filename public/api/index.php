
<?php
    require_once('../../config.php');

 //TESTING
  
        if (isset($_GET['user']) && isset($_GET['pass']) && $_GET['user'] == USER && $_GET['pass'] == PASS){
            $crontab = new Ssh2_crontab_manager('localhost', '22', 'sam', 'Jonsson91');

                if(!isset($_GET['command'])){
                    echo "This is the webservice-page";
                }

                   if(isset($_GET['command']) && $_GET['command'] == "toggleautoswitch"){
                    $crontab->append_cronjob('0 18 * * * curl http://localhost/api/?user='.USER.'&pass='.PASS.'&command=turnOff');  
                    echo "Toggle autoswitch";
                }
                  if(isset($_GET['command']) && $_GET['command'] == "untoggleautoswitch"){
                    $crontab->remove_crontab();
                    echo "Untoggle autoswitch";
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

        } else{
            echo 'wrong login...';
        }
    

?>
