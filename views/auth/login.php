<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email: </label>
        <input 
            type="email"
            id="email"
            placeholder="Tu email"
            name="email"
            />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu password"
            namespace="password"
            />
    </div>

    <input type="submit" class="boton" value="Iniciar sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Aun no tienes cuneta? crea una.</a>
    <a href="/olvide">Olvidaste tu contraseña?</a>
</div>