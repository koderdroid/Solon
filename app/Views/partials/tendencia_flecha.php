<?php
function tendencia_flecha($t) {
    if ($t > 0) return '<span class="kpi-trend kpi-up">&#8593;</span>';
    if ($t < 0) return '<span class="kpi-trend kpi-down">&#8595;</span>';
    return '<span class="kpi-trend kpi-same">&#8596;</span>';
}
?>