<?php
  header("Content-Type: application/json");

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $username=$_POST["username"];
    $host=$_POST["host"];
    $repo="https://github.com/whispernorbury/comkaraka-back.git";
    $pemkey=file_get_contents($_FILES["pemkey"]["tmp_name"]);

    # Parse .env
    $envals=parse_ini_file($_FILES["envfile"]["tmp_name"]);
    $MYSQL_ROOT_PASSWORD=$envals["MYSQL_ROOT_PASSWORD"];
    $ELASTIC_PASSWORD=$envals["ELASTIC_PASSWORD"];

    # get files
    move_uploaded_file($_FILES["firebase_key"]["tmp_name"], "/tmp/firebase-key.json");
    move_uploaded_file($_FILES["envfile"]["tmp_name"], "/tmp/.env");
    
    $envfile="/tmp/.env";
    $firebase_key="/tmp/firebase-key.json";

    # install
    $script_path="/var/task/user/sh/install.sh";
    echo file_get_contents($script_path);

    // $command="sh $script_path $username $host $repo $pemkey $envfile $firebase_key $MYSQL_ROOT_PASSWORD $ELASTIC_PASSWORD";
    // $descriptors= [
    //   1 => ["pipe", "w"],
    //   2 => ["pipe", "w"],
    // ];
    // $process = proc_open($command, $descriptors, $pipes);
    // if (is_resource($process)) {
    //   stream_set_blocking($pipes[1], false);
    //   stream_set_blocking($pipes[2], false);
    //   while (($stdout = fgets($pipes[1])) || ($stderr = fgets($pipes[2]))) {
    //     if (!empty($stdout)) {
    //       echo $stdout;
    //       flush();
    //     }
    //     if (!empty($stderr)) {
    //       echo $stderr;
    //       flush();
    //     }
    //     usleep(100000);
    //   }
    //   fclose($pipes[1]);
    //   fclose($pipes[2]);
    //   $exitCode=proc_close($process);
    //   echo "Exit: $exitCode";
    // }
  }
?>