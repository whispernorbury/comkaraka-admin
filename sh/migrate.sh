#!bin/bash

### Configuration
old_username=$1
old_host=$2
old_pemkey=$3
new_username=$4
new_host=$5
new_pemkey=$6

tarName="vol_$(date +%Y-%m-%d_%H-%M-%S).tar.gz"

# Migrate
ssh -i $old_pemkey $old_username@$old_host "
sudo tar -zcvf $tarName -P /root/Docker/comkaraka;
scp -i $new_pemkey ~/$tarName $new_username@$new_host:~
"

# Install volumes
ssh -i $new_pemkey $new_username@$new_host "
sudo mkdir /root/Docker;
sudo tar -zxvf $tarName -C /root/Docker;
sudo chmod -R g+w /root/Docker/comkaraka;
"