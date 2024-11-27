DELIMITER //
CREATE PROCEDURE ObtenerTodosLosCursos()
BEGIN
    SELECT
	c.ID_Curso AS 'ID_Curso',
	c.ID_Categoria AS 'ID_Categoria',
	ca.Titulo AS 'Titulo_Categoria',
	c.ID_Usuario_Instructor AS 'ID_Usuario_Instructor',
	c.Titulo AS 'Titulo',
	c.Descripcion AS 'Descripcion',
	c.Estatus AS 'Estatus',
	c.Imagen AS 'Imagen_Curso',
	c.Precio AS 'Precio',
	u.Nombre_Completo AS 'Nombre_Completo',
	u.Foto_Perfil AS 'Foto_Perfil'
	FROM curso c
	INNER JOIN usuario u ON c.ID_Usuario_Instructor = u.ID_Usuario
	INNER JOIN Categoria ca ON c.ID_Categoria = ca.ID_Categoria;
END //
DELIMITER ;