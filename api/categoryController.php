<?php
    include "../models/categoryModel.php";
    if (session_status() == PHP_SESSION_NONE) {
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

    if ($option == 'createCategory') {
        // Lógica para crear categoría
        $id_admin = $_SESSION['ID_Usuario'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        if (empty($id_admin) || empty($title) || empty($description)) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Favor de completar todos los campos"));
            exit;
        }

        $resultadoFuncion = CategoryClass::createCategory($id_admin, $title, $description);

        if (isset($resultadoFuncion['error']) && !$resultadoFuncion['error']) {
            ob_clean();
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "newCategoryId" => $resultadoFuncion['id']  // Usar la clave 'id'
            ]);
        } else {
            ob_clean();
            http_response_code(400);
            echo json_encode([
                "error" => true,
                "message" => $resultadoFuncion['message']  // Usar la clave 'message'
            ]);
        }
        exit;
    } elseif ($option == 'updateCategory') {
        // Lógica para actualizar categoría
        $id_category = $_POST['id_category'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        if (empty($id_category) || empty($title) || empty($description)) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Favor de completar todos los campos"));
            exit;
        }

        $resultadoFuncion = CategoryClass::updateCategory($id_category, $title, $description);

        if ($resultadoFuncion[0]) {
            ob_clean(); 
            http_response_code(200);
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => true]);
        }
        exit;
    } elseif ($option == 'getAllCategories') { 
        // Lógica para obtener todas las categorías 
        $resultadoFuncion = CategoryClass::getAllCategories(); 
        if ($resultadoFuncion[0]) { 
            ob_clean(); 
            http_response_code(200); 
            echo json_encode(["success" => true, "categories" => $resultadoFuncion[1]]); 
            // Envolver en un objeto con 'success' y 'categories' 
            } else { 
                http_response_code(400); 
                echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
            } 
            exit;
    } elseif ($option == 'deleteCategory') { 
        // Lógica para eliminar la categoría seleccionada 
        $id_category = $_POST['id_category'];
        $resultadoFuncion = CategoryClass::deleteCategory($id_category); 

        if ($resultadoFuncion[0]) { 
            ob_clean(); 
            http_response_code(200); 
            echo json_encode(["success" => true, "message" => "Categoría eliminada con éxito."]); 
            // Envolver en un objeto con 'success' y 'categories' 
            } else { 
                http_response_code(400); 
                echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
            } 
            exit;
    } else {
        echo json_encode(["success" => false, "message" => "Opción no válida"]);
    }
?>
