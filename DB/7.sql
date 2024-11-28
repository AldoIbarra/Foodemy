--Stored Procedure para Comprar curso
DELIMITER //
CREATE PROCEDURE Comprar_Curso(
    IN p_ID_Usuario_Instructor INT,
    IN p_ID_Usuario_Estudiante INT,
    IN p_ID_Curso INT,
    IN p_Total_Pagado DECIMAL(10, 2),
    IN p_Forma_Pago VARCHAR(50),
    IN p_Curso_Comprado_Totalmente BOOLEAN
)
BEGIN
    INSERT INTO cursos_vendidos_comprados (
        ID_Usuario_Instructor, ID_Usuario_Estudiante, ID_Curso, Estatus_Curso, 
        Total_Pagado, Forma_Pago, Curso_Comprado_Totalmente, Fecha_Inscripcion
    ) VALUES (
        p_ID_Usuario_Instructor, p_ID_Usuario_Estudiante, p_ID_Curso, 'Nuevo', 
        p_Total_Pagado, p_Forma_Pago, p_Curso_Comprado_Totalmente, CURDATE()
    );
END //
DELIMITER ;

--ObtenerInstructoresPorEstudiante

DELIMITER //
CREATE PROCEDURE ObtenerInstructoresPorEstudiante (
    IN ID_Estudiante INT
)
BEGIN
    SELECT 
        u.ID_Usuario AS 'ID_Estudiante',
        u2.ID_Usuario AS 'ID_Instructor',
        u.Nombre_Completo AS 'Nombre_Estudiante',
        u.Foto_Perfil AS 'Foto_Estudiante',
        u2.Nombre_Completo AS 'Nombre_Instructor',
        u2.Foto_Perfil AS 'Foto_Instructor'
    FROM 
        Usuario u
    INNER JOIN 
        Cursos_Vendidos_Comprados cvc ON u.ID_Usuario = cvc.ID_Usuario_Estudiante
    INNER JOIN 
        Usuario u2 ON cvc.ID_Usuario_Instructor = u2.ID_Usuario
    WHERE 
        u.ID_Usuario = ID_Estudiante
	GROUP BY
		u2.ID_Usuario;
END //
DELIMITER ;

--ObtenerEstudiantesPorInstructor

DELIMITER //
CREATE PROCEDURE ObtenerEstudiantesPorInstructor (
    IN ID_Instructor INT
)
BEGIN
    SELECT 
        u.ID_Usuario AS 'ID_Instructor',
        u2.ID_Usuario AS 'ID_Estudiante',
        u.Nombre_Completo AS 'Nombre_Instructor',
        u.Foto_Perfil AS 'Foto_Instructor',
        u2.Nombre_Completo AS 'Nombre_Estudiante',
        u2.Foto_Perfil AS 'Foto_Estudiante'
    FROM 
        Usuario u
    INNER JOIN 
        Cursos_Vendidos_Comprados cvc ON u.ID_Usuario = cvc.ID_Usuario_Instructor
    INNER JOIN 
        Usuario u2 ON cvc.ID_Usuario_Estudiante = u2.ID_Usuario
    WHERE 
        u.ID_Usuario = ID_Instructor
	GROUP BY u2.ID_Usuario;
END //
DELIMITER ;

--ObtenerMensajesEntreUsuarios

DELIMITER //

CREATE PROCEDURE ObtenerMensajesEntreUsuarios(
    IN idUsuario1 INT,
    IN idUsuario2 INT
)
BEGIN
    SELECT 
        ID_Mensaje,
        ID_Usuario_Emisor,
        ID_Usuario_Receptor,
        Fecha,
        Mensaje
    FROM 
        Mensajes
    WHERE 
        (ID_Usuario_Emisor = idUsuario1 AND ID_Usuario_Receptor = idUsuario2)
        OR 
        (ID_Usuario_Emisor = idUsuario2 AND ID_Usuario_Receptor = idUsuario1)
    ORDER BY 
        Fecha ASC;
END //

DELIMITER ;

--Agregar mensaje

DELIMITER //

CREATE PROCEDURE AgregarMensaje(
    IN p_Usuario_Emisor INT,
    IN p_Usuario_Receptor INT,
    IN p_Mensaje TEXT
)
BEGIN
    INSERT INTO Mensajes (
        ID_Usuario_Emisor,
        ID_Usuario_Receptor,
        Fecha,
        Mensaje
    )
    VALUES (
        p_Usuario_Emisor,
        p_Usuario_Receptor,
        CURDATE(),
        p_Mensaje
    );
END //

DELIMITER ;