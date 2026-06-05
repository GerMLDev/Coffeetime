document.addEventListener("DOMContentLoaded", function () {
    var tablavista = document.getElementById("tablaAlumno");
    if (!tablavista) {
        return;
    }

    var ajax = tablavista.dataset.listar;
    var editar = tablavista.dataset.editar;
    var actualizar = tablavista.dataset.actualizar;
    var eliminar = tablavista.dataset.eliminar;
    var csrf = tablavista.dataset.csrf;

    var tabla = new DataTable("#tablaAlumno", {
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
                return response.status === 200 ? response.alumno : [];
            },
        },
        columns: [
            { data: "dni" },
            { data: "nombre" },
            { data: "apellidos" },
            { data: "email" },
            { data: "nivel.nivel" },
            { data: "profe.nombre_profesor" },
            {
                data: null,
                render: function (data) {
                    return (
                        '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="' +
                        data.id +
                        '" data-dni="' +
                        data.dni +
                        '" data-nombre="' +
                        data.nombre +
                        '" data-apellidos="' +
                        data.apellidos +
                        '" data-email="' +
                        data.email +
                        '" data-usuario="' +
                        data.usuario +
                        '" data-contraseña="' +
                        data.contraseña +
                        '">Edit</a> ' +
                        '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' +
                        data.id +
                        '">Delete</a>'
                    );
                },
            },
        ],
    });

    document.querySelector("#tablaAlumno").addEventListener("click", function (event) {
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
                        var alumno = json.alumno;
                        var niveles = json.niveles;
                        var profesores = json.profesores;

                        document.getElementById("edit-id").value = alumno.id;
                        document.getElementById("nombre").value = alumno.nombre;
                        document.getElementById("apellidos").value = alumno.apellidos;
                        document.getElementById("email").value = alumno.email;
                        document.getElementById("dni").value = alumno.dni;
                        document.getElementById("usuario").value = alumno.usuario;
                        document.getElementById("contraseña").value = alumno.contraseña;

                        var nivelSelect = document.getElementById("nivel");
                        nivelSelect.innerHTML = "";
                        niveles.forEach(function (nivel) {
                            var option = document.createElement("option");
                            option.value = nivel.id;
                            option.text = nivel.nivel;
                            nivelSelect.appendChild(option);
                        });
                        nivelSelect.value = alumno.idnivel;

                        var profesorSelect = document.getElementById("profesor");
                        profesorSelect.innerHTML = "";
                        profesores.forEach(function (profesor) {
                            var option = document.createElement("option");
                            option.value = profesor.id;
                            option.text = profesor.nombre_profesor;
                            profesorSelect.appendChild(option);
                        });
                        profesorSelect.value = alumno.idprofesor;

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

            if (confirm("¿Estás seguro de que desea eliminar este alumno?")) {
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
                    });
            }
        }
    });

    document.getElementById("alumno-edit-form").addEventListener("submit", function (event) {
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
                    this.reset();
                    new bootstrap.Modal(document.getElementById("editModal")).hide();
                    tabla.ajax.reload();
                } else {
                    alert(json.message);
                }
            });
    });
});
