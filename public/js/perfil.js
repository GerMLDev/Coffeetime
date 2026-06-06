document.addEventListener("DOMContentLoaded", function () {
    // Controla el formulario de edición de perfil y valida la contraseña
    var form = document.getElementById("perfil-edit-form");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        var password = form.querySelector('[name="contraseña"]').value;
        if (password) {
            // Validación de la contraseña
            if (password.length < 8) {
                alert("La contraseña debe tener al menos 8 caracteres.");
                return;
            }
        }

        fetch(form.dataset.guardar, {
            method: "POST",
            body: new FormData(this)
        })
        .then(r => r.json())
        .then(json => {
            alert(json.message);
            if (json.status === 200) {
                bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
                location.reload();
            }
        })
        .catch(() => alert("Error al guardar los cambios."));
    });
});
