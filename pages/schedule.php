/* Pagina o seccion que muestra los horarios con ajax */

<!-- En census.php o una página específica -->
<div id="horarios">
    <h3>Horarios de Censo</h3>
    <div id="horario-content"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('schedule.php')
        .then(response => response.text())
        .then(data => document.getElementById('horario-content').innerHTML = data);
});
</script>

<?php
// schedule.php
echo "<ul>
        <li>Lunes a Viernes: 8:00 a 17:00</li>
        <li>Sábados: 8:00 a 14:00</li>
      </ul>";
?>

