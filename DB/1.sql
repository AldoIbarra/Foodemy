CREATE DATABASE PIA_BDM;

USE PIA_BDM;

CREATE TABLE Usuario (
    ID_Usuario INT PRIMARY KEY AUTO_INCREMENT,
    Nombre_Completo VARCHAR(255) NOT NULL,
    Genero VARCHAR(50) NOT NULL,
    Fecha_Nacimiento DATE NOT NULL,
    Foto_Perfil BLOB NOT NULL,
    Correo_Electronico VARCHAR(255) NOT NULL UNIQUE,
    Estatus INT NOT NULL,
    Contrasena VARCHAR(255) NOT NULL,
    Fecha_Registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Fecha_Actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Rol VARCHAR(50) NOT NULL,
    Intentos INT DEFAULT 0 NOT NULL
);

CREATE TABLE Categoria (
    ID_Categoria INT PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario_Administrador INT NOT NULL,
    Titulo VARCHAR(255) NOT NULL,
    Descripcion TEXT NOT NULL,
    Fecha_Hora_Creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (ID_Usuario_Administrador) REFERENCES Usuario(ID_Usuario)
);

CREATE TABLE Curso (
    ID_Curso INT PRIMARY KEY AUTO_INCREMENT,
    ID_Categoria INT NOT NULL,
    ID_Usuario_Instructor INT NOT NULL,
    Titulo VARCHAR(255) NOT NULL,
    Descripcion TEXT NOT NULL,
    Estatus INT NOT NULL,
    Imagen BLOB NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    Fecha_Creacion_Curso DATE NOT NULL,
    FOREIGN KEY (ID_Categoria) REFERENCES Categoria(ID_Categoria),
    FOREIGN KEY (ID_Usuario_Instructor) REFERENCES Usuario(ID_Usuario)
);

CREATE TABLE Nivel (
    ID_Nivel INT PRIMARY KEY AUTO_INCREMENT,
    ID_Curso INT NOT NULL,
    Titulo VARCHAR(255) NOT NULL,
    Descripcion TEXT NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    Video VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso)
);

-- Tabla para archivos asociados a niveles
CREATE TABLE Nivel_Archivo (
    ID_Archivo INT PRIMARY KEY AUTO_INCREMENT,
    ID_Nivel INT NOT NULL,
    Archivo VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_Nivel) REFERENCES Nivel(ID_Nivel)
);

CREATE TABLE Comentario (
    ID_Comentario INT PRIMARY KEY AUTO_INCREMENT,
    ID_Curso INT NOT NULL,
    ID_Usuario_Estudiante INT NOT NULL,
    Texto TEXT NOT NULL,
    Calificacion DECIMAL(3, 2) NOT NULL,
    Estatus INT NOT NULL,
    Fecha_Hora_Creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Fecha_Eliminacion DATE,
    Causa_Eliminacion TEXT,
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso),
    FOREIGN KEY (ID_Usuario_Estudiante) REFERENCES Usuario(ID_Usuario)
);

CREATE TABLE Mensajes (
    ID_Mensaje INT PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario_Emisor INT NOT NULL,
    ID_Usuario_Receptor INT NOT NULL,
    Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Mensaje TEXT NOT NULL,
    FOREIGN KEY (ID_Usuario_Emisor) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Usuario_Receptor) REFERENCES Usuario(ID_Usuario)
);

CREATE TABLE Niveles_Vendidos_Comprados (
    ID_Ventas INT PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario_Instructor INT NOT NULL,
    ID_Usuario_Estudiante INT NOT NULL,
    ID_Nivel INT NOT NULL,
    Total_Pagado DECIMAL(10, 2) NOT NULL,
    Estatus_Nivel ENUM('Visto', 'No visto') DEFAULT 'No visto',
    Fecha_Finalizacion DATE NOT NULL,
    FOREIGN KEY (ID_Usuario_Instructor) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Usuario_Estudiante) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Nivel) REFERENCES Nivel(ID_Nivel)
);

CREATE TABLE Cursos_Vendidos_Comprados (
    ID_Ventas INT PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario_Instructor INT NOT NULL,
    ID_Usuario_Estudiante INT NOT NULL,
    ID_Curso INT NOT NULL,
    Estatus_Curso  ENUM('Nuevo', 'En proceso', 'Terminado') DEFAULT 'Nuevo',
    Total_Pagado DECIMAL(10, 2) NOT NULL,
    Forma_Pago VARCHAR(50) NOT NULL,
    Curso_Comprado_Totalmente BOOLEAN NOT NULL,
    Fecha_Inscripcion DATE NOT NULL,
    Fecha_Terminacion DATE,
    FOREIGN KEY (ID_Usuario_Instructor) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Usuario_Estudiante) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso)
);


-- SP para Crear Usuarios
DELIMITER //
CREATE PROCEDURE Crear_Usuario(
    IN p_Nombre_Completo VARCHAR(255),
    IN p_Genero VARCHAR(50),
    IN p_Fecha_Nacimiento DATE,
    IN p_Foto_Perfil BLOB,
    IN p_Correo_Electronico VARCHAR(255),
    IN p_Contrasena VARCHAR(255),
    IN p_Rol VARCHAR(50)
)
BEGIN
    INSERT INTO Usuario (
        Nombre_Completo, Genero, Fecha_Nacimiento, Foto_Perfil, 
        Correo_Electronico, Estatus, Contrasena, Rol
    ) VALUES (
        p_Nombre_Completo, p_Genero, p_Fecha_Nacimiento, p_Foto_Perfil, 
        p_Correo_Electronico, 1, p_Contrasena, p_Rol
    );
END //
DELIMITER ;


-- SP para Actualizar Usuarios
DELIMITER //
CREATE PROCEDURE Actualizar_Usuario(
    IN p_ID_Usuario INT,
    IN p_Nombre_Completo VARCHAR(255),
    IN p_Genero VARCHAR(50),
    IN p_Fecha_Nacimiento DATE,
    IN p_Foto_Perfil BLOB,
    IN p_Correo_Electronico VARCHAR(255),
    IN p_Contrasena VARCHAR(255)
    -- IN p_Rol VARCHAR(50)
)
BEGIN
    UPDATE Usuario
    SET 
        Nombre_Completo = p_Nombre_Completo,
        Genero = p_Genero,
        Fecha_Nacimiento = p_Fecha_Nacimiento,
        Foto_Perfil = p_Foto_Perfil,
        Correo_Electronico = p_Correo_Electronico,
        Contrasena = p_Contrasena,
        Fecha_Actualizacion = CURRENT_TIMESTAMP
    WHERE ID_Usuario = p_ID_Usuario;
END //
DELIMITER ;


-- SP para Actualizar Intentos Usuarios
DELIMITER //
CREATE PROCEDURE Actualizar_Intentos_Usuario(
    IN p_ID_Usuario INT,
    IN p_Intento_Fallido BOOLEAN
)
BEGIN
    IF p_Intento_Fallido THEN
        -- Incrementar el contador de intentos en 1 en caso de error
        UPDATE Usuario
        SET Intentos = Intentos + 1
        WHERE ID_Usuario = p_ID_Usuario;
    ELSE
        -- Reiniciar el contador de intentos a 0 en caso de éxito
        UPDATE Usuario
        SET Intentos = 0
        WHERE ID_Usuario = p_ID_Usuario;
    END IF;
END //
DELIMITER ;


-- SP para Habilitar/Deshabilitar Usuarios
DELIMITER //
CREATE PROCEDURE Gestionar_Estatus_Usuario(
    IN p_ID_Usuario INT,
    IN p_Habilitar BOOLEAN
)
BEGIN
    IF p_Habilitar THEN
        -- Habilitar usuario
        UPDATE Usuario
        SET Estatus = 1
        WHERE ID_Usuario = p_ID_Usuario;
    ELSE
        -- Deshabilitar usuario
        UPDATE Usuario
        SET Estatus = 0
        WHERE ID_Usuario = p_ID_Usuario;
    END IF;
END //
DELIMITER ;


-- SP para Consultar Usuarios
DELIMITER //
CREATE PROCEDURE Consultar_Usuario(
    IN p_ID_Usuario INT
)
BEGIN
    SELECT 
        ID_Usuario, Nombre_Completo, Genero, Fecha_Nacimiento, 
        Foto_Perfil, Correo_Electronico, Estatus, Fecha_Registro, 
        Fecha_Actualizacion, Rol
    FROM Usuario
    WHERE ID_Usuario = p_ID_Usuario;
END //
DELIMITER ;


SELECT * FROM Usuario;

CALL Crear_Usuario(
    'Miguel López', 
    'Masculino', 
    '2002-04-12', 
    'foto_miguel.jpg', 
    'miguel.lopez@example.com', 
    'mi_contrasena', 
    'Estudiante'
);

CALL Actualizar_Usuario(
    1,  -- ID del usuario a actualizar
    'Miguel Alejandro López', 
    'Masculino', 
    '2003-04-12', 
    'nueva_foto_miguel.jpg', 
    'miguel.alejandro@example.com', 
    'mi_nueva_contrasena'
);

CALL Actualizar_Intentos_Usuario(1, TRUE); -- Incrementa el contador para el usuario con ID 1
CALL Actualizar_Intentos_Usuario(1, FALSE); -- Reinicia el contador para el usuario con ID 1

CALL Gestionar_Estatus_Usuario(1, TRUE);
CALL Gestionar_Estatus_Usuario(1, FALSE);

CALL Consultar_Usuario(1); -- Consulta los datos del usuario con ID 1

-- Crear índice único en Correo_Electronico para realizar búsquedas rápidas
CREATE UNIQUE INDEX idx_correo ON Usuario(Correo_Electronico);
