<head>
   <title>Print Checklist</title>
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
      <div class="col-lg-12 text-center"><span class="h3 fw-bold">Incoming Material Receiving Checklist</h2></div>
   </div><hr>
   <div class="row">
      <?= create_el(4, "Date Received", '<input type="date" class="form-control" name="date_received" disabled>'); ?>
      <?= create_el(4, "Arrival Time", '<input type="time" class="form-control" name="arrival_time" disabled>'); ?>
      <?= create_el(4, "PO # or Order #", '<input type="text" class="form-control" name="po" disabled>'); ?>
   </div>
   <div class="row">
      <?= create_el(8, "Supplier Name", '<input type=text class=form-control name="supplier_name" disabled>'); ?>
      <?= create_el(4, "Invoice", '<input type=text class=form-control name="invoice" disabled>'); ?>
   </div>
   <div class="row">
      <?= create_el(4, "Trailer #", '<input type=text class=form-control name="trailer_no" disabled>'); ?>
      <?= create_el(4, "Trailer Plate #", '<input type=text class=form-control name="trailer_plate" disabled>'); ?>
      <?= create_el(4, "Trailer Seal #", '<input type=text class=form-control name="trailer_seal" disabled>'); ?>
   </div>
   <h5><strong>Verify Packaging List</strong></h5><br>
   <table class="table table-sm table-bordered" id=warehouse_receiving_table1>
      <thead>
         <tr>
            <th width=40% colspan=2>List</th>
            <th width=30% colspan=3 class=text-center>Compliance</th>
            <th width=30% class=text-center>Corrective Action</th>
         </tr>
      </thead>
      <tbody></tbody>
   </table>
   <h5><strong>Vehicle or Transportation Inspection</strong></h5><br>
   <table class="table table-sm table-bordered" id=warehouse_receiving_table2>
      <thead>
         <tr>
            <th width=40% colspan=2>List</th>
            <th width=30% colspan=3 class=text-center>Compliance</th>
            <th width=30% class=text-center>Corrective Action</th>
         </tr>
      </thead>
      <tbody></tbody>
   </table>
   <div class=row>
      <div class=col-6>
         <div id=inspected2_container class=text-center></div>  
      </div>
      <div class=col-6>
         <div id=verified2_container class=text-center></div>  
      </div>
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
      const id   = `<?php echo $_GET['id']; ?>`

      $.ajax({
         url: path,
         type: "post",
         dataType: "json",
         data: {
            get_whouse_print_details: true,
            id : id
         },
         success: function(response){

            const po_details = response.main
            const table1 = response.table1
            const table2 = response.table2

            $('img').attr('src', po_details.logo)
            var cols = ["date_received","arrival_time","po","supplier_name","invoice","trailer_no","trailer_plate","trailer_seal"]
            cols.forEach(el=>{
               $(`[name='${el}']`).val(po_details[el])
            })
            
            var sig = get_fsig("Inspected By", po_details.supplier_inspected_by_sig, po_details.supplier_inspected_by_name, po_details.supplier_inspected_by_position, po_details.date_supplier_inspected)
            $("#inspected2_container").html(sig)

            sig = get_fsig("Verified By", po_details.supplier_verified_by_sig, po_details.supplier_verified_by_name, po_details.supplier_verified_by_position, po_details.date_supplier_verified)
            $("#verified2_container").html(sig)

            var div = "", counter = 1
            table1.forEach((el,index)=>{

               div += `<tr>
               <td>${counter}</td>
               <td>${el.description}</td>
               <td class=text-center colspan=3>
                  <label class="radio-inline">
                     <input type="radio" name="inlineRadio${index+el.id}" value=1 ${el.value==1 ? 'checked' : ''} disabled> Yes
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="inlineRadio${index+el.id}" value=2 ${el.value==2 ? 'checked' : ''} disabled> No
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="inlineRadio${index+el.id}" value=3 ${el.value==3 ? 'checked' : ''} disabled> N/A
                  </label>  
               </td>
               <td><input type=text class="form-control form-control-sm" name=corrective_action value='${el.corrective_action ? el.corrective_action : ""}' disabled></td>
               </tr>`
               counter++
            })
            $("#warehouse_receiving_table1 tbody").html(div)

            div = "", counter = 1
            table2.forEach((el,index)=>{

               div += `<tr>
               <td>${counter}</td>
               <td>${el.description}</td>
               <td class=text-center colspan=3>
                  <label class="radio-inline">
                     <input type="radio" name="inlineRadio${index+el.id}" value=1 ${el.value==1 ? 'checked' : ''} disabled> Yes
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="inlineRadio${index+el.id}" value=2 ${el.value==2 ? 'checked' : ''} disabled> No
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="inlineRadio${index+el.id}" value=3 ${el.value==3 ? 'checked' : ''} disabled> N/A
                  </label>  
               </td>
               <td><input type=text class=form-control name=corrective_action value='${el.corrective_action ? el.corrective_action : ""}' disabled></td>
               </tr>`
               counter++
            })
            $("#warehouse_receiving_table2 tbody").html(div)
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
