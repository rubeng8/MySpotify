function playSong(tituloCancion) {
    const audio = document.getElementById("audioPlayer");
    const cancionRuta = document.getElementById("srcCancion");
    
    // Ruta donde se encuentra el archivo de la canción (Symfony debe estar sirviendo el archivo con esta ruta)
    cancionRuta.src = `/cancion/${tituloCancion}`;

    audio.style.display = "inline-block";

    audio.load();
    audio.play();
}