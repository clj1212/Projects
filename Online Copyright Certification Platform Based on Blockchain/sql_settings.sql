create user 'prp'@'localhost' identified by '123';
create database if not exists prp DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
use prp; 
create table register(
user varchar(20) not null,
mailadd varchar(30),
pass varchar(16),
q1 varchar(30),
q2 varchar(30),
q3 varchar(30),
q4 varchar(30),
q5 varchar(30),
status int(1),
primary key (user))
;

create table certification(
user varchar(20) not null,
picname varchar(20),
date datetime,
filepath varchar(200),
description varchar(20000),
filesize varchar(10),
filetype varchar(20),
pichash char(64),
status int(1),
s1 int(1),
s2 int(1),
s3 int(1),
s4 int(1),
s5 int(1))

use prp;
create table tradable(
user varchar(20) not null,
picname varchar(20),
proname varchar(40),
pichash char(64),
price float(20),
certdate datetime,
tradabledate datetime,
filepath varchar(200),
clause varchar(20000),
s1 int(1),
s2 int(1),
s3 int(1),
s4 int(1),
s5 int(1))