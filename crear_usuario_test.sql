-- Crear usuario de prueba para MathBus
USE MathLeague;
GO

-- Ver usuarios actuales
PRINT '=== Usuarios actuales ===';
SELECT * FROM usuario;
GO

-- Intentar insertar el usuario con id_usuario = 1 si no existe
IF NOT EXISTS (SELECT 1 FROM usuario WHERE id_usuario = 1)
BEGIN
    PRINT 'Insertando usuario de prueba con id_usuario = 1...';
    
    -- Insertar con los campos correctos de tu tabla usuario
    INSERT INTO usuario (id_usuario, username, email, contraseña, fecha_registro)
    VALUES (1, 'TestUser', 'test@mathleague.com', 'test123', GETDATE());
    
    PRINT 'Usuario insertado correctamente.';
END
ELSE
BEGIN
    PRINT 'El usuario con id_usuario = 1 ya existe.';
END

-- Mostrar el usuario creado/existente
SELECT * FROM usuario WHERE id_usuario = 1;
GO

PRINT '=== Usuario verificado ===';

