//API publica - Frase del Día

// Carga una cita aleatoria de la API pública para la portada
function fraseDia() {
    var apifrase = document.getElementById("frase-del-dia");
    if (!apifrase) {
        return;
    }

    fetch("https://api.adviceslip.com/advice")
        .then((res) => {
            if (!res.ok) {
                throw new Error("HTTP error " + res.status);
            }
            return res.json();
        })
        .then((json) => {

            apifrase.textContent = `"${json.slip.advice}"`;
        })
        .catch((error) => {
            console.warn("No se pudo cargar la frase del día:", error);
            apifrase.textContent =
                "No se pudo cargar la frase del día. Por ahora, te digo esto: 'Be water, my friend'.";
        });
}

fraseDia();

//Links a RRSS en proceso
var rrss = document.querySelectorAll(".footer-rrss-links");
if (rrss.length > 0) {
    rrss.forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            alert(
                "Estamos trabajando en ello... ¡Próximamente en funcionamiento!",
            );
        });
    });
}
