<!--view modal-->
<div class="modal fade bs-modal-lg" id="modalGetMyPro_update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Project Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="submit" name="update_Project" value="Update" class="btn btn-info">       
                 </div>
            </form>
        </div>
    </div>
</div>
                        
<!--view modalGetMyPro_History-->
<div class="modal fade bs-modal-lg" id="modalGetMyPro_History" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:80%;">
        <div class="modal-content">
             <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Task Action</h4>
                </div>
                <div class="modal-body">
                    
                </div>
               
            </form>
        </div>
    </div>
</div>
<!--view modal-->
<div class="modal fade bs-modal-lg" id="modalGetMyPro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
             <form action="MyPro_Folders/MyPro_function.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Project Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="submit" name="btnAssign_Project" value="Assign" class="btn btn-info">       
                 </div>
            </form>
        </div>
    </div>
</div>
    <!-- Employee File -->
<div class="modal fade" id="modalAddActionItem" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalAddActionItem">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_History" id="btnSave_History" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
            
<!-- modalGetHistory File -->
<div class="modal fade" id="modalGetHistory" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem" id="btnSave_AddChildItem" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modalGetHistory_Child add Child layer -->
<div class="modal fade" id="modalGetHistory_Child" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_Child">
                <div class="modal-header">addNew
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem_layer" id="btnSave_AddChildItem_layer" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
                        
<!--__update_Action_item -->
<div class="modal fade" id="modalGetHistory_update_Action_item" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_update_Action_item">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_update_Action_item" id="btnSave_update_Action_item" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
                        
<!--  Modal Calendar -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm calendarModal">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn red btn-outline btn-xs" data-dismiss="modal" value="Close" />
                </div>
            </form>
        </div>
    </div>
</div>
<!--__update_shortcut > -->
<div class="modal fade" id="modalGet_shortcut" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_shortcut">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><b>Task Details</b></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline btn-xs" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button btn-xs" name="btnSubmit_shortcut" id="btnSubmit_shortcut" data-style="zoom-out"><span class="ladda-label">Save</span></button>
                </div>
            </form>
        </div>
    </div>
</div>