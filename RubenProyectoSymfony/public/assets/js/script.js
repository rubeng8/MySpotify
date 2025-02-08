function playSong(tituloCancion) {
    const audio = document.getElementById("audioPlayer");
    const cancionRuta = document.getElementById("srcCancion");
    
    cancionRuta.src = `/cancion/${tituloCancion}`;

    audio.style.display = "inline-block";

    audio.load();
    audio.play();
}


function buscarCancion() {

    console.log("hola")

    let input = document.getElementById("inputBuscar").value.toLowerCase();
    let canciones = document.getElementsByClassName("cancion");
    let encontrado = false;

    for (let i = 0; i < canciones.length; i++) {
        let titulo = canciones[i].querySelector("h3").textContent.toLowerCase();

        if (titulo.includes(input)) {
            canciones[i].style.display = "block"; // Mostrar si coincide
            encontrado = true;
        } else {
            canciones[i].style.display = "none"; // Ocultar si no coincide
        }
    }

    // Manejar mensaje de "No se encontraron canciones"
    let sinResultados = document.getElementById("sinResultados");

    if (!encontrado) {
        if (!sinResultados) {
            sinResultados = document.createElement("p");
            sinResultados.id = "sinResultados";
            sinResultados.textContent = "No se encontraron canciones.";
            sinResultados.style.color = "white";
            sinResultados.style.textAlign = "center";
            document.getElementById("centro").appendChild(sinResultados);
        }
    } else {
        if (sinResultados) {
            sinResultados.remove();
        }
    }
}

