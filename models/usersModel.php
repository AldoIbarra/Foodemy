<?php
    include_once '../config/bd_conexion.php';
    session_start();

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
    
        static function logIn($email, $password){
            self::initializeConnection();
            
            try{
                $sqlInsert="CALL Consultar_Usuario_Por_Correo(:email);";
                $consultaInsert= self::$connection->prepare($sqlInsert);
                $consultaInsert->execute(array(
                    ':email'=>$email
                ));

                $user = $consultaInsert->fetch();

                if(!$user) {
                    echo "error en correo";
                    return false;
                }

                if($password == $user["Contrasena"]){
                    $_SESSION['ID_Usuario']=$user["ID_Usuario"];
                    $_SESSION['Nombre_Completo']=$user["Nombre_Completo"];
                    $_SESSION['Genero']=$user["Genero"];
                    $_SESSION['Fecha_Nacimiento']=$user["Fecha_Nacimiento"];
                    $_SESSION['Foto_Perfil']=$user["Foto_Perfil"];
                    $_SESSION['Correo_Electronico']=$user["Correo_Electronico"];
                    $_SESSION['Estatus']=$user["Estatus"];
                    $_SESSION['Fecha_Registro']=$user["Fecha_Registro"];
                    $_SESSION['Fecha_Actualizacion']=$user["Fecha_Actualizacion"];
                    $_SESSION['Rol']=$user["Rol"];
                }
            
            }catch(PDOException $e){
                if ($e->errorInfo[1] == 1062) {
                    $cadena = "El usuario ya ha sido agregado.";
                    return array(false, $cadena);
                } else {
                    return array(false, "Error al agregar usuario: " . $e->getMessage());
                }
            }
            return $user;
        }
    }
?>