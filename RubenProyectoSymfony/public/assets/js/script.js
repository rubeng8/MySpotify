function playSong(tituloCancion, playlistId = null) {
    const audio = document.getElementById("audioPlayer");
    const cancionRuta = document.getElementById("srcCancion");

    cancionRuta.src = `/cancion/${tituloCancion}`;

    audio.style.display = "inline-block";

    fetch(`/cancion/reproducir/${tituloCancion}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({titulo: tituloCancion})
    }).then(response => {
        if (response.ok) {
            console.log("Reproducción de canción registrada correctamente.");
        } else {
            console.log("Error al registrar la reproducción de la canción.");
        }
    }).catch(error => {
        console.log("Hubo un error:", error);
    });

    if (playlistId) {
        fetch(`/playlist/reproducir/${playlistId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({playlistId: playlistId})
        }).then(response => {
            if (response.ok) {
                console.log("Reproducción de playlist registrada correctamente.");
            } else {
                console.log("Error al registrar la reproducción de la playlist.");
            }
        }).catch(error => {
            console.log("Hubo un error:", error);
        });
    }

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
            canciones[i].style.display = "block";
            encontrado = true;
        } else {
            canciones[i].style.display = "none";
        }
    }

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

function mostrarCancionesPlaylist(playlistId){

    window.location.href = `/playlist/${playlistId}`;

}


