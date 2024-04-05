<?php
  header("Content-Type: text/plain");
  ini_set("output_buffering", "off");
  ini_set('zlib.output_compression', false);
  while (@ob_end_flush());
  $string_legnth = 32768;
  ini_set('implicit_flush', true);
  ob_implicit_flush(true);
  
  if ($_SERVER["REQUEST_METHOD"]==="POST") {
    $username=$_POST["username"];
    $host=$_POST["host"];
    $repo="https://github.com/whispernorbury/comkaraka-back.git";

    # Parse .env
    $envals=parse_ini_file($_FILES["envfile"]["tmp_name"]);
    $MYSQL_ROOT_PASSWORD=$envals["MYSQL_ROOT_PASSWORD"];
    $ELASTIC_PASSWORD=$envals["ELASTIC_PASSWORD"];

    # get files
    move_uploaded_file($_FILES["pemkey"]["tmp_name"], "/tmp/sshkey.pem");
    move_uploaded_file($_FILES["firebase_key"]["tmp_name"], "/tmp/firebase-key.json");
    move_uploaded_file($_FILES["envfile"]["tmp_name"], "/tmp/.env");
    
    $envfile="/tmp/.env";
    $firebase_key="/tmp/firebase-key.json";
    $pemkey="/tmp/sshkey.pem";
    # install
    $script_path="../sh/install.sh";

    $command="sh $script_path $username $host $repo $pemkey $envfile $firebase_key $MYSQL_ROOT_PASSWORD $ELASTIC_PASSWORD";
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