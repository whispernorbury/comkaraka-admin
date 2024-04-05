<?php
  ini_set('output_buffering', 'off');
  ini_set('zlib.output_compression', false);
  header("Content-Type: application/json");

  if ($_SERVER["REQUEST_METHOD"]==="GET") {
    $script_path="/var/task/user/sh/play.sh";
    $command="sh $script_path";
    $process = popen("$command 2>&1", "r");
    if ($process) {
      while (!feof($process)) {
        $output=fread($process, 8192);
        echo $output;
        flush();
      }
      $exitCode=pclose($process);
      echo "Exit: $exitCode";
    }
  }
?>