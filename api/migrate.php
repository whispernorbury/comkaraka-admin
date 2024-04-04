<?php
  $new_username=$_POST["new_username"];
  $new_host=$_POST["new_host"];
  $new_pemkey=$_POST["new_pemkey"];

  $old_username=$_POST["old_username"];
  $old_host=$_POST["old_host"];
  $old_pemkey=$_POST["old_pemkey"];

  # install
  $scritp_path="./migratescript.sh";
  $handle = popen("sh $script_path $new_username $new_host $new_pemkey $old_username $old_host $old_pemkey 2>&1", "r");

  while (!feof($handle)) {
    $output=fgets($handle);

    flush();
    ob_flush();
  }
  pclose($handle);
?>