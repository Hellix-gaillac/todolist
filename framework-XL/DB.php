<?php
interface DB
{
    function esc($exp);

    function xeq($req);

    function nb();

    function tab($class='stdClass');

    function prem($class='stdClass');

    function ins($obj);

    function pk();

    function start();

    function savepoint($label);

    function rollback($label=null);

    function commit();
}

