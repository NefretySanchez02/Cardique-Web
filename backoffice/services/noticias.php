<?php
error_reporting(0);

//require_once 'security.php';

use App\Core\CRUD\Noticia;
use App\Core\Box\Tools;

require_once '../App/Core/CRUD/Noticia.php';
require_once '../App/BlackBox/uploader/RSFileUploader.php';
//require_once '../Core/Box/Tools.php';

date_default_timezone_set('America/Bogota');

if (!(isset($_POST['action']) || isset($_GET['action']))) {
    die('{"success": 0, "error": "No action sent"}');
}

if ($_GET['action'] == "list") {
    listItems();
} else if ($_GET['action'] == "listEntrys") {
    listEntrys();
} else if ($_GET['action'] == "get") {
    get();
} else if ($_GET['action'] == "getBySlug") {
    getBySlug();
} else if ($_GET['action'] == "getByTitle") {
    getByTitle();
} else if ($_GET['action'] == "listEntrySlug") {
    getRecentsWithoutSlug();
} else if ($_GET['action'] == "stats") {
    stats();
} else if ($_POST['action'] == "create") {
    create();
} else if ($_POST['action'] == "delete") {
    deleteNews();
} else if ($_POST['action'] == "update") {
    updateNews();
} else if ($_POST['action'] == "updateImage") {
    updateImageNews();
} else {
    die('{"success": 0, "error": "No valid action or method"}');
}



function listItems()
{
    $newsManager = new Noticia();
    $newsItem_list = $newsManager->find(array("sort" => array("fecha_publicacion" => "DESC")));

    $response = array();

    $response["success"] = 1;
    $response["messages"] = $newsItem_list;

    echo json_encode($response);
}

function listEntrys()
{
    $newsManager = new Noticia();
    $newsItem_list = $newsManager->find(array("sort" => array("fecha_publicacion" => "DESC"), 'limit' => 3));

    $response = array();

    $response["success"] = 1;
    $response["messages"] = $newsItem_list;

    echo json_encode($response);
}

function get()
{
    $newsManager = new Noticia();

    $slug = filter_input(INPUT_GET, "slug", FILTER_SANITIZE_STRING);
    if (empty($slug))
        die(json_encode(array("success" => 0, "error_msg" => "slug param has and invalid value")));

    $newsItem = $newsManager->getBySlug($slug);
    if (!$newsItem) {

    }

    $response = array();

    $response["success"] = 1;
    $response["news_item"] = $newsItem;
    //$response["services_count"] = count($servicios);

    echo json_encode($response);
}

function getBySlug()
{
    $newsManager = new Noticia();

    $slug = filter_input(INPUT_GET, "slug", FILTER_SANITIZE_STRING);
    if (empty($slug))
        die(json_encode(array("success" => 0, "error_msg" => "slug param has and invalid value")));

    $newsItem = $newsManager->getNewsBySlug($slug);
    if (!$newsItem) {

    }

    $response = array();

    $response["success"] = 1;
    $response["news_item"] = $newsItem;
    //$response["services_count"] = count($servicios);

    echo json_encode($response);
}

function getByTitle()
{
    $newsManager = new Noticia();

    $title = filter_input(INPUT_GET, "titular", FILTER_SANITIZE_STRING);
    if (empty($title))
        die(json_encode(array("success" => 0, "error_msg" => "slug param has and invalid value")));

    $newsItem = $newsManager->getNewsByTitle($title);
    if (!$newsItem) {

    }

    $response = array();

    $response["success"] = 1;
    $response["news_item"] = $newsItem;
    //$response["services_count"] = count($servicios);

    echo json_encode($response);
}

function getRecentsWithoutSlug()
{
    $newsManager = new Noticia();

    $slug = filter_input(INPUT_GET, "slug", FILTER_SANITIZE_STRING);
    if (empty($slug))
        die(json_encode(array("success" => 0, "error_msg" => "slug param has and invalid value")));

    $newsItem = $newsManager->getRecentsBySlug($slug);
    $response = array();
    $news = array();
    foreach ($newsItem as $serv) {
        $servicio_data = array();
        $servicio_data['id'] = $serv["id"];
        $servicio_data['titular'] = $serv["titular"];
        $servicio_data['slug'] = $serv["slug"];
        $servicio_data['foto'] = $serv["foto"];
        $servicio_data['contenido'] = $serv["contenido"];
        $servicio_data['autor'] = $serv["autor"];
        $servicio_data['fecha_publicacion'] = $serv["fecha_publicacion"];

        $news[] = $servicio_data;
    }

    if (!$newsItem) {

    }



    $response["success"] = 1;
    $response["news_item"] = $news;
    //$response["services_count"] = count($servicios);

    echo json_encode($response);
}

function stats()
{
    $newsManager = new Noticia();
    $newsItem_list = $newsManager->find(array("estado" => "VISIBLE"));

    $response = array();

    $response["success"] = 1;
    $response["news_count"] = count($newsItem_list);

    echo json_encode($response);
}

function deleteNews()
{
    $service_id = filter_input(INPUT_POST, 'id_item', FILTER_SANITIZE_NUMBER_INT);
    $serviceManager = new Noticia();
    $qres = $serviceManager->deleteById($service_id);
    $response = array();
    $response["success"] = 1;
    echo json_encode($response);
}

function updateNews()
{
    $serviceManager = new Noticia();
    $service_data[0] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $service_data[1] = filter_input(INPUT_POST, 'titular', FILTER_SANITIZE_STRING);
    $service_data[2] = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
    $service_data[3] = filter_input(INPUT_POST, 'foto', FILTER_SANITIZE_STRING);
    $service_data[4] = filter_input(INPUT_POST, 'contenido', FILTER_UNSAFE_RAW);
    $service_data[5] = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_STRING);

    $qres = $serviceManager->updateNewsById($service_data);

    $response = array();
    if ($qres) {
        $response["success"] = 1;
        $response["data"] = "Register could be updated";
    } else {
        $response["success"] = 0;
        $response["error"] = "Register couldn't be updated";
    }

    echo json_encode($response);
}
function updateImageNews()
{
    $target_dir = "../assets/img/services/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

}


function create()
{
    $serviceManager = new Noticia();
    $messaje = array();
    $service_data[0] = filter_input(INPUT_POST, 'titular', FILTER_SANITIZE_STRING);
    $service_data[1] = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
    $service_data[2] = filter_input(INPUT_POST, 'foto', FILTER_SANITIZE_STRING);
    $service_data[3] = filter_input(INPUT_POST, 'contenido', FILTER_UNSAFE_RAW);
    $service_data[5] = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_STRING);
    $service_data[6] = date("Y-m-d H:i:s");
    $qres = $serviceManager->createNews($service_data);

    $response = array();
    if ($qres) {
        $response["success"] = 1;
        $response["data"] = "Register could be updated";
    } else {
        $response["success"] = 0;
        $response["error"] = "Register couldn't be updated";
    }

    echo json_encode($response);
}