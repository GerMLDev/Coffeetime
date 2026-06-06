document.addEventListener("DOMContentLoaded", function () {
    // Inicializa la tabla de usuarios de la vista
    var tablavista = document.getElementById("tablaUsuario");
    if (!tablavista) {
        return;
    }

    var ajax = tablavista.dataset.listar;
    var editar = tablavista.dataset.editar;
    var actualizar = tablavista.dataset.actualizar;
    var eliminar = tablavista.dataset.eliminar;
    var csrf = tablavista.dataset.csrf;

    // Lista usuarios para editar o eliminar
    var tabla = new DataTable("#tablaUsuario", {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
        },
        ajax: {
            url: ajax,
            type: "GET",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
            dataSrc: function (response) {
                return response.status === 200 ? response.usuario : [];
            },
        },
        columns: [
            { data: "id" },
            { data: "usuario" },
            { data: "email" },
            { data: "role.rol" },
            {
                data: null,
                render: function (data) {
                    return (
                        '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="' +
                        data.id +
                        '" data-email="' +
                        data.email +
                        '" data-usuario="' +
                        data.usuario +
                        '" data-contraseña="' +
                        data.contraseña +
                        '" data-dni="' +
                        data.dni +
                        '" data-role="' +
                        data.role.rol +
                        '">Edit</a> ' +
                        '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' +
                        data.id +
                        '">Delete</a>'
                    );
                },
            },
        ],
    });

    // Acciones editar o eliminar 
    document.querySelector("#tablaUsuario").addEventListener("click", function (event) {
        var target = event.target;
        if (target.matches(".edit-btn")) {
            event.preventDefault();
            var id = target.dataset.id;
            fetch(editar.replace(":id", id), {
                headers: {
                    "X-CSRF-TOKEN": csrf,
                },
            })
                .then((response) => response.json())
                .then((json) => {
                    if (json.status === 200) {
                        var usuario = json.usuario;
                        var roles = json.roles;

                        document.getElementById("edit-id").value = usuario.id;
                        document.getElementById("usuario").value = usuario.usuario;
                        document.getElementById("contraseña").value = usuario.contraseña;
                        document.getElementById("email").value = usuario.email;
                        document.getElementById("dni").value = usuario.dni;

                        var rolSelect = document.getElementById("rol");
                        rolSelect.innerHTML = "";
                        roles.forEach(function (rol) {
                            var option = document.createElement("option");
                            option.value = rol.id;
                            option.text = rol.rol;
                            rolSelect.appendChild(option);
                        });
                        rolSelect.value = usuario.idrol;

                        new bootstrap.Modal(document.getElementById("editModal")).show();
                    } else {
                        alert(json.message);
                    }
                });
        }

        if (target.matches(".delete-btn")) {
            event.preventDefault();
            var id = target.dataset.id;
            var row = target.closest("tr");

            if (confirm("¿Estás seguro de que desea eliminar este usuario?")) {
                fetch(eliminar.replace(":id", id), {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf,
                    },
                    body: JSON.stringify({ _token: csrf }),
                })
                    .then((response) => response.json())
                    .then((json) => {
                        if (json.status === 200) {
                            tabla.row(row).remove().draw();
                        }
                        alert(json.mensaje || json.message);
                    })
                    .catch((error) => {
                        console.error(error);
                        alert("Error: " + error);
                    });
            }
        }
    });

    // Envía la actualización del usuario y recarga la tabla
    document.getElementById("usuario-edit-form").addEventListener("submit", function (event) {
        event.preventDefault();
        var id = document.getElementById("edit-id").value;
        var formData = new FormData(this);

        fetch(actualizar.replace(":id", id), {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrf,
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((json) => {
                if (json.status === 200) {
                    alert(json.message);
                    document.getElementById("usuario-edit-form").reset();
                    new bootstrap.Modal(document.getElementById("editModal")).hide();
                    tabla.ajax.reload();
                } else {
                    alert(json.message);
                }
            });
    });
});
