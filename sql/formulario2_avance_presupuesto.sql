-- Direcciones / Áreas
CREATE TABLE areas (
    id VARCHAR(8) PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL
);

-- Operaciones
CREATE TABLE operaciones (
    id SERIAL PRIMARY KEY,
    cod_op VARCHAR(12) NOT NULL,
    nombre TEXT NOT NULL,
    area_id VARCHAR(8) REFERENCES areas(id) NOT NULL
);

-- Tareas (cada tarea pertenece a una operación)
CREATE TABLE tareas (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(24) NOT NULL,
    nombre TEXT NOT NULL,
    operacion_id INTEGER REFERENCES operaciones(id) NOT NULL,
    ponderacion NUMERIC(5,2) NOT NULL DEFAULT 0 -- Ponderación respecto a operación (%)
);

-- Avance físico por periodo y tarea
CREATE TABLE tarea_avance (
    id SERIAL PRIMARY KEY,
    tarea_id INTEGER REFERENCES tareas(id) NOT NULL,
    periodo VARCHAR(12) NOT NULL, -- Ej: '1trim', '2trim', etc.
    avance NUMERIC(5,2) NOT NULL -- En porcentaje
);

-- Presupuesto por Área (asignado y ejecutado, por periodo)
CREATE TABLE area_presupuesto (
    id SERIAL PRIMARY KEY,
    area_id VARCHAR(8) REFERENCES areas(id),
    periodo VARCHAR(12),
    presupuesto_vigente NUMERIC(14,2) NOT NULL DEFAULT 0,
    presupuesto_ejecutado NUMERIC(14,2) NOT NULL DEFAULT 0
);

-- Presupuesto distribuido por tarea y periodo (calculado, no editable manual)
CREATE TABLE tarea_presupuesto (
    id SERIAL PRIMARY KEY,
    tarea_id INTEGER REFERENCES tareas(id),
    periodo VARCHAR(12),
    presupuesto_vigente NUMERIC(14,2) NOT NULL DEFAULT 0,
    presupuesto_ejecutado NUMERIC(14,2) NOT NULL DEFAULT 0
);