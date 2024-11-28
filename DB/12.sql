DELIMITER $$

CREATE PROCEDURE ReporteVentasInstructor (
    IN p_ID_Usuario_Instructor INT,
    IN p_Fecha_Inicio DATE,
    IN p_Fecha_Fin DATE,
    IN p_ID_Categoria INT
)
BEGIN
    SELECT 
        c.Titulo AS Nombre_Curso,
        COUNT(cv.ID_Usuario_Estudiante) AS Cantidad_Alumnos_Inscritos,
        SUM(cv.Total_Pagado) AS Total_Ingresos
    FROM 
        Curso c
    LEFT JOIN 
        Cursos_Vendidos_Comprados cv ON c.ID_Curso = cv.ID_Curso
    WHERE 
        c.ID_Usuario_Instructor = p_ID_Usuario_Instructor
        AND (p_Fecha_Inicio IS NULL OR c.Fecha_Creacion_Curso >= p_Fecha_Inicio)
        AND (p_Fecha_Fin IS NULL OR c.Fecha_Creacion_Curso <= p_Fecha_Fin)
        AND (p_ID_Categoria IS NULL OR c.ID_Categoria = p_ID_Categoria)
    GROUP BY 
        c.ID_Curso, c.Titulo
    ORDER BY 
        Total_Ingresos DESC;
END$$

DELIMITER ;
