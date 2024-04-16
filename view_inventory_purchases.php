<div id="purchases_tab" class="tab-pane fade">
   <ul class="nav nav-tabs">
      <li><a data-toggle="tab" href="#all_purchases">All</a></li>
      <li><a data-toggle="tab" href="#draft">Drafted</a></li>
      <li><a data-toggle="tab" href="#for_approval">For Approval</a></li>
      <li><a data-toggle="tab" href="#for_delivery">For Delivery</a></li>
      <li><a data-toggle="tab" href="#received">Received</a></li>
      <li><a data-toggle="tab" href="#cancelled">Cancelled</a></li>
   </ul>
   <div class="tab-content">
      <div id="all_purchases" class="tab-pane fade">

         <div class="row widget-row">
            <div class="col-md-4">
               <div class="row widget-row widget-row1"></div>
               <div class="row widget-row widget-row2"></div>
            </div>
            <div class="col-md-8">
               <div class="panel panel-default">
                  <div class="panel-body">
                     <h5 class="xmt12 p-2 text-primary"><strong>Breakdown of Purchase Orders by Status</strong></h5>
                     <div id=chart1div style="height:250px;width:100%"></div>
                  </div>
               </div>  
            </div>
         </div>
         <div class="row mt12">
            <div class="col-12">
               <div class="panel panel-default">
                  <div class="panel-body"><table class="main_table table table-bordered"></table></div>
               </div>               
            </div>
         </div>
      </div>

      <div id="draft" class="tab-pane fade">
         <div class="row">
            <div class="col-lg-6">
               <h3 class=drafted_title>Drafted</h3>
            </div>
            <div class="col-lg-6">
               <input type=button class="btn btn-md btn-primary pull-right mt-2" value="Add Purchase Order" data-toggle="modal" data-target="#add_po_modal">
            </div>
         </div>
         <div class="row mt12">
            <div class="col-12">
               <div class="panel panel-default">
                  <div class="panel-body"><table class="main_table table table-bordered"></table></div>
               </div> 
            </div>
         </div>
      </div>

      <div id="for_approval" class="tab-pane fade">
         <div class="row">
            <div class="col-lg-12">
               <h3 class=for_approval_title>For Approval</h3>
            </div>
         </div>
         <div class="row mt12">
            <div class="col-12">
               <div class="panel panel-default">
                  <div class="panel-body"><table class="main_table table table-bordered"></table></div>
               </div> 
            </div>
         </div>
      </div>
   
      <div id="for_delivery" class="tab-pane fade">
         <div class="row">
            <div class="col-lg-12">
               <h3 class=for_delivery_title>For Delivery</h3>
            </div>
         </div>
         <div class="row mt12">
            <div class="col-12">
               <div class="panel panel-default">
                  <div class="panel-body"><table class="main_table table table-bordered"></table></div>
               </div> 
            </div>
         </div>
      </div>
   
      <div id="received" class="tab-pane fade">
         <div class="row">
            <div class="col-lg-12">
               <h3 class=received_title>Received</h3>
            </div>
         </div>
         <div class="row mt12">
            <div class="col-12">
               <div class="panel panel-default">
                  <div class="panel-body"><table class="main_table table table-bordered"></table></div>
               </div> 
            </div>
         </div>
      </div>
   
      <div id="cancelled" class="tab-pane fade">
         <div class="row">
            <div class="col-lg-12">
               <h3 class=cancelled_title>Cancelled</h3>
            </div>
         </div>
         <div class="row mt12">
            <div class="col-12">
               <div class="panel panel-default">
                  <div class="panel-body"><table class="main_table table table-bordered"></table></div>
               </div> 
            </div>
         </div>
      </div>
   </div> 
</div>