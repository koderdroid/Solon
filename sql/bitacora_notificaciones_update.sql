-- Agrega campos para confirmar lectura y gestión de la alerta
ALTER TABLE bitacora_notificaciones
ADD COLUMN fecha_lectura TIMESTAMP,
ADD COLUMN usuario_lectura VARCHAR(60),
ADD COLUMN fecha_gestion TIMESTAMP,
ADD COLUMN usuario_gestion VARCHAR(60),
ADD COLUMN observacion_gestion TEXT;