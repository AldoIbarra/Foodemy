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
        header('Content-Type: application/json');

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

            //Verificar si ya existe un curso con ese título
            $resultado1 = CourseClass::verifyCourse($title);
            if ($resultado1['error']) {
                throw new Exception($resultado1['message']);
            }
    
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
    
            ob_clean(); 
            http_response_code(200);
            echo json_encode(["success" => true, "newCourseId" => $resultado['id']]);
        } catch (Exception $e) {
            ob_clean();
            http_response_code(400);
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        exit;
    }   elseif ($option == 'updateCourse') {
        


    } elseif ($option == 'getCoursesById') { 

        if (!isset($_SESSION['ID_Usuario'])) {
            throw new Exception("Usuario no autenticado.");
        }
        $id_instructor = $_SESSION['ID_Usuario'];

        // Lógica para obtener todas las categorías con id específico
        $resultadoFuncion = CourseClass::getCoursesById($id_instructor); 

        if ($resultadoFuncion[0]) {
            ob_clean(); 
            http_response_code(200);
            echo json_encode(["success" => true, "courses" => $resultadoFuncion[1]]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error al obtener los cursos: " . $resultadoFuncion[1]]);
        }
        exit;
    } elseif ($option == 'deleteCourse') { 
        header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON
    
        // Lógica para eliminar el curso seleccionado
        $id_course = $_POST['id_course'];
    
        if (empty($id_course) || !is_numeric($id_course)) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "ID de curso inválido."]);
            exit;
        }
        
        $resultadoFuncion = CourseClass::deleteCourse($id_course); 
    
        if ($resultadoFuncion[0]) { 
            ob_clean();
            http_response_code(200); 
            echo json_encode(["success" => true, "message" => "Curso eliminado con éxito."]); 
        } else { 
            ob_clean();
            http_response_code(400); 
            echo json_encode(["success" => false, "message" => $resultadoFuncion[1]]); 
        } 
        exit;
    } elseif ($option == 'getCourseById') {
        header('Content-Type: application/json'); // Especificamos que la respuesta será en formato JSON
    
        try {
            // Verificamos que el ID del curso esté presente
            if (!isset($_POST['id_curso']) && !isset($_GET['id_curso'])) {
                throw new Exception("ID del curso no proporcionado.");
            }
    
            // Obtenemos el ID del curso desde el POST o GET
            $id_curso = isset($_POST['id_curso']) ? $_POST['id_curso'] : $_GET['id_curso'];
    
            // Llamamos al modelo para obtener la información del curso
            $course = CourseClass::getCourseById($id_curso);
    
            if ($course) {
                ob_clean();
                // Si el curso existe, devolvemos los datos en formato JSON
                echo json_encode([
                    "success" => true,
                    "course" => $course
                ]);
            } else {
                ob_clean();
                // Si el curso no existe, respondemos con un mensaje de error
                echo json_encode([
                    "success" => false,
                    "message" => "No se encontró el curso con ID: $id_curso"
                ]);
            }
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos el mensaje de error
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        exit;
    } elseif ($option == 'searchCourses') {
        header('Content-Type: application/json'); // Especificamos que la respuesta será en formato JSON
    
        try {
            $query = $_GET['query'] ?? ''; 
            $category = $_GET['category'] ?? ''; 
            $startDate = $_GET['startDate'] ?? ''; 
            $endDate = $_GET['endDate'] ?? ''; 
            // Llama a la función del modelo para obtener los cursos filtrados
            $courses = CourseClass::searchCourses($query, $category, $startDate, $endDate);
            
            if ($courses) {
                ob_clean();
                echo json_encode([
                    "success" => true,
                    "courses" => $courses // Cambié "course" a "courses" para reflejar que puede haber varios
                ]);
            } else {
                ob_clean();
                echo json_encode([
                    "success" => false,
                    "message" => "No se encontraron cursos" // Cambié el mensaje para pluralizar
                ]);
            }
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos el mensaje de error
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        exit;
    } elseif ($option == 'getAllCourses') {
        ob_clean(); 
        try {
            $resultadoFuncion = CourseClass::getAllCourses(); 
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
        
    } else {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Opción no válida"]);
        exit;
    }
    
     
?>
