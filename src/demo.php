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




// Jointures

$Interfaces_acheves = $DB
            ->table('Interfaces')
            ->select(["Interfaces.Progression" , "Projets.IDProjets"])
            ->where(        
                array(
                    [
                        "key" => "Projets.IDProjets",
                        "value" => 0,
                        "operator" => "="
                    ],
                    [
                        "key" => "Interfaces.Progression",
                        "value" => 4,
                        "operator" => ">"
                    ],
                )
            )
            ->joinWith("Projets", "IDProjets" , "IDProjets")
            ->joinWith("Utilisateurs", "IDUtilisateurs" , "IDUtilisateurs")
            ->generateSQL();
            // ->execute()->fetchAssociative();
