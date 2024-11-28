ALTER TABLE Mensajes
MODIFY COLUMN Fecha DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL;

DROP PROCEDURE IF EXISTS AgregarMensaje;

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
        NOW(),
        p_Mensaje
    );
END //

DELIMITER ;