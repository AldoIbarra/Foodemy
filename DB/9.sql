DELIMITER //

CREATE FUNCTION VerificarCompraCurso(
    p_ID_Usuario_Estudiante INT,
    p_ID_Curso INT
) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE cursoComprado BOOLEAN;

    -- Comprobar si el curso fue comprado
    SELECT COUNT(*) > 0 
    INTO cursoComprado
    FROM Cursos_Vendidos_Comprados
    WHERE ID_Usuario_Estudiante = p_ID_Usuario_Estudiante
      AND ID_Curso = p_ID_Curso;

    RETURN cursoComprado;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE AgregarComentario(
    IN p_ID_Curso INT,
    IN p_ID_Usuario_Estudiante INT,
    IN p_Texto TEXT,
    IN p_Calificacion DECIMAL(3, 2)
)
BEGIN
    -- Insertar el comentario en la tabla
    INSERT INTO Comentario (
        ID_Curso, 
        ID_Usuario_Estudiante, 
        Texto, 
        Calificacion, 
        Estatus, 
        Fecha_Hora_Creacion
    )
    VALUES (
        p_ID_Curso, 
        p_ID_Usuario_Estudiante, 
        p_Texto, 
        p_Calificacion, 
        1, -- Estatus por defecto (activo)
        NOW()
    );
END //

DELIMITER ;