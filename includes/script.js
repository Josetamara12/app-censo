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
            // Realiza una solicitud Fetch al archivo PHP para obtener datos del DNI
            fetch(`../pages/fetch_data.php?dni=${encodeURIComponent(dni)}`)
                .then(response => response.json()) // Convierte la respuesta a JSON
                .then(data => {
                    // Si se recibe un objeto de datos válido
                    if (data) {
                        // Rellena los campos del formulario con los datos obtenidos
                        updateNombreInput.value = data.NOMBRE || '';
                        updateFecnacInput.value = data.FECNAC || '';
                        updateDirInput.value = data.DIR || '';
                        updateTfnoInput.value = data.TFNO || '';
                    } else {
                        // Muestra una alerta si no se encuentran datos
                        alert('No se encontraron datos para esta cédula.');
                    }
                })
                .catch(error => {
                    // Muestra un error en la consola si ocurre algún problema
                    console.error('Error fetching data:', error);
                });
        } else {
            // Muestra una alerta si no se ha ingresado un DNI
            alert('Por favor, ingrese una cédula.');
        }
    });
});



document.addEventListener('DOMContentLoaded', () => {
    const verHorariosBtn = document.getElementById('verHorarios');
    const horariosCensoDiv = document.getElementById('horariosCenso');

    if (verHorariosBtn && horariosCensoDiv) {
        verHorariosBtn.addEventListener('click', () => {
            fetch('../pages/obtener_horarios.php')
                .then(response => response.text()) // Lee la respuesta como texto
                .then(text => {
                    console.log('Response text:', text); // Muestra el texto de la respuesta
                    try {
                        const data = JSON.parse(text); // Intenta analizar el texto como JSON
                        let horariosHtml = '<h4>Horarios de Censo</h4><ul class="list-group">';
                        for (let dia in data) {
                            horariosHtml += `<li class="list-group-item"><strong>${dia}:</strong> ${data[dia]}</li>`;
                        }
                        horariosHtml += '</ul>';
                        horariosCensoDiv.innerHTML = horariosHtml;
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        horariosCensoDiv.innerHTML = '<p class="text-danger">Hubo un error al cargar los horarios. Por favor, intenta nuevamente.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    horariosCensoDiv.innerHTML = '<p class="text-danger">Hubo un error al cargar los horarios. Por favor, intenta nuevamente.</p>';
                });
        });
    } else {
        console.error('No se encontraron los elementos en el DOM.');
    }
});


