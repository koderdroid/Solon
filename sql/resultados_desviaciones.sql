-- Tabla para carga de resultados por Unidad/Área y periodo
CREATE TABLE resultados_unidad (
    id SERIAL PRIMARY KEY,
    unidad_id VARCHAR(16) REFERENCES unidades(id),
    area_id VARCHAR(4) REFERENCES areas(id),
    periodo VARCHAR(12) NOT NULL,  -- Ej: '2025-T1'
    resultados TEXT NOT NULL,      -- Narrativa (resultados clave)
    desviaciones TEXT,             -- Narrativa (desviaciones)
    avance_fisico NUMERIC(5,2),    -- % avance físico
    ejec_presupuestaria NUMERIC(5,2), -- % ejecución presupuestaria
    eficiencia NUMERIC(5,2),       -- % eficiencia ponderada
    personas_discapacidad INTEGER DEFAULT 0,
    fecha_carga TIMESTAMP DEFAULT now(),
    usuario_carga VARCHAR(60)
);

-- Vista consolidada (opcional para resumen por área)
CREATE OR REPLACE VIEW v_resultados_consolidados AS
SELECT
    r.area_id,
    r.periodo,
    STRING_AGG(r.resultados, E'\n') AS resultados,
    STRING_AGG(r.desviaciones, E'\n') AS desviaciones,
    ROUND(AVG(r.avance_fisico),2) AS avance_fisico,
    ROUND(AVG(r.ejec_presupuestaria),2) AS ejec_presupuestaria,
    ROUND(AVG(r.eficiencia),2) AS eficiencia,
    SUM(r.personas_discapacidad) AS personas_discapacidad
FROM resultados_unidad r
GROUP BY r.area_id, r.periodo;