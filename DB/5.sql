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