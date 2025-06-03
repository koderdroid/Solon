-- ÁREAS PRINCIPALES (código corto y nombre)
CREATE TABLE areas (
    id VARCHAR(4) PRIMARY KEY, -- Ej: '1R', '2D', '3L', '4A', ...
    nombre VARCHAR(120) NOT NULL
);

-- UNIDADES FUNCIONALES (ej: DRP-UC; DAF-PLA)
CREATE TABLE unidades (
    id VARCHAR(16) PRIMARY KEY, -- Ej: 'DRP-UC', 'DAF-PLA', ...
    area_id VARCHAR(4) REFERENCES areas(id),
    nombre VARCHAR(120) NOT NULL,
    UNIQUE(area_id, id)
);

-- USUARIOS
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    username VARCHAR(60) UNIQUE NOT NULL,
    nombre VARCHAR(100),
    unidad_id VARCHAR(16) REFERENCES unidades(id),
    area_id VARCHAR(4) REFERENCES areas(id),
    rol VARCHAR(32) NOT NULL, -- Ej: 'superusuario', 'planificador', 'operador'
    activo BOOLEAN DEFAULT TRUE
);