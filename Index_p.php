<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <link rel="stylesheet" href="styles.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<form class="contact_form" action="validar.php" method="post" name="contact_form">
    <ul>
        <li>
             <h2>Contacto TheJLupload</h2>
             <span class="required_notification">* Datos necesarios</span>
        </li>
        <li>
            <label for="name">Nombre:</label>
            <input type="text"  placeholder="Nombre(s)" name="nombre" id="nombre" required />
        </li>
        <li>
            <label for="email">Correo:</label>
            <input type="email" name="email" placeholder="nombre@dominio.com" name="email" id="email" required />
            <span class="form_hint">Ingresa un formato correcto"nombre@dominio.com"</span>
        </li>
        <li>
            <label for="website">Website:</label>
            <input type="url" name="website" placeholder="http://dominio.com" name="website" id="website"  required pattern="(http|https)://.+"/>
            <span class="form_hint">Ingresa un formato correcto "http://dominio.com"</span>
        </li>
        <li>
            <label for="message">Mensaje:</label>
            <textarea name="message" cols="40" rows="6" name="mensaje" id="mensaje" required ></textarea>
        </li>
        <div class="g-recaptcha" data-sitekey="6Le7qyIUAAAAANR8jWjtBZjV1AoWMzVdxn5lZuXf"></div>
        <li>
            <button class="submit" type="submit">Enviar</button>
        </li>
    </ul>
</form>
</body>
</html>