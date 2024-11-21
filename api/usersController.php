<?php
    include "../models/usersModel.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verificamos si 'option' está definida en $_POST o $_GET
    if (isset($_POST['option'])) {
        $option = $_POST['option'];
    } elseif (isset($_GET['option'])) {
        $option = $_GET['option'];
    } else {
        // Si no existe la opción, mostramos un mensaje de error
        echo json_encode(["success" => false, "message" => "Opción no válida"]);
        exit;
    }


    if($_POST['option'] == 'signUp'){
        header('Content-Type: application/json');

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
        header('Content-Type: application/json');

        $email = $_POST['email'];
        $password = $_POST['password'];

        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Campos incompletos"));
            exit;
        }
        
        $resultadoFuncion = UserClass::logIn($email, $password);

        if ($resultadoFuncion["success"]) {
            ob_clean();
            http_response_code(200);
            echo json_encode(["success" => true, "message" => $resultadoFuncion["message"]]);
        } else {
            ob_clean();
            http_response_code(400);
            echo json_encode(["success" => false, "message" => $resultadoFuncion["message"]]);
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
    } elseif ($option == 'getAllUsersExcept') { 
        header('Content-Type: application/json');
    
        if (!isset($_SESSION['ID_Usuario'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "No se encontró el ID del usuario en la sesión."));
            exit;
        }
    
        $id_admin = $_SESSION['ID_Usuario'];
    
        $resultadoFuncion = UserClass::getAllUsersExcept($id_admin); 
    
        if ($resultadoFuncion[0]) { 
            ob_clean();
            http_response_code(200); 
            echo json_encode(["success" => true, "Usuarios" => $resultadoFuncion[1]]); 
        } else { 
            ob_clean();
            http_response_code(400); 
            echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
        } 
        exit;
    }
    
    

    
?>