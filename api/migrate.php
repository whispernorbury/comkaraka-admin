<?php
  header("Content-Type: application/json");

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $new_username=$_POST["new_username"];
    $new_host=$_POST["new_host"];
    $new_pemkey=file_get_contents($_FILES["new_pemkey"]["tmp_name"]);

    $old_username=$_POST["old_username"];
    $old_host=$_POST["old_host"];
    $old_pemkey=file_get_contents($_FILES["old_pemkey"]["tmp_name"]);

    # install
    $script_path="/var/task/user/sh/migrate.sh";
    $command="sh $script_path $new_username $new_host $new_pemkey $old_username $old_host $old_pemkey";
  }
?>