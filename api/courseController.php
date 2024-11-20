<?php
    include "../models/courseModel.php";
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

    if ($option == 'createCourse') {
        try {
            if (!isset($_SESSION['ID_Usuario'])) {
                throw new Exception("Usuario no autenticado.");
            }
            $id_instructor = $_SESSION['ID_Usuario'];
    
            if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['category']) || empty($_POST['price'])) {
                throw new Exception("Datos incompletos para el curso.");
            }
            $title = $_POST['title'];
            $description = $_POST['description'];
            $category = $_POST['category'];
            $price = $_POST['price'];
    
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmp = $_FILES['image']['tmp_name'];
                $imageName = time() . '_' . $_FILES['image']['name'];
                $imagePath = "../uploads/courses/" . $imageName;
                if (!move_uploaded_file($imageTmp, $imagePath)) {
                    throw new Exception("Error al subir la imagen del curso.");
                }
            }
    
            if (!isset($_POST['levels']) || !is_array($_POST['levels'])) {
                throw new Exception("Debe incluir al menos un nivel.");
            }
            $levels = $_POST['levels'];
            $processedLevels = [];
            foreach ($levels as $index => $level) {
                if (empty($level['title']) || empty($level['description']) || empty($level['price'])) {
                    throw new Exception("Datos incompletos en el nivel $index.");
                }
    
                $videoPath = null;
                if (isset($_FILES["levels"]["tmp_name"][$index]["video"])) {
                    $videoTmp = $_FILES["levels"]["tmp_name"][$index]["video"];
                    $videoName = time() . '_level' . $index . '_' . $_FILES["levels"]["name"][$index]["video"];
                    $videoPath = "../uploads/levels/" . $videoName;
                    if (!move_uploaded_file($videoTmp, $videoPath)) {
                        throw new Exception("Error al subir el video del nivel $index.");
                    }
                }
    
                $filesPaths = [];
                if (isset($_FILES["levels"]["tmp_name"][$index]["files"]) && is_array($_FILES["levels"]["tmp_name"][$index]["files"])) {
                    foreach ($_FILES["levels"]["tmp_name"][$index]["files"] as $key => $fileTmp) {
                        $fileName = time() . '_level' . $index . '_' . basename($_FILES["levels"]["name"][$index]["files"][$key]);
                        $filePath = "../uploads/levels/files/" . $fileName;
                        
                        if (!move_uploaded_file($fileTmp, $filePath)) {
                            throw new Exception("Error al subir el archivo extra del nivel $index.");
                        }
                    
                        $filesPaths[] = $filePath; // Guardamos el archivo en el array
                    }
                }
    
                $processedLevels[] = [
                    'title' => $level['title'],
                    'description' => $level['description'],
                    'price' => $level['price'],
                    'video' => $videoPath,
                    'files' => $filesPaths, // Guardamos los archivos adicionales (si existen)
                ];
            }
    
            $resultado = CourseClass::createCourse($id_instructor, $title, $description, $category, $price, $imagePath, $processedLevels);
    
            if ($resultado['error']) {
                throw new Exception($resultado['message']);
            }
    
            echo json_encode(["success" => true, "newCourseId" => $resultado['id']]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        exit;
    }   elseif ($option == 'updateCourse') {
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
    } elseif ($option == 'getAllCourses') { 
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
    } elseif ($option == 'deleteCourse') { 
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
