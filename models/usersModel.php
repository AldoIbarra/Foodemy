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
                $consultaInsert->execute([
                    ':name'=>$name,
                    ':gender'=>$gender,
                    ':bornDate'=>$bornDate,
                    ':photo'=>$photo,
                    ':email'=>$email,
                    ':password'=>$password,
                    ':userType'=>$userType
                ]);
        
                return [true, "Usuario registrado correctamente."];
            
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) { // Código de error para clave duplicada
                    return [false, "El usuario ya existe."];
                } else {
                    return [false, "Error al agregar usuario: " . $e->getMessage()];
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

                    if ($_SESSION['Foto_Perfil']) {
                        // Convierte el contenido BLOB de la foto a Base64
                        $_SESSION['Foto_Perfil'] = base64_encode($_SESSION['Foto_Perfil']);
                    }
                
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

        static function getAllUsersExcept($id_admin) {
            self::initializeConnection();
        
            try {
                // Ejemplo para procesar el campo BLOB a Base64
            $sqlSelectUsuarios = "SELECT * FROM Usuario WHERE ID_Usuario != :id_admin;";
            $consultaSelectUsuarios = self::$connection->prepare($sqlSelectUsuarios);
            $consultaSelectUsuarios->execute(array(':id_admin'=>$id_admin));
            $usuarios = $consultaSelectUsuarios->fetchAll(PDO::FETCH_ASSOC);

            // Procesar la foto para convertirla en una cadena Base64
            foreach ($usuarios as &$usuario) {
                if ($usuario['Foto_Perfil']) {
                    // Convierte el contenido BLOB de la foto a Base64
                    $usuario['Foto_Perfil'] = base64_encode($usuario['Foto_Perfil']);
                }
            }

            return [true, $usuarios];

        
            } catch (PDOException $e) {
                error_log("Error al obtener los usuarios: " . $e->getMessage()); // Registrar el error
                return [false, "Error al obtener los usuarios: " . $e->getMessage()];
            }
        }
        

        static function blockUser($id_usuario) {
            self::initializeConnection();
            
            try {
                // Verificar si el usuario existe
                $user = UserClass::getUserById($id_usuario);
                if (!$user) {
                    return [false, "El usuario con ID $id_usuario no existe."];
                }
        
                // Alternar estatus
                $value = $user["Estatus"] == 1 ? 0 : 1;
        
                // Ejecutar procedimiento almacenado
                $sql = "CALL Gestionar_Estatus_Usuario(:id_usuario, :value);";
                $consulta = self::$connection->prepare($sql);
                $consulta->execute([
                    ':id_usuario' => $id_usuario,
                    ':value' => $value
                ]);
        
                return [true, "Estado del usuario actualizado con éxito"];
            } catch (PDOException $e) {
                error_log("Error al bloquear/desbloquear usuario: " . $e->getMessage());
                return [false, "Error al bloquear/desbloquear usuario: " . $e->getMessage()];
            }
        }


        static function getTeachersByStudentId($StudentId) {
            self::initializeConnection();
        
            try {
                $sqlSelect = "CALL ObtenerInstructoresPorEstudiante(:StudentId);"; 
                $consultaSelect = self::$connection->prepare($sqlSelect);
                $consultaSelect->execute([':StudentId'=>$StudentId]);
                $teachers = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);

                foreach ($teachers as &$teacher) {
                    if ($teacher['Foto_Estudiante']) {
                        $teacher['Foto_Estudiante'] = base64_encode($teacher['Foto_Estudiante']);
                    }
                    if ($teacher['Foto_Instructor']) {
                        $teacher['Foto_Instructor'] = base64_encode($teacher['Foto_Instructor']);
                    }
                }
        
                return [true, $teachers];
            } catch (PDOException $e) {
                return array(false, "Error al obtener instructores: " . $e->getMessage());
            }
        }


        static function getStudentsByTeacherId($TeacherId) {
            self::initializeConnection();
        
            try {
                $sqlSelect = "CALL ObtenerEstudiantesPorInstructor(:TeacherId);"; 
                $consultaSelect = self::$connection->prepare($sqlSelect);
                $consultaSelect->execute([':TeacherId'=>$TeacherId]);
                $students = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);

                foreach ($students as &$student) {
                    if ($student['Foto_Estudiante']) {
                        $student['Foto_Estudiante'] = base64_encode($student['Foto_Estudiante']);
                    }
                    if ($student['Foto_Instructor']) {
                        $student['Foto_Instructor'] = base64_encode($student['Foto_Instructor']);
                    }
                }
        
                return [true, $students];
            } catch (PDOException $e) {
                return array(false, "Error al obtener instructores: " . $e->getMessage());
            }
        }


        static function getMessagesBetweenUsers($userId, $user2Id) {
            self::initializeConnection();
        
            try {
                $sqlSelect = "CALL ObtenerMensajesEntreUsuarios(:userId, :user2Id);"; 
                $consultaSelect = self::$connection->prepare($sqlSelect);
                $consultaSelect->execute([':userId'=>$userId, ':user2Id'=>$user2Id]);
                $messages = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);
        
                return [true, $messages];
            } catch (PDOException $e) {
                return array(false, "Error al obtener instructores: " . $e->getMessage());
            }
        }
    
        static function sendMsg($emmiter, $receiver, $message){
            self::initializeConnection();
            
            try{
                $sqlInsert="CALL AgregarMensaje(:emmiter, :receiver, :message);";
                $consultaInsert= self::$connection->prepare($sqlInsert);
                $consultaInsert->execute([
                    ':emmiter'=>$emmiter,
                    ':receiver'=>$receiver,
                    ':message'=>$message
                ]);
        
                return [true, "Mensaje enviado."];
            
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) { // Código de error para clave duplicada
                    return [false, "El usuario ya existe."];
                } else {
                    return [false, "Error al agregar usuario: " . $e->getMessage()];
                }
            }
        }


        static function getStudentKardex($studentId, $categoryId, $courseStatus, $dateIni, $dateFin) {
            self::initializeConnection();
        
            try {
                $sqlSelect = "CALL ObtenerCursosAlumno(:studentId, :categoryId, :courseStatus, :dateIni, :dateFin);"; 
                $consultaSelect = self::$connection->prepare($sqlSelect);
                $consultaSelect->execute([':studentId'=>$studentId, ':categoryId'=>$categoryId, ':courseStatus'=>$courseStatus, ':dateIni'=>$dateIni, ':dateFin'=>$dateFin]);
                $courses = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);
        
                return [true, $courses];
            } catch (PDOException $e) {
                return array(false, "Error al obtener instructores: " . $e->getMessage());
            }
        }


        static function getSalesReport($teacherId, $categoryId, $dateIni, $dateFin) {
            self::initializeConnection();
        
            try {
                $sqlSelect = "CALL ReporteVentasInstructor (:teacherId, :dateIni, :dateFin, :categoryId);"; 
                $consultaSelect = self::$connection->prepare($sqlSelect);
                $consultaSelect->execute([':teacherId'=>$teacherId, ':dateIni'=>$dateIni, ':dateFin'=>$dateFin, ':categoryId'=>$categoryId]);
                $courses = $consultaSelect->fetchAll(PDO::FETCH_ASSOC);
        
                return [true, $courses];
            } catch (PDOException $e) {
                return array(false, "Error al obtener instructores: " . $e->getMessage());
            }
        }

    }
?>