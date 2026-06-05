document.addEventListener("DOMContentLoaded", function () {
    var canvas = document.getElementById("dashboard");
    if (!canvas) {
        return;
    }

    var datos = canvas.dataset.panel ? JSON.parse(canvas.dataset.panel) : [];

    new Chart(canvas, {
        type: "bar",
        data: {
            labels: datos.map((row) => `Profesor: ${row.PROFESOR}`),
            datasets: [
                {
                    label: "Cantidad de Alumnos",
                    data: datos.map((row) => row.cantidad),
                    backgroundColor: ["red", "blue", "green", "yellow"],
                },
            ],
        },
    });
});
