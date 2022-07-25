#!/bin/bash

sudo apt update
sudo apt -y upgrade
sudo apt install postgresql postgresql-client -y


############# Config
sudo su - postgres
psql -c "alter user postgres with password 'evB9NsqR05pV_Olk61Ia'"

....
sudo vim /etc/postgresql/12/main/postgresql.conf
...
listen_addresses='*'

sudo systemctl status postgresql
sudo systemctl restart postgresql
sudo systemctl enable postgresql

CREATE ROLE admin WITH LOGIN SUPERUSER CREATEDB CREATEROLE PASSWORD 'Passw0rd';
create database devdb;
create user devuser with encrypted password 'TSeZ0hNIPpRHB6fyjibQ';
grant all privileges on database devdb to devuser;

#  Remote connection
sudo sed -i '/^local/s/peer/trust/' /etc/postgresql/12/main/pg_hba.conf
sudo sed -i '/^host/s/ident/md5/' /etc/postgresql/12/main/pg_hba.conf
sudo vim /etc/postgresql/12/main/pg_hba.conf
# TYPE  DATABASE        USER            ADDRESS                 METHOD
host    devdb             devuser             0.0.0.0/0            md5

