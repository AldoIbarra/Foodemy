<?php
    include_once '../config/bd_conexion.php';
    session_start();

    class CategoryClass{

        public static $connection;
    
        public static function initializeConnection() {
            self::$connection = BD::createInstance();
        }
    
        static function createCategory($id_admin, $title, $description){
            self::initializeConnection();
            
            try {
                // Verificar si el título ya existe usando la función
                $sqlCheck = "SELECT fn_categoria_duplicada(:title) AS Existe;";
                $stmtCheck = self::$connection->prepare($sqlCheck);
                $stmtCheck->execute(array(':title' => $title));
                $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
                // Validar que se haya obtenido un resultado
                if ($resultCheck && $resultCheck['Existe']) {
                    return array("error" => true, "message" => "El título de la categoría ya existe.");
                }
        
                // Insertar la categoría si no existe
                $sqlInsert = "CALL CrearCategoria(:id_admin, :title, :description);";
                $stmtInsert = self::$connection->prepare($sqlInsert);
                $stmtInsert->execute(array(
                    ':id_admin' => $id_admin,
                    ':title' => $title,
                    ':description' => $description
                ));
        
                $lastInsertId = self::$connection->lastInsertId();
        
                return array("error" => false, "message" => "Categoría creada con éxito.", "id" => $lastInsertId);
        
            } catch (PDOException $e) {
                return array("error" => true, "message" => "Error al crear la categoría: " . $e->getMessage());
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