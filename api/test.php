<?php
  header("Content-Type: text/plain");
  header("Cache-Control: no-cache");
  
  ini_set("output_buffering", "off");
  ini_set('zlib.output_compression', false);
  while (@ob_end_flush());
  $string_legnth = 32768;
  ini_set('implicit_flush', true);
  ob_implicit_flush(true);
  
  $script_path="/var/task/user/sh/test.sh";
  $command="sh $script_path";

  ob_start();

  $process = popen("$command 2>&1", "r");
  if ($process) {
    while (!feof($process)) {
      $output=fread($process, 8192);
      $string = str_pad("", $string_legnth);
      echo $string;
      echo $output;
      ob_flush();
      flush();
    }
    $exitCode=pclose($process);
    echo "Exit: $exitCode";
  }
  ob_end_flush();
?>