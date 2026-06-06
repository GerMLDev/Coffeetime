    //API publica - Palabra del Día (NO FUNCIONA POR AHORA)

    // Carga una cita aleatoria de la API pública para la portada
    function palabraDia() {
        var apipalabra = document.getElementById("palabra-del-dia");
        if (!apipalabra) {
            return;
        }

        fetch("https://api.quotable.io/random")
            .then((res) => {
                if (!res.ok) {
                    throw new Error("HTTP error " + res.status);
                }
                return res.json();
            })
            .then((json) => {
                apipalabra.textContent = `"${json.content}" — ${json.author}`;
            })
            .catch((error) => {
                console.warn("No se pudo cargar la palabra del día:", error);
                apipalabra.textContent =
                    "No se pudo cargar la palabra del día. Intenta de nuevo más tarde.";
            });
    }

    palabraDia();
