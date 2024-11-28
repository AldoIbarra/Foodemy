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
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userType = $_POST['userType'];

        if(empty($name) || empty($gender) || empty($bornDate) || empty($email) || empty($password) || empty($userType)){
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
            exit;
        }
        
        $photo = "";
        if (isset($_FILES['imagen']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $photo = file_get_contents($_FILES['imagen']['tmp_name']);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No se pudo procesar la imagen."]);
            exit;
        }

        $resultadoFuncion = UserClass::signUp($name, $gender, $bornDate, $photo, $email, $password, $userType);

        // Manejo de respuesta de la función
        if ($resultadoFuncion[0]) {
            echo json_encode(["status" => "success", "data" => $resultadoFuncion[1]]);
        } else {
            echo json_encode(["status" => "error", "message" => $resultadoFuncion[1]]);
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
    } elseif ($option == 'blockUser') { 
        header('Content-Type: application/json');
    
        try {
            if (empty($_POST['id_usuario']) || !is_numeric($_POST['id_usuario'])) {
                throw new Exception("El ID del usuario es inválido.");
            }
    
            $id_usuario = (int) $_POST['id_usuario'];
            $resultadoFuncion = UserClass::blockUser($id_usuario); 
    
            if ($resultadoFuncion[0]) { 
                ob_clean();
                http_response_code(200); 
                echo json_encode(["success" => true, "message" => $resultadoFuncion[1]]);
            } else { 
                throw new Exception($resultadoFuncion[1]);
            }
        } catch (Exception $e) {
            ob_clean();
            http_response_code(400);
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        exit;
    } elseif ($option == 'getTeachersByStudentId') {
        ob_clean(); 

        $id = $_SESSION['ID_Usuario'];
        try {
            $resultadoFuncion = UserClass::getTeachersByStudentId($id); 
            if ($resultadoFuncion[0]) {
                echo json_encode(["success" => true, "teachers" => $resultadoFuncion[1]]); 
                // Envolver en un objeto con 'success' y 'categories' 
            } else {
                echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
            } 
            exit;
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos el mensaje de error
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        
    } elseif ($option == 'getStudentsByTeacherId') {
        ob_clean(); 

        $id = $_SESSION['ID_Usuario'];
        try {
            $resultadoFuncion = UserClass::getStudentsByTeacherId($id); 
            if ($resultadoFuncion[0]) {
                echo json_encode(["success" => true, "students" => $resultadoFuncion[1]]); 
                // Envolver en un objeto con 'success' y 'categories' 
            } else {
                echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
            } 
            exit;
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos el mensaje de error
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        
    } elseif ($option == 'getMessagesBetweenUsers') {
        ob_clean(); 
        $user2Id = (int)$_GET['user2Id'];
        $id = $_SESSION['ID_Usuario'];
        try {
            $resultadoFuncion = UserClass::getMessagesBetweenUsers($id, $user2Id); 
            if ($resultadoFuncion[0]) {
                echo json_encode(["success" => true, "messages" => $resultadoFuncion[1]]); 
                // Envolver en un objeto con 'success' y 'categories' 
            } else {
                echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
            } 
            exit;
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos el mensaje de error
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        
    }else if($_POST['option'] == 'sendMesage'){
        header('Content-Type: application/json');

        $emmiter = $_POST['emmiter'];
        $receiver = $_POST['receiver'];
        $message = $_POST['message'];

        if(empty($emmiter) || empty($receiver) || empty($message)){
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
            exit;
        }

        $resultadoFuncion = UserClass::sendMsg($emmiter, $receiver, $message);

        // Manejo de respuesta de la función
        if ($resultadoFuncion[0]) {
            echo json_encode(["status" => "success", "data" => $resultadoFuncion[1]]);
        } else {
            echo json_encode(["status" => "error", "message" => $resultadoFuncion[1]]);
        }
        exit;
    } elseif ($option == 'getStudentKardex') {
        ob_clean(); 
        $dateIni = $_GET['dateIni'] == '' ? null : $_GET['dateIni'];
        $dateFin = $_GET['dateFin'] == '' ? null : $_GET['dateFin'];
        $categoryId = $_GET['categoryId'] == 'todas' ? null : $_GET['categoryId'];
        $courseStatus = $_GET['courseStatus'] == 'Todos' ? null : $_GET['courseStatus'];
        $studentId = $_GET['studentId'];
        try {
            $resultadoFuncion = UserClass::getStudentKardex($studentId, $categoryId, $courseStatus, $dateIni, $dateFin); 
            if ($resultadoFuncion[0]) {
                echo json_encode(["success" => true, "courses" => $resultadoFuncion[1]]); 
                // Envolver en un objeto con 'success' y 'categories' 
            } else {
                echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
            } 
            exit;
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos el mensaje de error
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        
    } elseif ($option == 'getSalesReport') {
        ob_clean(); 
        $dateIni = $_GET['dateIni'] == '' ? null : $_GET['dateIni'];
        $dateFin = $_GET['dateFin'] == '' ? null : $_GET['dateFin'];
        $categoryId = $_GET['categoryId'] == 'todas' ? null : $_GET['categoryId'];
        $teacherId = $_GET['teacherId'];
        try {
            $resultadoFuncion = UserClass::getSalesReport($teacherId, $categoryId, $dateIni, $dateFin); 
            if ($resultadoFuncion[0]) {
                echo json_encode(["success" => true, "courses" => $resultadoFuncion[1]]); 
                // Envolver en un objeto con 'success' y 'categories' 
            } else {
                echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
            } 
            exit;
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos el mensaje de error
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        
    } 

    
?>