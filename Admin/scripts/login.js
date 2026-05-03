$("#frmAcceso").on('submit', function(e) {
    e.preventDefault();
    
    let logina = $("#logina").val();
    let clavea = $("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar", 
        {"logina": logina, "clavea": clavea}, 
        function(data) {
            // Limpiamos la respuesta por si PHP manda algún espacio en blanco extra
            data = $.trim(data);

            if (data !== "null" && data !== "0" && data !== "") {
                // Si el login es exitoso, redirigimos
                $(location).attr("href", "escritorio.php");
            } else {
                // Mostramos el error con SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Acceso Denegado',
                    text: 'Usuario y/o contraseña incorrectos.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Reintentar'
                });

                // Borramos la contraseña para que el usuario la vuelva a escribir
                $("#clavea").val("");
            }
        }
    );
});