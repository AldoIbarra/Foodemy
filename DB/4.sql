-- SP para Actualizar Basicos Usuarios
DELIMITER //
CREATE PROCEDURE Actualizar_Basicos_Usuario(
    IN p_ID_Usuario INT,
    IN p_Nombre_Completo VARCHAR(100),
    IN p_Genero VARCHAR(50),
    IN p_Fecha_Nacimiento DATE
)
BEGIN
    UPDATE Usuario
    SET 
        Nombre_Completo = p_Nombre_Completo,
        Genero = p_Genero,
        Fecha_Nacimiento = p_Fecha_Nacimiento,
        Fecha_Actualizacion = CURRENT_TIMESTAMP
    WHERE ID_Usuario = p_ID_Usuario;
END //
DELIMITER ;