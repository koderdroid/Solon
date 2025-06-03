CREATE TABLE formulario1_avance2025 (
    id SERIAL PRIMARY KEY,
    formulario1_id INTEGER REFERENCES formulario1(id),
    periodo VARCHAR(12) NOT NULL, -- Ejemplo: 'Prog.', 'Feb', etc.
    valor NUMERIC(8,2),
    UNIQUE (formulario1_id, periodo)
);