-- Esquema inicial simplificado para PostgreSQL

CREATE TABLE departamentos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(10) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    manager_id INTEGER,
    cod_padre INTEGER,
    nivel INTEGER DEFAULT 1
);

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    password_hash TEXT NOT NULL,
    rol VARCHAR(50) NOT NULL,
    departamento_id INTEGER REFERENCES departamentos(id),
    permisos TEXT[],
    activo BOOLEAN DEFAULT TRUE
);

CREATE TABLE categorias_indicador (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    orden INTEGER DEFAULT 1,
    activo BOOLEAN DEFAULT TRUE
);

CREATE TABLE indicadores (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    categoria_id INTEGER REFERENCES categorias_indicador(id),
    departamento_id INTEGER REFERENCES departamentos(id),
    formula TEXT,
    valor_objetivo NUMERIC(10,2),
    operador_objetivo VARCHAR(5),
    unidad VARCHAR(50),
    tipo_calculo VARCHAR(50),
    frecuencia VARCHAR(20),
    activo BOOLEAN DEFAULT TRUE,
    descripcion_numerador TEXT,
    descripcion_denominador TEXT,
    peso NUMERIC(5,2)
);

CREATE TABLE mediciones_indicador (
    id SERIAL PRIMARY KEY,
    indicador_id INTEGER REFERENCES indicadores(id),
    periodo VARCHAR(20),
    tipo_periodo VARCHAR(20),
    valor_numerador NUMERIC(14,2),
    valor_denominador NUMERIC(14,2),
    valor_calculado NUMERIC(14,2),
    valor_objetivo_medicion NUMERIC(14,2),
    estado_cumplimiento VARCHAR(20),
    varianza NUMERIC(10,2),
    origen_datos TEXT,
    usuario_responsable_id INTEGER REFERENCES usuarios(id),
    estado_verificacion VARCHAR(20),
    verificado_por_id INTEGER REFERENCES usuarios(id),
    notas TEXT
);

-- (Más tablas en roadmap: poa_items, documentos, auditoría, etc.)