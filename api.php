<?php
    header("Content-Type: application/json");

    $storageFile = 'items.json';
    if (!file_exists($storageFile)) {
        file_put_contents($storageFile, json_encode($items = []));
    }
    $items = json_decode(file_get_contents($storageFile), true);

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (!empty($_GET["name"])) {
            $name = $_GET["name"];
            $filteredItems = array_filter($items, function ($item) use ($name) {
                return stripos($item["Name"], $name) !== false;
            });
            echo json_encode(array_values($filteredItems));
        } elseif (!empty($items)) {
            echo json_encode($items);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No Data Found"]);
        }
    }
    else if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = json_decode(file_get_contents("php://input"), true);
        if(isset($data["id"]) && isset($data["name"])){
            $newItem = [
                "ID" => $data["id"],
                "Name" => $data["name"]
            ];
            $items[] = $newItem;
            file_put_contents($storageFile, json_encode($items));
            http_response_code(201);
            echo json_encode($items);
        }else{
            http_response_code(400);
            echo json_encode(["message" => "Bad Request"]);
        }
    }

    else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (isset($data["id"]) && isset($data["name"])) {
            $id = $data["id"];
            $name = $data["name"];
    
            $items = json_decode(file_get_contents($storageFile), true);
    
            $updated = false;
    
            
            foreach ($items as &$item) {
                if ($item["ID"] == $id) {
                    $item["Name"] = $name;
                    $updated = true;
                    break; 
                }
            }
    
            if ($updated) {
                file_put_contents($storageFile, json_encode($items));
                echo json_encode(["message" => "Item updated successfully", "item" => $item]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Item not found"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Bad Request: Missing 'id' or 'name'"]);
        }
    }
    

    // else if($_SERVER["REQUEST_METHOD"] == "DELETE"){
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     if(isset($data["name"])){
    //         unset($items[$data["name"]]);
    //         $items = array_values($items);
    //         file_put_contents($storageFile, json_encode($items));
    //         echo json_encode($items);
    //     }else{
    //         http_response_code(400);
    //         echo json_encode(["message" => "Bad Request"]);
    //     }
    // }

    else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data["id"])) {
            $id = $data["id"];
            $items = array_filter($items, function ($item) use ($id) {
                return $item["ID"] !== $id;
            });
            $items = array_values($items); 
            file_put_contents($storageFile, json_encode($items));
            echo json_encode($items);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Bad Request"]);
        }
    }