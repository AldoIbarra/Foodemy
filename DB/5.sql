-- SP para Crear Categorías
DELIMITER //
CREATE PROCEDURE CrearCategoria (
    IN p_ID_Usuario_Administrador INT,
    IN p_Titulo VARCHAR(255),
    IN p_Descripcion TEXT
)
BEGIN
    INSERT INTO Categoria (ID_Usuario_Administrador, Titulo, Descripcion)
    VALUES (p_ID_Usuario_Administrador, p_Titulo, p_Descripcion);
END //
DELIMITER ;


-- SP para Editar Categorías
DELIMITER //
CREATE PROCEDURE EditarCategoria (
    IN p_ID_Categoria INT,
    IN p_Titulo VARCHAR(255),
    IN p_Descripcion TEXT
)
BEGIN
    UPDATE Categoria
    SET Titulo = p_Titulo,
        Descripcion = p_Descripcion
    WHERE ID_Categoria = p_ID_Categoria;
END //
DELIMITER ;


-- SP para Borrar Categorías
DELIMITER //
CREATE PROCEDURE EliminarCategoria (
    IN p_ID_Categoria INT
)
BEGIN
    DELETE FROM Categoria
    WHERE ID_Categoria = p_ID_Categoria;
END //
DELIMITER ;


-- SP para Obtener Categorías
DELIMITER //
CREATE PROCEDURE ObtenerTodasLasCategorias()
BEGIN
    SELECT ID_Categoria, Titulo, Descripcion
    FROM Categoria;
END //
DELIMITER ;


-- Función verificar categoría existente
DELIMITER //
CREATE FUNCTION fn_categoria_duplicada(titulo_param VARCHAR(255)) 
RETURNS TINYINT
DETERMINISTIC
BEGIN
    DECLARE existe TINYINT;
    SET existe = EXISTS (
        SELECT 1 
        FROM Categoria 
        WHERE Titulo = titulo_param
    );
    RETURN existe;
END//
DELIMITER ;


-- Modificar el valor default del campo fecha de la tabla Curso
ALTER TABLE Curso 
MODIFY Fecha_Creacion_Curso TIMESTAMP DEFAULT CURRENT_TIMESTAMP;


-- Función verificar curso existente
DELIMITER //
CREATE FUNCTION fn_curso_duplicado(titulo_param VARCHAR(255)) 
RETURNS TINYINT
DETERMINISTIC
BEGIN
    DECLARE existe TINYINT;
    SET existe = EXISTS (
        SELECT 1 
        FROM Curso 
        WHERE Titulo = titulo_param
    );
    RETURN existe;
END//
DELIMITER ;