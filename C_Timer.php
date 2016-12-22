<?php

class C_Timer {
  private $microtime;

  public function C_Timer() {
    $this->microtime = microtime(true);
  }
  #############################
  public function reset() {
    $this->microtime = microtime(true);
  }
  #############################
  public function getElapsedTimeStr() {
    $elapsedMicrotime = microtime(true) - $this->microtime;
    return number_format($elapsedMicrotime, 3)." seconds.";
  }
  #############################
  public function getMemUsageStr() {
    $peakMemoryUsage = number_format(memory_get_peak_usage());
    $peakMemoryUsageReal = number_format(memory_get_peak_usage(true));
    return "$peakMemoryUsage ($peakMemoryUsageReal) bytes.";
  }
}

?>