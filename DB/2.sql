ALTER TABLE Usuario MODIFY Foto_Perfil LONGBLOB;

ALTER TABLE Curso MODIFY Imagen LONGBLOB;

DROP PROCEDURE Crear_Usuario;

--SP para crear usuario
DELIMITER //
CREATE PROCEDURE Crear_Usuario(
    IN p_Nombre_Completo VARCHAR(255),
    IN p_Genero VARCHAR(50),
    IN p_Fecha_Nacimiento DATE,
    IN p_Foto_Perfil LONGBLOB,
    IN p_Correo_Electronico VARCHAR(255),
    IN p_Contrasena VARCHAR(255),
    IN p_Rol VARCHAR(50)
)
BEGIN
    INSERT INTO Usuario (
        Nombre_Completo, Genero, Fecha_Nacimiento, Foto_Perfil, 
        Correo_Electronico, Estatus, Contrasena, Rol
    ) VALUES (
        p_Nombre_Completo, p_Genero, p_Fecha_Nacimiento, p_Foto_Perfil, 
        p_Correo_Electronico, 1, p_Contrasena, p_Rol
    );
END //
DELIMITER ;

DROP PROCEDURE Actualizar_Usuario;


-- SP para Actualizar Usuarios
DELIMITER //
CREATE PROCEDURE Actualizar_Usuario(
    IN p_ID_Usuario INT,
    IN p_Nombre_Completo VARCHAR(255),
    IN p_Genero VARCHAR(50),
    IN p_Fecha_Nacimiento DATE,
    IN p_Foto_Perfil LONGBLOB,
    IN p_Correo_Electronico VARCHAR(255),
    IN p_Contrasena VARCHAR(255)
    -- IN p_Rol VARCHAR(50)
)
BEGIN
    UPDATE Usuario
    SET 
        Nombre_Completo = p_Nombre_Completo,
        Genero = p_Genero,
        Fecha_Nacimiento = p_Fecha_Nacimiento,
        Foto_Perfil = p_Foto_Perfil,
        Correo_Electronico = p_Correo_Electronico,
        Contrasena = p_Contrasena,
        Fecha_Actualizacion = CURRENT_TIMESTAMP
    WHERE ID_Usuario = p_ID_Usuario;
END //
DELIMITER ;