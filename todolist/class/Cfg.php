<?php
Cfg::init();
class Cfg
{
    private static $intDone = false;
    //Appli
    const APP_TITRE = "Todolist";
    //Images
    const IMG_TAB_MIME = ['image/jpeg'];
    const IMG_V_LARGEUR = 150; //px
    const IMG_V_HAUTEUR = 150; //px
    const IMG_P_LARGEUR = 250; //px
    const IMG_P_HAUTEUR = 250; //px    
    //constantes du PDO
    const DB_NAME = 'todolist';
    const DB_LOG = 'root';
    const DB_MDP = '';
    //Session
    const SESSION_TIMEOUT = 600; //seconde

    private function __construct()
    { }

    public static function init()
    {
        if (self::$intDone) {
            return false;
        }
        //autoload
        spl_autoload_register(function ($class) {
            // qd php recherche une class , sans require_once il va chercher un spl_autoload
            // symbole(oppérateur) pour supprimer les erreurs: @,
            @include "class/{$class}.php";
            @include "../framework-XL/{$class}.php";
        });

        //DSN DB
        DBMySQL::setDSN(self::DB_NAME, self::DB_LOG, self::DB_MDP);

        //Session
        //Session::getInstance(self::SESSION_TIMEOUT); // met en route la session

        //initdone
        return self::$intDone = true;
    }
}