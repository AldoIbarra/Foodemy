<?php
    include_once '../config/bd_conexion.php';

    class UserClass{

        public static $connection;
    
        public static function initializeConnection() {
            self::$connection = BD::createInstance();
        }
    
        static function signUp($name, $gender, $bornDate, $photo, $email, $password, $userType){
            self::initializeConnection();
            
            try{
                $sqlInsert="CALL Crear_Usuario(:name, :gender, :bornDate, :photo, :email, :password, :userType);";
                $consultaInsert= self::$connection->prepare($sqlInsert);
                $consultaInsert->execute(array(
                    ':name'=>$name,
                    ':gender'=>$gender,
                    ':bornDate'=>$bornDate,
                    ':photo'=>$photo,
                    ':email'=>$email,
                    ':password'=>$password,
                    ':userType'=>$userType
                ));
        
                return array(true,"insertado con exito");
            
            }catch(PDOException $e){
                if ($e->errorInfo[1] == 1062) {
                    $cadena = "El usuario ya ha sido agregado.";
                    return array(false, $cadena);
                } else {
                    return array(false, "Error al agregar usuario: " . $e->getMessage());
                }
            }
        }
    }
?>