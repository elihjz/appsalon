<h1 class="nombre-pagina"></h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<form action="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu nombre"
        />
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu apellido"
        />
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Tu telefono"
        />
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu email"
        />
    </div>

    <input type="submit" class="boton" value="Iniciar sesion">
</form>
<div class="acciones">
    <a href="/">Ya tienes una? Inicia sesion</a>
    <a href="/olvide">Olvidaste tu contraseña</a>
</div>