<?php
  header("Content-Type: text/plain");
  ini_set("output_buffering", "off");
  ini_set('zlib.output_compression', false);
  while (@ob_end_flush());
  $string_legnth = 32768;
  ini_set('implicit_flush', true);
  ob_implicit_flush(true);

  if ($_SERVER["REQUEST_METHOD"]==="POST") {
    $new_username=$_POST["new_username"];
    $new_host=$_POST["new_host"];
    move_uploaded_file($_FILES["new_pemkey"]["tmp_name"], "/tmp/new_sshkey.pem");
    $new_pemkey="/tmp/new_sshkey.pem";

    $old_username=$_POST["old_username"];
    $old_host=$_POST["old_host"];
    move_uploaded_file($_FILES["old_pemkey"]["tmp_name"], "/tmp/old_sshkey.pem");
    $old_pemkey="/tmp/old_sshkey.pem";

    # install
    $script_path="/var/task/user/sh/migrate.sh";
    $command="sh $script_path $new_username $new_host $new_pemkey $old_username $old_host $old_pemkey";

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
      echo "##### Script Complete. Exit: $exitCode #####";
    }
    ob_end_flush();
  }
?>