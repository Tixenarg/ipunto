<footer>
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-lg-6 mb-5">

                <a class="navbar-brand" href="index.php">
                    <img src="assets/img/logoblanco.png"
                        alt="Logo Ipunto"
                        class="img-fluid"
                        style="max-height: 40px; width: auto;">
                </a>
                <p class="text-secondary pe-lg-5">Combatimos la desinformación con datos crudos y periodismo de precisión. Porque la verdad no tiene precio, pero sí tiene pruebas.</p>
                <!--                 <div class="d-flex gap-3 mt-4 justify-content-center justify-content-md-start">
                    <a href="#"><i class="fa-brands fa-x-twitter fs-4"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram fs-4"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin fs-4"></i></a>
                </div> -->
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
                <h5>Newsletter</h5>
                <p class="small text-secondary">La verdad, cada lunes en tu inbox.</p>

                <form id="frmNewsletter" class="input-group">
                    <input type="email" class="form-control bg-transparent border-secondary text-white" id="emailNewsletter" name="email" placeholder="Tu email" required>
                    <button type="submit" class="btn btn-primary" id="btnSuscripcion">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="border-top border-secondary mt-5 pt-4 text-center">
            <p class="small text-secondary">© 2026 Ipunto. Prohibida la reproducción sin citar la fuente.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    $es_local = ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1');
    $ruta_base = $es_local ? '/ipunto/' : '/'; 
    ?>
    
    <script>
    // 1. Guardamos la ruta base en una constante de JS
    const RUTA_BASE = '<?php echo $ruta_base; ?>';

    $(document).ready(function() {
        $("#frmNewsletter").on('submit', function(e) {
            e.preventDefault(); 
            
            let email = $("#emailNewsletter").val();
            let btn = $("#btnSuscripcion");

            btn.prop("disabled", true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

            // 2. Usamos la RUTA_BASE acá. Así funciona impecable en local y en Hostinger
            $.post(RUTA_BASE + "ajax/suscriptor.php?op=guardar", {email: email}, function(data) {
                
                btn.prop("disabled", false).html('<i class="fa-solid fa-paper-plane"></i>');
                
                data = $.trim(data);
                if (data === "ok") {
                    Swal.fire({ icon: 'success', title: '¡Suscrito!', text: 'Gracias por sumarte.', confirmButtonColor: '#c93b28' });
                    $("#emailNewsletter").val("");
                } else if (data === "existe") {
                    Swal.fire({ icon: 'info', title: 'Ya registrado', text: 'Este mail ya es parte del club.' });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo guardar.' });
                }
            });
        });
    });
    </script>
</body>

</html>