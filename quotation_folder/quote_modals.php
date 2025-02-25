<!--add modal requirement-->
<div class="modal fade bs-modal-lg" id="add_requirement" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm add_requirement">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add New Requirement</h4>
                </div>
                <div class="modal-body">
                     <div class="form-group">
                        <div class="col-md-12">
                            <label>Service Name</label>
                            <input class="form-control" name="quote_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Estimated Hour</label>
                            <input type="number" class="form-control" name="estimated_hrs">
                        </div>
                        <div class="col-md-6">
                            <label>Estimated Cost</label>
                            <input type="number" class="form-control" name="estimated_cost">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Hourly Rate</label>
                            <input type="number" class="form-control" name="hourly_rate">
                        </div>
                        <div class="col-md-6">
                            <label>Estimated Time of Delivery</label>
                            <input type="date" class="form-control" name="time_of_delivery" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Supporting Files</label>
                            <input type="file" class="form-control" name="file_attch">
                        </div>
                        <div class="col-md-6">
                            <label>Services Category</label>
                            <select  class="form-control" name="quote_category">
                            <option value="0">--Select--</option>
                            <?php
                                $sql_category = mysqli_query($conn,"select * from tblQuotation_cat");
                                foreach($sql_category as $row_cat){?>   
                                    <option  value="<?= $row_cat['category_id']; ?>"><?= $row_cat['Category_Name']; ?></option>
                               <?php }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="btnAdd_requirement" id="btnAdd_requirement" value="Save" class="btn btn-info">       
                 </div>
        </div>
    </div>
    </form>
</div>

<!--view modal requirement-->
<div class="modal fade bs-modal-lg" id="modalGet_requirement" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm modalGet_requirement">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Requirement Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="submit" name="update_requirement" id="update_requirement" value="Save" class="btn btn-info">       
                 </div>
        </div>
    </div>
    </form>
</div>


<!--add modal category-->
<div class="modal fade bs-modal-lg" id="add_category" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm add_category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add New Category</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Category Name</label>
                        <input class="form-control" name="Category_Name">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="btnAdd_category" id="btnAdd_category" value="Save" class="btn btn-info">       
             </div>
        </div>
    </div>
    </form>
</div>

<!--add modal TOS-->
<div class="modal fade bs-modal-lg" id="add_tos" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm add_tos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Terms Of Condition</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Terms</label>
                        <input class="form-control" name="tos_name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea class="form-control" name="tos_description" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="btnAdd_tos" id="btnAdd_tos" value="Save" class="btn btn-info">       
             </div>
        </div>
    </div>
    </form>
</div>

<!--add modal paymet-->
<div class="modal fade bs-modal-lg" id="add_payment" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm add_payment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Payment</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Price</label>
                        <input class="form-control" type="number" name="links_price">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label>Subscription Links</label>
                        <input class="form-control" type="url" name="links">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="btnAdd_payment" id="btnAdd_payment" value="Save" class="btn btn-info">       
             </div>
        </div>
    </div>
    </form>
</div>
<!--view modal category-->
<div class="modal fade bs-modal-lg" id="modalGet_category" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm modalGet_category">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Category Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="submit" name="update_category" id="update_category" value="Save" class="btn btn-info">       
                 </div>
        </div>
    </div>
    </form>
</div>
<!--view modal payment-->
<div class="modal fade bs-modal-lg" id="modalGet_payment" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm modalGet_payment">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Payment Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="submit" name="update_payment" id="update_payment" value="Save" class="btn btn-info">       
                 </div>
        </div>
    </div>
    </form>
</div>
<!--view modal tos-->
<div class="modal fade bs-modal-lg" id="modalGet_tos" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm modalGet_tos">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Terms Of Service Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <input type="submit" name="update_tos" id="update_tos" value="Save" class="btn btn-info">       
                 </div>
        </div>
    </div>
    </form>
</div>

<!--view modal tos-->
<div class="modal fade bs-modal-lg" id="modalGet_records" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" class="form-horizontal modalForm modalGet_records">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Record Details</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <!--<input type="submit" name="update_records" id="update_records" value="Save" class="btn btn-info">       -->
                 </div>
        </div>
    </div>
    </form>
</div>
