<head>
   <title>Print PO</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
   @media print{
      @page {
         size: auto;
         margin : 0;
         width: 100%;
      }
   }
</style>
<body>
<div class="container">
   <div class="row mt-3">
      <div class="col-lg-12 text-center"><img class=img-fluid style="width:150px; height:100px"></div>
      <div class="col-lg-12 text-center"><span class="h3 fw-bold">Purchase Order</h2></div>
   </div><hr>
   <div class="row">
      <?= create_el(6, "Purchase Order", '<input type="text" class="form-control" name="po" disabled>'); ?>
      <?= create_el(3, "Expected Arrival", '<input type="date" class="form-control" name="expected_arrival" disabled>'); ?>
      <?= create_el(3, "Created Date", '<input type="date" class="form-control" name="created_date" disabled>'); ?>
   </div>
   <div class="row">
      <?= create_el(6, "Supplier", '<input type=text class=form-control name="supplier_name" disabled>'); ?>
      <?= create_el(6, "Location", '<input type=text class=form-control name="location" disabled>'); ?>
   </div>
   <div class="row mt-1">
      <?= create_el(12, "Items", '<table class="item_table table table-bordered table-sm"><thead></thead><tbody></tbody></table>'); ?>
   </div>
   <div class="row">
      <?= create_el(12, "Remarks", '<textarea class=form-control name=remarks disabled></textarea>'); ?>
   </div>
   <div class="row mt-2">
      <div class="col-5 offset-7">
         <table class="table table-sm xtable-bordered">
            <tbody>
               <tr>
                  <td><strong>Subtotal (Tax excluded)</strong></td>
                  <td><span class=float-end name=sub_total></span></td>
               </tr>
               <tr>
                  <td><strong>Plus Tax</strong></td>
                  <td><span class=float-end name=tax></span></td>
               </tr>
               <tr>
                  <td><strong>Shipping</strong></td>
                  <td><span class=float-end name=shipping></span></td>
               </tr>
               <tr>
                  <td><strong>Total</strong></td>
                  <td><span class="float-end fw-bold" name=total_price></span></td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <div class="row mt-3">
      <div id=sig_row class="d-flex align-items-center text-center"></div>
   </div>
</div>
</body>
<?php
   function create_el($col_num, $label, $input){
      $el = '<div class=col-'.$col_num.'>';
      $el .= '<div class="form-group">';
      $el .= '<label class="form-label fw-bold">'.$label.'</label>';
      $el .= $input;
      $el .= '</div>';
      $el .= '</div>';
      return $el;
   }
?>
<script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
   $(()=>{
      const path = "inventory_functions.php";
      var id     = `<?php echo $_GET['id']; ?>`

      $.ajax({
         url: path,
         type: "post",
         dataType: "json",
         data: {
            get_po_print_details: true,
            id : id
         },
         success: function(response){

            const po_details = response.po_data
            const po_items   = response.po_items_data

            $('img').attr('src',po_details.logo)
            $("[name='supplier_name']").val(po_details.supplier_name)
            $("[name='location']").val(po_details.location)
            $("[name='expected_arrival']").val(po_details.expected_arrival)
            $("[name='created_date']").val(po_details.created_date)
            $("[name='po']").val(po_details.po)
            $("[name='remarks']").val(po_details.remarks)
            $("[name='sub_total']").text(display_amount(po_details.sub_total, po_details.currency))
            $("[name='tax']").text(display_amount(po_details.tax, po_details.currency))
            $("[name='shipping']").text(display_amount(po_details.shipping, po_details.currency))
            $("[name='total_price']").text(display_amount(po_details.total_price, po_details.currency))

            var sig_div = ""
            const sig_num = po_details.sig_num
            const col_div = 12/sig_num

            if(sig_num >= 1){
               var sig = get_fsig("Prepared By", po_details.drafted_by_sig, po_details.drafted_by_name, po_details.drafted_by_position, po_details.date_prepared)
               sig_div += `<div class=col-${col_div}>${sig}</div>`
            }

            if(sig_num >= 2){
               var sig = get_fsig("Approved By", po_details.approved_by_sig, po_details.approved_by_name, po_details.approved_by_position, po_details.date_approved)
               sig_div += `<div class=col-${col_div}>${sig}</div>`
            }

            if(sig_num == 3){
               var sig = get_fsig("Received By", po_details.po_received_by_sig, po_details.po_received_by_name, po_details.po_received_by_position, po_details.date_received)
               sig_div += `<div class=col-${col_div}>${sig}</div>`
            }

            $("#sig_row").html(sig_div)

            var items_header = `<tr>
               <th class=text-center>SKU</th>
               <th class=text-center>Item</th>
               <th class=text-center>Category</th>
               <th class=text-center>Quantity</th>
               ${sig_num == 3 ? '<th class=text-center>Quantity Received</th>' : ''}
               <th class=text-center>UoM</th>
               <th class=text-center>Price Per Unit</th>
               <th class=text-center>Total Price</th>
               <th class=text-center>Tax (in Percent)</th>
            </tr>`
            $(".item_table thead").html(items_header)

            var items_div = ""
            po_items.forEach(el=>{
               items_div += `<tr class=text-center>`
               items_div += `<td>${el.sku}</td>`
               items_div += `<td>${el.item}</td>`
               items_div += `<td>${el.category}</td>`
               items_div += `<td>${el.quantity}</td>`
               if(sig_num == 3){
                  items_div += `<td>${el.quantity_received}</td>`
               }               
               items_div += `<td>${el.uom}</td>`
               items_div += `<td>${display_amount(el.price_per_unit, po_details.currency)}</td>`
               items_div += `<td>${display_amount(el.total_price, po_details.currency)}</td>`
               items_div += `<td>${el.tax}</td>`
               items_div += `</tr>`
            })
            $(".item_table tbody").html(items_div)
         },
         error: function(response){
            alert(response.responseText)
         }
      })

      function get_fsig(label, signature, name_entered, position, date_entered){
         
         var sig = "";
         if(date_entered){
            sig += `<div class="fw-bold mt-2 mb-3">${label}</div>`
            sig += `<div><img style="height:50px;width:150px;" src="${signature}" class="mt-3"></div>`
            sig += `<div>${clean_data(name_entered)}</div>`
            sig += `<div>${clean_data(position)}</div>`
            sig += `<div>${clean_data(date_entered)}</div>`
         }
         return sig 
      }

      function clean_data(data){
         return data == null ? "" : data;
      }

      function add_comma(x) {
         return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      }

      function display_amount(amount, currency){
         return `${add_comma(amount)} ${currency}`
      }
   })
</script>
