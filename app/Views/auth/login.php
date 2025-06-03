<?php
$title = "Iniciar sesión";
include(APPPATH.'Views/layouts/header.php');
?>
    <h2>Iniciar sesión</h2>
    <?php if (!empty($error)): ?>
        <div style="color:#b00"><?= esc($error) ?></div>
    <?php endif; ?>
    <form method="post" action="/auth/login">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Entrar</button>
    </form>
<?php include(APPPATH.'Views/layouts/footer.php'); ?>