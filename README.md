# SNP insights · Módulo Indicadores

Este proyecto inicia con CodeIgniter 4 (PHP), frontend básico con jQuery/DataTables, y el primer módulo funcional: **Indicadores**.

## Características Iniciales

- Gestión de indicadores estratégicos, complementarios y de área.
- Visualización, alta y consulta de indicadores.
- Relación conceptual con tareas del POA (avance narrativo, sin integración automática aún).
- Scripts de migración y seeds para todos los indicadores institucionales y de áreas específicas.

## Instalación

1. Clona el repo y copia `.env.example` a `.env`, ajusta la configuración.
2. Instala dependencias de CodeIgniter 4 (`composer install`).
3. Crea la base de datos y ejecuta la migración:
    ```bash
    php spark migrate
    php spark db:seed IndicadoresSeeder
    psql -U usuario snp_insights < sql/indicadores.sql
    ```
4. Configura Apache para servir la carpeta `public/`.
5. Accede a `/indicadores` para ver el módulo.

## Estructura

Ver `estructura.txt` para el detalle de carpetas y archivos.

## Notas

- El módulo de indicadores es extensible.
- Se recomienda usar el archivo SQL para cargar todos los indicadores de áreas específicas.