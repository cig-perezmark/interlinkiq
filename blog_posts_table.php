<?php 
    include "navbar/header.php";
    include "database_iiq.php";
    // include "inc/landing_header.php"; 
?> 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>InterlinkIQ Blogs</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="shortcut icon" href="assets/img/interlink icon.png" type="image/png">


        <style>
            .cards {
                display:grid;
                grid-template-columns: 1fr 1fr 1fr;
                grid-gap: 10px;
            }
            .card:hover {
                cursor:pointer;
                box-shadow: 9px 11px 5px -5px rgba(0,0,0,0.25);
                -webkit-box-shadow: 9px 11px 5px -5px rgba(0,0,0,0.25);
                -moz-box-shadow: 9px 11px 5px -5px rgba(0,0,0,0.25);
                border:solid black 0.5px;
            }

            #searchbarinputdiv {
                margin: 0 auto;
                max-width: 960px;
                height:30px;
                margin-bottom:30px;
            }

            #searchbarinputdiv input {
                width:100%;
                height:100%;
                font-size:1em;
                height:30px;
                border:solid gray 1px;
                border-radius:5px;
            }


            html {
                box-sizing: border-box;
            }
            *, *:before, *:after {
                box-sizing: inherit;
            }

            body {
                font: 1em/1.4 Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                background-color: #fafafa;
            }

            img {
                max-width: 100%;
            }

            .cards {
                margin: 0 auto;
                max-width: 1000px;
            }

            .card {
                background-color: #fff;
                box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
                margin:20px;
            }

            .card header {
                padding: 10px;
                background-color: #0084AD;
                color: #fff;
            }

            .card header h2 {
                font-size: 1.4rem;
                font-weight: normal;
                margin: 0;
                padding: 0;
            }

            .card .body {
                padding: 10px;
                font-size: .9rem;
                color: #757575;
            }
        </style>
    </head>
    <body>
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner" style="background-color:#fff;">
                <!-- BEGIN LOGO -->
                <div class="page-logo" style="background-color:#fff;">
                    <a href="https://interlinkiq.com/"><img src="assets/img/interlinkiq v3.png" alt="logo" class="logo-default" height="70" style="margin-top:-3px;" /> </a>
                </div>
                <div class="page-top">
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <?php include "navbar/topbar.php"; ?>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
 
        <br/><br/><br/><br/><br/>
        <br/><br/><br/><br/><br/>
        <div id="searchbarinputdiv">
            <input type="text" style="padding:5px;" id="Search" onkeyup="myFunction()" placeholder="Search for a keyword" title="Type in a name">
        </div>

        <div class="cards">

            <?php   
            
                $i = 1;
                $query = "SELECT * FROM tbl_blogs_pages where status_publish = 1 order by blogs_title ASC";
                $result = mysqli_query($conn, $query);
                                            
                while($row = mysqli_fetch_array($result)) {
                    $url = $row['description_view'].'.png';
                    $decodeUrl = urlencode($url);
                    $name = basename($url);
                    $finalimageurl =  rawurlencode($name);

                    echo '<div class="card">
                        <a href="blog_posts.php?id='.$row['blogs_id'].'" target="blank">
                            <img src="inc/blog_thumbnails/'.$finalimageurl.'" alt="No Thumbnail Image" onerror="this.onerror=null; this.src=\'inc/blog_thumbnails/defaultimage.png\'">
                        
                            <div class="body" style="background-color:#ADD8E6;">
                                <h3>'.$row['description_view'].'</h3>
                            </div>
                        </a>
                    </div>';

                }
            
            ?>
    
        </div>
        <br/><br/>
        <?php include "navbar/footer.php"; ?>
        <script>
            function myFunction() {
                var input = document.getElementById("Search");
                var filter = input.value.toLowerCase();
                var nodes = document.getElementsByClassName('card');

                for (i = 0; i < nodes.length; i++) {
                    if (nodes[i].innerText.toLowerCase().includes(filter)) {
                        nodes[i].style.display = "block";
                    } else {
                        nodes[i].style.display = "none";
                    }
                }
            }
        </script>
    </body>
</html>