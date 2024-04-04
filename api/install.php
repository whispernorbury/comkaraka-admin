<?php
  header("Content-Type: application/json");

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $username=$_POST["username"];
    $host=$_POST["host"];
    $pemkey=$_FILES["sshkey.pem"]["tmp_name"];
    $repo="https://github.com/whispernorbury/comkaraka-back.git";

    # Parse .env
    $envfile=$_FILES["envfile"]["tmp_name"];
    $envs=file_get_contents($envfile);
    $envals=parse_ini_file($envs);
    $MYSQL_ROOT_PASSWORD=$envals["MYSQL_ROOT_PASSWORD"];
    $ELASTIC_PASSWORD=$envals["ELASTIC_PASSWORD"];

    # install
    $scritp_path="installscript.sh";
    $handle = popen("sh $script_path $username $host $pemkey $repo $MYSQL_ROOT_PASSWORD $ELASTIC_PASSWORD 2>&1", "r");

    while (!feof($handle)) {
      $output=fgets($handle);

      flush();
      ob_flush();
    }
    pclose($handle);
  }
?>