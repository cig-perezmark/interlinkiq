
//all  dynamic table script below
//multiple table customer
$(document).on('click', '#add_customer_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_customer_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_customer').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_customer_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblcustomer'+button_id+'').remove();
    });
   
});


//multiple table officer
$(document).on('click', '#add_officer_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_officer_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_officer').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_officer_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblofficer'+button_id+'').remove();
    });
   
});

//multiple table US
$(document).on('click', '#add_us_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_us_sales_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_us').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_us_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblus'+button_id+'').remove();
    });
   
});


//multiple table foreign
$(document).on('click', '#add_foreign_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_foreign_sales_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_foreign').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_foreign_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblforeign'+button_id+'').remove();
    });
   
});

//multiple table payroll
$(document).on('click', '#add_payroll_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_payroll_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_payroll').append(response);
      }
    });
});

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_payroll_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblpayroll'+button_id+'').remove();
    });
   
});

//multiple table product by plant
$(document).on('click', '#add_pbp_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_pbp_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_pbp').append(response);
      }
    });
});

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_pbp_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblpbp'+button_id+'').remove();
    });
   
});

//multiple table import
$(document).on('click', '#add_import_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_import_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_import').append(response);
      }
    });
});

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_import_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblimport'+button_id+'').remove();
    });
   
});

//multiple table description of products
$(document).on('click', '#add_dp_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_dp_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_dp').append(response);
      }
    });
});

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_dp_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tbldp'+button_id+'').remove();
    });
   
});

//multiple table newproduct
$(document).on('click', '#add_newproduct_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_newproduct_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_newproduct').append(response);
      }
    });
});

$(document).ready(function(){
     var key = 'ids';
    
    $(document).on('click', '.btn_remove_newproduct_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblnewproduct'+button_id+'').remove();
    });
   
});

//Product Specific Coverage
$(document).on('click', '#add_psc_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_psc_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_psc').append(response);
      }
    });
});

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_psc_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblpsc'+button_id+'').remove();
    });
   
});

//Split By Country
$(document).on('click', '#add_sbc_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_sbc_box.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_sbc').append(response);
      }
    });
});

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_sbc_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tblsbc'+button_id+'').remove();
    });
   
});

//multiple table annual revenue
$(document).on('click', '#add_ar_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/annual_revenue_form.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_annual').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_ar_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tbl_annual_rev'+button_id+'').remove();
    });
   
});

//multiple table Employees
$(document).on('click', '#add_no_emp_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/fetch_no_employee.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_no_emp').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_no_emp_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tbl_no_emp'+button_id+'').remove();
    });
   
});

//multiple table Employees
$(document).on('click', '#add_coverage_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/coverage_option.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_field_coverage').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_coverage_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tbl_coverage'+button_id+'').remove();
    });
   
});

//multiple table Plant And Facility
$(document).on('click', '#add_plant_facility_row', function(){
    var key = 'ids';
  $.ajax({
      url:'insurance_folder/plants_and_facilities.php',
      method: 'POST',
      dataType: 'html',
      data: {
          key: key
      }, success: function (response) {
        $('#dynamic_plant_facility').append(response);
      }
    });
}); 

$(document).ready(function(){
     var key = 'ids';
    $(document).on('click', '.btn_remove_plant_facility_row', function(){
        var button_id = $(this).attr("id");
        $('#row_tbl_plant_facility'+button_id+'').remove();
    });
   
});