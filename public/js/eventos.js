document.addEventListener("DOMContentLoaded", function () {
    var tablavista = document.getElementById("tablaEventos");
    if (!tablavista) return;

    var csrf = tablavista.dataset.csrf;
    var ajax     = tablavista.dataset.listar;
    var crear   = tablavista.dataset.crear;
    var eliminar   = tablavista.dataset.eliminar;
    var inscribir  = tablavista.dataset.inscribir;
    var cancelar   = tablavista.dataset.cancelar;
    var inscritos  = tablavista.dataset.inscritos;
    var rol    = tablavista.dataset.role;

    var tabla = new DataTable("#tablaEventos", {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
            emptyTable: "No hay eventos disponibles para ti todavía."
        },
        ajax: {
            url: ajax,
            type: "GET",
            headers: { "X-CSRF-TOKEN": csrf },
            dataSrc: function (response) {
                return response.status === 200 ? response.eventos : [];
            }
        },
        columns: [
            { data: "id" },
            { data: "titulo" },
            { data: "nivel" },
            {
                data: "estado",
                render: function (data) {
                    return data === "Caducado"
                        ? '<span class="badge bg-danger">Caducado</span>'
                        : '<span class="badge bg-success">Activo</span>';
                }
            },
            {
                data: null,
                render: function (data) {
                    return data.fecha + " " + data.hora;
                }
            },
            { data: "nombre_profesor" },
            {
                data: null,
                render: function (data) {
                    let buttons = "";

                    if (data.caducado) {
                        buttons += '<button class="btn btn-sm btn-secondary" disabled>Caducado</button> ';
                    }

                    if (rol === "admin" || data.puede_eliminar) {
                        buttons += '<button class="btn btn-sm btn-info ver-inscritos-btn" data-id="' + data.id + '">Inscritos</button> ';
                        buttons += '<button class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '">Borrar</button>';
                    } else if (rol === "alumno" && !data.caducado) {
                        if (data.inscrito) {
                            buttons += '<a href="' + data.enlace + '" target="_blank" class="btn btn-sm btn-primary">Unirse</a> ';
                            buttons += '<button class="btn btn-sm btn-warning cancelar-inscripcion-btn" data-id="' + data.id + '">Cancelar</button>';
                        } else {
                            buttons += '<button class="btn btn-sm btn-success inscribir-btn" data-id="' + data.id + '">Inscribirse</button>';
                        }
                    }

                    return buttons;
                }
            }
        ]
    });

    // Crear evento
    var form = document.getElementById("evento-crear-form");
    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            var titulo = this.querySelector('[name="titulo"]');
            var fecha = this.querySelector('[name="fecha"]');
            var hora = this.querySelector('[name="hora"]');
            var enlace = this.querySelector('[name="enlace"]');

            var valid = true;
            valid = validarCampo(titulo) && valid;
            valid = validarFechaHoy(fecha) && valid;
            valid = validarCampo(hora) && valid;
            valid = validarCampo(enlace) && valid;

            if (!valid) {
                return;
            }

            fetch(crear, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": csrf, "Accept": "application/json" },
                body: new FormData(this)
            })
            .then(r => r.json())
            .then(json => {
                alert(json.message);
                if (json.status === 200) {
                    form.reset();
                    bootstrap.Modal.getInstance(document.getElementById("crearModal")).hide();
                    tabla.ajax.reload();
                }
            });
        });
    }

    // Acciones de la tabla
    tablavista.addEventListener("click", function (e) {
        var target = e.target;
        var id = target.dataset.id;

        if (target.matches(".delete-btn")) {
            if (!confirm("¿Estás seguro de que deseas eliminar este evento?")) return;
            fetch(eliminar.replace(":id", id), {
                method: "DELETE",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
                body: JSON.stringify({ _token: csrf }),
            })
            .then(r => r.json())
            .then(json => {
                if (json.status === 200) tabla.row(target.closest("tr")).remove().draw();
                alert(json.mensaje);
            });
        }
//Si tiene los permisos aadecuados, se habilita el botón para ver alumnos inscritos al evento
        if (target.matches(".ver-inscritos-btn")) {
            fetch(inscritos.replace(":id", id), {
                headers: { "X-CSRF-TOKEN": csrf }
            })
            .then(r => r.json())
            .then(response => {
                let inscritos = Array.isArray(response.inscripciones) ? response.inscripciones : [];
                let html = "<p><strong>Evento:</strong> " + (response.evento || "N/A") + "</p>";
                if (inscritos.length > 0) {
                    html += '<ul class="list-group">';
                    inscritos.forEach(item => {
                        html += '<li class="list-group-item">' + item.nombre + " " + item.apellidos + "</li>";
                    });
                    html += "</ul>";
                } else {
                    html += '<p class="text-muted">No hay alumnos inscritos aún.</p>';
                }
                document.getElementById("inscritosModalContent").innerHTML = html;
                new bootstrap.Modal(document.getElementById("inscritosModal")).show();
            });
        }
//Si es alumno, se habilita el botón de inscripción
        if (target.matches(".inscribir-btn")) {
            fetch(inscribir.replace(":id", id), {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
                body: JSON.stringify({ _token: csrf })
            })
            .then(r => r.json())
            .then(json => { alert(json.message); tabla.ajax.reload(); });
        }
//Si es alumno y ya está inscrito, se habilita el botón de cancelar inscripción

        if (target.matches(".cancelar-inscripcion-btn")) {
            if (!confirm("¿Estás seguro de que deseas cancelar tu inscripción?")) return;
            fetch(cancelar.replace(":id", id), {
                method: "DELETE",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
                body: JSON.stringify({ _token: csrf })
            })
            .then(r => r.json())
            .then(json => { alert(json.message); tabla.ajax.reload(); });
        }
    });
});
