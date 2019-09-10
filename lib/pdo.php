<?php
namespace lib;
class pdo {
    public $pdo;
    private $error;
    private $dsn=null;
    private $user=null;
    private $password=null;
    private $persistent=false;
    function __construct($params) {
        $this->dsn=$params['dsn'];
        $this->user=$params['username'];
        $this->password=$params['password'];
        $this->persistent=$params['persistent'];
        $this->connect();
    }
    function prep_query($query){
            return $this->pdo->prepare($query);
    }
    function connect(){
        if(!$this->pdo){
            try {
                $this->pdo = new \PDO($this->dsn, $this->user, $this->password,array(
                    \PDO::ATTR_PERSISTENT => $this->persistent
                ));
                return true;
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                die($this->error);
                return false;
            }
        }else{
                $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
                return true;
        }
    }
    function execute($query, $values = null){
            if($values == null){
                    $values = array();
            }else if(!is_array($values)){
                    $values = array($values);
            }
            $stmt = $this->prep_query($query);
            $stmt->execute($values);
            return $stmt;
    }
    function fetch($query, $values = null){
            if($values == null){
                    $values = array();
            }else if(!is_array($values)){
                    $values = array($values);
            }
            $stmt = $this->execute($query, $values);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    function fetchAll($query, $values = null, $key = null){
            if($values == null){
                    $values = array();
            }else if(!is_array($values)){
                    $values = array($values);
            }
            $stmt = $this->execute($query, $values);
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($key != null && $results[0][$key]){
                    $keyed_results = array();
                    foreach($results as $result){
                            $keyed_results[$result[$key]] = $result;
                    }
                    $results = $keyed_results;
            }
            return $results;
    }
    function lastInsertId(){
            return $this->pdo->lastInsertId();
    }
}

