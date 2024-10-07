function createSnowflake() {
    const snowFlake = document.createElement('div');
    snowFlake.innerHTML = '&#10052;'; // Carácter de copo de nieve
    snowFlake.classList.add('snowflake');
    snowFlake.style.left = Math.random() * 100 + '%';
    snowFlake.style.animationDuration = Math.random() * 3 + 2 + 's'; // Duración entre 2 y 5 segundos
    snowFlake.style.opacity = Math.random();
    snowFlake.style.fontSize = Math.random() * 10 + 10 + 'px'; // Tamaño entre 10px y 20px

    document.getElementById('snow').appendChild(snowFlake);

    // Elimina el copo de nieve después de un tiempo para evitar sobrecargar el DOM
    setTimeout(() => {
        snowFlake.remove();
    }, 5000 + Math.random() * 5000); // Elimina entre 5 y 10 segundos después
}

setInterval(createSnowflake, 100); // Crea un copo de nieve cada 100ms
