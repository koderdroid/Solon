-- Indicadores de áreas específicas (DRP, DBRAE, DLEGSS, DAF, DJ, UAI, TRA, OD)
INSERT INTO indicadores (codigo, nombre, formula, meta, area, tipo, descripcion) VALUES
-- DRP
('IACDBE', 'Indicador Anual de Cumplimiento a la Declaración Jurada de Bienes del Estado', '(Entidades Públicas que presentaron la DEJURBE finalizada en el plazo / Entidades Públicas habilitadas para realizar la DEJURBE) x 100', '≥ 95%', 'DRP', 'area', ''),
('IACCDBE', 'Indicador Anual de Cumplimiento de la Calidad de la DEJURBE', '(Cantidad de bienes registrados en la DEJURBE sin errores / Cantidad de bienes registrados en la DEJURBE) x 100', '≥ 50%', 'DRP', 'area', ''),
('IACVDBE', 'Indicador Anual de Cumplimiento a la Validación de la DEJURBE', '(Total de documentos validados / Total de documentos remitidos) x 100', '≥ 90%', 'DRP', 'area', ''),
-- DBRAE
('IACVRG', 'Indicador Anual de Cumplimiento de Verificación de Recursos Generados', '(Ingreso de recursos, verificados / Recursos generados para el TGN) x 100', '≥ 95%', 'DBRAE', 'area', ''),
('IACS', 'Indicador Anual de Cumplimiento a la Sistematización de la Documentación', '(Ordenamiento de la documentación sistematizada, realizada / Ordenamiento de la documentación planificada) x 100', '≥ 85%', 'DBRAE', 'area', ''),
('IACLE', 'Indicador Anual de Cumplimiento de Liquidación de ex Entidades', '(Extinción de la Personería Jurídica de ex Entidades, gestionada / Extinción de la Personería Jurídica de ex Entidades, programada) x 100', '95%', 'DBRAE', 'area', ''),
-- DLEGSS
('IACEEFEG', 'Indicador Anual de Cumplimiento a la Emisión de Estados Financieros de Gestión y Cierre de ex Entes Gestores de la Seguridad Social', '(Estados Financieros de gestión y de cierre emitidos / Estados Financieros de gestión y de cierre planificados) x 100', '95%', 'DLEGSS', 'area', ''),
('IACASPJ', 'Indicador Anual de Cumplimiento a la Actualización del SIPROJ', '(Información de Procesos judiciales a cargo de la DLEGSS actualizada en el SIPROJ / Procesos Judiciales registrados en el SIPROJ a cargo de la DLEGSS) x 100', '≥ 90%', 'DLEGSS', 'area', ''),
('IACSB', 'Indicador Anual de Cumplimiento al Saneamiento de Bienes', '(Tramites de saneamiento atendidos / Tramites de saneamiento planificados) x 100', '≥ 95%', 'DLEGSS', 'area', ''),
('IACRC', 'Indicador Anual de Cumplimiento a la Reconstrucción de Cartera', '(Reconstrucción de cartera efectuada / Reconstrucción de cartera planificada) x 100', '≥ 95%', 'DLEGSS', 'area', ''),
-- DAF
('IACAFA', 'Indicador Anual de Cumplimiento a la Administración Financiera Adecuada', '(Presupuesto Ejecutado / Presupuesto vigente) x 100', '≥ 90%', 'DAF', 'area', ''),
('IACAFSEPOA', 'Indicador Anual de Cumplimiento del Avance Físico, Seguimiento y Evaluación al POA', '(Porcentaje de ejecución del POA del SENAPE / POA Programado del SENAPE) x 100', '≥ 90%', 'DAF', 'area', ''),
('IACATI', 'Indicador Anual de Cumplimiento a las Actividades de Tecnologías de Información', '(Sistemas de Información implementados / Sistemas de Información para desarrollar, solicitados) x 100', '≥ 95%', 'DAF', 'area', ''),
('IACAAF', 'Indicador Anual de Cumplimiento a la Administración de Activos Fijos', '(Activos Fijos del SENAPE asignados / Activos fijos del SENAPE) x 100', '≥ 95%', 'DAF', 'area', ''),
('AICITH', 'Indicador de Anual Cumplimiento a la Integración del Talento Humano', '(Cantidad de Procesos del Sistema de Administración de Personal Automatizados / Cantidad de Procesos del Sistema de Administración de Personal) x 100', '≥ 90%', 'DAF', 'area', ''),
-- DJ
('IACPJTC', 'Indicador Anual de Cumplimiento de Procesos Judiciales Tramitados y Controlados', '(Información de Procesos judiciales actualizada en el SIPROJ / Procesos Judiciales registrados en el SIPROJ) x 100', '≥ 90%', 'DJ', 'area', ''),
('IACCL', 'Indicador de Cumplimiento de Emisión de Criterio Legal', '(Emisión de Criterio Legal atendidos / Emisión de Criterio Legal solicitados) x 100', '≥ 95%', 'DJ', 'area', ''),
('IACPN', 'Indicador Anual de Cumplimiento de Proyección de Normativa', '(Proyección de normativa atendida / Proyección de normativa solicitada) x 100', '≥ 95%', 'DJ', 'area', ''),
-- UAI
('IACCII', 'Indicador Anual de Cumplimiento del Control Interno Institucional', '(Auditorías internas realizadas en el SENAPE / Auditorías internas programadas y no programadas, solicitadas) x 100', '≥ 95%', 'UAI', 'area', ''),
('IACE', 'Indicador Anual de Cumplimiento de Evaluaciones', '(Evaluaciones realizadas en el SENAPE / Evaluaciones programadas y no programadas, solicitadas) x 100', '≥ 95%', 'UAI', 'area', ''),
-- TRA
('IACTLCC', 'Indicador Anual de Cumplimiento de Transparencia y Lucha Contra la Corrupción', '(Actividades realizadas y participación en eventos de transparencia, coordinada / Eventos programados por el SENAPE e invitaciones de eventos de Transparencia) x 100', '≥ 90%', 'TRA', 'area', ''),
('IACDVEHC', 'Indicador Anual de Cumplimiento de Atención Oportuna de las Denuncias por Vulneración a la Ética y Presuntos Hechos de Corrupción', '(Denuncias por vulneración a la ética y presuntos hechos de corrupción verificadas y derivadas a la Unidad de Transparencia del MEFP / Denuncias por vulneración a la ética y presuntos hechos de corrupción recibidas) x 100', '≥ 90%', 'TRA', 'area', ''),
-- OD
('IACOD', 'Indicador Anual de Cumplimiento del POA de las Oficinas Distritales', '(Porcentaje de ejecución del POA en Oficinas Distritales / POA Programado de las Oficinas Distritales) x 100', '≥ 90%', 'OD', 'area', '');