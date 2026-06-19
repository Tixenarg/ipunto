<footer>
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-lg-6 mb-5">
                <a class="navbar-brand" href="<?php echo defined('RUTA_BASE') ? RUTA_BASE : ''; ?>index.php">
                    <img src="<?php echo defined('RUTA_BASE') ? RUTA_BASE : ''; ?>assets/img/logoblanco.png"
                        alt="Logo Ipunto"
                        class="img-fluid"
                        style="max-height: 40px; width: auto;">
                </a>
                <p class="text-secondary pe-lg-5">Todo lo importante del día, en un solo lugar.</p>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Metodología</h5>
                <ul class="list-unstyled">
                    <li><a href="#">El Sello Ipunto</a></li>
                    <li><a href="#">Fuentes Abiertas</a></li>
                    <li><a href="#">Transparencia</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 text-center bg-dark p-4 rounded-4">
                <h5 class="mb-3 text-white">Newsletter</h5>
                <form id="frmNewsletter">
                    <div class="input-group">
                        <input type="email" id="emailNewsletter" class="form-control" placeholder="Tu correo electrónico" required>
                        <button class="btn btn-outline-light" type="submit" id="btnSuscripcion">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <hr class="border-secondary my-4">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-secondary small">&copy; 2026 Ipunto. Todos los derechos reservados.</span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <ul class="list-inline mb-0 small">
                    <li class="list-inline-item"><a href="#" class="text-secondary text-decoration-none">Privacidad</a></li>
                    <li class="list-inline-item"><a href="#" class="text-secondary text-decoration-none">Términos</a></li>
                    <li class="list-inline-item"><a href="#" class="text-secondary text-decoration-none">Contacto</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- SCRIPTS OBLIGATORIOS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // USAMOS LA CONSTANTE GLOBAL QUE DEFINISTE EN GLOBAL.PHP
    // Si por alguna razón no está definida en la vista actual, usa una ruta vacía por defecto
    const RUTA_BASE = '<?php echo defined("RUTA_BASE") ? RUTA_BASE : ""; ?>';

    $(document).ready(function() {
        $("#frmNewsletter").on('submit', function(e) {
            e.preventDefault();

            let email = $("#emailNewsletter").val();
            let btn = $("#btnSuscripcion");

            btn.prop("disabled", true).html('<i class=\"fa-solid fa-spinner fa-spin\"></i>');

            // URL dinámica absoluta
            $.post(RUTA_BASE + "ajax/suscriptor.php?op=guardar", {
                email: email
            }, function(data) {

                btn.prop("disabled", false).html('<i class=\"fa-solid fa-paper-plane\"></i>');

                data = $.trim(data);
                if (data === "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Suscrito!',
                        text: 'Gracias por sumarte.',
                        confirmButtonColor: '#c93b28'
                    });
                    $("#emailNewsletter").val("");
                } else if (data === "existe") {
                    Swal.fire({
                        icon: 'info',
                        title: 'Ya registrado',
                        text: 'Este mail ya está en nuestra lista.',
                        confirmButtonColor: '#c93b28'
                    });
                    $("#emailNewsletter").val("");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo procesar la suscripción.',
                        confirmButtonColor: '#c93b28'
                    });
                }
            }).fail(function() {
                btn.prop("disabled", false).html('<i class=\"fa-solid fa-paper-plane\"></i>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Red',
                    text: 'No se pudo conectar con el servidor.',
                    confirmButtonColor: '#c93b28'
                });
            });
        });
    });
</script>
</body>
</html>