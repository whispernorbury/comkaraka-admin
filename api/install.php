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
    $agora="~/";
    $output=shell_exec("ls");
    echo $output;
    // move_uploaded_file($_FILES["firebase_key"]["tmp_name"], $agora."firebase-key.json");
    // move_uploaded_file($_FILES["envfile"]["tmp_name"], $agora.".env");
    
    $envfile=$agora.".env";
    $firebase_key=$agora."firebase-key.json";

    # install
    // $scritp_path="installscript.sh";
    // $handle = popen("sh $script_path $username $host $repo $pemkey $envfile $firebase_key $MYSQL_ROOT_PASSWORD $ELASTIC_PASSWORD 2>&1", "r");

    // while (!feof($handle)) {
    //   $output=fgets($handle);

    //   flush();
    //   ob_flush();
    // }
    // pclose($handle);
  }
?>