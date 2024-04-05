<?php
  @ini_set('zlib.output_compression', 0);
  @ini_set('implicit_flush', 1);
  @ob_end_clean();
  ob_implicit_flush(true);

  header("Content-Type: application/json");

  if ($_SERVER["REQUEST_METHOD"]==="GET") {
    ob_start();
    $script_path="/var/task/user/sh/play.sh";
    $command="sh $script_path";
    $process = popen("$command 2>&1", "r");
    if ($process) {
      while (!feof($process)) {
        $output=fread($process, 8192);
        echo $output;
        flush();
        ob_flush();
      }
      $exitCode=pclose($process);
      echo "Exit: $exitCode";
    }
  }
?>