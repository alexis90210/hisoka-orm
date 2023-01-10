<?php

require 'vendor/autoload.php';

// Dependancies 

// use Hisoka\Orm\DB; 

// instance

$config = \Hisoka\Env\Data::getEnv('.env.prod'); // custom .env file ( ex : .env.test )

$orm = new Hisoka\Orm\DB();

$orm->setDefaultConfig( $config );

$orm->getConnexionInfo();

# case 1 :

$test = $orm
    ->table('test')
    ->select([])->execute()->fetchAssociative();


// case 2

$Interfaces_acheves = $orm
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
            ->generateSQL();
