<?php
    include_once '../config/bd_conexion.php';
    session_start();

    class CourseClass{

        public static $connection;
    
        public static function initializeConnection() {
            self::$connection = BD::createInstance();
        }
    
        static function createCourse($id_instructor, $title, $description, $category, $price, $imagePath, $levels) {
            self::initializeConnection();
    
            try {
                self::$connection->beginTransaction();

                // Insertar el curso
                $sqlCourse = "INSERT INTO Curso (ID_Categoria, ID_Usuario_Instructor, Titulo, Descripcion, Estatus, Imagen, Precio) 
                              VALUES (:category, :id_instructor, :title, :description, :estatus, :image, :price)";
                $stmtCourse = self::$connection->prepare($sqlCourse);
                $stmtCourse->execute([
                    ':category' => $category,
                    ':id_instructor' => $id_instructor,
                    ':title' => $title,
                    ':description' => $description,
                    ':estatus' => 1,
                    ':image' => $imagePath,
                    ':price' => $price,
                ]);
    
                $courseId = self::$connection->lastInsertId();
    
                // Insertar los niveles
                $sqlLevel = "INSERT INTO Nivel (ID_Curso, Titulo, Descripcion, Precio, Video) 
                             VALUES (:course_id, :title, :description, :price, :video)";
                $stmtLevel = self::$connection->prepare($sqlLevel);
                foreach ($levels as $level) {
                    $stmtLevel->execute([
                        ':course_id' => $courseId,
                        ':title' => $level['title'],
                        ':description' => $level['description'],
                        ':price' => $level['price'],
                        ':video' => $level['video'],
                    ]);
    
                    $levelId = self::$connection->lastInsertId(); // Obtener el ID del nivel insertado
    
                    // Guardar archivos adicionales
                    if (!empty($level['files'])) {
                        $sqlFile = "INSERT INTO Nivel_Archivo (ID_Nivel, Archivo) VALUES (:level_id, :file)";
                        $stmtFile = self::$connection->prepare($sqlFile);
                        foreach ($level['files'] as $filePath) {
                            if (!$stmtFile->execute([
                                ':level_id' => $levelId,
                                ':file' => $filePath,
                            ])) {
                                throw new Exception("Error al insertar archivo en la base de datos.");
                            }
                        }
                    }
                }
    
                self::$connection->commit();
    
                return ["error" => false, "id" => $courseId];
            } catch (PDOException $e) {
                self::$connection->rollBack();
                return ["error" => true, "message" => "Error al crear el curso: " . $e->getMessage()];
            }
        }


        static function verifyCourse($title) {
            self::initializeConnection();
    
            try {
                // Verificar si el título ya existe usando la función
                $sqlCheck = "SELECT fn_curso_duplicado(:title) AS Existe;";
                $stmtCheck = self::$connection->prepare($sqlCheck);
                $stmtCheck->execute(array(':title' => $title));
                $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
                // Validar que se haya obtenido un resultado
                if ($resultCheck && $resultCheck['Existe']) {
                    return array("error" => true, "message" => "Ya existe un curso con este título.");
                }
    
                return ["error" => false, "id" => $title];
            } catch (PDOException $e) {
                self::$connection->rollBack();
                return ["error" => true, "message" => "Error al crear el curso: " . $e->getMessage()];
            }
        }
        
    
        static function updateCategory($id_category, $title, $description){
            
        }


        static function getCoursesById($id_instructor) {
            self::initializeConnection();
        
            try {
                $sqlCourse = "SELECT * FROM Vista_Cursos_Instructor WHERE Instructor_ID = :id_instructor AND Curso_Estatus != 0;";
                $stmtCourse = self::$connection->prepare($sqlCourse);
                $stmtCourse->execute([
                    ':id_instructor' => $id_instructor,
                ]);
                $courses = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);
                foreach ($courses as &$course) {
                    $course['Curso_Imagen'] = str_replace("pages/", "", $course['Curso_Imagen']);
                }
                
        
                if ($courses) {
                    return [true, $courses]; // Retorna los cursos obtenidos
                } else {
                    return [false, "No se encontraron cursos para este instructor."];
                }
            } catch (PDOException $e) {
                return array(false, "Error al obtener los cursos del instructor: " . $e->getMessage());
            }
        }

        static function deleteCourse($id_course) {
            self::initializeConnection();
        
            try {
                $sqlCheck = "SELECT COUNT(*) FROM Curso WHERE ID_Curso = :id_course";
                $consultaCheck = self::$connection->prepare($sqlCheck);
                $consultaCheck->execute([':id_course' => $id_course]);
                if ($consultaCheck->fetchColumn() == 0) {
                    return array(false, "El curso no existe o ya ha sido eliminado.");
                }

                $sqlInsert = "UPDATE Curso SET Estatus = 0 WHERE ID_Curso = :id_course;"; 
                $consultaInsert = self::$connection->prepare($sqlInsert);
                $consultaInsert->execute(array(
                    ':id_course'=>$id_course
                ));
                
        
                return array(true,"Curso eliminado con éxito");
            }catch(PDOException $e){
                if ($e->errorInfo[1] == 1062) {
                    $cadena = "El Curso ya ha sido eliminado.";
                    return array(false, $cadena);
                } else {
                    return array(false, "Error al agregar usuario: " . $e->getMessage());
                }
            }
        }

        
            static function getCourseById($id_curso) {
                self::initializeConnection(); // Asegurarse de que la conexión está inicializada
        
                try {
                    // Consulta principal para obtener la información básica del curso
                    $query = "
                    SELECT 
                        c.ID_Curso,
                        c.Titulo AS Curso_Titulo,
                        c.Descripcion AS Curso_Descripcion,
                        c.Imagen AS Curso_Imagen,
                        c.Precio AS Curso_Precio,
                        c.Fecha_Creacion_Curso,
                        c.Estatus AS Curso_Estatus,
                        u.ID_Usuario AS Instructor_ID,
                        u.Nombre_Completo AS Instructor_Nombre,
                        cat.Titulo AS Categoria_Titulo,
                        COUNT(DISTINCT n.ID_Nivel) AS Total_Niveles,
                        AVG(com.Calificacion) AS Promedio_Calificacion,
                        COUNT(DISTINCT cv.ID_Ventas) AS Total_Ventas
                    FROM 
                        Curso c
                    JOIN 
                        Usuario u ON c.ID_Usuario_Instructor = u.ID_Usuario
                    JOIN 
                        Categoria cat ON c.ID_Categoria = cat.ID_Categoria
                    LEFT JOIN 
                        Nivel n ON c.ID_Curso = n.ID_Curso
                    LEFT JOIN 
                        Comentario com ON c.ID_Curso = com.ID_Curso
                    LEFT JOIN 
                        Cursos_Vendidos_Comprados cv ON c.ID_Curso = cv.ID_Curso
                    WHERE 
                        c.ID_Curso = :id
                    GROUP BY 
                        c.ID_Curso
                    ";
        
                    // Ejecutamos la consulta
                    $stmt = self::$connection->prepare($query);
                    $stmt->execute([':id' => $id_curso]);
                    $course = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    if ($course) {
                        // Consultamos los niveles asociados al curso
                        $levelQuery = "
                        SELECT 
                            n.ID_Nivel,
                            n.Titulo AS Nivel_Titulo,
                            n.Descripcion AS Nivel_Descripcion,
                            n.Precio AS Nivel_Precio,
                            n.Video AS Nivel_Video
                        FROM 
                            Nivel n
                        WHERE 
                            n.ID_Curso = :id
                        ORDER BY 
                            n.ID_Nivel ASC
                        ";
                        $stmtLevel = self::$connection->prepare($levelQuery);
                        $stmtLevel->execute([':id' => $id_curso]);
                        $levels = $stmtLevel->fetchAll(PDO::FETCH_ASSOC);
        
                        // Para cada nivel, obtenemos los archivos extras si existen
                        foreach ($levels as &$level) {
                            $filesQuery = "
                            SELECT 
                                na.ID_Archivo,
                                na.Archivo AS Archivo_Ruta
                            FROM 
                                Nivel_Archivo na
                            WHERE 
                                na.ID_Nivel = :id_nivel
                            ";
                            $stmtFiles = self::$connection->prepare($filesQuery);
                            $stmtFiles->execute([':id_nivel' => $level['ID_Nivel']]);
                            $files = $stmtFiles->fetchAll(PDO::FETCH_ASSOC);
        
                            // Añadimos los archivos al nivel
                            if ($files) {
                                $level['archivos'] = $files;
                            }
                        }
        
                        // Añadimos los niveles al resultado del curso
                        $course['niveles'] = $levels;
        
                        // Consultamos los comentarios asociados al curso
                        $commentsQuery = "
                        SELECT 
                            com.ID_Comentario,
                            com.Texto AS Comentario_Texto,
                            com.Calificacion AS Comentario_Calificacion,
                            com.Fecha_Hora_Creacion AS Comentario_Fecha,
                            com.Estatus AS Comentario_Estatus,
                            com.Fecha_Eliminacion AS Comentario_Eliminacion,
                            com.Causa_Eliminacion AS Comentario_Causa,
                            u.Nombre_Completo AS Usuario_Nombre,
                            u.Foto_Perfil AS Usuario_Foto
                        FROM 
                            Comentario com
                        JOIN 
                            Usuario u ON com.ID_Usuario_Estudiante = u.ID_Usuario
                        WHERE 
                            com.ID_Curso = :id
                        ORDER BY 
                            com.Fecha_Hora_Creacion DESC
                        ";
                        $stmtComments = self::$connection->prepare($commentsQuery);
                        $stmtComments->execute([':id' => $id_curso]);
                        $comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);

                        // Reemplaza los valores NULL con algo más adecuado
                        foreach ($comments as &$comment) {
                            $comment['Comentario_Eliminacion'] = $comment['Comentario_Eliminacion'] ?? 'No Eliminado';
                            $comment['Comentario_Causa'] = $comment['Comentario_Causa'] ?? 'N/A';
                        }

                        // Procesa la foto del usuario (BLOB -> Base64)
                        foreach ($comments as &$comment) {
                            if ($comment['Usuario_Foto']) {
                                // Convierte el BLOB a Base64
                                $comment['Usuario_Foto'] = base64_encode($comment['Usuario_Foto']);
                            } else {
                                // Si no hay foto, puedes establecer un valor predeterminado
                                $comment['Usuario_Foto'] = 'ruta/a/imagen/default.jpg'; // o null si no deseas mostrar nada
                            }
                        }
        
                        // Depuración: Verificar la consulta de comentarios
                        error_log('Comentarios obtenidos: ' . print_r($comments, true));
        
                        // Añadimos los comentarios al resultado del curso
                        $course['comentarios'] = !empty($comments) ? $comments : [];
        
                        return $course;
                    } else {
                        return null; // Si no se encuentra el curso
                    }
                } catch (PDOException $e) {
                    return ["error" => true, "message" => "Error al obtener el curso: " . $e->getMessage()];
                }
            }

        
            static function searchCourses($query, $category, $startDate, $endDate) {
                self::initializeConnection();
            
                try {
                    $sql = "
                        SELECT 
                            c.ID_Curso,
                            c.Titulo AS Curso_Titulo,
                            c.Descripcion AS Curso_Descripcion,
                            c.Imagen AS Curso_Imagen,
                            c.Precio AS Curso_Precio,
                            c.Fecha_Creacion_Curso,
                            c.Estatus AS Curso_Estatus,
                            u.Nombre_Completo AS Instructor_Nombre,
                            cat.Titulo AS Categoria_Titulo,
                            COUNT(DISTINCT n.ID_Nivel) AS Total_Niveles,
                            AVG(com.Calificacion) AS Promedio_Calificacion,
                            COUNT(DISTINCT cv.ID_Ventas) AS Total_Ventas
                        FROM 
                            Curso c
                        JOIN 
                            Usuario u ON c.ID_Usuario_Instructor = u.ID_Usuario
                        JOIN 
                            Categoria cat ON c.ID_Categoria = cat.ID_Categoria
                        LEFT JOIN 
                            Nivel n ON c.ID_Curso = n.ID_Curso
                        LEFT JOIN 
                            Comentario com ON c.ID_Curso = com.ID_Curso
                        LEFT JOIN 
                            Cursos_Vendidos_Comprados cv ON c.ID_Curso = cv.ID_Curso
                        WHERE c.Estatus = 1 -- Filtrar solo los cursos activos
                    ";
                            
                    $params = [];
                            
                    // Filtrar por nombre del curso
                    if ($query) {
                        $sql .= " AND c.Titulo LIKE :query";
                        $params[':query'] = "%" . $query . "%";
                    }
                
                    // Filtrar por categoría
                    if ($category) {
                        $sql .= " AND c.ID_Categoria = :category";
                        $params[':category'] = $category;
                    }
                
                    // Filtrar por fechas
                    if ($startDate) {
                        $sql .= " AND DATE(c.Fecha_Creacion_Curso) >= :startDate";
                        $params[':startDate'] = $startDate;
                    }
                
                    if ($endDate) {
                        $sql .= " AND DATE(c.Fecha_Creacion_Curso) <= :endDate";
                        $params[':endDate'] = $endDate;
                    }
                
                    $sql .= " GROUP BY c.ID_Curso ORDER BY c.Fecha_Creacion_Curso DESC";
                
                    $stmt = self::$connection->prepare($sql);
                    $stmt->execute($params);
                
                    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna los resultados en forma de arreglo asociativo
                } catch (PDOException $e) {
                    error_log("Error al obtener los cursos: " . $e->getMessage());
                    return false;
                }
            }


            static function getAllCourses() {
                self::initializeConnection();
            
                try {
                    $sqlSelect = "CALL ObtenerTodosLosCursos();"; 
                    $consultaSelect = self::$connection->prepare($sqlSelect);
                    $consultaSelect->execute();
                    $cursos = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($cursos as &$curso) {
                        if ($curso['Foto_Perfil']) {
                            $curso['Foto_Perfil'] = base64_encode($curso['Foto_Perfil']);
                        }
                    }
            
                    return [true, $cursos];
                } catch (PDOException $e) {
                    return array(false, "Error al obtener cursos: " . $e->getMessage());
                }
            }
    
            static function buyCourse($ID_Usuario_Instructor, $ID_Usuario_Estudiante, $ID_Curso, $Total_Pagado, $Forma_Pago, $Curso_Comprado_Totalmente){
                self::initializeConnection();
                
                try{
                    $sqlInsert="CALL Comprar_Curso(:ID_Usuario_Instructor, :ID_Usuario_Estudiante, :ID_Curso, :Total_Pagado, :Forma_Pago, :Curso_Comprado_Totalmente);";
                    $consultaInsert= self::$connection->prepare($sqlInsert);
                    $consultaInsert->execute([
                        ':ID_Usuario_Instructor'=>$ID_Usuario_Instructor,
                        ':ID_Usuario_Estudiante'=>$ID_Usuario_Estudiante,
                        ':ID_Curso'=>$ID_Curso,
                        ':Total_Pagado'=>$Total_Pagado,
                        ':Forma_Pago'=>$Forma_Pago,
                        ':Curso_Comprado_Totalmente'=>$Curso_Comprado_Totalmente
                    ]);
            
                    return [true, "Usuario registrado correctamente."];
                
                } catch (PDOException $e) {
                    if ($e->errorInfo[1] == 1062) { // Código de error para clave duplicada
                        return [false, "Este usuario ya ha comprado este curso."];
                    } else {
                        return [false, "Error al comprar el curso: " . $e->getMessage()];
                    }
                }
            }

            static function doesStudentHaveCourse($userId, $courseId) {
                self::initializeConnection();
                try {
                    $sqlSelect = "SELECT VerificarCompraCurso(:userId, :courseId) AS CursoComprado;"; 
                    $consultaSelect = self::$connection->prepare($sqlSelect);
                    $consultaSelect->execute([':userId'=>$userId, ':courseId'=>$courseId]);
                    $result = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);
            
                    return [true, $result];
                } catch (PDOException $e) {
                    return array(false, "Error al obtener instructores: " . $e->getMessage());
                }
            }
    
            static function makeAComment($courseId, $userId, $comment, $rank){
                self::initializeConnection();
                
                try{
                    $sqlInsert="CALL AgregarComentario(:courseId, :userId, :comment, :rank);";
                    $consultaInsert= self::$connection->prepare($sqlInsert);
                    $consultaInsert->execute([
                        ':courseId'=>$courseId,
                        ':userId'=>$userId,
                        ':comment'=>$comment,
                        ':rank'=>$rank
                    ]);
            
                    return [true, "Comentario registrado."];
                
                } catch (PDOException $e) {
                    if ($e->errorInfo[1] == 1062) { // Código de error para clave duplicada
                        return [false, "El usuario ya existe."];
                    } else {
                        return [false, "Error al agregar usuario: " . $e->getMessage()];
                    }
                }
            }
    }
?>