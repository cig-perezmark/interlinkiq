 <!--view project modal-->
 <div class="modal fade bs-modal-lg" id="modalGetMyPro_update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <form action="MyPro_Folders/mypro_action.php" method="POST" enctype="multipart/form-data">
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
 
 <!-- add new parent -->
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
<!-- modalGetHistory_Child add Child 2 layer -->
<div class="modal fade" id="modalGetHistory_Child2" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_Child2">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem_layer2" id="btnSave_AddChildItem_layer2" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modalGetHistory_Child add Child 3 layer -->
<div class="modal fade" id="modalGetHistory_Child3" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_Child3">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem_layer3" id="btnSave_AddChildItem_layer3" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modalGetHistory_Child add Child 4 layer -->
<div class="modal fade" id="modalGetHistory_Child4" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_Child4">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem_layer4" id="btnSave_AddChildItem_layer4" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modalGetHistory_Child add Child 5 layer -->
<div class="modal fade" id="modalGetHistory_Child5" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_Child5">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_AddChildItem_layer5" id="btnSave_AddChildItem_layer5" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Services -->
<div class="modal fade" id="modalGetHistory_logs" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_logs">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Service Log 
                        (<i style="color:#B73E3E;font-size:12px;font-weight:600;">Please double check the date completed and Account. Thank you</i>)
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_add_logs" id="btnSave_add_logs" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Services -->
<div class="modal fade" id="modal_get_newlogs" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_get_newlogs">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Service Log 
                        (<i style="color:#B73E3E;font-size:12px;font-weight:600;">Please double check the date completed and Account. Thank you</i>)
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="Save_logs" id="Save_logs" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Services 3 -->
<div class="modal fade" id="modalGetHistory_logs3" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_logs3">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Service Log 
                        (<i style="color:#B73E3E;font-size:12px;font-weight:600;">Please double check the date completed and Account. Thank you</i>)
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_add_logs3" id="btnSave_add_logs3" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Services 4 -->
<div class="modal fade" id="modalGetHistory_logs4" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_logs4">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Service Log 
                        (<i style="color:#B73E3E;font-size:12px;font-weight:600;">Please double check the date completed and Account. Thank you</i>)
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_add_logs4" id="btnSave_add_logs4" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Services 5 -->
<div class="modal fade" id="modalGetHistory_logs5" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_logs5">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Service Log 
                        (<i style="color:#B73E3E;font-size:12px;font-weight:600;">Please double check the date completed and Account. Thank you</i>)
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_add_logs5" id="btnSave_add_logs5" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Add Services 6 -->
<div class="modal fade" id="modalGetHistory_logs6" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGetHistory_logs6">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Service Log 
                        (<i style="color:#B73E3E;font-size:12px;font-weight:600;">Please double check the date completed and Account. Thank you</i>)
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_add_logs6" id="btnSave_add_logs6" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
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
                <div class="modal-header">
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
<!--__seemore_parent_item -->
<div class="modal fade" id="modalGet_more_detail" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Description</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_parent_item -->
<div class="modal fade" id="modalGet_more_detail2" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail2">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Description</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_sub_item -->
<div class="modal fade" id="modalGet_more_detail_sub2" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail_sub2">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Task Name</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_sub_item -->
<div class="modal fade" id="modalGet_more_detail_sub3" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail_sub3">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Task Name</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_sub_item -->
<div class="modal fade" id="modalGet_more_detail_sub4" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail_sub4">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Task Name</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>
<!--__seemore_sub_item -->
<div class="modal fade" id="modalGet_more_detail_sub5" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail_sub5">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Task Name</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_sub_item -->
<div class="modal fade" id="modalGet_more_detail_sub6" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail_sub6">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Task Name</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_parent_item -->
<div class="modal fade" id="modalGet_more_detail3" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail3">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Description</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_parent_item -->
<div class="modal fade" id="modalGet_more_detail4" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail4">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Description</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_parent_item -->
<div class="modal fade" id="modalGet_more_detail5" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail5">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Description</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<!--__seemore_parent_item -->
<div class="modal fade" id="modalGet_more_detail6" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_more_detail6">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Description</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>
<!--__update_parent_item -->
<div class="modal fade" id="modalGet_parent" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_parent">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSubmit_parent" id="btnSubmit_parent" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--__update_Action_item -->
<div class="modal fade" id="modalGet_child2" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_child2">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSubmit_2" id="btnSubmit_2" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--__update_shortcut -->
<div class="modal fade" id="modalGet_shortcut" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_shortcut">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSubmit_shortcut" id="btnSubmit_shortcut" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--__update_Action_item -->
<div class="modal fade" id="modalGet_child3" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_child3">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSubmit_3" id="btnSubmit_3" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--__update_Action_item 4 -->
<div class="modal fade" id="modalGet_child4" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_child4">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSubmit_4" id="btnSubmit_4" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--__update_Action_item 5 -->
<div class="modal fade" id="modalGet_child5" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_child5">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSubmit_5" id="btnSubmit_5" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--__update_Action_item 6 -->
<div class="modal fade" id="modalGet_child6" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_child6">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">New Action Item</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSubmit_6" id="btnSubmit_6" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- Not Started  Modal -->
<div class="modal fade" id="modalGet_filter_notstarted" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_filter_notstarted">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Not Started</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>
<!-- Inprogress  Modal -->
<div class="modal fade" id="modalGet_filter_progress" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_filter_progress">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">In-progress</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>
<!-- Completed  Modal -->
<div class="modal fade" id="modalGet_filter_completed" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_filter_completed">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Completed</h4>
                </div>
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>
<!-- Comments Status Modal -->
<div class="modal fade" id="modalGet_Comments" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_Comments">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_Comments" id="btnSave_Comments" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Comments Status Modal -->
<div class="modal fade" id="modalGet_Comments_filter" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_Comments_filter">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_Comments_filter" id="btnSave_Comments_filter" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Comments3 Status Modal -->
<div class="modal fade" id="modalGet_Comments3" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_Comments3">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_Comments3" id="btnSave_Comments3" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Comments4 Status Modal -->
<div class="modal fade" id="modalGet_Comments4" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_Comments4">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_Comments4" id="btnSave_Comments4" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Comments5 Status Modal -->
<div class="modal fade" id="modalGet_Comments5" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_Comments5">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_Comments5" id="btnSave_Comments5" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Comments6 Status Modal -->
<div class="modal fade" id="modalGet_Comments6" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalGet_Comments6">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Comments</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <button type="submit" class="btn green ladda-button" name="btnSave_Comments6" id="btnSave_Comments6" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>