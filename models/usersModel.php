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
                $consultaInsert->execute([':email' => $email]);
                $user = $consultaInsert->fetch();
                $consultaInsert->closeCursor();

                if(!$user) {
                    return ["success" => false, "message" => "Correo no encontrado"];
                }

                // Verificar si el usuario está deshabilitado
                if ($user["Estatus"] == 0) {
                    return ["success" => false, "message" => "Usuario deshabilitado por intentos fallidos."];
                }
            
                if ($password == $user["Contrasena"]) {
                    // Contraseña correcta, reiniciar intentos fallidos
                    $sqlResetAttempts = "CALL Actualizar_Intentos_Usuario(:id_usuario, :intento_fallido);";
                    $resetAttempts = self::$connection->prepare($sqlResetAttempts);
                    $resetAttempts->execute([
                        ':id_usuario' => $user["ID_Usuario"],
                        ':intento_fallido' => 0 // Reiniciar intentos
                    ]);
                
                    // Iniciar sesión
                    $_SESSION['ID_Usuario'] = $user["ID_Usuario"];
                    $_SESSION['Nombre_Completo'] = $user["Nombre_Completo"];
                    $_SESSION['Genero'] = $user["Genero"];
                    $_SESSION['Fecha_Nacimiento'] = $user["Fecha_Nacimiento"];
                    $_SESSION['Foto_Perfil'] = $user["Foto_Perfil"];
                    $_SESSION['Correo_Electronico'] = $user["Correo_Electronico"];
                    $_SESSION['Estatus'] = $user["Estatus"];
                    $_SESSION['Fecha_Registro'] = $user["Fecha_Registro"];
                    $_SESSION['Fecha_Actualizacion'] = $user["Fecha_Actualizacion"];
                    $_SESSION['Rol'] = $user["Rol"];
                
                    return ["success" => true, "message" => "Inicio de sesión exitoso"];
                } else {
                    // Contraseña incorrecta, incrementar intentos
                    $sqlIncrementAttempts = "CALL Actualizar_Intentos_Usuario(:id_usuario, :intento_fallido);";
                    $incrementAttempts = self::$connection->prepare($sqlIncrementAttempts);
                    $incrementAttempts->execute([
                        ':id_usuario' => $user["ID_Usuario"],
                        ':intento_fallido' => true // Incrementar intentos
                    ]);
                
                    // Consultar nuevamente los intentos actualizados
                    $sqlCheckAttempts = "SELECT Intentos FROM Usuario WHERE ID_Usuario = :id_usuario;";
                    $checkAttempts = self::$connection->prepare($sqlCheckAttempts);
                    $checkAttempts->execute([':id_usuario' => $user["ID_Usuario"]]);
                    $updatedUser = $checkAttempts->fetch();
                
                    if ($updatedUser["Intentos"] >= 3) {
                        // Deshabilitar usuario si tiene 3 o más intentos fallidos
                        $sqlDisableUser = "CALL Gestionar_Estatus_Usuario(:id_usuario, :habilitar);";
                        $disableUser = self::$connection->prepare($sqlDisableUser);
                        $disableUser->execute([
                            ':id_usuario' => $user["ID_Usuario"],
                            ':habilitar' => 0 // Deshabilitar usuario
                        ]);
                    
                        return ["success" => false, "message" => "Usuario deshabilitado por superar los intentos fallidos."];
                    }
                
                    return ["success" => false, "message" => "Contraseña incorrecta. Intentos fallidos: " . $updatedUser["Intentos"]];
                }
            } catch (PDOException $e) {
                return ["success" => false, "message" => "Error en el sistema: " . $e->getMessage()];
            }
        }
    
        static function updateInfo($id, $name, $gender, $bornDate){
            self::initializeConnection();
            
            try{
                $sqlInsert="CALL Actualizar_Basicos_Usuario(:id, :name, :gender, :bornDate);";
                $consultaInsert= self::$connection->prepare($sqlInsert);
                $consultaInsert->execute(array(
                    ':id'=>$id,
                    ':name'=>$name,
                    ':gender'=>$gender,
                    ':bornDate'=>$bornDate
                ));

                $user = UserClass::getUserById($id);
                
                $_SESSION['Nombre_Completo']=$user["Nombre_Completo"];
                $_SESSION['Genero']=$user["Genero"];
                $_SESSION['Fecha_Nacimiento']=$user["Fecha_Nacimiento"];
        
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

        static function getUserById($id){
            
            self::initializeConnection();
            $sqlInsert="CALL Consultar_Usuario(:id);";
            $consultaInsert= self::$connection->prepare($sqlInsert);
            $consultaInsert->execute(array(
                ':id'=>$id
            ));
        
            $usuario = $consultaInsert->fetch(PDO::FETCH_ASSOC);
            
        
            if(!$usuario) {
               return null;
            }else{
                return $usuario;
            }
        }
    }
?>