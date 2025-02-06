function playSong(tituloCancion) {

    const audio=document.getElementById("audioPlayer");
    const cancionRuta=document.getElementById("srcCancion");
    cancionRuta.src=`/cancion/${tituloCancion}`;

    audio.load();
    audio.play();



}