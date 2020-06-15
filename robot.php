<?php
include_once('src/Timer.php');
# Namespace
use Assignment\Timer;

$timer = new Timer();

$timer->start('Cleaning');
sleep(5);
$timer->lap('Charging');
$timer->end();

//echo "Data -> $data";

var_dump($timer->summary());