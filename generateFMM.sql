/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  24/01/2020 13:24:43                      */
/*==============================================================*/


drop table if exists AVOIR;

drop table if exists T_AFFINITE;

drop table if exists T_LIKE;

drop table if exists T_MESSAGE;

drop table if exists T_NOTIFICATION;

drop table if exists T_PERMISSION;

drop table if exists T_PHOTOS;

drop table if exists T_SIGNALEMENT;

drop table if exists T_UTILISATEUR;

/*==============================================================*/
/* Table : AVOIR                                                */
/*==============================================================*/
create table AVOIR
(
   ID_AFFINITE          int not null,
   ID_UTILISATEUR       int not null,
   primary key (ID_AFFINITE, ID_UTILISATEUR)
);

/*==============================================================*/
/* Table : T_AFFINITE                                           */
/*==============================================================*/
create table T_AFFINITE
(
   ID_AFFINITE          int not null auto_increment,
   AFF_AFFINITE         varchar(100),
   primary key (ID_AFFINITE)
);

/*==============================================================*/
/* Table : T_LIKE                                               */
/*==============================================================*/
create table T_LIKE
(
   ID_LIKE              char(10) not null,
   ID_UTILISATEUR       int not null,
   primary key (ID_LIKE)
);

/*==============================================================*/
/* Table : T_MESSAGE                                            */
/*==============================================================*/
create table T_MESSAGE
(
   ID_MESSAGE           int not null auto_increment,
   ID_NOTIFICATION      int not null,
   ID_UTILISATEUR       int not null,
   MES_DATE             date,
   MES_CONTENU          longtext,
   primary key (ID_MESSAGE)
);

/*==============================================================*/
/* Table : T_NOTIFICATION                                       */
/*==============================================================*/
create table T_NOTIFICATION
(
   ID_NOTIFICATION      int not null auto_increment,
   ID_UTILISATEUR       int not null,
   NOT_DATE             date,
   NOT_TITRE            varchar(40),
   NOT_CONTENU          longtext,
   primary key (ID_NOTIFICATION)
);

/*==============================================================*/
/* Table : T_PERMISSION                                         */
/*==============================================================*/
create table T_PERMISSION
(
   ID_PERMISSION        int not null auto_increment,
   ID_UTILISATEUR       int not null,
   primary key (ID_PERMISSION)
);

/*==============================================================*/
/* Table : T_PHOTOS                                             */
/*==============================================================*/
create table T_PHOTOS
(
   ID_PHOTOS            int not null auto_increment,
   ID_UTILISATEUR       int not null,
   PHO_IMG_LIEN         varchar(100),
   PHO_IMG_NOM          varchar(40),
   primary key (ID_PHOTOS)
);

/*==============================================================*/
/* Table : T_SIGNALEMENT                                        */
/*==============================================================*/
create table T_SIGNALEMENT
(
   ID_SIGNALEMENT       int not null auto_increment,
   ID_UTILISATEUR       int not null,
   SIG_CONTENU          longtext not null,
   SIG_DATE             date not null,
   SIG_TYPE             varchar(40),
   primary key (ID_SIGNALEMENT)
);

/*==============================================================*/
/* Table : T_UTILISATEUR                                        */
/*==============================================================*/
create table T_UTILISATEUR
(
   ID_UTILISATEUR       int not null auto_increment,
   UTI_NOM              varchar(40) not null,
   UTI_PRENOM           varchar(40) not null,
   UTI_DATE_INSCRIPTION date,
   UTI_EMAIL            varchar(255) not null,
   UTI_TITRE            varchar(100) not null,
   UTI_DESCRIPTION      longtext not null,
   UTI_SEXE             varchar(40) not null,
   UTI_VILLE            varchar(40) not null,
   UTI_TEL              varchar(40) not null,
   UTI_MDP              varchar(40) not null,
   UTI_CAMPUS           varchar(40),
   UTI_SITUATION        varchar(40) not null,
   UTI_AGE              int not null,
   UTI_ATTIRANCE        varchar(40),
   UTI_IMAGE_NOM        varchar(40),
   UTI_IMAGE_LIEN       longtext,
   UTI_POS_LAT          decimal,
   UTI_POS_LONG         decimal,
   primary key (ID_UTILISATEUR)
);

alter table AVOIR add constraint FK_AVOIR foreign key (ID_AFFINITE)
      references T_AFFINITE (ID_AFFINITE) on delete restrict on update restrict;

alter table AVOIR add constraint FK_AVOIR2 foreign key (ID_UTILISATEUR)
      references T_UTILISATEUR (ID_UTILISATEUR) on delete restrict on update restrict;

alter table T_LIKE add constraint FK_AIMER foreign key (ID_UTILISATEUR)
      references T_UTILISATEUR (ID_UTILISATEUR) on delete restrict on update restrict;

alter table T_MESSAGE add constraint FK_EMETTRE foreign key (ID_NOTIFICATION)
      references T_NOTIFICATION (ID_NOTIFICATION) on delete restrict on update restrict;

alter table T_MESSAGE add constraint FK_ENVOYER foreign key (ID_UTILISATEUR)
      references T_UTILISATEUR (ID_UTILISATEUR) on delete restrict on update restrict;

alter table T_NOTIFICATION add constraint FK_RECEVOIR foreign key (ID_UTILISATEUR)
      references T_UTILISATEUR (ID_UTILISATEUR) on delete restrict on update restrict;

alter table T_PERMISSION add constraint FK_DONNER foreign key (ID_UTILISATEUR)
      references T_UTILISATEUR (ID_UTILISATEUR) on delete restrict on update restrict;

alter table T_PHOTOS add constraint FK_CONTENIR foreign key (ID_UTILISATEUR)
      references T_UTILISATEUR (ID_UTILISATEUR) on delete restrict on update restrict;

alter table T_SIGNALEMENT add constraint FK_SIGNALER foreign key (ID_UTILISATEUR)
      references T_UTILISATEUR (ID_UTILISATEUR) on delete restrict on update restrict;

