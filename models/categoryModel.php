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
            
            try{
                $sqlInsert="CALL CrearCategoria(:id_admin, :title, :description);";
                $consultaInsert= self::$connection->prepare($sqlInsert);
                $consultaInsert->execute(array(
                    ':id_admin'=>$id_admin,
                    ':title'=>$title,
                    ':description'=>$description
                ));
        
                $lastInsertId = self::$connection->lastInsertId();  // Método para obtener el último ID insertado
        
                // Retornar éxito con el ID de la nueva categoría
                return array(true, "insertado con éxito", $lastInsertId);  // Incluimos el ID
            
            }catch(PDOException $e){
                if ($e->errorInfo[1] == 1062) {
                    $cadena = "Nueva Categoría agregada correctamente.";
                    return array(false, $cadena);
                } else {
                    return array(false, "Error al agregar usuario: " . $e->getMessage());
                }
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