<footer class="main-footer">
    <!--  <div class="pull-right hidden-xs">
       <b>Version</b> 2.4.0
     </div> -->
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="">Demostream</a>.</strong> All rights
    reserved.
</footer>

<script type="text/javascript">
    $('#cancel').click(function () {
        $('.form-reset')[0].reset();
    });
</script>
<script>
    $('#example1').DataTable({
        responsive: true,
        scroller: true,
        scrollY: true,
        sScrollX: "100%",
        sScrollXInner: "100%"
    });
     $('#example').DataTable({
        responsive: true,
        scroller: true,
        scrollY: true,
        sScrollX: "100%",
        sScrollXInner: "100%",
        order:[0,'desc']
    });
    
    
    
    function confirm(id, name) {

        bootbox.confirm({
            title: '',
            message: '<h4><i class="fa fa-remove text-danger"></i>&nbsp;&nbsp;Are you sure you want to delete this ' + name + ' ?</h4>',
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function (result) {
                if (result == true) {
                    window.location.replace(id);
                }
            }
        });
    }
</script>


<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/admin/js/demo.js"></script>


</body>
</html>