<!-- INIT DB -->
require 'vendor/autoload.php';

// require ORM

use Hisoka\Orm\DB;

// instance

$DB =  new DB();

========================================
# DELETE
========================================

 $query = $DB->table('Utilisateurs')
 ->delete()
 ->where(["Identifiant" =>  'login']) 
 ->execute();
 ->status();
 
========================================
# SELECT ALL
========================================
  
 $query = $DB->table('Utilisateurs')
 ->select([]) 
 ->where(["Identifiant" =>  'login']) 
 ->limit( 1 )
 ->execute();
 ->fetchAssociative();
 
========================================
# SELECT BY
========================================
  
 $query = $DB->table('Utilisateurs')
  ->select(["id", "nom" , ...]) 
  ->execute();
  ->fetchObject();
  
========================================
# UPDATE
========================================

 $query = $DB->table('Utilisateurs')
 ->update()
 ->where(["Identifiant" =>  'login']) 
 ->execute();
 ->status();
 
 
========================================
# INSERT
========================================

 $query = $DB->table('Utilisateurs')
 ->insert(["nom" =>  'alexis'])
 ->execute();
 ->status(); 
 
 
========================================
# JOINTURE 
========================================

 joinWith( string $tableA , string $jointureA, string $tableB, string $jointureB,   string $type = "" )
 @ tableA => tableA to join
 @ jointureA => jointure in table A
 @ tableB => tableB to join
 @ jointureB => jointure in table B
 @ type => can be INNER , LEFT , RIGHT ... default is a simple JOIN
 ---------------------------------------------------------------------------
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
 ->joinWith("Projets", "IDProjets" ,"Interfaces", "IDInterfaces")
 ->generateSQL();
 // ->execute()->fetchAssociative();
            
========================================
# EXTRAS
========================================

# to see error PDOException

$DB->debug();

# to see SQL REQUEST PDOException

$DB->generateSQL();

# to see STATUT OF THE REQUEST

$DB->status();











 
 
