<?php

require 'vendor/autoload.php';

// require ORM

use Hisoka\Orm\DB;

// instance

$DB =  new DB();

// utilisateurs

$Utilisateurs = $DB
    ->table('Utilisateurs')
    ->select([])->execute()->fetchAssociative();

$Utilisateurs = count( $Utilisateurs );


// stats global

$stats = [
    "Utilisateurs" => $Utilisateurs
];

var_dump( $stats );