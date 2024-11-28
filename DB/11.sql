DROP FUNCTION VerificarCompraCurso;

DELIMITER $$

CREATE PROCEDURE VerificarCompraYEstadoCurso(
    IN p_ID_Usuario_Estudiante INT,
    IN p_ID_Curso INT
)
BEGIN
    DECLARE cursoComprado TINYINT(1);
    DECLARE cursoTerminado TINYINT(1);

    -- Comprobar si el curso fue comprado
    SELECT COUNT(*) > 0 
    INTO cursoComprado
    FROM Cursos_Vendidos_Comprados
    WHERE ID_Usuario_Estudiante = p_ID_Usuario_Estudiante
      AND ID_Curso = p_ID_Curso;

    -- Comprobar si el curso fue terminado
    SELECT COUNT(*) > 0 
    INTO cursoTerminado
    FROM Cursos_Vendidos_Comprados
    WHERE ID_Usuario_Estudiante = p_ID_Usuario_Estudiante
      AND ID_Curso = p_ID_Curso
      AND Estatus_Curso = "Terminado"; -- Considerando que "2" es el estado para "Terminado"

    -- Devolver los resultados como una fila con dos columnas
    SELECT cursoComprado AS CursoComprado, cursoTerminado AS CursoTerminado;
END $$

DELIMITER ;




DELIMITER $$

CREATE PROCEDURE MarcarCursoComoTerminado (
    IN p_ID_Usuario_Estudiante INT,
    IN p_ID_Curso INT
)
BEGIN
    -- Actualizamos la fecha de terminación y el estatus del curso
    UPDATE Cursos_Vendidos_Comprados
    SET Estatus_Curso = 'Terminado',  -- Cambiar el estatus a 'Terminado'
        Fecha_Terminacion = CURDATE()  -- Establecer la fecha de terminación como la fecha actual
    WHERE ID_Usuario_Estudiante = p_ID_Usuario_Estudiante
      AND ID_Curso = p_ID_Curso
      AND Estatus_Curso <> 'Terminado';  -- Solo actualizar si el curso no está ya terminado

END $$

DELIMITER ;



DROP PROCEDURE ObtenerCursosAlumno;

DELIMITER $$

CREATE PROCEDURE ObtenerCursosAlumno (
    IN p_IdAlumno INT,
    IN p_IdCategoria INT,
    IN p_EstatusCurso VARCHAR(20),  -- Modificado para que reciba un string
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
        AND (p_EstatusCurso IS NULL OR cv.Estatus_Curso = p_EstatusCurso)  -- Filtra directamente por el estatus recibido
        AND (
            (p_FechaInicio IS NULL AND p_FechaFin IS NULL) OR 
            (p_FechaInicio IS NULL AND cv.Fecha_Inscripcion <= p_FechaFin) OR
            (p_FechaFin IS NULL AND cv.Fecha_Inscripcion >= p_FechaInicio) OR
            (cv.Fecha_Inscripcion BETWEEN p_FechaInicio AND p_FechaFin)
        );
END$$

DELIMITER ;