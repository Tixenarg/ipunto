var tabla;

// Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });
}

// Función limpiar campos
function limpiar() {
    $("#nombre").val("");
    $("#apellido").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#idusuario").val("");
}

// Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

// Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

// Función Listar
// Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, // Activa el procesamiento del datatables
        "aServerSide": true, // Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', // Definimos los elementos del control de tabla
        
        // --- ACÁ ESTÁ LA MAGIA: TRADUCCIÓN AL ESPAÑOL ---
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando del 0 al 0 de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sSearch":         "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        // ------------------------------------------------

        "ajax": {
            url: '../ajax/usuario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, // Paginación
        "order": [[0, "desc"]] // Ordenar (columna, orden)
    }).DataTable();
}

// Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); // No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            // Reemplazamos alert() por SweetAlert2
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: datos,
                showConfirmButton: false,
                timer: 1500
            });
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idusuario) {
    $.post("../ajax/usuario.php?op=mostrar", {idusuario: idusuario}, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#apellido").val(data.apellido);
        $("#login").val(data.login);
        $("#tipo").val(data.tipo);
        $("#idusuario").val(data.idusuario);
    });
}

// Función para desactivar registros
function desactivar(idusuario) {
    // Reemplazamos confirm() por SweetAlert2
    Swal.fire({
        title: '¿Está seguro?',
        text: "El usuario será desactivado y no podrá acceder al sistema.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../ajax/usuario.php?op=desactivar", {idusuario: idusuario}, function(e) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Desactivado!',
                    text: e,
                    showConfirmButton: false,
                    timer: 1500
                });
                tabla.ajax.reload();
            });
        }
    });
}

// Función para activar registros
function activar(idusuario) {
    // Reemplazamos confirm() por SweetAlert2
    Swal.fire({
        title: '¿Está seguro?',
        text: "El usuario será activado nuevamente.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, activar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../ajax/usuario.php?op=activar", {idusuario: idusuario}, function(e) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Activado!',
                    text: e,
                    showConfirmButton: false,
                    timer: 1500
                });
                tabla.ajax.reload();
            });
        }
    });
}

init();