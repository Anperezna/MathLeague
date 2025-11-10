-- Script de prueba para verificar la configuración de MathBus
USE MathLeague;
GO

-- 1. Verificar que existe el usuario con id_usuario = 1
PRINT '=== Verificando usuario ===';
SELECT * FROM usuario WHERE id_usuario = 1;

-- Si no existe, crearlo
IF NOT EXISTS (SELECT 1 FROM usuario WHERE id_usuario = 1)
BEGIN
    PRINT 'Usuario no existe. Creándolo...';
    INSERT INTO usuario (id_usuario, username, email, password, birthdate)
    VALUES (1, 'TestUser', 'test@mathleague.com', 'password123', '2000-01-01');
    PRINT 'Usuario creado correctamente.';
END
ELSE
BEGIN
    PRINT 'Usuario existe correctamente.';
END

GO

-- 2. Verificar que existe el juego MathBus
PRINT '=== Verificando juego MathBus ===';
SELECT * FROM juegos WHERE nombre LIKE '%MathBus%';

GO

-- 3. Verificar que existen preguntas
PRINT '=== Verificando preguntas ===';
SELECT COUNT(*) AS 'Total Preguntas' 
FROM preguntas p
INNER JOIN juegos j ON p.id_juego = j.id_juego
WHERE j.nombre LIKE '%MathBus%';

GO

-- 4. Ver el último ID de sesiones
PRINT '=== Último ID de sesiones ===';
SELECT MAX(id_sesion) AS 'Max ID Sesion' FROM sesiones;

GO

-- 5. Ver el último ID de juegos_sesion
PRINT '=== Último ID de juegos_sesion ===';
SELECT MAX(id_juegos_sesion) AS 'Max ID Juegos_Sesion' FROM juegos_sesion;

GO

PRINT '=== Verificación completada ===';
