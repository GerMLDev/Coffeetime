document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("formulario");
    var usuario = document.getElementById("usuario");
    var password = document.getElementById("password");
    var correcto = document.getElementById("correcto");
    var errormsg = document.getElementById("errormsg");

    // Navegación con ENTER entre campos de login
    var campos = [usuario, password];
    campos.forEach(function (campo, index) {
        campo.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                var siguiente = campos[index + 1];
                if (siguiente) {
                    siguiente.focus();
                } else {
                    document.querySelector(".btn-primary").focus();
                }
            }
        });
    });

    // Validación de los campos antes de enviar el formulario de login

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        let valido = true;

        if (usuario.value.trim() === "") {
            marcarError(usuario);
            alert("El  campo usuario está vacío");

            valido = false;
        } else {
            marcarOk(usuario);
        }
        if (password.value.trim() === "") {
            marcarError(password);
            alert("El  campo password está vacío");

            valido = false;
        } else {
            marcarOk(password);
        }


        //Sí válido se envía
        if (valido) {
            form.submit();
        }
    });

    //Validar al perder focos
    usuario.addEventListener("blur", function () {
        if (usuario.value.trim() === "") {
            marcarError(usuario);
            usuario.setAttribute("placeholder", "El campo usuario está vacío");
        } else {
            marcarOk(usuario);
        }
    });

    password.addEventListener("blur", function () {
        if (password.value.trim() === "") {
            marcarError(password);
            password.setAttribute(
                "placeholder",
                "El campo password está vacío",
            );
        } else {
            marcarOk(password);
        }
    });

    // Pinta el campo de rojo cuando está vacío o inválido
    function marcarError(campo) {
        campo.focus();
        campo.style.border = "2px solid red";
    }
    // Restaura el estilo normal del campo cuando es válido
    function marcarOk(campo) {
        campo.style.border = "1px solid black";
    }
});
