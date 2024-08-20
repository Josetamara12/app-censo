// Este código utiliza varias funciones y técnicas modernas para manejar la manipulación de datos en una tabla HTML
// a través de AJAX. También gestiona la interacción con modales de Bootstrap para editar y eliminar registros.
document.addEventListener('DOMContentLoaded', () => {
    obtenerDatosTabla();//Este evento asegura que el código dentro de la función se ejecuta una vez que el DOM
    //ha sido completamente cargado y parseado por el navegador,
    
    const tableBody = document.querySelector('.table tbody');
    const updateForm = document.getElementById('updateForm');
   

    //funcion obtenerDatosTabla
    function obtenerDatosTabla() {
        //Realizamos una solicitud HTTP GET a un archivo PHP para obtener los datos.
        return fetch('../pages/fetch_table_data.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener datos de la tabla');
                }
                return response.json(); // Convierte la respuesta en un objeto JSON
            })
           // Llamamos a la función renderizarTabla
            .then(data => renderizarTabla(data))
            //luego manejo de los errores que ocurren durante la solicitud con .catch
            .catch(error => {
                console.error('Error al obtener los datos de la tabla:', error);
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No se pudieron cargar los datos.</td></tr>';
            });
    }
    //funcion renderizarTabla
    function renderizarTabla(data) {
        tableBody.innerHTML = '';

        //Itera sobre cada registro de datos y crea una fila (tr)
        data.forEach(row => {
            const tr = document.createElement('tr');
            //Insertamos las celdas dentro de la fila, incluyendo botones de editar y eliminar.
            tr.innerHTML = `
                <td>${row.DNI}</td>
                <td>${row.NOMBRE}</td>
                <td>${new Date(row.FECNAC).toLocaleDateString('es-CO', { day: '2-digit', month: '2-digit', year: 'numeric' })}</td>
                <td>${row.DIR}</td>
                <td>${row.TFNO}</td>
                <td>

                    <button type="button" class="btn btn-warning btn-sm me-2 btn-edit" data-dni="${row.DNI}" data-nombre="${row.NOMBRE}" data-fecnac="${row.FECNAC}" data-dir="${row.DIR}" data-tfno="${row.TFNO}">Editar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-dni="${row.DNI}">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });

        // Boton de Editar
        //Al hacer clic en el botón de editar, los valores de los 
        //campos correspondientes se copian al formulario de actualización y se muestra un modal para editar el registro.
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', () => {
                const dni = button.getAttribute('data-dni');
                const nombre = button.getAttribute('data-nombre');
                const fecnac = button.getAttribute('data-fecnac');
                const dir = button.getAttribute('data-dir');
                const tfno = button.getAttribute('data-tfno');

                document.getElementById('update_dni').value = dni;
                document.getElementById('update_nombre').value = nombre;
                document.getElementById('update_fecnac').value = new Date(fecnac).toISOString().split('T')[0];
                document.getElementById('update_dir').value = dir;
                document.getElementById('update_tfno').value = tfno;
                
                // Mostramos el modal
                const updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
                updateModal.show();
            });
        });

        
        // Boton Eliminar
        //Al hacer clic en el botón de eliminar, se guarda el DNI del registro a eliminar y se muestra un modal de confirmación.
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', () => {
                dniToDelete = button.getAttribute('data-dni');

                // Mostrar el modal de confirmación
                const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                deleteConfirmModal.show();
            });
        });
    }
        // Manejar la confirmación de eliminación
            document.getElementById('confirmDeleteButton').addEventListener('click', () => {
                if (dniToDelete) {
                const formData = new FormData();
                formData.append('dni', dniToDelete);

            fetch('../pages/eliminar_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const deleteConfirmModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                    deleteConfirmModal.hide();
                    obtenerDatosTabla(); // Recargar los datos de la tabla
                } else {
                    alert(data.error || 'No se pudo eliminar el registro.');
                }
            })
            .catch(error => {
                console.error('Error eliminando el registro:', error);
            });
        }
    });
    

    // Manejo del formulario de actualización
    if (updateForm) {
        updateForm.addEventListener('submit', (event) => {
            event.preventDefault(); //Previene que el formulario se envíe de manera tradicional y recargue la página

            const dni = document.getElementById('update_dni').value.trim();
            const nombre = document.getElementById('update_nombre').value.trim();
            const fecnac = document.getElementById('update_fecnac').value.trim();
            const dir = document.getElementById('update_dir').value.trim();
            const tfno = document.getElementById('update_tfno').value.trim();

            //Aseguramos que todos los campos estén completos antes de enviar la solicitud de actualización.
            if (dni && nombre && fecnac && dir && tfno) {
                const formData = new FormData();
                formData.append('upd_dni', dni);
                formData.append('nombre', nombre);
                formData.append('fecnac', fecnac);
                formData.append('dir', dir);
                formData.append('tfno', tfno);

                //Utiliza fetch para enviar los datos del formulario al servidor para actualizar el registro.
                fetch('../pages/actualizar_data.php', { 
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = document.getElementById('updateModal');
                        const bootstrapModal = bootstrap.Modal.getInstance(modal);
                        bootstrapModal.hide();
                        obtenerDatosTabla(); // Recargar los datos de la tabla
                    } else {
                        alert(data.error || 'No se pudieron actualizar los datos.');
                    }
                })
                .catch(error => {
                    console.error('Error updating data:', error);
                });
            } else {
                alert('Por favor, complete todos los campos.');
            }
        });
    }

    //Este código maneja la interacción con un botón que al ser presionado realiza una solicitud al servidor 
    //para obtener los horarios del censo y luego insertar el contenido HTML devuelto en un contenedor específico de la página.
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('#horariosCenso button').addEventListener('click', function() {
            // Realiza la solicitud al servidor
            fetch('obtener_horarios.php')
                .then(response => response.text()) // Espera el contenido HTML
                .then(html => {
                    // Inserta el HTML en el contenedor
                    document.querySelector('#horariosCenso').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error al obtener los horarios:', error);
                });
        });
    
    });
    
});
