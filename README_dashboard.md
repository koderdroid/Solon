# Dashboard de Avance POA — Integración con Google Charts

- **Visualización:** KPIs, barras de cumplimiento y torta de estado usando [Google Charts](https://developers.google.com/chart).
- **Filtros:** Por dirección, operación, estado.
- **Edición rápida:** Avance y cumplimiento de tareas editables directamente en tabla.
- **Opción abierta:** Puedes cambiar a Chart.js u otra librería fácilmente, solo cambia el `<script>` y la lógica JS de gráficos.

## Extender o cambiar a Chart.js

1. Descomenta el script CDN de Chart.js en el `<head>`.
2. Sustituye los bloques `google.visualization` por la sintaxis de Chart.js.
3. Puedes usar los mismos arrays de datos PHP para alimentar los datasets de Chart.js.

---

¿Deseas ejemplos concretos de cómo migrar estos gráficos a Chart.js o agregar nuevos tipos de visualizaciones?