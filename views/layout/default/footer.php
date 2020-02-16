<!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿ Listo para Salir ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Seleccione "Cerrar Ssesi&oacute;n" a continuación si está listo para finalizar su sesión actual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="<?php echo BASE_URL ?>login/cerrar/">Cerrar Sesi&oacute;n</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo BASE_URL ?>public/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo BASE_URL ?>public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo BASE_URL ?>public/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo BASE_URL ?>public/js/sb-admin-2.min.js"></script>

  <script src="<?php echo BASE_URL ?>public/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo BASE_URL ?>public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo BASE_URL ?>public/js/demo/datatables-demo.js"></script>

  <script src="<?php echo BASE_URL ?>public/js/bootstrap-datepicker/bootstrap-datepicker.js"></script>
  <script src="<?php echo BASE_URL ?>public/js/bootstrap-datepicker/bootstrap-datepicker.es.min.js"></script>
  <script src="<?php echo BASE_URL ?>public/js/bootstrap-select/bootstrap-select.min.js"></script>

  <script src="<?php echo BASE_URL ?>public/js/inputmask/jquery.inputmask.js"></script>
  <script src="<?php echo BASE_URL ?>public/js/inputmask/bindings/inputmask.binding.js"></script>

  <script src="<?php echo BASE_URL; ?>public/js/toastr/toastr.min.js" type="text/javascript"></script>

  <script src="<?php echo BASE_URL ?>public/js/deparqueo.js?v=<?php echo(rand()); ?>"></script>
  

  <?php
    if (isset($_layoutParams['js']) && count($_layoutParams['js'])) {
      for ($i = 0; $i < count($_layoutParams['js']); $i++) {
        $x = substr($_layoutParams['js'][$i], -3);
        if ($x[0] == ".") { ?>
          <script src="<?php echo $_layoutParams['js'][$i] ?>?v=<?php echo(rand()); ?>" type="text/javascript"></script>
        <?php } else { ?>
          <link rel="stylesheet" href="<?php echo $_layoutParams['js'][$i] ?>" type="text/css" />
        <?php }
      }
    }
  ?>

</body>

</html>
