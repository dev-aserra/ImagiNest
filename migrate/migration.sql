create database if not exists IMAGINEST;
use IMAGINEST;

create table if not exists users (
    iduser int not null auto_increment,
    mail varchar(40) not null,
    username varchar(16) not null,
    passHash varchar(60) not null,
    userFirstName varchar(60),
    userLastName varchar(120),
    creationDate datetime default current_timestamp,
    lastSignIn datetime,
    removeDate datetime,
    active tinyint default 0,
    activationDate datetime,
    activationCode varchar(64),
    resetPass tinyint default 0,
 	resetPassExpiry datetime,
    resetPassCode varchar(64),
    primary key(iduser)
) engine = InnoDB;

create table if not exists fotografia (
    nom char(64) primary key,
    descripcio varchar(200),
    data datetime,
    url varchar(100),
    likes int default 0,
    dislikes int default 0,
    puntuacio decimal(3,2),
    usuariId int,
    constraint fk_fotografia_users foreign key (usuariId) references users(iduser)
) engine = InnoDB;

create table if not exists hashtags (
    nom varchar(30) primary key
) engine = InnoDB;

create table if not exists FotografiaHashtags (
    fotografiaNom char(64),
    hashtagNom varchar(30),
    primary key(fotografiaNom, hashtagNom),
    constraint fk_fotografiaHashtags_fotografia foreign key (fotografiaNom) references fotografia(nom),
    constraint fk_fotografiaHashtags_hashtags foreign key (hashtagNom) references hashtags(nom)
) engine = InnoDB;