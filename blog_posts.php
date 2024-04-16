<?php 
    include "database_iiq.php";
    include "inc/landing_header.php"; 
?>
<div style="background-color:#242F9B;height:80px;width:100%;"></div>
<div class="container">

    <br><br>
    <div class="row">
        <div class="col-md-12">
            <?php
                if (!empty($_GET['id'])) {
                    $blogid = $_GET['id'];
                    $query = "SELECT * FROM tbl_blogs_pages where blogs_id = $blogid";
                    $result = mysqli_query($conn, $query);
                    if ( mysqli_num_rows($result) > 0 ) {
                        while($row = mysqli_fetch_array($result)) {
                            echo '<p class="big">'.$row['descriptions'].'<br><br></p><br><br>';
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>
<?php include "inc/footer.php"; ?>