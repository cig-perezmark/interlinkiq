<div class="footer-wrap pd-20 mb-20 card-box d-print-none">
				<a href="https://consultareinc.com/dropways" target="_blank">Consultare Incorporated</a>
			</div>
			
			
<!-- axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const axiosInstance = axios.create({
    baseURL: '<?= base_url() ?>',
    timeout: 10000
});

axios = axiosInstance;
</script>

	<!-- js -->
	<!-- js -->
    <script src="<?php echo base_url(); ?>css/js/js.js"></script>
	<script src="<?php echo base_url(); ?>css/vendors/scripts/core.js"></script>
    <script src="<?php echo base_url(); ?>css/vendors/scripts/script.min.js"></script>
    <script src="<?php echo base_url(); ?>css/vendors/scripts/process.js"></script>
    <script src="<?php echo base_url(); ?>css/vendors/scripts/layout-settings.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

	<!-- buttons for Export datatable -->
    
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>css/src/plugins/datatables/js/vfs_fonts.js"></script>

	<!-- Datatable Setting js -->
    <script src="<?php echo base_url(); ?>css/vendors/scripts/datatable-setting.js"></script>

    

</html>
