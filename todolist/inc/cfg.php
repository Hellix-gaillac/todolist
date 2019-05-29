<?php
require_once '../framework-XL/DBMySQL.php';
const TITRE = "LOWA";
//Images
const TAB_MIME = ['image/jpeg'];
const IMG_V_LARGEUR = 300; //px
const IMG_V_HAUTEUR = 300; //px
const IMG_P_LARGEUR = 450; //px
const IMG_P_HAUTEUR = 450; //px
//css vignette cover, detail c'est du contain.
//reflechir a l'algo pour redimentionné (fonction copié()) , 
//calcul ratio h x l, attention au ratio entre zone d'arrivee et taille image, )
//si cible trop etroite ou trop large 

//constantes du PDO
const DB_NAME = 'commerce';
const LOG = 'root';
const MDP = '';
DBMySQL::setDSN(DB_NAME,LOG,MDP);
