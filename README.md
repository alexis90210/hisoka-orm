# 📘 Hisoka ORM – Guide d’utilisation

Ce projet utilise l’ORM `Hisoka\Orm\DB` pour simplifier les interactions avec une base de données en PHP. Ce guide présente les principales opérations prises en charge par la bibliothèque, y compris les opérations CRUD, les jointures, et les outils de débogage.

📦 Dépendances

Ce projet repose sur :
- Composer pour l’autoload
- Le namespace: Hisoka\Orm\DB

🔧 Initialisation

require 'vendor/autoload.php';

use Hisoka\Orm\DB;
$DB = new DB();

🗑️ Suppression
Supprimer un utilisateur par identifiant :

$query = $DB->table('Utilisateurs')
    ->delete()
    ->where(["Identifiant" => 'login'])
    ->execute()
    ->status();

📥 Sélection (SELECT)
- Sélection de tous les enregistrements avec filtre :

$query = $DB->table('Utilisateurs')
    ->select([])
    ->where(["Identifiant" => 'login'])
    ->limit(1)
    ->execute()
    ->fetchAssociative();

- Sélection ciblée par colonnes :
  
$query = $DB->table('Utilisateurs')
    ->select(["id", "nom", /* autres colonnes */])
    ->execute()
    ->fetchObject();

✏️ Mise à jour (UPDATE)
- Mettre à jour les données d’un utilisateur :

$query = $DB->table('Utilisateurs')
    ->update()
    ->where(["Identifiant" => 'login'])
    ->execute()
    ->status();

➕ Insertion (INSERT)
- Insérer un nouvel utilisateur :

  $query = $DB->table('Utilisateurs')
    ->insert(["nom" => 'alexis'])
    ->execute()
    ->status();

🔗 Jointures (JOIN)
- Effectuer une jointure entre deux tables :

->joinWith(string $tableA, string $jointureA, string $tableB, string $jointureB, string $type = "")

joinWith(string $tableA, string $jointureA, string $tableB, string $jointureB, string $type = "")

- [tableA] : Première table
  [jointureA] : Clé de jointure dans la table A

- [tableB] : Deuxième table
  [jointureB] : Clé de jointure dans la table B

- [type] : Type de jointure (INNER, LEFT, RIGHT, etc.). Par défaut, une jointure simple.

Exemple :

$Interfaces_acheves = $DB
    ->table('Interfaces')
    ->select(["Interfaces.Progression", "Projets.IDProjets"])
    ->where([
        ["key" => "Projets.IDProjets", "value" => 0, "operator" => "="],
        ["key" => "Interfaces.Progression", "value" => 4, "operator" => ">"]
    ])
    ->joinWith("Projets", "IDProjets", "Interfaces", "IDInterfaces")
    ->generateSQL();
// ->execute()->fetchAssociative();


🧪 Utilitaires
- Activer le mode debug pour les erreurs PDO :
  $DB->debug();

- Visualiser la requête SQL générée :
  $DB->generateSQL();

- Obtenir le statut d’une requête :
  $DB->status();




