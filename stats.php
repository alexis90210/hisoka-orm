<?php

require 'orm.php';

// utilisateurs 

$Utilisateurs = $DB
    ->table('Utilisateurs')
    ->select([])->execute()->fetchAssociative();

$Utilisateurs = count( $Utilisateurs );


// stats global

$stats = [
    "Utilisateurs" => $Utilisateurs
];

ds( $stats );
