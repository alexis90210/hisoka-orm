<!-- INIT DB -->
$DB =  new \Hisoka\Orm\DB();
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
# EXTRAS
========================================

# to see error PDOException

$DB->debug();

# to see SQL REQUEST PDOException

$DB->generateSQL();

# to see STATUT OF THE REQUEST

$DB->status();











 
 
