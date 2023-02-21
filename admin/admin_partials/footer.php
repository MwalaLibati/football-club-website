<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>
    All rights reserved.
    &copy; <?php echo date("Y") ?> Mufulira Wanderers FC. All rights reserved
  </strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Designed By</b> Stone & Jdslk
  </div>
</footer>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Custom Forms -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function() {
    bsCustomFileInput.init();
  });
</script>

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<!-- <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<!-- <script src="dist/js/adminlte.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../script/init.js"></script>
<script src="../script/toastManager.js"></script>
<script src="../script/productDetails.js"></script>
<script src="../script/categoryUpload.js"></script>
<script src="../script/categoryControl.js"></script>
<script src="../script/productControl.js"></script>
<script src="../script/uploadProduct.js"></script>
<script src="../script/membershipTypeControl.js"></script>
<script src="../script/activateMemberAdminControl.js"></script>
<script src="../script/adminMembership.js"></script>
<script src="../script/signupFormSubmit.js"></script>
<script src="../script/membershipForm.js"></script>
<script src="../script/NRC_Formatting.js"></script>
<script src="../script/loadMsgs.js"></script>
<script src="../script/composeMsg.js"></script>
<script src="../script/homePageBanners.js"></script>
<script>
  $(function() {
    $("#example1,#example22,#example33").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<?php
//DISPLAY MSG-----------------------------------------------------------------
if (isset($_GET["msg"]) && isset($_GET["type"])) {
  echo '
        <script>
            $(document).ready(function () {
                toastMe("' . $_GET["msg"] . '", "' . $_GET["type"] . '", 120);
            });
        </script>
    ';
} ?>

</body>

</html>