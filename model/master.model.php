<?php
//requerir otros modelos
require_once "conn.model.php";
require_once "procedure.model.php";
//añadir todas las clases a la variable main
function masterModel()
{
    $main = new MasterModel();
    $main->procedure = new ProcedureModel;
    return $main;
}
class MasterModel
{
    protected $pdo;
    protected $sql;
    //acceso a conexion de base de datos
    public  function __CONSTRUCT()
    {
        try {
            $this->pdo = DataBase::openDB();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    function columnsOfTable($table, $skip = null)
    {
        try {
            $dbname = DataBase::getName();
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'  AND table_schema = '$dbname'";
            $query = $this->pdo->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_BOTH);
            $columns = " ";
            $i = 0;
            foreach ($result as $row) {
                if ($row[0] == $skip[$i]) {
                    if ($i < (count($skip) - 1)) {
                        $i++;
                    }
                } else {
                    $columns .= $row[0] . ",";
                }
            }
            $result = $columns;
            $result = substr($result, 0, -1);
        } catch (PDOException $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    //saber el numero de  comodines
    public function comodines($comodines)
    {
        $resultComodines = "";
        foreach ($comodines as $como) {
            $resultComodines .= "?,";
        }
        $resultComodines = substr($resultComodines, 0, -1);
        return $resultComodines;
    }
    //saber los valores
    public function values($valores)
    {
        $i = 0;
        // $resultado = count($valores);
        $resultValues = "";
        foreach ($valores as $value) {
            $resultValues .= $value . ",";
            $i = $i + 1;
        }
        $resultValues = substr($resultValues, 0, -1);
        return $resultValues;
    }
    //acomodar las columnas y los valores al hacer un update
    public function columnsUpdate($columns)
    {
        $columns = explode(",", $columns);
        $resultColomnsUpdate = "";
        foreach ($columns as $col) {
            $resultColomnsUpdate .= $col . " = ? , ";
        }
        $resultColomnsUpdate = substr($resultColomnsUpdate, 0, -2);
        return $resultColomnsUpdate;
    }
    function api($ruta)
    {
        $url = "htttp://direccion/api/";
        $respuesta = $url . $ruta;
        return $respuesta;
    }
}
