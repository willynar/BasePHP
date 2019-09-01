<?php
class ProcedureModel extends MasterModel{
      public function __CONSTRUCT(){
           try {
               $this->pdo=DataBase::closeDB();
               $this->pdo=DataBase::openDB();
               $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
           } catch (PDOException $e) {
               die($e->getMessage());
           }
       }
       //NPRAll = no params return all
      public function NPRAll($procedureName){
          try {
              $this->sql="call $procedureName()";
              $query=$this->pdo->prepare($this->sql);
              $query->execute();
              $result = $query->fetchAll(PDO::FETCH_BOTH);
          } catch (PDOException $e) {
              $result = $query->errorInfo()[1];
          }
          return $result;
      }
      //PRBy = no params return by
      public function PRByAll($procedureName,$params){
          $comodines = $this->comodines($params);
          try {
              $this->sql="call $procedureName($comodines)";
              $query=$this->pdo->prepare($this->sql);
              $query->execute($params);
              $result = $query->fetchAll(PDO::FETCH_BOTH);
          } catch (PDOException $e) {
              $result = $query->errorInfo()[1];
          }
          return $result;
      }
      //NRP = no return params
      public function NRP($procedureName,$params){
          $comodines = $this->comodines($params);
          try {
              $this->sql="call $procedureName($comodines)";
              $query=$this->pdo->prepare($this->sql);
              $query->execute($params);
              $result = true;
          } catch (PDOException $e) {
              $result = $query->errorInfo()[1];
          }
          return $result;
      }
      public function noParams($procedureName){
          try {
              $this->sql="call $procedureName()";
              $query=$this->pdo->prepare($this->sql);
              $query->execute();
              $result = true;
          } catch (PDOException $e) {
              $result = $query->errorInfo()[1];
          }
          return $result;
      }
}

?>
