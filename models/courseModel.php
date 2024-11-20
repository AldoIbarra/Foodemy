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
        
    
        static function updateCategory($id_category, $title, $description){
            self::initializeConnection();
            
            try{
                $sqlInsert="CALL EditarCategoria(:id_category, :title, :description);";
                $consultaInsert= self::$connection->prepare($sqlInsert);
                $consultaInsert->execute(array(
                    ':id_category'=>$id_category,
                    ':title'=>$title,
                    ':description'=>$description
                ));

                // $user = CategoryClass::getUserById($id_category);
                
                // $_SESSION['Nombre_Completo']=$user["Nombre_Completo"];
                // $_SESSION['Genero']=$user["Genero"];
                // $_SESSION['Fecha_Nacimiento']=$user["Fecha_Nacimiento"];
        
                return array(true,"Categoría actualizada con éxito");
            
            }catch(PDOException $e){
                if ($e->errorInfo[1] == 1062) {
                    $cadena = "La Categoría ya ha sido agregada.";
                    return array(false, $cadena);
                } else {
                    return array(false, "Error al agregar usuario: " . $e->getMessage());
                }
            }
        }


        static function getAllCategories() {
            self::initializeConnection();
        
            try {
                
                $sqlSelect = "CALL ObtenerTodasLasCategorias();"; 
                $consultaSelect = self::$connection->prepare($sqlSelect);
                $consultaSelect->execute();
                $categorias = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);
        
                return [true, $categorias];
            } catch (PDOException $e) {
                return array(false, "Error al obtener categorías: " . $e->getMessage());
            }
        }

        static function deleteCategory($id_category) {
            self::initializeConnection();
        
            try {
                $sqlInsert = "CALL EliminarCategoria(:id_category);"; 
                $consultaInsert = self::$connection->prepare($sqlInsert);
                $consultaInsert->execute(array(
                    ':id_category'=>$id_category
                ));
                
        
                return array(true,"Categoría eliminada con éxito");
            }catch(PDOException $e){
                if ($e->errorInfo[1] == 1062) {
                    $cadena = "La Categoría ya ha sido eliminada.";
                    return array(false, $cadena);
                } else {
                    return array(false, "Error al agregar usuario: " . $e->getMessage());
                }
            }
        }
        
        
    }
?>