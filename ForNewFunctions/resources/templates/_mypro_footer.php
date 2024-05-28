            <div class="page-footer">
                
                <!-- END FOOTER -->
                <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
                <!-- BEGIN CORE PLUGINS -->
                <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
                <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
                <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
                <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
                <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
                <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
                <!-- END CORE PLUGINS -->
                <!-- BEGIN PAGE LEVEL PLUGINS -->
                <script src="assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>
                <!-- END PAGE LEVEL PLUGINS -->
                <!-- BEGIN THEME GLOBAL SCRIPTS -->
                <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
                <!-- END THEME GLOBAL SCRIPTS -->
                <!-- BEGIN THEME LAYOUT SCRIPTS -->
                <script src="assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
                <script src="assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
                <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
                <script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
                <script src="js/process.js"></script>
                <!-- END THEME LAYOUT SCRIPTS -->
                <!-- personal script -->
                <script>
                    $(document).ready(function() {
                        $('#dogshit').multiselect({
                            onChange: function(option, checked) {
                                // Get the selected values
                                var selectedValues = $('#dogshit').val();
                                console.log(selectedValues);
                            }
                        });
                        $('#shitdog').multiselect({
                            onChange: function(option, checked) {
                                // Get the selected values
                                var selectedValues = $('#shitdog').val();
                                console.log(selectedValues);
                            }
                        });
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        $("#todo-task-modal").on("show.bs.modal", function() {
                            $(this).find(".modal-dialog").css({
                                transform: "translateX(100%)",
                                opacity: 0,
                                "transition": "transform 0.3s ease-in-out, opacity 0.3s ease-in-out"
                            });
                        });

                        $("#todo-task-modal").on("shown.bs.modal", function() {
                            $(this).find(".modal-dialog").css({
                                transform: "translateX(0)",
                                opacity: 1
                            });
                        });
                        $("#todo-task-modal").on("hide.bs.modal", function() {
                            $(this).find(".modal-dialog").css({
                                transform: "translateX(100%)",
                                opacity: 0,
                                "transition": "transform 0.6s ease-in-out, opacity 0.6s ease-in-out"
                            });
                        });
                    });
                    getData('ids');

                    function getData(key) {
                        //reviewed code
                        var view_id = <?= $_GET['view_id'] ?>;
                        var action = "ParentTask";
                        $.ajax({
                            url: 'modules/process.php',
                            method: 'POST',
                            dataType: 'text',
                            data: {
                                action: action,
                                view_id: view_id,
                                key: key
                            },
                            success: function(response) {
                                console.log(response);
                                $('#data_items').append(response);
                            }
                        });
                    }
                </script>
                <!-- end of personal script -->
                </body>

                </html>