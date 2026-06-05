document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("form-informa");
    var nombre = document.getElementById("nombre");
    var apellidos = document.getElementById("apellidos");
    var email = document.getElementById("email");
    var mensaje = document.getElementById("mensaje");
    var correcto = document.getElementById("correcto");
    var errormsg = document.getElementById("errormsg");

    if (form && nombre && apellidos && email && mensaje && errormsg) {
        //No hacemos foco al cargar la página porque genera error por el blur si queremos pinchar en cualquier otro enlace.

        var ahora = new Date();
    document.getElementById("fecha_envio").value =
        ahora.toLocaleDateString("es-ES");
    document.getElementById("hora_envio").value =
        ahora.toLocaleTimeString("es-ES");

    // Navegación con ENTER
    var campos = [nombre, apellidos, email, mensaje];
    campos.forEach(function (campo, index) {
        campo.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                var siguiente = campos[index + 1];
                if (siguiente) {
                    siguiente.focus();
                } else {
                    document.getElementById("btn-enviar").focus();
                }
            }
        });
    });

    //Validar al perder focos
    nombre.addEventListener("blur", function () {
        if (nombre.value.trim() === "" || /\d/.test(nombre.value)) {
            marcarError(nombre);
            errormsg.innerHTML = "NOMBRE está vacío o contiene números";
        } else if (nombre.value.length > 50) {
            marcarError(nombre);
            errormsg.innerHTML = "NOMBRE no debe superar 50 caracteres";
        } else {
            marcarOk(nombre);
        }
    });

    apellidos.addEventListener("blur", function () {
        if (apellidos.value.trim() === "" || /\d/.test(apellidos.value)) {
            marcarError(apellidos);
            errormsg.innerHTML = "APELLIDOS está vacío o contiene números";
        } else if (apellidos.value.length > 50) {
            marcarError(apellidos);
            errormsg.innerHTML = "APELLIDOS no debe superar 50 caracteres";
        } else {
            marcarOk(apellidos);
        }
    });

    email.addEventListener("blur", function () {
        var regexEmail = /^[a-zA-Z0-9.-_]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!regexEmail.test(email.value.trim())) {
            marcarError(email);
            errormsg.innerHTML = "Formato de EMAIL incorrecto";
        } else if (email.value.length > 100) {
            marcarError(email);
            errormsg.innerHTML = "EMAIL no debe superar 100 caracteres";
        } else {
            marcarOk(email);
        }
    });

    mensaje.addEventListener("blur", function () {
        if (mensaje.value.trim() === "") {
            marcarError(mensaje);
            errormsg.innerHTML = "MENSAJE está vacío";
         } else if (mensaje.value.length > 100) {
            marcarError(mensaje);
            errormsg.innerHTML = "MENSAJE no debe superar 100 caracteres";
        } else {
            marcarOk(mensaje);
        }
    });

    // Validación vacío o numérico

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        let valido = true;

        if (nombre.value.trim() === "" || /\d/.test(nombre.value)) {
            marcarError(nombre);
            alert("NOMBRE está vacío o contiene números");

            valido = false;
        } else {
            marcarOk(nombre);
        }
        if (apellidos.value.trim() === "" || /\d/.test(apellidos.value)) {
            marcarError(apellidos);
            alert("APELLIDOS está vacío o contiene números");

            valido = false;
        } else {
            marcarOk(apellidos);
        }

        // Email
        var regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!regexEmail.test(email.value.trim())) {
            marcarError(email);
            alert("Formato de EMAIL incorrecto");

            valido = false;
        } else {
            marcarOk(email);
        }

        // Mensaje
        if (mensaje.value.trim() === "") {
            marcarError(mensaje);
            alert("MENSAJE está vacío");
            valido = false;
        } else {
            marcarOk(mensaje);
        }

        //MAIL DE CONFIRMACIÓN DE ENVíO (PHP Mailer)
        if (valido) {
            var formData = new FormData(form);
            //Fetch a la URL
            fetch(urlContacto, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status === 200) {
                        alert("Mensaje enviado correctamente, te contactaremos en breve.");
                        form.reset();
                    } else {
                        alert(
                            "No se pudo enviar el mensaje. Intenta de nuevo más tarde.",
                        );
                    }
                })
                .catch((error) => {
                    alert(
                        "Error al enviar tus dudas.",
                    );
                });
        }
    });
    }

    function marcarError(campo) {
        campo.focus();
        campo.style.border = "2px solid red";
    }

    function marcarOk(campo) {
        campo.style.border = "1px solid green";
        errormsg.innerHTML = "";
    }


});
