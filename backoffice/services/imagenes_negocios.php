<?php
error_reporting(0);

//require_once 'security.php';

use App\Core\CRUD\Imagenes_Negocios;
use App\Core\Box\Tools;

require_once '../App/Core/CRUD/Imagenes-Negocios.php';
//require_once '../App/BlackBox/uploader/RSFileUploader.php';
//require_once '../Core/Box/Tools.php';

date_default_timezone_set('America/Bogota');

if (!(isset($_POST['action']) || isset($_GET['action']))) {
    die('{"success": 0, "error": "No action sent"}');
}

if ($_GET['action'] == "list") {
    listItems();
} else if ($_GET['action'] == "get") {
    get();
} else if ($_GET['action'] == "getByName") {
    getByName();
} else if ($_POST['action'] == "create") {
    create();
} else if ($_POST['action'] == "delete") {
    delete();
} else if ($_POST['action'] == "update") {
    update();
} else {
    die('{"success": 0, "error": "No valid action or method"}');
}



function listItems()
{
    $newsManager = new Imagenes_Negocios();
    $title = filter_input(INPUT_GET, "id_mapa", FILTER_SANITIZE_STRING);
    if (empty($title))
        die(json_encode(array("success" => 0, "error_msg" => "id_map param has and invalid value")));

    $newsItem = $newsManager->getByIdMapIndex($title);
    if (!$newsItem) {

    }

    $response = array();

    $response["success"] = 1;
    $response["news_item"] = $newsItem;

    echo json_encode($response);
}

function getByName()
{
    $newsManager = new Imagenes_Negocios();

    $title = filter_input(INPUT_GET, "id_mapa", FILTER_SANITIZE_STRING);
    if (empty($title))
        die(json_encode(array("success" => 0, "error_msg" => "id_map param has and invalid value")));

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
    $newsManager = new Imagenes_Negocios();

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

function updateImage()
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

function updateFile()
{
    $target_dir = "../assets/boletines/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }


}

function insert($name, $id)
{
    $serviceManager = new Imagenes_Negocios();
    $service_data[0] = $name;
    $service_data[1] = $id;
    $qres = $serviceManager->createImagen($service_data);
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

function create()
{
    $target_dir = "../assets/img/img_negocios/";
    $countfiles = count($_FILES['files']['name']);
    $id_map = $_POST['id_mapa'];
    $files_arr = array();

    for ($index = 0; $index < $countfiles; $index++) {
        $filename = $_FILES['files']['name'][$index];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $valid_ext = array("png", "jpeg", "jpg");
        if (in_array($ext, $valid_ext)) {
            $path = $target_dir . $filename;
            if (move_uploaded_file($_FILES['files']['tmp_name'][$index], $path)) {
                echo "File upload";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    for ($index = 0; $index < $countfiles; $index++) {
        $filename = $_FILES['files']['name'][$index];
        insert($filename, $id_map);
    }
}

function update()
{

    $serviceManager = new Imagenes_Negocios();
    $service_data[0] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $service_data[1] = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $service_data[2] = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_STRING);
    $service_data[3] = filter_input(INPUT_POST, 'boletin', FILTER_SANITIZE_STRING);

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

function delete()
{
    $service_id = filter_input(INPUT_POST, 'id_item', FILTER_SANITIZE_NUMBER_INT);
    $service_name = filter_input(INPUT_POST, 'name_img', FILTER_SANITIZE_STRING);
    $target_dir = "../assets/img/img_negocios/";
    $target_file = $target_dir . $service_name;
    $serviceManager = new Imagenes_Negocios();
    $qres = $serviceManager->deleteById($service_id);
    print($target_file);
    if (!unlink($target_file)) {
        echo "Error delete image in folder";
    } else {
        echo "Delete Image";
    }

    $response = array();
    $response["success"] = 1;
    echo json_encode($response);
}