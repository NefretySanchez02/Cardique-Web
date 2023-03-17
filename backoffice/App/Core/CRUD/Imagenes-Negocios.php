<?php

namespace App\Core\CRUD;


require_once 'Model.php';

/**
 * Description of User
 *
 * @author rafaelsanchez
 */
class Imagenes_Negocios extends Model
{
    const SQL_TABLE = "fotos_negocios";

    const MODEL_CONFIG = array(
        "tablename" => "fotos_negocios",
        "fields" => array(
            "id" => array("type" => "INT", "length" => "10"),
            "nombre" => array("type" => "STR", "length" => "250"),
            "intensidad" => array("type" => "INT", "length" => "10"),
            "modalidad" => array("type" => "STR", "length" => "250"),
            "descripcion_corta" => array("type" => "STR", "length" => "250"),
            "brochure" => array("type" => "STR", "length" => "250")
        )
    );

    function __construct()
    {
        parent::__construct(self::MODEL_CONFIG);
    }


    public function get($id)
    {
        return parent::findOne(array("id" => $id));
    }

    public function getById($id)
    {
        return parent::findOne(array("id" => $id));
    }

    public function deleteById($id)
    {
        $sql = parent::generateDeleteQuery(self::SQL_TABLE, "id", $id);
        return $sql;
    }

    public function getListType($tipo)
    {
        $sql = parent::generateListForColumn(self::SQL_TABLE, "id_Mapa", $tipo);
        $params = array(
            array("value" => $tipo, "type" => "STR")
        );

        return $sql;
    }

    public function getByIdMapIndex($tipo)
    {
        $sql = parent::generateListImageForIdMap(self::SQL_TABLE, "id_Mapa", $tipo);
        $params = array(
            array("value" => $tipo, "type" => "STR")
        );

        return $sql;
    }

    public static function updateImage($datap)
    {
        $fields_array = array(
            // array( array("field" => FIELD-NAME, "value" => FIELD-VALUE, "type" => ["INT" | "STR"] ) )
            array("field" => "id", "value" => $datap[0], "type" => "INT"),
            //Send the table id field in the first array position
            array("field" => "imagen", "value" => $datap[1], "type" => "STR"),
            array("field" => "id_mapa", "value" => $datap[2], "type" => "STR"),
        );
        $sql = parent::generateUpdateQuery(self::SQL_TABLE, $fields_array);
        $params = array(
            array("value" => $fields_array[0]["field"], "type" => "INT")
        );
        $affected_arrows = parent::executeQuery($sql, $params, false);
        return $affected_arrows;
    }

    public static function createImagen($data)
    {
        $fields_array = array(
            array("field" => "imagen", "value" => $data[0], "type" => "STR"),
            array("field" => "id_mapa", "value" => $data[1], "type" => "STR"),
        );
        $sql = parent::generateInsertManyQuerys(self::SQL_TABLE, $fields_array);
        return $sql;
    }
}