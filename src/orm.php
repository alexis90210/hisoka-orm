<?php

/**
 * custom ORM ( Object Relationnal Mapping )
 * Build and propulsed by @Hisoka 
 * Find on github <@alexis90210>
 */

namespace Hisoka\Orm;

use \PDO;
use \PDOException;
use stdClass;

class DB
{
    public PDO $db;
    protected $host;
    protected $dbname;
    protected $username;
    protected $password;
    protected $port;
    protected $table = "";
    protected $query = "";
    protected $prepare;
    protected $limit = 0;
    protected $status = false;
    protected $error = array();
    protected $whereStatement = "";
    protected $joinStatement = "";
    protected string $environnement = '.env';

    /**
     * INSTANCE CONFIGURATION  
    */

    public function getConnexionInfo() {
        echo json_encode([

            "host" => $this->host,
            "dbname" => $this->dbname,
            "username" => $this->username,
            "password" => $this->password,
            "port" => $this->port

        ]);
    }

    public function setDefaultConfig( stdClass $env = new stdClass() ) : self {


        if ( empty( $env->HOST ) || empty( $env->DBNAME ) || empty( $env->USERNAME ) || empty( $env->PASSWORD ) || empty( $env->PORT )  ) {
            
            $env = \Hisoka\Env\Data::getEnv("{$this->environnement}");

        }

        try {
            
            $this->host     =  $env->HOST;
            $this->dbname   =  $env->DBNAME;
            $this->username =  $env->USERNAME;
            $this->password =  $env->PASSWORD;
            $this->port     =  $env->PORT;

            $this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8;port='.$env->PORT, $this->username, $this->password, [
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
            ]);
                
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this;

        } catch (\Throwable $th) {
            echo json_encode( $th );
           die();
        }

    }

    /**
     * TABLE REQUEST
     */

    public function table(string $table): self
    {
        $this->table = $table;
        $this->whereStatement = "";
        $this->joinStatement = "";

        return $this;
    }

    /**
     * INSERT REQUEST
     */

    public function insert(array $data): self
    {
        $query = "INSERT INTO $this->table SET ";

        foreach ($data as $key => $item) :

            $query .= " $key = '$item' ,";

        endforeach;

        $this->query = substr($query, 0, -1);

        return $this;
    }

    /**
     * UPDATE REQUEST
     */

    public function update(array $data): self
    {
        $query = "UPDATE $this->table SET ";

        foreach ($data as $key => $item) :

            $query .= " $key = '$item' ,";

        endforeach;

        $query = substr($query, 0, -1);

        $this->query = $query;

        return $this;
    }

    /**
     * SELECT REQUEST
     */

    public function select(array  $data): self
    {
        $query = "";

        if (is_array($data)) {

            if (count($data) == 0) {

                $query = "SELECT * FROM  $this->table ";
            } else {

                $query = "SELECT ";

                foreach ($data as $key => $item) :

                    $query .= " $item ,";

                endforeach;

                $query = substr($query, 0, -1); // remove <,>

                $query .= " FROM  $this->table ";
            }

            $this->query = $query;
        }

        return $this;
    }

    /**
     * DELETE REQUEST
     */

    public function delete(): self
    {
        $query = "DELETE FROM $this->table ";

        $this->query = $query;

        return $this;
    }

    /**
     *  LINIT STATEMEMENT
     */

    public function limit(int $limit = 1): self
    {

        $this->limit = $limit;

        if ($this->limit != 0)  $this->query .= " LIMIT " . $this->limit;

        return $this;
    }


    /**
     *  WHERE STATEMEMENT
     */
    public function where(array | int $data, string $operator = "="): self
    {
        $query = "";

        if (is_int($data)) {

            $query = " WHERE 1 ";
        } else if (is_array($data)) {

            $query = " WHERE ";

            if (count($data) > 0 && isset($data[0]) && is_array($data[0])) {

                foreach ($data as $key => $item) :

                    if (!empty($item['key']) && !empty($item['value']) && !empty($item['operator'])) $query .= " " . $item['key'] . $item['operator'] . "'" . $item['value'] . "' AND";

                endforeach;
            } else if (count($data) > 0) {
                foreach ($data as $key => $item) :

                    if (!empty($item)) $query .= " $key $operator '$item' AND";

                endforeach;
            }

            if ($query == " WHERE ") {
                $query .= " 1";
            } else {
                $query = substr($query, 0, -1); // remove <D>

                $query = substr($query, 0, -1); // remove <N>

                $query = substr($query, 0, -1); // remove <A>
            }
        } else {

            $err_type = gettype($data);

            die($err_type . ' : Type non pris en charge');
        }

        // $this->query .= $query;
        $this->whereStatement .= $query;

        return $this;
    }

    /**
     *  JOIN STATEMEMENT
     */

    public function joinWith(string $tableA, string $jointureA, string $tableB, string $jointureB,   string $type = ""): self
    {

        if (empty($type)) $this->joinStatement .= " JOIN $tableA ON $tableA.$jointureA = $tableB.$jointureB ";

        else $this->joinStatement .= " $type JOIN $tableA ON $tableA.$jointureA = $tableB.$jointureB ";

        return $this;
    }

    /**
     *  OR WHERE STATEMEMENT
     */
    public function orWhere(array | int $data): self
    {
        $query = "";

        if (is_int($data)) {

            $query = " WHERE 1 ";
        } else if (is_array($data)) {

            $query = " WHERE ";

            foreach ($data as $key => $item) :

                if (empty($item)) $item = (int) $item;

                $query .= " $key = '$item' OR";

            endforeach;

            $query = substr($query, 0, -1); // remove <O>

            $query = substr($query, 0, -1); // remove <R>

        } else {

            $err_type = gettype($data);

            die($err_type . ' : Type non pris en charge');
        }

        $this->query .= $query;

        return $this;
    }

    /**
     *  GENERATE STATEMEMENT
     */

    public function generateSQL()
    {

        return $this->query . " " . $this->joinStatement . " " . $this->whereStatement;
    }



    /**
     *  EXECUTE STATEMEMENT
     */

    public function execute(): self
    {

        if (empty($this->table)) {
            die('Fichier de donnee manquant');
        }

        try {

            $prepare = $this->db->prepare($this->generateSQL());

            $this->status = $prepare->execute();

            $this->prepare = $prepare;

            return $this;
        } catch (PDOException $e) {

            $this->error = [
                "code" => "error",
                "message" => $e->getMessage()
            ];

            return  $this;
        }
    }

    /**
     *  ASSOCIATIVE RENDER STATEMEMENT
     */

    public function fetchAssociative(): array
    {

        $fetch = $this->prepare->fetchAll(PDO::FETCH_ASSOC);

        return $fetch;
    }

    /**
     *  OBJECT RENDER STATEMEMENT
     */

    public function fetchObject(): object
    {

        $fetch = $this->prepare->fetchAll(PDO::FETCH_OBJ);

        return $fetch;
    }

    /**
     *  STATUS STATEMEMENT
     */

    public function status()
    {
        return $this->status;
    }

    /**
     *  ERROR STATEMEMENT
     */

    public function debug(): array
    {
        return $this->error;
    }
}
