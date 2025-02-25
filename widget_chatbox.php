<style type="text/css">
    .excerpt:hover {
        background: #f3f3f3;
    }
    .excerpt p {
        /*display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        */
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>



<div class="offcanvas offcanvas-end" id="chatbox">
    <div class="offcanvas-header">
        <?php 
            $sql = mysqli_query($conn, "SELECT * FROM tbl_user WHERE is_active = 1 AND ID = $current_userID");
            if(mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);

                $selectUserInfo = mysqli_query($conn, "SELECT * FROM tbl_user_info WHERE user_id = '".$row['ID']."'");
                if(mysqli_num_rows($selectUserInfo) > 0) {
                    $rowInfo = mysqli_fetch_assoc($selectUserInfo);
                    $current_userAvatar = $rowInfo['avatar'];
                }
            }
        ?>
        <div class="d-flex flex-columnx justify-content-betweenx align-items-center w-100 border-1">
            <span class="position-relative me-2">
                <span class="d-none position-absolute bottom-0 end-0 translate-middlex badge border border-light rounded-circle p-2 <?php echo $row['is_active'] == 1 ? 'bg-success':'bg-danger'; ?>">
                    <span class="visually-hidden">unread messages</span>
                </span>
                <img class="d-flex justify-content-center border border-2 bg-light rounded-circle" style="width:80px; height:80px; object-fit: contain;" src="<?php echo $base_url.'uploads/avatar/'.$current_userAvatar; ?>" alt="Avatar" onerror="this.onerror=null;this.src='https://via.placeholder.com/150x150/EFEFEF/AAAAAA.png?text=no+image';" />
            </span>
            <span class="fs-4"><?php echo $row['first_name']. " " . $row['last_name'] ?></span>
        </div>
    </div>
    <div class="row px-3 pb-3">
        <div class="mx-auto">
            <div class="input-group">
                <input class="form-control border-end-0 border rounded-pill bg-light" type="search" placeholder="search" id="txtSearch">
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button" style="margin-left: -40px;">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="offcanvas-body pt-0">
        <div class="users-list" style="max-height: calc(100vh - 185px) !important;" id="userList"></div>
    </div>
</div>

<?php
    // message icon
    echo '<button type="button" data-bs-toggle="offcanvas" data-bs-target="#chatbox" class="btn position-relative text-white position-fixed rounded-circle bg-primary" style="right: 30px; bottom: 30px; z-index: 1; width: 70px; height: 70px;" id="notification-count">
        <i class="bi-envelope fs-2"></i>
        <span class="d-none position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-6" style="margin: 10px 10px 0 0;">
            <div id="countNotif"></div>
        </span>
    </button>';
?>
