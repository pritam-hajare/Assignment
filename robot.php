<?php
include_once('src/Timer.php');
# Namespace
use Assignment\Timer;

$options = getopt("null", ["action:","floor:","area:"]);
$error = false;
$error_message ='';
$action = 'clean';
$battery_remaining = 60;
if(!empty($options)){
    if(isset($options['action']) && ($options['action'] == 'clean' || $options['action'] == 'charge')){
        $action = strtolower($options['action']);
    }

    if(isset($options['floor']) && ($options['floor'] == 'carpet' || $options['floor'] == 'hard')){
        $floor = strtolower($options['floor']);
    }else{
        $error = true;
        $error_message = "Make sure floor value is correct\n";
    }

    if(isset($options['area']) && is_numeric($options['area'])){
        $area = (int)$options['area'];
    }else{
        $error = true;
        $error_message = $error_message."Make sure area value is correct and numeric only";

    }
}else{
    echo "This script expects parameters \n E.G. - ";
    echo '$robot.php --action=<clean> --floor=<carpet> --area=<70>';
    echo "\n\n";
    exit;
}

if($error){
    echo $error_message;
    exit;
}

if($floor == 'carpet'){
    $duration_to_clean = $area * 2;
}elseif ($floor == 'hard'){
    $duration_to_clean = $area;
}else{
    echo "Invalid Floor";
    exit;
}
$timer = new Timer();

if($action == 'charge'){
    $battery_remaining = 0;
    $timer->start('Battery Charging');
    echo "\n\nRobot Started Battery Charging\n\n";
    for($j=0; $j <= 30; $j++){
        $charging_done = $j*3.33;
        echo $timer->progress_bar($charging_done,100,"Charging");
        $battery_remaining = 60;
    }
    echo "\n\nBattery Charging finished\n\n";
    $timer->end();
    exit;
}else {
    $timer->start('Floor Cleaning');
    echo "Robot Started Floor Cleaning\n\n";
    for ($i = 0; $i <= $duration_to_clean; $i++) {
        if ($floor == 'carpet') {
            $cleaning_done = $i * 0.5;
            echo $timer->progress_bar($cleaning_done, $area, "Cleaning");
            if ($battery_remaining == 0 && ($cleaning_done * 2) < $duration_to_clean) {
                $timer->pause();
                $timer->lap('Battery Charging');
                echo "\n\nRobot Started Battery Charging\n\n";
                for ($j = 0; $j <= 30; $j++) {
                    $charging_done = $j * 3.33;
                    echo $timer->progress_bar($charging_done, 100, "Charging");
                    $battery_remaining = 60;
                }
                $timer->unpause();
                echo "\n\n Robot Resumed Floor Cleaning\n\n";
                $timer->lap('Floor Cleaning');
            }
        } else if ($floor == 'hard') {
            $cleaning_done = $i;
            echo $timer->progress_bar($cleaning_done, $area, "Cleaning");
            if ($battery_remaining == 0 && $cleaning_done < $duration_to_clean) {
                $timer->pause();
                $timer->lap('Battery Charging');
                echo "\n\nRobot Started Battery Charging\n\n";
                for ($j = 0; $j <= 30; $j++) {
                    $charging_done = $j * 3.33;
                    echo $timer->progress_bar($charging_done, 100, "Charging");
                    $battery_remaining = 60;
                }
                $timer->unpause();
                echo "\n\n Robot Resumed Floor Cleaning\n\n";
                $timer->lap('Floor Cleaning');
            }
        }
        $battery_remaining = $battery_remaining - 1;
    }
    $timer->end();
    echo "\n\nRobot Finished Floor Cleaning\n\n";
}