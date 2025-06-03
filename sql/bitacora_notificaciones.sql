-- Bitácora de notificaciones de alertas/desviaciones
CREATE TABLE bitacora_notificaciones (
    id SERIAL PRIMARY KEY,
    periodo VARCHAR(12) NOT NULL,
    unidad_id VARCHAR(16) REFERENCES unidades(id),
    area_id VARCHAR(4) REFERENCES areas(id),
    usuario_destino VARCHAR(60), -- username/email responsable notificado
    asunto VARCHAR(200),
    cuerpo TEXT,
    fecha_envio TIMESTAMP DEFAULT now(),
    tipo VARCHAR(30) DEFAULT 'alerta', -- alerta, info, advertencia, etc.
    estado VARCHAR(20) DEFAULT 'enviado', -- enviado, visto, confirmado, etc.
    detalles JSONB -- datos adicionales, ejemplo: indicadores afectados, etc.
);