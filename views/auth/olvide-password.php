<h1 class="nombre-pagina">Olvide mi password</h1>
<p class="descripcion-pagina">Reestablece tu password con tu email a continuacion</p>

<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="text"
            id="email"
            name="email"
            placeholder="Tu correo"
            />
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href="/">Ya tienes una? Inicia sesion</a>
    <a href="/crear-cuenta">Aun no tienes cuenta? Crea una.</a>
</div>

