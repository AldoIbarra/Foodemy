<?php
    include "../models/usersModel.php";
    session_start();

    if($_POST['option'] == 'signUp'){
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $bornDate = $_POST['bornDate'];
        $photo = "";
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userType = $_POST['userType'];

        $data = json_decode(file_get_contents('php://input'), true);
            if(empty($name) || empty($gender) || empty($bornDate) || empty($email) || empty($password) || empty($userType)){
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "algun dato vacio"));
            }

            if (isset($_FILES['imagen'])) {
                $archivo = $_FILES['imagen']['tmp_name'];
                $nombre_imagen = $_FILES['imagen']['name'];
                $tipo_imagen = $_FILES['imagen']['type'];
                $photo = file_get_contents($archivo);
            }
            
            if (empty($photo)) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "La imagen no se pudo procesar"));
                exit;
            }

            $resultadoFuncion = UserClass::signUp($name, $gender, $bornDate, $photo, $email, $password, $userType);

            if ($resultadoFuncion[0]){
                    http_response_code(200);
                    $json_response = ["success" => true];
                    echo json_encode($json_response);
            }else{
                    http_response_code(400);
                    $json_response = ["error" => true];
                    echo json_encode($json_response);
            }
            exit;
    }else if($_POST['option'] == 'logIn'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $data = json_decode(file_get_contents('php://input'), true);
        if(empty($email) || empty($password)){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "algun dato vacio"));
        }
        $resultadoFuncion = UserClass::logIn($email, $password);

        if($resultadoFuncion==null){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "ningun usuario encontrado"));
        }else{
            http_response_code(200);
            echo json_encode($resultadoFuncion);
        }
    }else if($_POST['option'] == 'updateInfo'){
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $bornDate = $_POST['bornDate'];
        $id = $_POST['id'];

        $data = json_decode(file_get_contents('php://input'), true);
            if(empty($name) || empty($gender) || empty($bornDate)){
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "algun dato vacio"));
            }

            $resultadoFuncion = UserClass::updateInfo($id, $name, $gender, $bornDate);

            if ($resultadoFuncion[0]){
                    http_response_code(200);
                    $json_response = ["success" => true];
                    echo json_encode($json_response);
            }else{
                    http_response_code(400);
                    $json_response = ["error" => true];
                    echo json_encode($json_response);
            }
            exit;
    }

    
?>