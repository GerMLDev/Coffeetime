document.addEventListener("DOMContentLoaded", function () {
    // Comprueba que el campo no esté vacío y pinta borde rojo si falta algo
    function validarCampo(campo) {
        if (!campo.value.trim()) {
            campo.style.border = "2px solid red";
            mostrarError(campo, "Este campo es obligatorio.");
            return false;
        } else {
            campo.style.border = "";
            limpiarError(campo);
            return true;
        }
    }
    // Valida que el DNI tenga 8 números y una letra mayúscula
    function validarDNI(campo) {
        var valor = campo.value.trim().toUpperCase();
        if (!valor || !/^\d{8}[A-Z]$/.test(valor)) {
            campo.style.border = "2px solid red";
            mostrarError(
                campo,
                "Formato incorrecto: 8 números y 1 letra mayúscula.",
            );
            return false;
        } else {
            campo.style.border = "";
            limpiarError(campo);
            return true;
        }
    }
    // Valida el formato del email y muestra error si no es válido
    function validarEmail(campo) {
        var valor = campo.value.trim();
        var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!valor || !regex.test(valor)) {
            campo.style.border = "2px solid red";
            mostrarError(campo, "Formato de email incorrecto.");
            return false;
        } else {
            campo.style.border = "";
            limpiarError(campo);
            return true;
        }
    }
    // Valida que la contraseña tenga al menos 8 caracteres
    function validarPassword(campo) {
        if (campo.value.length < 8) {
            campo.style.border = "2px solid red";
            mostrarError(campo, "Mínimo 8 caracteres.");
            return false;
        } else {
            campo.style.border = "";
            limpiarError(campo);
            return true;
        }
    }

    //FORMULARIOS DEL GESTOR

    // ALUMNO: valida el formulario de creación de alumno antes de enviarlo
    var formAlumno = document.getElementById("alumno-crear-form");
    if (formAlumno) {
        formAlumno.addEventListener("submit", function (e) {
            var relleno = true;
            relleno = validarCampo(formAlumno.querySelector('[name="nombre"]')) && relleno;
            relleno = validarCampo(formAlumno.querySelector('[name="apellidos"]')) && relleno;
            relleno = validarEmail(formAlumno.querySelector('[name="email"]')) && relleno;
            relleno = validarDNI(formAlumno.querySelector('[name="dni"]')) && relleno;
            relleno = validarCampo(formAlumno.querySelector('[name="usuario"]')) && relleno;
            relleno = validarPassword(formAlumno.querySelector('[name="contraseña"]')) && relleno;
            if (!relleno) e.preventDefault();
        });
    }

    // PROFESOR: valida el formulario de creación de profesor antes de enviarlo
    var formProfesor = document.getElementById("profesor-crear-form");
    if (formProfesor) {
        formProfesor.addEventListener("submit", function (e) {
            var relleno = true;
            relleno =
                validarCampo(
                    formProfesor.querySelector('[name="nombre_profesor"]'),
                ) && relleno;
            relleno =
                validarCampo(
                    formProfesor.querySelector('[name="apellidos_profesor"]'),
                ) && relleno;
            relleno =
                validarEmail(
                    formProfesor.querySelector('[name="email_profesor"]'),
                ) && relleno;
            relleno =
                validarDNI(
                    formProfesor.querySelector('[name="dni_profesor"]'),
                ) && relleno;
            relleno =
                validarCampo(
                    formProfesor.querySelector('[name="usuario_prof"]'),
                ) && relleno;
            relleno =
                validarPassword(
                    formProfesor.querySelector('[name="contrasena_prof"]'),
                ) && relleno;
            if (!relleno) e.preventDefault();
        });
    }

    // USUARIO: valida el formulario de nuevo usuario antes de enviar
    var formUsuario = document.getElementById("usuario-crear-form");
    if (formUsuario) {
        formUsuario.addEventListener("submit", function (e) {
            var relleno = true;
            relleno =
                validarCampo(formUsuario.querySelector('[name="usuario"]')) &&
                relleno;
            relleno =
                validarPassword(
                    formUsuario.querySelector('[name="contraseña"]'),
                ) && relleno;
            relleno =
                validarDNI(formUsuario.querySelector('[name="dni"]')) &&
                relleno;
            relleno =
                validarEmail(formUsuario.querySelector('[name="email"]')) &&
                relleno;
            if (!relleno) e.preventDefault();
        });
    }

    // ALUMNO (web): valida el formulario de registro web del alumno
    var formWebAlumno = document.getElementById("web-alumno-crear-form");
    if (formWebAlumno) {
        formWebAlumno.addEventListener("submit", function (e) {
            var relleno = true;
            relleno =
                validarCampo(formWebAlumno.querySelector('[name="nombre"]')) &&
                relleno;
            relleno =
                validarCampo(
                    formWebAlumno.querySelector('[name="apellidos"]'),
                ) && relleno;
            relleno =
                validarEmail(formWebAlumno.querySelector('[name="email"]')) &&
                relleno;
            relleno =
                validarDNI(formWebAlumno.querySelector('[name="dni"]')) &&
                relleno;
            relleno =
                validarCampo(formWebAlumno.querySelector('[name="usuario"]')) &&
                relleno;
            relleno =
                validarPassword(
                    formWebAlumno.querySelector('[name="contraseña"]'),
                ) && relleno;
            if (!relleno) e.preventDefault();
        });
    }

    // EVENTO: valida campos obligatorios del formulario de evento
    var formEvento = document.getElementById("evento-crear-form");
    if (formEvento) {
        formEvento.addEventListener("submit", function (e) {
            var relleno = true;
            relleno =
                validarCampo(formEvento.querySelector('[name="titulo"]')) &&
                relleno;
            relleno =
                validarCampo(formEvento.querySelector('[name="fecha"]')) &&
                relleno;
            relleno =
                validarCampo(formEvento.querySelector('[name="enlace"]')) &&
                relleno;
            if (!relleno) e.preventDefault();
        });
    }

    // RECURSO: valida título y enlace antes de crear un recurso
    var formRecurso = document.getElementById("recurso-crear-form");
    if (formRecurso) {
        formRecurso.addEventListener("submit", function (e) {
            var relleno = true;
            relleno =
                validarCampo(formRecurso.querySelector('[name="titulo"]')) &&
                relleno;
            relleno =
                validarCampo(formRecurso.querySelector('[name="enlace"]')) &&
                relleno;
            if (!relleno) e.preventDefault();
        });
    }
});





// Muestra un mensaje de error junto al campo y mantiene el estilo rojo
function mostrarError(campo, mensaje) {

    var siguiente = campo.nextElementSibling;
    if (siguiente && siguiente.classList.contains("error-campo")) {
        siguiente.textContent = mensaje;
    } else {
        var small = document.createElement("small");
        small.classList.add("error-campo");
        small.style.color = "red";
        small.textContent = mensaje;
        campo.parentNode.insertBefore(small, campo.nextSibling);
    }
}

// Elimina el mensaje de error si el campo es válido de nuevo
function limpiarError(campo) {
    var siguiente = campo.nextElementSibling;
    if (siguiente && siguiente.classList.contains("error-campo")) {
        siguiente.remove();
    }
}
