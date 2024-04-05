#!/bin/bash

# Configuration
username=$1
host=$2
repo=$3
pemkey=$4
envfile=$5
firebase_key=$6
MYSQL_ROOT_PASSWORD=$7
ELASTIC_PASSWORD=$8

# refresh ssh key
ssh -i $pemkey $username@$host exit

if [ $? -eq 0 ]; then

  # install Docker(compose)
  ssh -i $pemkey $username@$host "
  sudo apt-get update;
  curl -fsSL https://get.docker.com -o docker-install.sh;
  sudo sh docker-install.sh;
  "

  # clone repo and modify environmentals
  ssh -i $pemkey $username@$host "
  git clone $repo;
  sed -i 's/\${MYSQL_ROOT_PASSWORD}/$MYSQL_ROOT_PASSWORD/g' comkaraka-back/elk/logstash/config/*.conf;
  sed -i 's/\${ELASTIC_PASSWORD}/$ELASTIC_PASSWORD/g' comkaraka-back/elk/logstash/config/*.conf;
  "

  # copy private files
  scp -i $pemkey $envfile $firebase_key $username@$host:~/comkaraka-back

  # permission setting
  ssh -i $pemkey $username@$host "
  sudo docker compose up --build -d;
  sudo docker compose down;
  sudo chmod -R g+w /root/Docker/comkaraka;
  "
  echo "####### Installation Complete #######"

else
  echo "Cannot connect server. Check SSH Connection."  

fi