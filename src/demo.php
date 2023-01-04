<?php

require 'vendor/autoload.php';

// utilisateurs 

$DB =  new \Hisoka\Orm\DB();


$Utilisateurs = $DB
    ->table('Utilisateurs')
    ->select([])->execute()->fetchAssociative();

$Utilisateurs = count( $Utilisateurs );


// stats global

$stats = [
    "Utilisateurs" => $Utilisateurs
];

var_dump( $stats );