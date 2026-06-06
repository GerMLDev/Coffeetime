document.addEventListener("DOMContentLoaded", function () {
    // Inicializa la tabla de profesores
    var tablavista = document.getElementById("tablaProfesor");
    if (!tablavista) {
        return;
    }

    var niveles = tablavista.dataset.niveles
        ? JSON.parse(tablavista.dataset.niveles)
        : [];
    var ajax = tablavista.dataset.listar;
    var editar = tablavista.dataset.editar;
    var actualizar = tablavista.dataset.actualizar;
    var eliminar = tablavista.dataset.eliminar;
    var csrf = tablavista.dataset.csrf;

    // Lista profesores para editar o eliminar
    var tabla = new DataTable("#tablaProfesor", {
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
                return response.status === 200 ? response.profesor : [];
            },
        },
        columns: [
            { data: "id" },
            { data: "nombre_profesor" },
            { data: "apellidos_profesor" },
            { data: "dni_profesor" },
            { data: "email_profesor" },
            { data: "nivel.nivel" },
            {
                data: null,
                render: function (data) {
                    return (
                        '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="' +
                        data.id +
                        '" data-nombre_profesor="' +
                        data.nombre_profesor +
                        '" data-apellidos_profesor="' +
                        data.apellidos_profesor +
                        '" data-dni_profesor="' +
                        data.dni_profesor +
                        '" data-email_profesor="' +
                        data.email_profesor +
                        '" data-idnivel="' +
                        data.idnivel +
                        '" data-usuario_prof="' +
                        data.usuario_prof +
                        '" data-contrasena_prof="' +
                        data.contrasena_prof +
                        '">Editar</a> ' +
                        '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' +
                        data.id +
                        '">Borrar</a>'
                    );
                },
            },
        ],
    });

    // Editar o borrar profesores
    document
        .querySelector("#tablaProfesor")
        .addEventListener("click", function (event) {
            var target = event.target;
            if (target.matches(".edit-btn")) {
                event.preventDefault();
                var id = target.dataset.id;

                document.getElementById("edit-id").value = id;
                document.getElementById("dni_profesor").value =
                    target.dataset.dni_profesor;
                document.getElementById("nombre_profesor").value =
                    target.dataset.nombre_profesor;
                document.getElementById("apellidos_profesor").value =
                    target.dataset.apellidos_profesor;
                document.getElementById("email_profesor").value =
                    target.dataset.email_profesor;
                document.getElementById("usuario_prof").value =
                    target.dataset.usuario_prof;
                document.getElementById("contrasena_prof").value =
                    target.dataset.contrasena_prof;

                var nivelSelect = document.getElementById("nivel");
                nivelSelect.innerHTML = "";
                niveles.forEach(function (nivel) {
                    var option = document.createElement("option");
                    option.value = nivel.id;
                    option.text = nivel.nivel;
                    nivelSelect.appendChild(option);
                });
                nivelSelect.value = target.dataset.idnivel;

                new bootstrap.Modal(
                    document.getElementById("editModal"),
                ).show();
            }

            if (target.matches(".delete-btn")) {
                event.preventDefault();
                var id = target.dataset.id;
                var row = target.closest("tr");

                if (
                    confirm(
                        "¿Estás seguro de que desea eliminar este profesor?",
                    )
                ) {
                    fetch(eliminar.replace(":id", id), {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrf,
                        },
                        body: JSON.stringify({ _token: csrf }),
                    })
                        .then((response) => {
                            if (!response.ok) {
                                return response.text().then((text) => {
                                    throw new Error(text);
                                });
                            }
                            return response.json();
                        })
                        .then((json) => {
                            if (json.status === 200) {
                                tabla.row(row).remove().draw();
                            }
                            alert(json.mensaje || json.message);
                        })
                        .catch((error) => {
                            console.error("Error capturado:", error);
                            alert(
                                "Hubo un error 500 en el servidor. Revisa la pestaña Network o los logs de Laravel.",
                            );
                        });
                }
            }
        });

    // Envía los cambios del profesor y recarga la tabla
    document
        .getElementById("profesor-edit-form")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch(actualizar.replace(":id", formData.get("id")), {
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
                        this.reset();
                        new bootstrap.Modal(
                            document.getElementById("editModal"),
                        ).hide();
                        tabla.ajax.reload();
                    } else {
                        alert(json.message);
                    }
                });
        });
});
