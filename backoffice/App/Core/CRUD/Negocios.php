<?php

namespace App\Core\CRUD;


require_once 'Model.php';

/**
 * Description of User
 *
 * @author rafaelsanchez
 */
class Negocios extends Model
{
    const SQL_TABLE = "negocios_verdes";

    const MODEL_CONFIG = array(
        "tablename" => "negocios_verdes",
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
        $params = array(
            array("value" => $id, "type" => "INT")
        );
        echo $sql;
        return parent::executeQuery($sql, $params, false);
    }

    public function getListType($tipo)
    {
        $sql = parent::generateListForColumn(self::SQL_TABLE, "id_Mapa", $tipo);
        $params = array(
            array("value" => $tipo, "type" => "STR")
        );

        return $sql;
    }

    public function getListByCategory($slug)
    {
        $sql = parent::generateIdMapsCategory(self::SQL_TABLE, "categoria", $slug);
        $params = array(
            array("value" => $slug, "type" => "STR")
        );
        return $sql;
    }

    public function getListByName($title)
    {
        $sql = parent::searchList(self::SQL_TABLE, "nombre", $title);
        $params = array(
            array("value" => $title, "type" => "STR")
        );
        return $sql;
    }

    public static function updateNegociosById($datap)
    {
        $fields_array = array(
            // array( array("field" => FIELD-NAME, "value" => FIELD-VALUE, "type" => ["INT" | "STR"] ) )
            array("field" => "id", "value" => $datap[0], "type" => "INT"),
            //Send the table id field in the first array position
            array("field" => "nombre", "value" => $datap[1], "type" => "STR"),
            array("field" => "descripcion", "value" => $datap[2], "type" => "STR"),
            array("field" => "ubicacion", "value" => $datap[3], "type" => "INT"),
            array("field" => "foto", "value" => $datap[4], "type" => "STR"),
            array("field" => "codigo_plus", "value" => $datap[5], "type" => "STR"),
            array("field" => "link_ubicacion", "value" => $datap[6], "type" => "STR"),
            array("field" => "categoria", "value" => $datap[7], "type" => "STR"),
            array("field" => "zona", "value" => $datap[8], "type" => "STR"),
            array("field" => "facebook", "value" => $datap[9], "type" => "STR"),
            array("field" => "instagram", "value" => $datap[10], "type" => "STR"),
            array("field" => "whatsapp", "value" => $datap[11], "type" => "STR"),
            array("field" => "mail", "value" => $datap[12], "type" => "STR"),
            array("field" => "web", "value" => $datap[13], "type" => "STR")
        );
        $sql = parent::generateUpdateQuery(self::SQL_TABLE, $fields_array);
        $params = array(
            array("value" => $fields_array[0]["field"], "type" => "INT")
        );
        $affected_arrows = parent::executeQuery($sql, $params, false);
        return $affected_arrows;
    }

}