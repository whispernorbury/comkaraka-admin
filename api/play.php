<?php
  header("Content-Type: application/json");

  if ($_SERVER["REQUEST_METHOD"]=="GET") {
    $script_path="/var/task/user/sh/play.sh";
    $command="sh $script_path";
    $descriptors= [
      1 => ["pipe", "w"],
      2 => ["pipe", "w"],
    ];
    $process = proc_open($command, $descriptors, $pipes);
    if (is_resource($process)) {
      stream_set_blocking($pipes[1], false);
      stream_set_blocking($pipes[2], false);
      while (($stdout = fgets($pipes[1])) || ($stderr = fgets($pipes[2]))) {
        if (!empty($stdout)) {
          echo $stdout;
          flush();
        }
        if (!empty($stderr)) {
          echo $stderr;
          flush();
        }
        usleep(100000);
      }
      fclose($pipes[1]);
      fclose($pipes[2]);
      $exitCode=proc_close($process);
      echo "Exit: $exitCode";
    }
  }
?>