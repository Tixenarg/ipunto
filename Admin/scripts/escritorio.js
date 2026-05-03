function init() {
    // Llamada AJAX para obtener los totales
    $.post("../ajax/consulta.php?op=cantidadNoticias", function(data) {
        // Verificamos si hay datos antes de parsear
        if (data && data !== "null") {
            try {
                let res = JSON.parse(data);
                $("#total_noticias").html(res.total || 0);
                $("#total_verdaderas").html(res.verdaderas || 0);
                $("#total_falsas").html(res.falsas || 0);
                $("#total_usuarios").html(res.usuarios || 0);
            } catch (e) {
                console.error("Error al parsear JSON del escritorio", e);
            }
        }
    });
}

// Ejecutamos al cargar
$(document).ready(function() {
    init();
});