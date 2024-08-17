document.addEventListener('DOMContentLoaded', () => {
    // Obtiene el botón de buscar datos y los campos de entrada del formulario
    const fetchDataBtn = document.getElementById('fetchDataBtn');
    const updateDniInput = document.getElementById('update_dni');
    const updateNombreInput = document.getElementById('update_nombre');
    const updateFecnacInput = document.getElementById('update_fecnac');
    const updateDirInput = document.getElementById('update_dir');
    const updateTfnoInput = document.getElementById('update_tfno');

    // Añade un manejador de eventos al botón para buscar datos cuando se hace clic
    fetchDataBtn.addEventListener('click', () => {
        // Obtiene el valor del campo DNI y elimina espacios en blanco
        const dni = updateDniInput.value.trim();
        
        // Verifica si se ha ingresado un DNI
        if (dni) {
            // Llama a la función obtenerDatosPorDNI para buscar los datos
            obtenerDatosPorDNI(dni, function(error, data) {
                if (error) {
                    console.error('Error fetching data:', error);
                    return;
                }

                console.log('Datos obtenidos:', data);

                // Si se recibe un objeto de datos válido
                if (data && !data.error) {
                    // Rellena los campos del formulario con los datos obtenidos
                    updateNombreInput.value = data.NOMBRE || '';
                    updateFecnacInput.value = data.FECNAC || '';
                    updateDirInput.value = data.DIR || '';
                    updateTfnoInput.value = data.TFNO || '';
                } else {
                    // Muestra una alerta si no se encuentran datos
                    alert(data.message || 'No se encontraron datos para esta cédula.');
                }
            });
        } else {
            // Muestra una alerta si no se ha ingresado un DNI
            alert('Por favor, ingrese una cédula.');
        }
    });
});

function obtenerDatosPorDNI(dni, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../pages/fetch_data.php?dni=${encodeURIComponent(dni)}`, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) { // El 4 significa que la solicitud se ha completado
            if (xhr.status === 200) {
                console.log('Response Text:', xhr.responseText); // Imprime la respuesta completa
                try {
                    const data = JSON.parse(xhr.responseText);
                    callback(null, data);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    callback(new Error('Error parsing JSON'));
                }
            } else {
                callback(new Error('Error al obtener los datos'));
            }
        }
    };

    xhr.send();
}

