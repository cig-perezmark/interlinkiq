<?php 
    $title = "System Settings";
    $site = "settings";
    $breadcrumbs = '';
    $sub_breadcrumbs = '';

    if ($sub_breadcrumbs) {
        $breadcrumbs .= '<li><span>'. $sub_breadcrumbs .'</span><i class="fa fa-angle-right"></i></li>';
    }
    $breadcrumbs .= '<li><span>'. $title .'</span></li>';

    include_once ('header.php'); 
?>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark bold uppercase">System Settings</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group">
                                            <a class="btn dark btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a data-toggle="modal" href="#modalNew" > Add New Customer</a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="javascript:;">Option 2</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Option 3</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Option 4</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <form method="post" class="form-horizontal formSettings">
                                        <input class="form-control" type="hidden" name="ID" value="<?php echo $current_userID; ?>" />
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Header Background</label>
                                            <div class="col-md-3"><input type="text" name="bgHeader" class="form-control demo" data-control="hue" value="<?php echo !empty($bgHeader) == true ? $bgHeader : "#ffffff"; ?>" required /></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Header Logo Background</label>
                                            <div class="col-md-3"><input type="text" name="bgHeaderLogo" class="form-control demo" data-control="hue" value="<?php echo !empty($bgHeaderLogo) == true ? $bgHeaderLogo : "#ffffff"; ?>" required /></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Sidebar Background</label>
                                            <div class="col-md-3"><input type="text" name="bgSidebar" class="form-control demo" data-control="hue" value="<?php echo !empty($bgSidebar) == true ? $bgSidebar : "#26344B"; ?>" required /></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Body Background</label>
                                            <div class="col-md-3"><input type="text" name="bgBody" class="form-control demo" data-control="hue" value="<?php echo !empty($bgBody) == true ? $bgBody : "#eef1f5"; ?>" required /></div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <input type="submit" class="btn dark btn-outlinen" name="btnSave_SettingsDefault" id="btnSave_SettingsDefault" value="Default Settings" />
                                                    <input type="submit" class="btn green" name="btnSave_Settings" id="btnSave_Settings" value="Save" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                        </div>
                                     
                    </div><!-- END CONTENT BODY -->

        <?php include_once ('footer.php'); ?>
        
        <script type="text/javascript">
            var ComponentsColorPickers=function(){
                var t=function(){
                    jQuery().colorpicker&&($(".colorpicker-default").colorpicker({format:"hex"}),
                        $(".colorpicker-rgba").colorpicker())
                },
                o=function(){
                    $(".demo").each(function(){
                        $(this).minicolors({
                            control:$(this).attr("data-control")||"hue",
                            defaultValue:$(this).attr("data-defaultValue")||"",
                            inline:"true"===$(this).attr("data-inline"),
                            letterCase:$(this).attr("data-letterCase")||"lowercase",
                            opacity:$(this).attr("data-opacity"),
                            position:$(this).attr("data-position")||"bottom left",
                            change:function(t,o){
                                t&&(o&&(t+=", "+o),"object"==typeof console&&console.log(t))
                            },
                            theme:"bootstrap"
                        })
                    })
                };
                return{ init:function(){o(),t()} }
            }();
            jQuery(document).ready(function(){
                ComponentsColorPickers.init()
            });

            // Data Save
            $(document).ready(function(){
                BtnSave.init()
                BtnDefault.init()
                $(".formSettings").validate();
            });
            var BtnSave=function(){
                return{
                    init:function(){
                        $("#btnSave_Settings").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.formSettings').serialize()+'&btnSave_Settings=btnSave_Settings';
                            $.ajax({
                                url:'function.php',
                                type:'post',
                                dataType:'JSON',
                                data:data,
                                success:function(response) {
                                    $.bootstrapGrowl(response.message,{
                                        ele:"body",
                                        type:"success",
                                        offset:{
                                            from:"top",
                                            amount:100
                                        },
                                        align:"right",
                                        width:250,
                                        delay:5000,
                                        allow_dismiss:1,
                                        stackup_spacing:10
                                    })
                                }
                            });
                        })
                    }
                }
            }();
            var BtnDefault=function(){
                return{
                    init:function(){
                        $("#btnSave_SettingsDefault").click(function(event){
                            event.preventDefault();

                            formObj = $(this).parents().parents();
                            if (!formObj.validate().form()) return false;

                            var data = $('.formSettings').serialize()+'&btnSave_SettingsDefault=btnSave_SettingsDefault';
                            $.ajax({
                                url:'function.php',
                                type:'post',
                                dataType:'JSON',
                                data:data,
                                success:function(response) {
                                    $.bootstrapGrowl(response.message,{
                                        ele:"body",
                                        type:"success",
                                        offset:{
                                            from:"top",
                                            amount:100
                                        },
                                        align:"right",
                                        width:250,
                                        delay:5000,
                                        allow_dismiss:1,
                                        stackup_spacing:10
                                    })
                                }
                            });
                        })
                    }
                }
            }();
        </script>

    </body>
</html>