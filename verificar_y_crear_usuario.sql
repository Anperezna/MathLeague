-- Verificar y crear usuario para MathBus
USE MathLeague;
GO

-- Ver usuarios actuales
PRINT '=== Verificando usuarios ===';
SELECT * FROM usuario;
GO

-- Crear usuario con id=1 si no existe
IF NOT EXISTS (SELECT 1 FROM usuario WHERE id_usuario = 1)
BEGIN
    PRINT 'Creando usuario con id_usuario = 1...';
    
    SET IDENTITY_INSERT usuario ON;
    
    INSERT INTO usuario (id_usuario, username, email, contraseña, fecha_registro)
    VALUES (1, 'TestUser', 'test@mathleague.com', 'test123', GETDATE());
    
    SET IDENTITY_INSERT usuario OFF;
    
    PRINT 'Usuario creado exitosamente.';
END
ELSE
BEGIN
    PRINT 'El usuario con id_usuario = 1 ya existe.';
END
GO

-- Mostrar el usuario
SELECT * FROM usuario WHERE id_usuario = 1;
GO
