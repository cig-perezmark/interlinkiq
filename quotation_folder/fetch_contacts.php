<?php 
include "../database.php";

if(isset($_POST["search_val"])) {
    $get_id = $_POST["search_val"];
    if(!empty($_POST["search_val"])) {
        $get_id = $_POST["search_val"];
        $query = mysqli_query($conn,"select * from tbl_Customer_Relationship where crm_id = '$get_id'");
        foreach($query as $row){?>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="50px">Company:</td>
                        <td><input class="form-control no-border" value="<?= $row['account_name']; ?>" name="company_name"></td>
                        <td width="180px">Date:</td>
                        <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>" name="date_create_q"></td>
                    </tr>
                    <tr>
                        <td width="50px">Contact:</td>
                        <td><input class="form-control no-border" value="<?= $row['account_phone']; ?>" name="contact_no"></td>
                        <td width="180px">Target Completion Date:</td>
                        <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>" name="target_date"></td>
                    </tr>
                    <tr>
                        <td width="50px">Address</td>
                        <td>
                            <?php
                               // for display country
                                $country_id = $row['account_country'];
                                $querycountry = "SELECT * FROM countries where id = '$country_id'";
                                $resultcountry = mysqli_query($conn, $querycountry);
                                while($rowcountry = mysqli_fetch_array($resultcountry))
                                    {
                                         $country = $rowcountry['name'];
                                    }
                                ?>
                            <input class="form-control no-border" value="<?= $row['account_address']; ?>, <?= $country; ?>" name="address_q"></td>
                        <td width="180px">Project No.:</td>
                        <td><input class="form-control no-border" placeholder="" name="project_no"></td>
                    </tr>
                    <tr>
                        <td width="50px">Phone:</td>
                        <td><input class="form-control no-border" value="<?= $row['account_phone']; ?>" name="phone_no"></td>
                        <td width="180px">Location:</td>
                        <td><input class="form-control no-border" placeholder="" name="location_no"></td>
                    </tr>
                    <tr>
                        <td width="50px">Email:</td>
                        <td><input class="form-control no-border" value="<?= $row['account_email']; ?>" name="email_q"></td>
                        <td width="180px">Start Date:</td>
                        <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>" name="start_date"></td>
                    </tr>
                </tbody>
            </table>
            <?php
         } 
    }
    else{?>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>Client:</td>
                    <td><input class="form-control no-border" placeholder=""></td>
                    <td width="180px">Date:</td>
                    <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>"></td>
                </tr>
                <tr>
                    <td>Contact:</td>
                    <td><input class="form-control no-border" placeholder=""></td>
                    <td width="180px">Target Completion Date:</td>
                    <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>"></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><input class="form-control no-border" placeholder=""></td>
                    <td width="180px">Project No.:</td>
                    <td><input class="form-control no-border" placeholder=""></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><input class="form-control no-border" placeholder=""></td>
                    <td width="180px">Location:</td>
                    <td><input class="form-control no-border" placeholder=""></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input class="form-control no-border" placeholder=""></td>
                    <td width="180px">Start Date:</td>
                    <td><input class="form-control no-border" type="date" value="<?= date('Y-m-d', strtotime(date('Y-m-d'))); ?>"></td>
                </tr>
            </tbody>
        </table>
    <?php } 
}
?>
