DELIMITER $$

CREATE PROCEDURE ObtenerCursosAlumno (
    IN p_IdAlumno INT,
    IN p_IdCategoria INT,
    IN p_EstatusCurso INT,
    IN p_FechaInicio DATE,
    IN p_FechaFin DATE
)
BEGIN
    SELECT 
        c.ID_Curso AS IdCurso,
        c.Titulo AS Curso,
        cv.Fecha_Inscripcion,
        cv.Fecha_Terminacion,
        cv.Estatus_Curso,
        cat.Titulo AS Categoria
    FROM 
        Cursos_Vendidos_Comprados cv
    INNER JOIN 
        Curso c ON cv.ID_Curso = c.ID_Curso
    INNER JOIN 
        Categoria cat ON c.ID_Categoria = cat.ID_Categoria
    WHERE 
        cv.ID_Usuario_Estudiante = p_IdAlumno
        AND (p_IdCategoria IS NULL OR c.ID_Categoria = p_IdCategoria)
        AND (p_EstatusCurso IS NULL OR cv.Estatus_Curso = 
             CASE p_EstatusCurso
                 WHEN 1 THEN 'Nuevo'
                 WHEN 2 THEN 'En proceso'
                 WHEN 3 THEN 'Terminado'
             END
        )
        AND (
            (p_FechaInicio IS NULL AND p_FechaFin IS NULL) OR 
            (p_FechaInicio IS NULL AND cv.Fecha_Inscripcion <= p_FechaFin) OR
            (p_FechaFin IS NULL AND cv.Fecha_Inscripcion >= p_FechaInicio) OR
            (cv.Fecha_Inscripcion BETWEEN p_FechaInicio AND p_FechaFin)
        );
END$$

DELIMITER ;
