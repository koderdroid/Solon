<!DOCTYPE html>
<html>
<head>
    <title><?= esc($title ?? 'SNP insights') ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/libs/datatables.min.css">
    <link rel="stylesheet" href="/assets/libs/jquery-ui.min.css">
    <script src="/assets/libs/jquery.min.js"></script>
    <script src="/assets/libs/jquery-ui.min.js"></script>
    <script src="/assets/libs/datatables.min.js"></script>
    <script src="/assets/js/app.js"></script>
</head>
<body>
    <header>
        <h1>SNP insights</h1>
        <nav>
            <a href="/indicadores">Indicadores</a>
            <a href="/poa-tareas">Tareas POA</a>
            <?php if(session()->get('isLoggedIn')): ?>
                <span style="float:right">
                    Usuario: <?= esc(session('usuario_nombre')) ?> (<a href="/auth/logout">Salir</a>)
                </span>
            <?php endif; ?>
        </nav>
    </header>
    <main>