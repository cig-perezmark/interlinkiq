<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <style>
      body {
        background: #5da5a4;
        font-family: sans-serif;
      } 
      .border-radius-left {
        border-radius: 10px 0px 0px 10px;
      }
      .border-radius-right {
        border-radius: 0px 10px 10px 0px;
      }
      .bd-placeholder-img
      {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      .form-control-primary .form-control-success .form-control-danger {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      }
      .form-control-primary:focus {
        color: #212529;
        background-color: #fff;
        border-color: rgba(134, 183, 254);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
      }
      .form-control-success:focus {
        color: #212529;
        background-color: #fff;
        border-color: rgba(183, 254, 134);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(110, 253, 13, 0.25);
      }
      .form-control-danger:focus {
        color: #212529;
        background-color: #fff;
        border-color: rgba(254, 134, 183);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(253, 13, 110, 0.25);
      }
      .product-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
      .product-list-scroller {
        height:500px;
        overflow-x: hidden;
        overflow-y: scroll;
      }
      .product-row {
        background: white;
        outline: 0;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }
      .text-limit {
        white-space: nowrap; 
        overflow: hidden;
        text-overflow: ellipsis; 
      }
      .product-plate-xs {
        width: 250px;
        height: 600px;
        background: whitesmoke;
      }
      .product-checkbox {
        flex: 0 0 auto;
        width: 40px;
      }
      .product-image {
        flex: 0 0 auto;
        width: 90px;
      }
      .product-row-xs {
        flex: 0 0 auto;
        width: 345px;
      }
      .product-body-xs {
        flex: 0 0 auto;
        width: 345px;
      }
      .product-name-xs {
        flex: 0 0 auto;
        width: 100%;
      }
      .product-tag-xs {
        flex: 0 0 auto;
        width: 100%;
      }
      .product-description-xs {
        flex: 0 0 auto;
        width: 100%;
      }
      .product-time-xs {
        flex: 0 0 auto;
        width: 345px;
        text-align: center;
        height: auto;
      }
      .date-xs {
        flex: 0 0 auto;
        width: 100%;
      }
      .day-xs {
        flex: 0 0 auto;
        width: 40%;
        text-align: center;
      }
      .time-xs {
        flex: 0 0 auto;
        width: 60%;
      }
      .product-action-xs {
        flex: 0 0 auto;
        width: 85px;
      }
      .view-product-btn-xs {
        flex: 0 0 auto;
        width: 50%;
      }
      .display-product-btn-xs {
        flex: 0 0 auto;
        width: 50%;
      }
      .edit-product-btn-xs {
        flex: 0 0 auto;
        width: 50%;
      }
      .remove-product-btn-xs {
        flex: 0 0 auto;
        width: 50%;
      }
      .mainProductImage-xs {
        flex: 0 0 auto;
        width: 80%;
        height: 80%;
      }
      .img-angle-xs {
        flex: 0 0 auto;
        width: 60px;
        height: 60px;
      }
      .upload-img-angle-btn-xs {
        flex: 0 0 auto;
        width: 65px;
        font-size: 8px;
      }
      .uploaded-img-box-xs {
        flex: 0 0 auto;
        width: 50px;
        height: 50px;
      }
      .uploaded-img-xs {
        width: 100%;
        height: 100%;
      }
      @media (min-width: 576px) {
        .product-plate-sm {
          width: 480px;
          height: 600px;
          background: whitesmoke;
        }
        .search-product-sm {
          flex: 0 0 auto;
          width: 300px;
        }
        .add-product-btn-sm {
          width: 50px;
        }
        .product-list-sm {
          flex: 0 0 auto;
          width: 460px;
        }
        .product-row-sm {
          flex: 0 0 auto;
          width: 415px;
        }
        .product-body-sm {
          flex: 0 0 auto;
          width: 285px;
        }
        .product-name-sm {
          flex: 0 0 auto;
          width: 285px;
        }
        .product-tag-sm {
          flex: 0 0 auto;
          width: 285px;
          display: flex;
          justify-content: start;
        }
        .product-description-sm {
          flex: 0 0 auto;
          width: 285px;
        }
        .product-time-sm {
          flex: 0 0 auto;
          width: 255px;
          text-align: center;
          height: auto;
        }
        .date-sm {
          flex: 0 0 auto;
          width: 155px;
        }
        .day-sm {
          flex: 0 0 auto;
          width: 97px;
          text-align: center;
        }
        .time-sm {
          flex: 0 0 auto;
          width: 252px;
        }
        .product-action-sm {
          flex: 0 0 auto;
          width: 160px;
        }
        .view-product-btn-sm {
          flex: 0 0 auto;
          width: 40px;
        }
        .display-product-btn-sm {
          flex: 0 0 auto;
          width: 40px;
        }
        .edit-product-btn-sm {
          flex: 0 0 auto;
          width: 40px;
        }
        .remove-product-btn-sm {
          flex: 0 0 auto;
          width: 40px;
        }
        .mainProductImage-sm {
          flex: 0 0 auto;
          width: 175px;
          height: 175px;
        }
        .img-angle-sm {
          flex: 0 0 auto;
          width: 50px;
          height: 50px;
        }
        .upload-img-angle-btn-sm {
          flex: 0 0 auto;
          width: 50px;
          font-size: 10px;
        }
        .uploaded-img-box-sm {
          flex: 0 0 auto;
          width: 70px;
          height: 70px;
        }
        .uploaded-img-sm {
          width: 100%;
          height: 100%;
        }
      }
      @media (min-width: 768px) {
        .product-plate-md {
          width: 580px;
          height: 600px;
          background: whitesmoke;
        }
        .search-product-md {
          flex: 0 0 auto;
          width: 400px;
        }
        .add-product-btn-md {
          width: 150px;
        }
        .product-list-md {
          flex: 0 0 auto;
          width: 560px;
        }
        .product-row-md {
          flex: 0 0 auto;
          width: 515px;
        }
        .product-body-md {
          flex: 0 0 auto;
          width: 385px;
        }
        .product-name-md {
          flex: 0 0 auto;
          width: 233px;
        }
        .product-tag-md {
          flex: 0 0 auto;
          width: 150px;
          display: flex;
          justify-content: center;
        }
        .product-description-md {
          flex: 0 0 auto;
          width: 390px;
        }
        .product-time-md {
          flex: 0 0 auto;
          width: 355px;
          text-align: center;
          height: 35px;
        }
        .date-md {
          flex: 0 0 auto;
          width: 140px;
        }
        .day-md {
          flex: 0 0 auto;
          width: 80px;
          text-align: center;
        }
        .time-md {
          flex: 0 0 auto;
          width: 133px;
        }
        .product-action-md {
          flex: 0 0 auto;
          width: 160px;
        }
        .view-product-btn-md {
          flex: 0 0 auto;
          width: 40px;
        }
        .display-product-btn-md {
          flex: 0 0 auto;
          width: 40px;
        }
        .edit-product-btn-md {
          flex: 0 0 auto;
          width: 40px;
        }
        .remove-product-btn-md {
          flex: 0 0 auto;
          width: 40px;
        }
        .mainProductImage-md {
          flex: 0 0 auto;
          width: 175px;
          height: 175px;
        }
        .img-angle-md {
          flex: 0 0 auto;
          width: 50px;
          height: 50px;
        }
        .upload-img-angle-btn-md {
          flex: 0 0 auto;
          width: 50px;
          font-size: 10px;
        }
        .uploaded-img-box-md {
          flex: 0 0 auto;
          width: 70px;
          height: 70px;
        }
        .uploaded-img-md {
          width: 100%;
          height: 100%;
        }
      }
      @media (min-width: 992px) {
        .product-plate-lg {
          width: 790px;
          height: 600px;
          background: whitesmoke;
        }
        .search-product-lg {
          flex: 0 0 auto;
          width: 350px;
        }
        .add-product-btn-lg {
          width: 150px;
        }
        .product-list-lg {
          flex: 0 0 auto;
          width: 770px;
        }
        .product-row-lg {
          flex: 0 0 auto;
          width: 720px;
        }
        .product-body-lg {
          flex: 0 0 auto;
          width: 370px;
        }
        .product-name-lg {
          flex: 0 0 auto;
          width: 218px;
        }
        .product-tag-lg {
          flex: 0 0 auto;
          width: 150px;
          display: flex;
          justify-content: center;
        }       
        .product-description-lg {
          flex: 0 0 auto;
          width: 370px;
        }
        .product-time-lg {
          flex: 0 0 auto;
          width: 140px;
          height: auto;
        }
        .date-lg {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .day-lg {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .time-lg {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .product-action-lg {
          flex: 0 0 auto;
          width: 80px;
        }
        .view-product-btn-lg {
          flex: 0 0 auto;
          width: 40px;
        }
        .display-product-btn-lg {
          flex: 0 0 auto;
          width: 40px;
        }
        .edit-product-btn-lg {
          flex: 0 0 auto;
          width: 40px;
        }
        .remove-product-btn-lg {
          flex: 0 0 auto;
          width: 40px;
        }
        .mainProductImage-lg {
          flex: 0 0 auto;
          width: 275px;
          height: 275px;
        }
        .img-angle-lg {
          flex: 0 0 auto;
          width: 90px;
          height: 90px;
        }
        .upload-img-angle-btn-xxl {
          flex: 0 0 auto;
          width: 90px;
          font-size: 12px;
        }
        .uploaded-img-box-lg {
          flex: 0 0 auto;
          width: 70px;
          height: 70px;
        }
        .uploaded-img-lg {
          width: 100%;
          height: 100%;
        }
      }
      @media (min-width: 1200px) {
        .product-plate-xl {
          width: 1060px;
          height: 600px;
          background: whitesmoke;
        }
        .search-product-xl {
          flex: 0 0 auto;
          width: 500px;
        }
        .add-product-btn-xl {
          width: 180px;
        }
        .product-list-xl {
          flex: 0 0 auto;
          width: 1040px;
        }
        .product-row-xl {
          flex: 0 0 auto;
          width: 995px;
        }
        .product-body-xl {
          flex: 0 0 auto;
          width: 645px;
        }
        .product-name-xl {
          flex: 0 0 auto;
          width: 493px;
        }
        .product-tag-xl {
          flex: 0 0 auto;
          width: 150px;
          display: flex;
          justify-content: center;
        }
        .product-description-xl {
          flex: 0 0 auto;
          width: 645px;
        }
        .product-time-xl {
          flex: 0 0 auto;
          width: 140px;
          height: auto;
        }
        .date-xl {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .day-xl {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .time-xl {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .product-action-xl {
          flex: 0 0 auto;
          width: 80px;
        }
        .view-product-btn-xl {
          flex: 0 0 auto;
          width: 40px;
        }
        .display-product-btn-xl {
          flex: 0 0 auto;
          width: 40px;
        }
        .edit-product-btn-xl {
          flex: 0 0 auto;
          width: 40px;
        }
        .remove-product-btn-xl {
          flex: 0 0 auto;
          width: 40px;
        }
        .mainProductImage-xl {
          flex: 0 0 auto;
          width: 275px;
          height: 275px;
        }
        .img-angle-xl {
          flex: 0 0 auto;
          width: 90px;
          height: 90px;
        }
        .upload-img-angle-btn-xxl {
          flex: 0 0 auto;
          width: 90px;
          font-size: 12px;
        }
        .uploaded-img-box-xl {
          flex: 0 0 auto;
          width: 70px;
          height: 70px;
        }
        .uploaded-img-xl {
          width: 100%;
          height: 100%;
        }
      }
      @media (min-width: 1400px) {
        .product-plate-xxl {
          width: 1200px;
          height: 600px;
          background: whitesmoke;
        }
        .search-product-xxl {
          flex: 0 0 auto;
          width: 600px;
        }
        .add-product-btn-xxl {
          width: 180px;
        }
        .product-list-xxl {
          flex: 0 0 auto;
          width: 1180px;
        }
        .product-row-xxl {
          flex: 0 0 auto;
          width: 1130px;
        }
        .product-body-xxl {
          flex: 0 0 auto;
          width: 780px;
        }
        .product-name-xxl {
          flex: 0 0 auto;
          width: 627px;
        }
        .product-tag-xxl {
          flex: 0 0 auto;
          width: 150px;
          display: flex;
          justify-content: center;
        }
        .product-description-xxl {
          flex: 0 0 auto;
          width: 780px;
        }
        .product-time-xxl {
          flex: 0 0 auto;
          width: 140px;
          height: auto;
        }
        .date-xxl {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .day-xxl {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .time-xxl {
          flex: 0 0 auto;
          width: 140px;
          text-align: end;
        }
        .product-action-xxl {
          flex: 0 0 auto;
          width: 80px;
        }
        .view-product-btn-xxl {
          flex: 0 0 auto;
          width: 40px;
        }
        .display-product-btn-xxl {
          flex: 0 0 auto;
          width: 40px;
        }
        .edit-product-btn-xxl {
          flex: 0 0 auto;
          width: 40px;
        }
        .remove-product-btn-xxl {
          flex: 0 0 auto;
          width: 40px;
        }
        .mainProductImage-xxl {
          flex: 0 0 auto;
          width: 275px;
          height: 275px;
        }
        .img-angle-xxl {
          flex: 0 0 auto;
          width: 90px;
          height: 90px;
        }
        .upload-img-angle-btn-xxl {
          flex: 0 0 auto;
          width: 90px;
          font-size: 12px;
        }
        .uploaded-img-box-xxl {
          flex: 0 0 auto;
          width: 70px;
          height: 70px;
        }
        .uploaded-img-xxl {
          width: 100%;
          height: 100%;
        }
      }
    </style>
  </head>
  <body>
    <div class="product-container">
      <div class="border border-0 rounded-1 product-plate-xxl product-plate-xl product-plate-lg product-plate-md product-plate-sm product-plate-xs">
        <div class="p-2">
          <!--Start of Top Bar-->
          <div class="row">
            <div class="d-flex justify-content-between">
              <div class="input-group search-product-xxl search-product-xl search-product-lg search-product-md search-product-sm search-product-xs">
                <input type="text" class="form-control border border-2" autocomplete="off" placeholder="Search Product">
                <span class="input-group-text"><i class="las la-search"></i></span>
              </div>
              <button class="btn btn-info add-product-btn-xxl add-product-btn-xl add-product-btn-lg add-product-btn-md add-product-btn-sm add-product-btn-xs" id="addProduct-modal-btn" data-toggle="modal" data-target="#addProduct-modal">
                <span class="d-none d-md-inline">Add Product</span>
                <i class="d-inline d-md-none las la-plus"></i>
              </button>
            </div>
          </div>
          <!--End of Top Bar-->
          <hr class="px-2" style="margin-top:9px;margin-bottom:9px;">
          <!--Start of Table-->
          <div class="d-flex justify-content-center">
            <div class="border product-list-scroller product-list-xxl product-list-xl product-list-lg product-list-md product-list-sm product-list-xs">
              <div class="row d-flex justify-content-center" style="padding:12px">
                <?php
                  include("select_table.php");
                  while($rows = mysqli_fetch_assoc($result))
                  {
                ?>
                <!--Start of First Product-->
                <div class="product-row product-row-xxl product-row-xl product-row-lg product-row-md product-row-sm product-row-xs">
                  <div class="row">
                    <div class="d-flex align-items-center product-checkbox bg-primary">
                      <!--<input type="checkbox">-->
                    </div>
                    <div class="d-flex justify-content-center product-image">
                      <img src="upload/<?php echo $rows["mainProductImage"] ?>" class="img-thumbnail p-0 m-1 border border-dark">
                    </div>
                    <div class="d-sm-none d-flex product-action-xs">
                      <div class="row h-100">
                        <div class="d-flex align-items-center justify-content-center bg-info view-product-btn-xs" id="viewProduct-btn"><i class="las la-eye"></i></div>
                        <div class="d-flex align-items-center justify-content-center bg-warning edit-product-btn-xs" id="editProduct-btn"><i class="las la-edit"></i></div>
                        <div class="d-flex align-items-center justify-content-center bg-success display-product-btn-xs" id="displayProduct-btn"><i class="las la-globe"></i></div>
                        <div class="d-flex align-items-center justify-content-center bg-danger remove-product-btn-xs" id="removeProduct-btn"><i class="las la-trash-alt"></i></div>
                      </div>
                    </div>
                    <div class="product-body-xxl product-body-xl product-body-lg product-body-md product-body-sm product-body-xs">
                      <div class="row h-100 d-flex align-items-center">
                        <div class="product-name-xxl product-name-xl product-name-lg product-name-md product-name-sm product-name-xs text-limit">
                          <small><b><?php echo $rows["productName"] ?></b></small>
                        </div>
                        <div class="product-tag-xxl product-tag-xl product-tag-lg product-tag-md product-tag-sm product-tag-xs">
                          <span class="badge bg-primary">
                            <?php if ($rows["productCategory"] != "Other") {
                                echo $rows["productCategory"];
                              } 
                              else 
                              {
                                echo $rows["productCategory_other"];
                              }
                              ?></span>
                        </div>
                        <div class="product-description-xxl product-description-xl product-description-lg product-description-md product-description-sm product-description-xs text-limit">
                          <small><?php echo $rows["productDescription"] ?></small>
                        </div>
                      </div>
                    </div>  
                    <div class="border border-top-0 border-bottom-0 border-right-0 d-flex align-items-center product-time-xxl product-time-xl product-time-lg product-time-md product-time-sm product-time-xs">
                      <div class="row">
                        <div class="date-xxl date-xl date-lg date-md date-sm date-xs"><small class="d-block" style="font-size:12px;" id="productAddedTime" name="productAddedTime"><?php echo $rows["productAddedTime"] ?></small></div>
                      </div>
                    </div>
                    <div class="d-none d-sm-flex product-action-xxl product-action-xl product-action-lg product-action-md product-action-sm product-action-xs">
                      <div class="row h-100">
                        <button type="button" class="d-flex align-items-center justify-content-center bg-info border-0 view-product-btn-xxl view-product-btn-xl view-product-btn-lg view-product-btn-md view-product-btn-sm" id="viewProduct-btn<?php echo $rows["ID"] ?>" data-toggle="modal" data-target="#editviewProduct-modal<?php echo $rows["ID"] ?>"><i class="las la-eye"></i></button>
                        <button type="button" class="d-flex align-items-center justify-content-center bg-warning border-0 edit-product-btn-xxl edit-product-btn-xl edit-product-btn-lg edit-product-btn-md edit-product-btn-sm" id="editProduct-btn<?php echo $rows["ID"] ?>" data-toggle="modal" data-target="#editviewProduct-modal<?php echo $rows["ID"] ?>"><i class="las la-edit"></i></button>
                        <button type="button" class="d-flex align-items-center justify-content-center bg-success border-0 display-product-btn-xxl display-product-btn-xl display-product-btn-lg display-product-btn-md display-product-btn-sm" id="displayProduct-btn<?php echo $rows["ID"] ?>"><i class="las la-globe"></i></button>
                        <button type="button" class="d-flex align-items-center justify-content-center bg-danger border-0 remove-product-btn-xxl remove-product-btn-xl remove-product-btn-lg remove-product-btn-md remove-product-btn-sm" id="removeProduct-btn<?php echo $rows["ID"] ?>"><i class="las la-trash-alt"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                  }
                ?>
                <!--End of First Product-->
              </div> 
            </div>    
          </div>    
        </div>
      </div>
    </div>
  <!--Start of View/Edit Product Modal-->
  <!--Supposed to Be Edit/View Modal
  <?php
    //include("select_table.php");
    //while($rows = mysqli_fetch_assoc($result))
    //{
  ?>
  <div class="modal fade" id="editviewProduct-modal<?php echo $rows["ID"] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <form action="" method=""> 
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light"  style="position:sticky;top:0;z-index:1">
            <h5 class="modal-title">Edit/View Product</h5>
            <button type="button" class="border-0" data-dismiss="modal" aria-label="Close">
              <i class="las la-times"></i>
            </button>
          </div>
          <div class="modal-body" style="background:whitesmoke;">
            <h3 class="mb-3 text-center"><b>Product's Profile</b></h3>
            <div class="row d-flex justify-content-center">
              <div class="col-12 col-sm-5 mt-2">
                <img src="./sample_images/null_image.jpg" class="border border-dark mainProductImage-xxl mainProductImage-xl mainProductImage-lg mainProductImage-md mainProductImage-sm mainProductImage-xs" id="mainProductImage">
                <div class="mt-1">
                  <strong>Main Product Image</strong>
                  <input type="file" class="form-control border border-dark" id="uploadMainProductImage" accept="image/png, image/jpg, image/jpeg">
                </div> 
              </div>
              <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                <div class="row">
                  <div class="col-12 border">
                    <div class="row">
                      <div class="col-4 d-flex align-items-center">
                        <div>
                          <img src="./sample_images/null_image.jpg" id="leftProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                          <div class="mt-1">
                            <strong>Left View</strong>
                            <input type="file" id="uploadLeftProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadLeftProductImages" accept="image/png, image/jpg, image/jpeg">
                          </div> 
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="row g-3">
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="topProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Top View</strong>
                              <input type="file" id="uploadTopProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadTopProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="frontProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Front View</strong>
                              <input type="file" id="uploadFrontProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadFrontProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="backProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Back View</strong>
                              <input type="file" id="uploadBackProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadBackProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="bottomProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Bottom View</strong>
                              <input type="file" id="uploadBottomProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadBottomProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                        </div>
                      </div>
                      <div class="col-4 d-flex align-items-center">
                        <div>
                          <img src="./sample_images/null_image.jpg" id="rightProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                          <div class="mt-1">
                            <strong>Right View</strong>
                            <input type="file" id="uploadRightProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadRightProductImages" accept="image/png, image/jpg, image/jpeg">
                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <strong class="mt-3">Product Images</strong>
              <div class="col-12 py-2 border border-secondary d-flex justify-content-start" id="displayProductImages" style="height:85px;overflow-y:scroll;">
                <div class="row g-1" id="displayProductImages-row"></div>
              </div>
              <div class="col-12 mt-1 mb-3">
                <input type="file" class="form-control border border-dark" id="uploadProductImages" accept="image/png, image/jpg, image/jpeg" multiple>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-sm-4">
                <strong class="form-label mb-0">Product Code</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border" id="productCode" name="productCode" autocomplete="off" value="">
                  <span class="input-group-text"><i id="productCode-span"></i></span>
                </div>
                <div>
                  <i id="productCode-icon"></i>
                  <strong id="productCode-text">.</strong>
                </div>
              </div>
              <div class="col-sm-8">
                <strong class="form-label mb-0">Product Name</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border" id="productName" name="productName" autocomplete="off" value="">
                  <span class="input-group-text"><i id="productName-span"></i></span>
                </div>
                <div>
                  <i id="productName-icon"></i>
                  <strong id="productName-text">.</strong>
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Product Category</strong>
                <div class="input-group">
                  <select class="form-select border border-danger" id="productCategory" name="productCategory" value="">
                    <option value="">-Select Category-</option>
                    <option value="Food">Food</option>
                    <option value="Beverage">Beverage</option>
                    <option value="Dietary Supplement">Dietary Supplement</option>
                    <option value="Phramaceutical">Phramaceutical</option>
                    <option value="Produce">Produce</option>
                    <option value="Medical Food">Medical Food</option>
                    <option value="Other">Other</option>
                  </select>
                  <span class="input-group-text"><i id="productCategory-span"></i></span>
                </div>
                <div>
                  <i id="productCategory-icon"></i>
                  <strong id="productCategory-text">.</strong>
                </div>
              </div>
              <div class="col-sm-6">
                <span class="form-label text-muted mb-0">(Specify if other)</span>
                <div class="input-group"> 
                  <input type="text" class="form-control border" id="productCategory-other" name="productCategory_other" autocomplete="off" value="">
                  <span class="input-group-text"><i id="productCategory-other-span"></i></span>
                </div>
                <div>
                  <i id="productCategory-other-icon"></i>
                  <strong id="productCategory-other-text">.</strong>
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Product Description</strong>
                <div class="input-group"> 
                  <textarea type="text" class="form-control border" id="productDescription" name="productDescription" autocomplete="off" value=""></textarea>
                  <span class="input-group-text"><i id="productDescription-span"></i></span>
                </div>
                <div>
                  <i id="productDescription-icon"></i>
                  <strong id="productDescription-text">.</strong>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Product's Formula</b></h3>
            <div class="row g-3">
              <div class="col-sm-12">
                <strong class="form-label mb-0">Ingredient List</strong>
                <div class="input-group"> 
                  <textarea type="text" class="form-control border border-primary" id="ingredientList" name="ingredientList" autocomplete="off" value=""></textarea>
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Allergens</strong>
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen1" value="Milk">
                      <label class="form-check-label" for="allergen1">Milk</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen2" value="Egg">
                      <label class="form-check-label" for="allergen2">Egg</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen3" value="Fish">
                      <label class="form-check-label" for="allergen3">Fish (e.g., bass, flounder, cod)</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen4" value="Crustacean shellfish">
                      <label class="form-check-label" for="allergen4">Crustacean shellfish (e.g., crab, lobster, shrimp)</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen5" value="Tree nuts">
                      <label class="form-check-label" for="allergen5">Tree nuts (e.g., almonds, walnuts, pecans)</label>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen6" value="Peanuts">
                      <label class="form-check-label" for="allergen6">Peanuts</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen7" value="Wheat">
                      <label class="form-check-label" for="allergen7">Wheat</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen8" value="Soybeans">
                      <label class="form-check-label" for="allergen8">Soybeans</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen9" value="Sesame">
                      <label class="form-check-label" for="allergen9">Sesame</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergenOther" value="Other">
                      <label class="form-check-label" for="allergenOther">Other</label>
                    </div>
                  </div>
                  <div class="col-6 d-none d-md-inline"></div>
                  <div class="col-12 col-md-6">
                    <span class="text-muted">(Specify if other)</span>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="allergen_other" name="allergen_other" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Dimensions</b></h3>
            <div class="row g-3">
              <div class="col-12">
                <strong class="form-label mb-0">Packaging Material List</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="packMatList" name="packMatList" autocomplete="off" value="">
                </div>
              </div>
              <h4 class="mt-3 mb-0 text-center"><b>Unit</b></h4>
              <div class="col-12 py-3 border">
                <div class="row">
                  <div class="col-sm-12">
                    <strong class="form-label mb-0">Unit Dimension/s</strong>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="unitDimensions" name="unitDimensions" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <button class="btn btn-primary">Add More Unit Size</button>
              </div>
              <h4 class="mt-3 mb-0 text-center"><b>Box</b></h4>
              <div class="col-12 py-3 border">
                <div class="row">
                  <div class="col-sm-12">
                    <strong class="form-label mb-0">Box Dimension/s</strong>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="boxDimensions" name="boxDimensions" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <button class="btn btn-primary">Add More Box Size</button>
              </div>
              <h4 class="mt-3 mb-0 text-center"><b>Pallet</b></h4>
              <div class="col-12 py-3 border">
                <div class="row">
                  <div class="col-sm-12">
                    <strong class="form-label mb-0">Pallet Dimension/s</strong>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="palletDimensions" name="palletDimensions" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-5">
                <button class="btn btn-primary">Add More Pallet Dimension</button>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Storage</b></h3>
            <div class="row g-3">
              <div class="col-sm-6">
                <strong class="form-label mb-0">Shelf Life</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="shelfLife" name="shelfLife" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Storage and Handling</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="storeAndHand" name="storeAndHand" autocomplete="off" value="">
                </div>
              </div>
            </div>
            <hr>
            <div class="row g-3">
              <div class="col-sm-6">
                <strong class="form-label mb-0">UPC Code</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="upcCode" name="upcCode" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">GTIN Number</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="gtinNo" name="gtinNo" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Lead Time</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="leadTime" name="leadTime" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">MOQ</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="moq" name="moq" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-2">
                    <strong class="form-label mb-0">Export</strong>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="export" id="export" value="Yes">
                      <label class="form-check-label" for="exportYes">Yes</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="export" id="export" value="No">
                      <label class="form-check-label" for="exportNo">No</label>
                    </div>
                  </div>
                  <div class="col-10">
                    <strong class="form-label mb-0">Countries</strong>
                    <div class="input-group"> 
                      <textarea type="text" class="form-control border border-primary" id="exportCountry" name="exportCountry" autocomplete="off" value=""></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Manufacturing Details</b></h3>
            <div class="row g-3">
              <div class="col-sm-6">
                <strong class="form-label mb-0">Manufactured by</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="manufacturedBy" name="manufacturerBy" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Manufactured for</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="manufacturedFor" name="manufacturerFor" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Distributed by</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="distributedBy" name="distributedBy" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Country of Origin</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="originCountry" name="originCountry" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Storage/Warehouse</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="warehouse" name="warehouse" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Lot Code Explanation</strong>
                <div class="input-group"> 
                  <textarea type="text" class="form-control border border-primary" id="lotCodeExplanation" name="lotCodeExplanation" autocomplete="off" value=""></textarea>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Exercises</b></h3>
            <div class="row g-3">       
              <div class="col-sm-6">
                <strong class="form-label mb-0">Mock Recall Exercise</strong>
                <div class="input-group"> 
                  <input type="date" class="form-control border border-primary" id="mockRecallExercise" name="mockRecallExercise" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Product Trace Exercise</strong>
                <div class="input-group"> 
                  <input type="date" class="form-control border border-primary" id="productTraceExercise" name="productTracExercise" autocomplete="off" value="">
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Documents</b></h3>
            <div class="row g-3">
              <div class="col-sm-12">
                <strong class="form-label mb-0">Food Safety Plan/HACCP</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="foodSafetyPlan" name="foodSafetyPlan" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Formulator Approval</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="productTraceExercise" name="productTracExercise" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Finish Product Recall Procedures</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="finishProductRecallProcedures" name="finishProductRecallProcedures" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Certificate of Analysis</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="certificateOfAnalysis" name="certificateOfAnalysis" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Specifications</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="specifications" name="specifications" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">SDS</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="sds" name="sds" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Certificate of Guarantee</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="certificateOfGuarantee" name="certificateOfGuarantee" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Certificate of Conformance</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="certificateOfConformance" name="certificateOfConformance" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Product Liability Insurance</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="productLiabilityInsurance" name="productLiabilityInsurance" autocomplete="off" value="">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-light" style="position:sticky;bottom:0;z-index:2;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addProduct-btn" id="addProduct-btn" class="btn btn-primary">Add Product</button>
          </div>
        </div>
      </form>
    </div>
  <?php
    //}
  ?>-->
  <!--Edit View/Edit Product Modal-->
  <!--Start of Add Product Modal-->
  <div class="modal fade" id="addProduct-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <form action="add_product.php" method="post" enctype="multipart/form-data"> 
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light"  style="position:sticky;top:0;z-index:1">
            <h5 class="modal-title">Add Product</h5>
            <button type="button" class="border-0" data-dismiss="modal" aria-label="Close">
              <i class="las la-times"></i>
            </button>
          </div>
          <div class="modal-body" style="background:whitesmoke;">
            <h3 class="mb-3 text-center"><b>Product's Profile</b></h3>
            <div class="row d-flex justify-content-center">
              <div class="col-12 col-sm-5 mt-2">
                <img src="./sample_images/null_image.jpg" class="border border-dark mainProductImage-xxl mainProductImage-xl mainProductImage-lg mainProductImage-md mainProductImage-sm mainProductImage-xs" id="mainProductImage">
                <div class="mt-1">
                  <strong>Main Product Image</strong>
                  <input type="file" class="form-control border border-dark" id="uploadMainProductImage" name="uploadMainProductImage" accept="image/png, image/jpg, image/jpeg">
                </div> 
              </div>
              <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                <div class="row">
                  <div class="col-12 border">
                    <div class="row">
                      <div class="col-4 d-flex align-items-center">
                        <div>
                          <img src="./sample_images/null_image.jpg" id="leftProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                          <div class="mt-1">
                            <strong>Left View</strong>
                            <input type="file" id="uploadLeftProductImage" name="uploadLeftProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadLeftProductImages" accept="image/png, image/jpg, image/jpeg">
                          </div> 
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="row g-3">
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="topProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Top View</strong>
                              <input type="file" id="uploadTopProductImage" name="uploadTopProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadTopProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="frontProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Front View</strong>
                              <input type="file" id="uploadFrontProductImage" name="uploadFrontProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadFrontProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="backProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Back View</strong>
                              <input type="file" id="uploadBackProductImage" name="uploadBackProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadBackProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                          <div class="col-12">
                            <img src="./sample_images/null_image.jpg" id="bottomProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                            <div class="mt-1">
                              <strong>Bottom View</strong>
                              <input type="file" id="uploadBottomProductImage" name="uploadBottomProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadBottomProductImages" accept="image/png, image/jpg, image/jpeg">
                            </div> 
                          </div>
                        </div>
                      </div>
                      <div class="col-4 d-flex align-items-center">
                        <div>
                          <img src="./sample_images/null_image.jpg" id="rightProductImage" name="rightProductImage" class="border border-dark img-angle-xxl img-angle-xl img-angle-lg img-angle-md img-angle-sm img-angle-xs">
                          <div class="mt-1">
                            <strong>Right View</strong>
                            <input type="file" id="uploadRightProductImage" class="form-control border border-dark upload-img-angle-btn-xxl upload-img-angle-btn-xl upload-img-angle-btn-lg upload-img-angle-btn-md upload-img-angle-btn-sm upload-img-angle-btn-xs" id="uploadRightProductImages" accept="image/png, image/jpg, image/jpeg">
                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <strong class="mt-3">Product Images</strong>
              <div class="col-12 py-2 border border-secondary d-flex justify-content-start" id="displayProductImages" style="height:85px;overflow-y:scroll;">
                <div class="row g-1" id="displayProductImages-row"></div>
              </div>
              <div class="col-12 mt-1 mb-3">
                <input type="file" class="form-control border border-dark" id="uploadProductImages" name="uploadProductImages" accept="image/png,image/PNG,image/jpg,image/jpeg">
              </div>
            </div>
            <div class="row g-3">
              <div class="col-sm-4">
                <strong class="form-label mb-0">Product Code</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border" id="productCode" name="productCode" autocomplete="off" value="">
                  <span class="input-group-text"><i id="productCode-span"></i></span>
                </div>
                <div>
                  <i id="productCode-icon"></i>
                  <strong id="productCode-text">.</strong>
                </div>
              </div>
              <div class="col-sm-8">
                <strong class="form-label mb-0">Product Name</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border" id="productName" name="productName" autocomplete="off" value="">
                  <span class="input-group-text"><i id="productName-span"></i></span>
                </div>
                <div>
                  <i id="productName-icon"></i>
                  <strong id="productName-text">.</strong>
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Product Category</strong>
                <div class="input-group">
                  <select class="form-select border border-danger" id="productCategory" name="productCategory" value="">
                    <option value="">-Select Category-</option>
                    <option value="Food">Food</option>
                    <option value="Beverage">Beverage</option>
                    <option value="Dietary Supplement">Dietary Supplement</option>
                    <option value="Phramaceutical">Phramaceutical</option>
                    <option value="Produce">Produce</option>
                    <option value="Medical Food">Medical Food</option>
                    <option value="Other">Other</option>
                  </select>
                  <span class="input-group-text"><i id="productCategory-span"></i></span>
                </div>
                <div>
                  <i id="productCategory-icon"></i>
                  <strong id="productCategory-text">.</strong>
                </div>
              </div>
              <div class="col-sm-6">
                <span class="form-label text-muted mb-0">(Specify if other)</span>
                <div class="input-group"> 
                  <input type="text" class="form-control border" id="productCategory-other" name="productCategory_other" autocomplete="off" value="">
                  <span class="input-group-text"><i id="productCategory-other-span"></i></span>
                </div>
                <div>
                  <i id="productCategory-other-icon"></i>
                  <strong id="productCategory-other-text">.</strong>
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Product Description</strong>
                <div class="input-group"> 
                  <textarea type="text" class="form-control border" id="productDescription" name="productDescription" autocomplete="off" value=""></textarea>
                  <span class="input-group-text"><i id="productDescription-span"></i></span>
                </div>
                <div>
                  <i id="productDescription-icon"></i>
                  <strong id="productDescription-text">.</strong>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Product's Formula</b></h3>
            <div class="row g-3">
              <div class="col-sm-12">
                <strong class="form-label mb-0">Ingredient List</strong>
                <div class="input-group"> 
                  <textarea type="text" class="form-control border border-primary" id="ingredientList" name="ingredientList" autocomplete="off" value=""></textarea>
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Allergens</strong>
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen1" value="Milk">
                      <label class="form-check-label" for="allergen1">Milk</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen2" value="Egg">
                      <label class="form-check-label" for="allergen2">Egg</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen3" value="Fish">
                      <label class="form-check-label" for="allergen3">Fish (e.g., bass, flounder, cod)</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen4" value="Crustacean shellfish">
                      <label class="form-check-label" for="allergen4">Crustacean shellfish (e.g., crab, lobster, shrimp)</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen5" value="Tree nuts">
                      <label class="form-check-label" for="allergen5">Tree nuts (e.g., almonds, walnuts, pecans)</label>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen6" value="Peanuts">
                      <label class="form-check-label" for="allergen6">Peanuts</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen7" value="Wheat">
                      <label class="form-check-label" for="allergen7">Wheat</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen8" value="Soybeans">
                      <label class="form-check-label" for="allergen8">Soybeans</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergen9" value="Sesame">
                      <label class="form-check-label" for="allergen9">Sesame</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="allergenOther" value="Other">
                      <label class="form-check-label" for="allergenOther">Other</label>
                    </div>
                  </div>
                  <div class="col-6 d-none d-md-inline"></div>
                  <div class="col-12 col-md-6">
                    <span class="text-muted">(Specify if other)</span>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="allergen_other" name="allergen_other" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Dimensions</b></h3>
            <div class="row g-3">
              <div class="col-12">
                <strong class="form-label mb-0">Packaging Material List</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="packMatList" name="packMatList" autocomplete="off" value="">
                </div>
              </div>
              <h4 class="mt-3 mb-0 text-center"><b>Unit</b></h4>
              <div class="col-12 py-3 border">
                <div class="row">
                  <div class="col-sm-12">
                    <strong class="form-label mb-0">Unit Dimension/s</strong>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="unitDimensions" name="unitDimensions" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
              <!--<div class="col-sm-4">
                <button class="btn btn-primary">Add More Unit Size</button>
              </div>-->
              <h4 class="mt-3 mb-0 text-center"><b>Box</b></h4>
              <div class="col-12 py-3 border">
                <div class="row">
                  <div class="col-sm-12">
                    <strong class="form-label mb-0">Box Dimension/s</strong>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="boxDimensions" name="boxDimensions" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
              <!--<div class="col-sm-4">
                <button class="btn btn-primary">Add More Box Size</button>
              </div>-->
              <h4 class="mt-3 mb-0 text-center"><b>Pallet</b></h4>
              <div class="col-12 py-3 border">
                <div class="row">
                  <div class="col-sm-12">
                    <strong class="form-label mb-0">Pallet Dimension/s</strong>
                    <div class="input-group"> 
                      <input type="text" class="form-control border border-primary" id="palletDimensions" name="palletDimensions" autocomplete="off" value="">
                    </div>
                  </div>
                </div>
              </div>
              <!--<div class="col-sm-5">
                <button class="btn btn-primary">Add More Pallet Dimension</button>
              </div>-->
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Storage</b></h3>
            <div class="row g-3">
              <div class="col-sm-6">
                <strong class="form-label mb-0">Shelf Life</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="shelfLife" name="shelfLife" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Storage and Handling</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="storeAndHand" name="storeAndHand" autocomplete="off" value="">
                </div>
              </div>
            </div>
            <hr>
            <div class="row g-3">
              <div class="col-sm-6">
                <strong class="form-label mb-0">UPC Code</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="upcCode" name="upcCode" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">GTIN Number</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="gtinNo" name="gtinNo" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Lead Time</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="leadTime" name="leadTime" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">MOQ</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="moq" name="moq" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-2">
                    <strong class="form-label mb-0">Export</strong>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="export" id="export" value="Yes">
                      <label class="form-check-label" for="exportYes">Yes</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="export" id="export" value="No">
                      <label class="form-check-label" for="exportNo">No</label>
                    </div>
                  </div>
                  <div class="col-10">
                    <strong class="form-label mb-0">Countries</strong>
                    <div class="input-group"> 
                      <textarea type="text" class="form-control border border-primary" id="exportCountry" name="exportCountry" autocomplete="off" value=""></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Manufacturing Details</b></h3>
            <div class="row g-3">
              <div class="col-sm-6">
                <strong class="form-label mb-0">Manufactured by</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="manufacturedBy" name="manufacturedBy" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Manufactured for</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="manufacturedFor" name="manufacturedFor" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Distributed by</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="distributedBy" name="distributedBy" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Country of Origin</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="originCountry" name="originCountry" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Storage/Warehouse</strong>
                <div class="input-group"> 
                  <input type="text" class="form-control border border-primary" id="warehouse" name="warehouse" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Lot Code Explanation</strong>
                <div class="input-group"> 
                  <textarea type="text" class="form-control border border-primary" id="lotCodeExplanation" name="lotCodeExplanation" autocomplete="off" value=""></textarea>
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Exercises</b></h3>
            <div class="row g-3">       
              <div class="col-sm-6">
                <strong class="form-label mb-0">Mock Recall Exercise</strong>
                <div class="input-group"> 
                  <input type="date" class="form-control border border-primary" id="mockRecallExercise" name="mockRecallExercise" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <strong class="form-label mb-0">Product Trace Exercise</strong>
                <div class="input-group"> 
                  <input type="date" class="form-control border border-primary" id="productTraceExercise" name="productTracExercise" autocomplete="off" value="">
                </div>
              </div>
            </div>
            <hr>
            <h3 class="mb-3 text-center"><b>Documents</b></h3>
            <div class="row g-3">
              <div class="col-sm-12">
                <strong class="form-label mb-0">Food Safety Plan/HACCP</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="foodSafetyPlan" name="foodSafetyPlan" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Formulator Approval</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="formulatorApproval" name="formulatorApproval" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Finish Product Recall Procedures</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="finishProductRecallProcedures" name="finishProductRecallProcedures" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Certificate of Analysis</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="certificateOfAnalysis" name="certificateOfAnalysis" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Specifications</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="specifications" name="specifications" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">SDS</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="sds" name="sds" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Certificate of Guarantee</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="certificateOfGuarantee" name="certificateOfGuarantee" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Certificate of Conformance</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="certificateOfConformance" name="certificateOfConformance" autocomplete="off" value="">
                </div>
              </div>
              <div class="col-sm-12">
                <strong class="form-label mb-0">Product Liability Insurance</strong>
                <div class="input-group"> 
                  <input type="file" class="form-control border border-dark" id="productLiabilityInsurance" name="productLiabilityInsurance" autocomplete="off" value="">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-light" style="position:sticky;bottom:0;z-index:2;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addProduct-btn" id="addProduct-btn" class="btn btn-primary">Add Product</button>
          </div>
        </div>
      </form>
    </div>
    <!--End of Add Product Modal-->
    <script>
      var addProduct_modal_btn = document.getElementById("addProduct-modal-btn");
      var addProduct_btn = document.getElementById("addProduct-btn");

      var productAddedTimeLong = document.getElementById("productAddedTimeLong");
      var productAddedTimeDay = document.getElementById("productAddedTimeDay");
      var productAddedTimeTime = document.getElementById("productAddedTimeTime");

      var mainProductImage = document.getElementById("mainProductImage");
      var leftProductImage = document.getElementById("leftProductImage");
      var topProductImage = document.getElementById("topProductImage");
      var frontProductImage = document.getElementById("frontProductImage");
      var backProductImage = document.getElementById("backProductImage");
      var bottomProductImage = document.getElementById("bottomProductImage");
      var rightProductImage = document.getElementById("rightProductImage");
      var uploadMainProductImage = document.getElementById("uploadMainProductImage");
      var uploadLeftProductImage = document.getElementById("uploadLeftProductImage");
      var uploadTopProductImage = document.getElementById("uploadTopProductImage");
      var uploadFrontProductImage = document.getElementById("uploadFrontProductImage");
      var uploadBackProductImage = document.getElementById("uploadBackProductImage");
      var uploadBottomProductImage = document.getElementById("uploadBottomProductImage");
      var uploadRightProductImage = document.getElementById("uploadRightProductImage");
      var uploadProductImages = document.getElementById("uploadProductImages");
      var displayProductImages = document.getElementById("displayProductImages");
      var displayProductImages_row = document.getElementById("displayProductImages-row");

      var productCode = document.getElementById("productCode");
      var productCode_span = document.getElementById("productCode-span");
      var productCode_icon = document.getElementById("productCode-icon");
      var productCode_text = document.getElementById("productCode-text");
      var productName = document.getElementById("productName");
      var productName_span = document.getElementById("productName-span");
      var productName_icon = document.getElementById("productName-icon");
      var productName_text = document.getElementById("productName-text");
      var productCategory = document.getElementById("productCategory");
      var productCategory_span = document.getElementById("productCategory-span");
      var productCategory_icon = document.getElementById("productCategory-icon");
      var productCategory_text = document.getElementById("productCategory-text");
      var productCategory_other = document.getElementById("productCategory-other");
      var productCategory_other_span = document.getElementById("productCategory-other-span");
      var productCategory_other_icon = document.getElementById("productCategory-other-icon");
      var productCategory_other_text = document.getElementById("productCategory-other-text");
      var productDescription = document.getElementById("productDescription");
      var productDescription_span = document.getElementById("productDescription-span");
      var productDescription_icon = document.getElementById("productDescription-icon");
      var productDescription_text = document.getElementById("productDescription-text");

      var ingredientList = document.getElementById("ingredientList");
      
      var productImages_message = ["Upload images!","All necessary images uploaded."];
      var productCode_message = ["Enter product code!","Product code entered."];
      var productName_message = ["Enter product name!","Product name entered."];
      var productCategory_message = ["Enter product category!","Product category entered."];
      var productCategory_other_message = ["Specify product category!","Product category specified."];
      var productDescription_message = ["Enter product description!","Product description entered."];

      var uploadedImages = "";

      var allergen1 = document.getElementById("allergen1");
      var allergen2 = document.getElementById("allergen2");
      var allergen3 = document.getElementById("allergen3");
      var allergen4 = document.getElementById("allergen4");
      var allergen5 = document.getElementById("allergen5");
      var allergen6 = document.getElementById("allergen6");
      var allergen7 = document.getElementById("allergen7");
      var allergen8 = document.getElementById("allergen8");
      var allergen9 = document.getElementById("allergen9");
      var allergenOther = document.getElementById("allergenOther");
      var allergen_other = document.getElementById("allergen_other");
      var allergensArrayBool = [false,false,false,false,false,false,false,false,false];
      var allergensArrayString = "";

      var exportRadio = document.getElementById("export");
      var exportCountry = document.getElementById("exportCountry");

      var imageUploadedCounter = 0;
      var verifiedFields = [];

      uploadMainProductImage.addEventListener("change",mainProductImageUpload);
      uploadMainProductImage.addEventListener("change",productImageFields);
      uploadLeftProductImage.addEventListener("change",leftProductImageUpload,);
      uploadLeftProductImage.addEventListener("change",productImageFields);
      uploadTopProductImage.addEventListener("change",topProductImageUpload);
      uploadTopProductImage.addEventListener("change",productImageFields);
      uploadFrontProductImage.addEventListener("change",frontProductImageUpload);
      uploadFrontProductImage.addEventListener("change",productImageFields);
      uploadBackProductImage.addEventListener("change",backProductImageUpload);
      uploadBackProductImage.addEventListener("change",productImageFields);
      uploadBottomProductImage.addEventListener("change",bottomProductImageUpload);
      uploadBottomProductImage.addEventListener("change",productImageFields);
      uploadRightProductImage.addEventListener("change",rightProductImageUpload);
      uploadRightProductImage.addEventListener("change",productImageFields);
      uploadProductImages.addEventListener("change",productImagesUpload);
      uploadProductImages.addEventListener("change",productImageFields);
      productCode.addEventListener("input",productCodeField);
      productName.addEventListener("input",productNameField);
      productCategory.addEventListener("change",productCategoryField);
      productCategory_other.addEventListener("input",productCategory_otherField);
      productDescription.addEventListener("input",productDescriptionField);
      allergen1.addEventListener("click",allergen1Field);
      allergen2.addEventListener("click",allergen2Field);
      allergen3.addEventListener("click",allergen3Field);
      allergen4.addEventListener("click",allergen4Field);
      allergen5.addEventListener("click",allergen5Field);
      allergen6.addEventListener("click",allergen6Field);
      allergen7.addEventListener("click",allergen7Field);
      allergen8.addEventListener("click",allergen8Field);
      allergen9.addEventListener("click",allergen9Field);

      productCodeField();
      productNameField();
      productCategoryField();
      productCategory_otherField();
      productDescriptionField();

      function mainProductImageUpload() {
        let reader = new FileReader();
        reader.addEventListener("load", () => {
          let uploadedImage = reader.result;
          mainProductImage.src = uploadedImage;
        });
        reader.readAsDataURL(uploadMainProductImage.files[0]);
      }

      function leftProductImageUpload() {
        let reader = new FileReader();
        reader.addEventListener("load", () => {
          let uploadedImage = reader.result;
          leftProductImage.src = uploadedImage;
        });
        reader.readAsDataURL(uploadLeftProductImage.files[0]);
      }

      function topProductImageUpload() {
        let reader = new FileReader();
        reader.addEventListener("load", () => {
          let uploadedImage = reader.result;
          topProductImage.src = uploadedImage;
        });
        reader.readAsDataURL(uploadTopProductImage.files[0]);
      }

      function frontProductImageUpload() {
        let reader = new FileReader();
        reader.addEventListener("load", () => {
          let uploadedImage = reader.result;
          frontProductImage.src = uploadedImage;
        });
        reader.readAsDataURL(uploadFrontProductImage.files[0]);
      }

      function backProductImageUpload() {
        let reader = new FileReader();
        reader.addEventListener("load", () => {
          let uploadedImage = reader.result;
          backProductImage.src = uploadedImage;
        });
        reader.readAsDataURL(uploadBackProductImage.files[0]);
      }

      function bottomProductImageUpload() {
        let reader = new FileReader();
        reader.addEventListener("load", () => {
          let uploadedImage = reader.result;
          bottomProductImage.src = uploadedImage;
        });
        reader.readAsDataURL(uploadBottomProductImage.files[0]);
      }

      function rightProductImageUpload() {
        let reader = new FileReader();
        reader.addEventListener("load", () => {
          let uploadedImage = reader.result;
          rightProductImage.src = uploadedImage;
        });
        reader.readAsDataURL(uploadRightProductImage.files[0]);
      }

      function productImagesUpload() {
        for (let i = 0; i < uploadProductImages.files.length; i++) {
          let reader = new FileReader();
          reader.addEventListener("load", () => {
            let uploadedImages = reader.result;
            let div = document.createElement("div");
            div.setAttribute("class","uploaded-img-box-xxl uploaded-img-box-xl uploaded-img-box-lg uploaded-img-box-md uploaded-img-box-sm uploaded-img-box-xs");
            displayProductImages_row.append(div);
            let img = document.createElement("img");
            img.setAttribute("class","border border-dark uploaded-img-xxl uploaded-img-xl uploaded-img-lg uploaded-img-md uploaded-img-sm uploaded-img-xs")
            img.src = uploadedImages;
            div.append(img);
            imageUploadedCounter++;
            console.log(imageUploadedCounter)
          });
          reader.readAsDataURL(uploadProductImages.files[i]);
        }
      }
      function productImageFields() {
        if (mainProductImageUpload.value != undefined && leftProductImageUpload.value != undefined && 
        topProductImageUpload.value != undefined && frontProductImageUpload.value != undefined && 
        backProductImageUpload.value != undefined && bottomProductImageUpload.value != undefined && 
        rightProductImageUpload.value != undefined && productImagesUpload.value != undefined) {
          console.log("YES");
        }
        else {
          console.log("NO");
        }
      }

      function productCodeField() {
        basicVerifier(productCode,productCode_span,productCode_icon,productCode_text,productCode_message,0);
      }

      function productNameField() {
        basicVerifier(productName,productName_span,productName_icon,productName_text,productName_message,1);
      }

      function productCategoryField() {
        basicVerifier(productCategory,productCategory_span,productCategory_icon,productCategory_text,productCategory_message,2);
        basicOther(productCategory,productCategory_other,productCategory_other_span,productCategory_other_icon,productCategory_other_text,productCategory_message,3);
      }

      function productCategory_otherField() {
        basicOther(productCategory,productCategory_other,productCategory_other_span,productCategory_other_icon,productCategory_other_text,productCategory_message,3);
      }

      function productDescriptionField() {
        basicVerifier(productDescription,productDescription_span,productDescription_icon,productDescription_text,productDescription_message,4);
      }

      function allergen1Field() {
        if (allergen1.checked == true) {
          allergensArrayBool[0] = true;
        }
        else {
          allergensArrayBool[0] = false;
        }
        generalAllergens(allergen1,0);
      }

      function allergen2Field() {
        if (allergen2.checked == true) {
          allergensArrayBool[1] = true;
        }
        else {
          allergensArrayBool[1] = false;
        }
        generalAllergens(allergen2,1);
      }

      function allergen3Field() {
        if (allergen3.checked == true) {
          allergensArrayBool[2] = true;
        }
        else {
          allergensArrayBool[2] = false;
        }
        generalAllergens(allergen3,2);
      }

      function allergen4Field() {
        if (allergen4.checked == true) {
          allergensArrayBool[3] = true;
        }
        else {
          allergensArrayBool[3] = false;
        }
        generalAllergens(allergen4,3);
      }

      function allergen5Field() {
        if (allergen5.checked == true) {
          allergensArrayBool[4] = true;
        }
        else {
          allergensArrayBool[4] = false;
        }
        generalAllergens(allergen5,4);
      }

      function allergen6Field() {
        if (allergen6.checked == true) {
          allergensArrayBool[5] = true;
        }
        else {
          allergensArrayBool[5] = false;
        }
        generalAllergens(allergen6,5);
      }

      function allergen7Field() {
        if (allergen7.checked == true) {
          allergensArrayBool[6] = true;
        }
        else {
          allergensArrayBool[6] = false;
        }
        generalAllergens(allergen7,6);
      }

      function allergen8Field() {
        if (allergen8.checked == true) {
          allergensArrayBool[7] = true;
        }
        else {
          allergensArrayBool[7] = false;
        }
        generalAllergens(allergen8,7);
      }

      function allergen9Field() {
        if (allergen9.checked == true) {
          allergensArrayBool[8] = true;
        }
        else {
          allergensArrayBool[8] = false;
        }
        generalAllergens(allergen9,8);
      }

      function generalAllergens(allergen,id) {
        allergenArrayString = "";
        for (let i = 0; i < allergensArrayBool.length; i++) {
          if (i == id) {
            if (allergensArrayBool[id] == true) {
              allergensArrayString += allergen.value + ",";
            }
          }
        }
        allergensOtherist();
        console.log(allergensArrayBool);
        console.log(allergensArrayString);
      }

      function allergensOtherist() {
        if (allergenOther.checked == true) {
          allergen_other.disabled = false;
        }
        else {
          allergen_other.disabled = true;
          allergen_other.value = "";
        }
      }

      function basicOther(otherer,otherist,span,icon,text,message,id) {
        if (otherer.value == "Other") {
          otherist.disabled = false;
          icon.style.visibility = "visible";
          text.style.visibility = "visible";
          basicVerifier(otherist,span,icon,text,message,id);
        }
        else {
          otherist.disabled = true;
          otherist.value = "";
          icon.style.visibility = "hidden";
          text.style.visibility = "hidden";
          verifiedTruePassive(otherist,span,icon,text,message,id);
        }
      }

      function basicVerifier(field,span,icon,text,message,id) {
        if (field.value == "") {
          verifiedFalse(field,span,icon,text,message,id);
        }
        else {
          verifiedTrue(field,span,icon,text,message,id);
        }
      }

      function verifiedTrue(field,span,icon,text,message,id) {
        field.setAttribute("class","form-control form-control-success border border-success");
        span.setAttribute("class","fa fa-check-circle text-success");
        icon.setAttribute("class","las la-check text-success");
        text.setAttribute("class","text-success");
        text.innerHTML = message[1];
        verifiedFields[id] = true;
        verification();
      }

      function verifiedTruePassive(field,span,icon,text,message,id) {
        field.setAttribute("class","form-control border");
        span.setAttribute("class","fa fa-check-circle text-success");
        icon.setAttribute("class","las la-check text-success");
        text.setAttribute("class","text-success");
        text.innerHTML = message[1];
        verifiedFields[id] = true;
        verification();
      }

      function verifiedFalse(field,span,icon,text,message,id) {
        field.setAttribute("class","form-control form-control-danger border border-danger");
        span.setAttribute("class","fa-solid fa-circle-xmark text-danger");
        icon.setAttribute("class","las la-times text-danger");
        text.setAttribute("class","text-danger");
        text.innerHTML = message[0];
        verifiedFields[id] = false;
        verification();
      }

      function verification () {
        let breaker = false;
        for (let i = 0; i < verifiedFields.length; i++) {
          if (verifiedFields[i] == false) {
            breaker = true;
          }
        }
        if (breaker == true) {
          addProduct_btn.disabled = true;
        }
        else {
          addProduct_btn.disabled = false;
        }
      }
    </script>
  </body>
</html>
