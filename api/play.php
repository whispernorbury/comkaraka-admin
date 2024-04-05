<?php
  header("Content-Type: application/json");

  if ($_SERVER["REQUEST_METHOD"]==="GET") {
    $script_path="/var/task/user/sh/play.sh";
    $command="sh $script_path";
    $descriptors= [
    ];
    $process = proc_open($command, array(
      0 => ["pipe", "r"],
      1 => ["pipe", "w"],
      2 => ["pipe", "w"]
    ), $pipes);
    if (is_resource($process)) {
      while (($stdout = fgets($pipes[1])) || ($stderr = fgets($pipes[2]))) {
        if (!empty($stdout)) {
          echo $stdout;
          flush();
        }
        if (!empty($stderr)) {
          echo $stderr;
          flush();
        }
      }
      $exitCode=proc_close($process);
      echo "Exit: $exitCode";
    }
  }
?>