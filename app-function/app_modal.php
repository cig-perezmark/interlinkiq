<!--Update Status-->
<div class="modal fade" id="modal_update_pricing" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_update_pricing">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Pricing Details</h4>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                   <input class="btn btn-info" type="submit" name="btnSave_pricing" id="btnSave_pricing" value="Save" >
                </div>
            </form>
        </div>
    </div>
</div>
<!--Update Status-->
<div class="modal fade" id="modal_delete_pricing" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modal_delete_pricing">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Are You Sure You Want to delete the details below?</h4>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                   <input class="btn btn-warning" type="submit" name="btndelete_pricing" id="btndelete_pricing" value="Yes" >
                   <input type="button" class="btn btn-info" data-dismiss="modal" value="No" />
                </div>
            </form>
        </div>
    </div>
</div>

 <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="image_form" method="post"  class="form-horizontal modalSave" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">NEW APP DESCRIPTION FORM</h4>
                </div>
                <div class="modal-body"> 
                    <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-10">
                                <input class="form-control" type="hidden" name="apptype" id="apptype" value="LINK" />
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="application_name" id="application_name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="descriptions" id="descriptions" rows="3" required ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Pricing</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" name="pricing" id="pricing" value="0" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">App URL</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="app_url" id="app_url" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Image/Logo</label>
                        <div class="col-md-10">
                            <input class="form-control" type="file" id="image" name="image" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Developer</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" id="developer" name="developer" id="developer" required />
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="row">
                             <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-md-3 control-label">Image 1</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="file" id="image1" name="image1" required/>
                                </div>
                             </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Image 2</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="file" id="image2" name="image2" required/>
                                    </div>
                                 </div>
                             </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-md-3 control-label">Image 3</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="file" id="image3" name="image3" required/>
                                </div>
                             </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Image 4</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="file" id="image4" name="image4" required />
                                    </div>
                                 </div>
                             </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-md-3 control-label">Image 5</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="file" id="image5" name="image5" required/>
                                </div>
                             </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Image 6</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="file" id="image6" name="image6" required/>
                                    </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                    <input type="hidden" name="action" id="action" value="insert" />
                    <input type="hidden" name="app_id" id="app_id" />
                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
                </div>
            </form>
        </div>
    </div>
</div>

<!--get free app modal-->
<div class="modal fade bs-modal-lg" id="modalGetFree" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="getFreeAppForm" method="post" class="form-horizontal modalForm modalUpdate">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">App Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="action" value="insert" />
                    <input type="submit" class="btn green" name="insert" id="insert" value="Subscribe" />
                </div>
            </form>
        </div>
    </div>
</div>


<!--view modal-->

<div class="modal fade bs-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalUpdate">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">App Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>
                
<!--view modal library-->

<div class="modal fade bs-modal-lg" id="modalViewLibrary" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal modalForm modalUpdate">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">App Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalViewComply" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewComply">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Compliance Details</h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="submit" class="btn green ladda-button" name="btnUpdate_Comply" id="btnUpdate_Comply" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modalViewModule" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewModule">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Module Details</h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="submit" class="btn green ladda-button" name="btnUpdate_Module" id="btnUpdate_Module" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modalViewSOP" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" enctype="multipart/form-data" class="form-horizontal modalForm modalViewSOP">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">SOP Details</h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="submit" class="btn green ladda-button" name="btnUpdate_SOP" id="btnUpdate_SOP" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
				</div>
			</form>
		</div>
	</div>
</div>
