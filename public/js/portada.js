


    //API publica - Palabra del Día

    // Carga una cita aleatoria de la API pública para la portada
    function cargarPalabraDelDia() {
        var palabraElemento = document.getElementById("palabra-del-dia");
        if (!palabraElemento) {
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
                palabraElemento.textContent = `"${json.content}" — ${json.author}`;
            })
            .catch((error) => {
                console.warn("No se pudo cargar la palabra del día:", error);
                palabraElemento.textContent =
                    "No se pudo cargar la palabra del día. Intenta de nuevo más tarde.";
            });
    }

    cargarPalabraDelDia();
