<?php
/**
 * Assignment
 * @author   Pritam Hajare <pritam.hajare@gmail.com>
 */

namespace Assignment;

class Timer {
    /**
     * Handle the running state of the timer
     */
    const RUNNING = 1;
    const PAUSED = 0;
    const STOPPED = -1;

    /**
     * Maintains the state of the timer (RUNNING, PAUSED, STOPPED)
     */
    public $state = self::STOPPED;

    /**
     * Time that $this->start() was called
     */
    public $startTime = 0;

    /**
     * Time that $this->end() was called
     */
    public $endTime = 0;

    /**
     * Total time spent in pause
     */
    public $totalPauseTime = 0;

    /**
     * Time spent in pause
     */
    public $pauseTime = 0;

    /**
     * All laps
     */
    public $laps = array();

    /**
     * Total lap count, inclusive of the current lap
     */
    public $lapCount = 0;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->reset();
    }

    /**
     * Resets the timers, laps and summary
     */
    public function reset() {
        $this->startTime = 0;
        $this->endTime   = 0;
        $this->pauseTime = 0;
        $this->laps      = [];
        $this->lapCount  = 0;
    }

    /**
     * Starts the timer
     * @param string $name
     */
    public function start( $name = "start" ) {
        $this->state = self::RUNNING;

        # Set the start time
        $this->startTime = $this->getCurrentTime();

        # Create a lap with this start time
        $this->lap( $name );
    }

    /**
     * Ends the timer
     */
    public function end() {
        $this->state = self::STOPPED;

        # Set the end time
        $this->endTime = $this->getCurrentTime();

        # end the last lap
        $this->endLap();
    }

    /**
     * Creates a new lap in lap array property
     * @param null $name
     */
    public function lap( $name = null ) {
        $this->endLap(); # end the last lap

        # Create new lap
        $this->laps[] = array(
            "name"  => ( $name ? $name : $this->lapCount ),
            "start" => $this->getCurrentTime(),
            "end"   => -1,
            "total" => -1,
        );

        $this->lapCount += 1;
    }

    /**
     * Assign end and total times to the previous lap
     */
    public function endLap() {
        $lapCount = count($this->laps ) - 1;
        if ( count( $this->laps ) > 0 ) {
            $this->laps[$lapCount]['end']   = $this->getCurrentTime();
            $this->laps[$lapCount]['total'] = $this->laps[$lapCount]['end'] - $this->laps[$lapCount]['start'];
        }
    }

    /**
     * Returns a summary of all timer activity so far
     * @return array
     */
    public function summary() {
        return array(
            'running' => $this->state,
            'start'   => $this->startTime,
            'end'     => $this->endTime,
            'total'   => $this->endTime - $this->startTime,
            'paused'  => $this->totalPauseTime,
            'laps'    => $this->laps
        );
    }

    /**
     * Initiates a pause in the timer
     */
    public function pause() {
        $this->state = self::PAUSED;
        $this->pauseTime = $this->getCurrentTime();
    }

    /**
     * Cancels the pause previously set
     */
    public function unpause() {
        $this->state = self::RUNNING;
        $this->totalPauseTime += $this->getCurrentTime() - $this->pauseTime;
        $this->pauseTime      = 0;
    }

    /**
     * Returns the current time
     * @return float
     */
    public function getCurrentTime() {
        return microtime( true );
    }

    /**
     * To Print Progress Bar on command line
     * @param $done
     * @param $total
     * @param string $info
     * @param int $width
     * @return string
     */
    public function progress_bar($done, $total, $info="", $width=50) {
        sleep(1);
        $perc = round(($done * 100) / $total);
        $bar = round(($width * $perc) / 100);
        //echo "Per = ".$perc."-- Bar".$bar;
        return sprintf("%s%%[%s>%s]%s\r", $perc, str_repeat("=", $bar), str_repeat(" ", $width-$bar), $info);
    }
}


