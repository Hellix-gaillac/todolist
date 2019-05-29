<?php

interface ORM
{
    function charger();

    function sauver();

    function supprimer();

    static function tab($where = 1, $orderBy = 1, $limit = null);
}