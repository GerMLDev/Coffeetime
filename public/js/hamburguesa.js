document.addEventListener("DOMContentLoaded", function () {
    var botonHamburguesa = document.getElementById("hamburguesa");
    var menuPrincipal = document.getElementById("principal");
    var botonUsuario = document.getElementById("hamburguesaUsuario");
    var botonInvitado = document.getElementById("hamburguesaInvitado");

    var menuUsuario = document.getElementById("menuUsuario");
    var menuInvitado = document.getElementById("menuInvitado");

    // TOGGLE MENÚ PRINCIPAL: abre/cierra el menú hamburguesa principal
    if (botonHamburguesa && menuPrincipal) {
        botonHamburguesa.addEventListener("click", function (e) {
            e.stopPropagation();
            menuPrincipal.classList.toggle("abierto");

            if (menuUsuario) menuUsuario.classList.remove("abierto");
            if (menuInvitado) menuInvitado.classList.remove("abierto");
        });
    }

    // TOGGLE MENÚ LOGIN: abre/cierra el menú de usuario
    if (botonUsuario && menuUsuario) {
        botonUsuario.addEventListener("click", function (e) {
            e.stopPropagation();
            menuUsuario.classList.toggle("abierto");

            if (menuPrincipal) menuPrincipal.classList.remove("abierto");
        });
    }

    // TOGGLE MENÚ INVITADO: abre/cierra el menú para invitados
    if (botonInvitado && menuInvitado) {
        botonInvitado.addEventListener("click", function (e) {
            e.stopPropagation();
            menuInvitado.classList.toggle("abierto");

            if (menuPrincipal) menuPrincipal.classList.remove("abierto");
        });
    }

    // CERRAR MENÚS al hacer clic fuera de ellos
    document.addEventListener("click", function (e) {
        if (menuPrincipal && !menuPrincipal.contains(e.target) && e.target !== botonHamburguesa) {
            menuPrincipal.classList.remove("abierto");
        }
        if (menuUsuario && !menuUsuario.contains(e.target) && e.target !== botonUsuario) {
            menuUsuario.classList.remove("abierto");
        }
        if (menuInvitado && !menuInvitado.contains(e.target) && e.target !== botonInvitado) {
            menuInvitado.classList.remove("abierto");
        }
    });
});
