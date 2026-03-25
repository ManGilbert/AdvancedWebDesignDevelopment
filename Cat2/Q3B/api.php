<?php
header("Content-Type: application/json");

$file = "data.json";

// READ
function getData($file){
    if(!file_exists($file)){
        file_put_contents($file, json_encode([]));
    }
    return json_decode(file_get_contents($file), true);
}

// SAVE
function saveData($file, $data){
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    // ✅ GET
    case 'GET':
        $data = getData($file);

        if(isset($_GET['id'])){
            foreach($data as $item){
                if($item['id'] == $_GET['id']){
                    echo json_encode($item);
                    exit;
                }
            }
            echo json_encode(["message"=>"Not found"]);
        } else {
            echo json_encode($data);
        }
    break;

    // ✅ POST
    case 'POST':
        $data = getData($file);

        $input = json_decode(file_get_contents("php://input"), true);

        if(!$input){
            echo json_encode(["error"=>"No data"]);
            exit;
        }

        $lastId = 0;
        if(count($data) > 0){
            $lastId = end($data)['id'];
        }

        $input['id'] = $lastId + 1;

        $data[] = $input;

        saveData($file, $data);

        echo json_encode(["message"=>"Added"]);
    break;

    // ✅ PUT
    case 'PUT':
        $data = getData($file);
        $input = json_decode(file_get_contents("php://input"), true);

        foreach($data as &$item){
            if($item['id'] == $input['id']){
                $item = $input;
            }
        }

        saveData($file, $data);

        echo json_encode(["message"=>"Updated"]);
    break;

    // ✅ DELETE
    case 'DELETE':
        $data = getData($file);

        $id = $_GET['id'];

        $data = array_filter($data, function($item) use ($id){
            return $item['id'] != $id;
        });

        saveData($file, array_values($data));

        echo json_encode(["message"=>"Deleted"]);
    break;
}
?>