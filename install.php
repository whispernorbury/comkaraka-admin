<?php
  $username=$_POST["username"];
  $host=$_POST["host"];
  $pemkey=$_POST["sshkey.pem"];
  $repo="https://github.com/whispernorbury/comkaraka-back.git";

  # Parse .env
  $envfile=$_POST["envfile"];
  $envals=parse_ini_file($envfile);
  $MYSQL_ROOT_PASSWORD=$envals["MYSQL_ROOT_PASSWORD"];
  $ELASTIC_PASSWORD=$envals["ELASTIC_PASSWORD"];

  # install
  $scritp_path="./install.sh";
  $handle = popen("sh $script_path 
    $username $host $pemkey $repo
    $MYSQL_ROOT_PASSWORD $ELASTIC_PASSWORD
    2>&1", "r");

  while (!feof($handle)) {
    $output=fgets($handle);

    flush();
    ob_flush();
  }
  pclose($handle);
?>