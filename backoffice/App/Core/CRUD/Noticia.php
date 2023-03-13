<?php

namespace App\Core\CRUD;


require_once 'Model.php';

/**
 * Description of User
 *
 * @author rafaelsanchez
 */
class Noticia extends Model
{
    const SQL_TABLE = "noticias";

    const MODEL_CONFIG = array(
        "tablename" => "noticias",
        "fields" => array(
            "id" => array("type" => "INT", "length" => "10"),
            "titular" => array("type" => "STR", "length" => "250"),
            "slug" => array("type" => "STR", "length" => "100"),
            "foto" => array("type" => "STR", "length" => "250"),
            "descripcion_corta" => array("type" => "STR", "length" => "250"),
            "contenido" => array("type" => "STR", "length" => ""),
            "estado" => array("type" => "STR", "length" => "10"),
            "fecha_publicacion" => array("type" => "STR", "length" => "25")
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

    public function getBySlug($slug)
    {
        return parent::findOne(array("id" => $slug));
    }

    public function getNewsBySlug($slug)
    {
        return parent::findOne(array("slug" => $slug));
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

    public function getRecentsBySlug($slug)
    {
        $sql = parent::generateEntrysRecentWithoutSlug(self::SQL_TABLE, "slug", $slug);
        $params = array(
            array("value" => $slug, "type" => "STR")
        );
        return $sql;
    }

    public function getNewsByTitle($title)
    {
        $sql = parent::searchList(self::SQL_TABLE, "titular", $title);
        $params = array(
            array("value" => $title, "type" => "STR")
        );
        return $sql;
    }


    public static function updateNewsById($datap)
    {
        $fields_array = array(
            // array( array("field" => FIELD-NAME, "value" => FIELD-VALUE, "type" => ["INT" | "STR"] ) )
            array("field" => "id", "value" => $datap[0], "type" => "INT"),
            //Send the table id field in the first array position
            array("field" => "titular", "value" => $datap[1], "type" => "STR"),
            array("field" => "slug", "value" => $datap[2], "type" => "STR"),
            array("field" => "foto", "value" => $datap[3], "type" => "STR"),
            array("field" => "contenido", "value" => $datap[4], "type" => "STR"),
            array("field" => "autor", "value" => $datap[5], "type" => "STR"),
        );
        $sql = parent::generateUpdateQuery(self::SQL_TABLE, $fields_array);
        $params = array(
            array("value" => $fields_array[0]["field"], "type" => "INT")
        );
        $affected_arrows = parent::executeQuery($sql, $params, false);
        return $affected_arrows;
    }

    public static function createNews($dataNews)
    {
        $fields_array = array(
            array("field" => "titular", "value" => $dataNews[0], "type" => "STR"),
            array("field" => "slug", "value" => $dataNews[1], "type" => "STR"),
            array("field" => "foto", "value" => $dataNews[2], "type" => "STR"),
            array("field" => "contenido", "value" => $dataNews[3], "type" => "STR"),
            array("field" => "autor", "value" => $dataNews[5], "type" => "STR"),
            array("field" => "fecha_publicacion", "value" => $dataNews[6], "type" => "STR")
        );
        $sql = parent::generateInsertQuery(self::SQL_TABLE, $fields_array);
        $affected_arrows = parent::executeQuery($sql, false);
        return $affected_arrows;
    }
}