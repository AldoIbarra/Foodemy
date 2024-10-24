-- SP para Consultar Usuarios
DELIMITER //
CREATE PROCEDURE Consultar_Usuario_Por_Correo(
    IN p_Correo_Electronico VARCHAR(255)
)
BEGIN
    SELECT 
        ID_Usuario, Nombre_Completo, Genero, Fecha_Nacimiento, 
        Foto_Perfil, Correo_Electronico, Estatus, Fecha_Registro, 
        Fecha_Actualizacion, Rol, Contrasena
    FROM Usuario
    WHERE Correo_Electronico = p_Correo_Electronico;
END //
DELIMITER ;