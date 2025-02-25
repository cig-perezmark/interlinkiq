
$(document).ready(function(){

$('[id*="edit_pay"]').click(function(){
    var id = $(this).attr('payid'); //get the attribute value
    var paiddate = $(this).attr('paiddate'); //get the attribute value
    var amount = $(this).attr('amount'); //get the attribute value
    var paidstatus = $(this).attr('paidstatus'); //get the attribute value
    var refno = $(this).attr('refno'); //get the attribute value
    var sourcename = $(this).attr('sourcename'); //get the attribute value
    var source_id = $(this).attr('source_id');
    var adjustment = $(this).attr('adjustment');
    var notes = $(this).attr('notes');
  //alert(id);
     $('#pay_id').val(id);
     $('#paiddate').val(paiddate);
     $('#amount').val(amount);
     $('#paidstatus').val(paidstatus);
     $('#refno').val(refno);
     $('#adjustment').val(adjustment);
     $('#sourcename').val(sourcename);
     $('#notes').val(notes);
     $("#dropdown_data option[value="+paidstatus+"]").attr('selected','selected');
     $("#source_dropdown option[value="+source_id+"]").attr('selected','selected');
    $('#show_modal').modal({backdrop: 'static', keyboard: true, show: true});
     
})

$('[id*="get_deduction"]').click(function(){

    var id = $(this).attr('deduct_id');
    var deduct_type = $(this).attr('deduct_type'); //get the attribute value
    var frequency = $(this).attr('frequency'); //get the attribute value
    var total_deduct = $(this).attr('total_deduct'); //get the attribute value
    var notes = $(this).attr('notes'); //get the attribute value
    var start_date = $(this).attr('start_date'); //get the attribute value
    var end_date = $(this).attr('end_date'); //get the attribute value
    var deduction_per_pay = $(this).attr('deduction_per_pay'); //get the attribute value
    $('#id').val(id);
    $('#deduct_type').val(deduct_type);
    $('#total_deduct').val(total_deduct);
    $('#notes').val(notes);
    $('#start_date').val(start_date);
    $('#end_date').val(end_date);
    $('#frequency').val(frequency);
    $('#deduction_per_pay').val(deduction_per_pay);
    $('#show_modal').modal({backdrop: 'static', keyboard: true, show: true});
    
});


$('[id*="update_leave"]').click(function(){

    var leave_id = $(this).attr('leave_id');
    var end_date = $(this).attr('end_date'); //get the attribute value
    var start_date = $(this).attr('start_date'); //get the attribute value
    var leave_type = $(this).attr('leave_type'); //get the attribute value
    var leave_count = $(this).attr('leave_count'); //get the attribute value
    var notes = $(this).attr('notes'); //get the attribute value
    
    $('#leave_id').val(leave_id);
    $('#end_date').val(end_date);
    $('#start_date').val(start_date);
    $('#leave_type').val(leave_type);
    $('#leave_count').val(leave_count);
    $('#notes').html(notes);

    
});

    
});