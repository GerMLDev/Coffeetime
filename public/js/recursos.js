document.addEventListener("DOMContentLoaded", function () {
    var tablavista = document.getElementById("tablaRecursos");
    if (!tablavista) return;

    var csrf    = tablavista.dataset.csrf;
    var ajax    = tablavista.dataset.listar;
    var crear   = tablavista.dataset.crear;
    var eliminar = tablavista.dataset.eliminar;
    var esAdmin = tablavista.dataset.esAdmin === "1";

    var tabla = new DataTable("#tablaRecursos", {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json",
            emptyTable: "No hay recursos disponibles para ti todavía.",
            zeroRecords: "No hay recursos disponibles para ti todavía."
        },
        ajax: {
            url: ajax,
            type: "GET",
            headers: { "X-CSRF-TOKEN": csrf },
            dataSrc: function (response) {
                return response.status === 200 ? response.recursos : [];
            }
        },
        columns: [
            { data: "id" },
            { data: "titulo" },
            { data: "nivel" },
            { data: "tipo" },
            { data: "nombre_profesor" },
            {
                data: null,
                render: function (data) {
                    let btns = '<a href="' + data.enlace + '" target="_blank" class="btn btn-sm btn-primary">Ver recurso</a> ';
                    if (esAdmin) {
                        btns += '<button class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '">Borrar</button>';
                    }
                    return btns;
                }
            }
        ]
    });

    // Subir recurso
    var form = document.getElementById("recurso-crear-form");
    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            fetch(crear, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": csrf },
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

    // Eliminar recurso
    tablavista.addEventListener("click", function (e) {
        var target = e.target;
        var id = target.dataset.id;

        if (target.matches(".delete-btn")) {
            if (!confirm("¿Estás seguro de que deseas eliminar este recurso?")) return;
            fetch(eliminar.replace(":id", id), {
                method: "DELETE",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
                body: JSON.stringify({ _token: csrf })
            })
            .then(r => r.json())
            .then(json => {
                if (json.status === 200) tabla.row(target.closest("tr")).remove().draw();
                alert(json.mensaje);
            });
        }
    });
});
