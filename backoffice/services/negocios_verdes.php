<?php
error_reporting(0);

//require_once 'security.php';

use App\Core\CRUD\Negocios;
use App\Core\Box\Tools;

require_once '../App/Core/CRUD/Negocios.php';
//require_once '../App/BlackBox/uploader/RSFileUploader.php';
//require_once '../Core/Box/Tools.php';

date_default_timezone_set('America/Bogota');

if (!(isset($_POST['action']) || isset($_GET['action']))) {
    die('{"success": 0, "error": "No action sent"}');
}

if ($_GET['action'] == "list") {
    listItems();
}  else if ($_GET['action'] == "get") {
    get();
} else if ($_GET['action'] == "getByName") {
    getByName();
} else {
    die('{"success": 0, "error": "No valid action or method"}');
}



function listItems()
{
    $newsManager = new Negocios();
    $newsItem_list = $newsManager->find(array("sort" => array("id" => "ASC")));
    print_r($newsItem_list);

    $response = array();

    $response["success"] = 1;
    $response["messages"] = $newsItem_list;

    echo json_encode($response);
}

function getByName()
{
    $newsManager = new Negocios();

    $title = filter_input(INPUT_GET, "id_mapa", FILTER_SANITIZE_STRING);
    if (empty($title))
        die(json_encode(array("success" => 0, "error_msg" => "slug param has and invalid value")));

    $newsItem = $newsManager->getListType($title);
    if (!$newsItem) {

    }

    $response = array();

    $response["success"] = 1;
    $response["news_item"] = $newsItem;
    //$response["services_count"] = count($servicios);

    echo json_encode($response);
}

function get()
{
    $newsManager = new Negocios();

    $slug = filter_input(INPUT_GET, "slug", FILTER_SANITIZE_STRING);
    if (empty($slug))
        die(json_encode(array("success" => 0, "error_msg" => "slug param has and invalid value")));

    $newsItem = $newsManager->getById($slug);
    if (!$newsItem) {

    }

    $response = array();

    $response["success"] = 1;
    $response["news_item"] = $newsItem;
    //$response["services_count"] = count($servicios);

    echo json_encode($response);
}
