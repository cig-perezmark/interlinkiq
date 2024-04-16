
<?php 
include "navbar/header.php";
include "database.php";
 
?>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        
        
        
       <div id="loading">
             <img id="loading-image" src="assets/img/loading.gif" alt="Loading..." />
       </div>
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner" style="background-color:#fff;">
                <!-- BEGIN LOGO -->
                <div class="page-logo" style="background-color:#fff;">
                    <a href="#">
                         <img src="assets/img/interlinkiq v3.png" alt="logo" class="logo-default" height="70" style="margin-top:-3px;" /> </a>
                        </a>
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
        
           <form id="live-search" action="" class="styled search-container" method="post">
   
                <input type="text" class="text-input" id="filter" placeholder="ENTER KEYWORD TO SEARCH......." value="" />
        			 <!--<a href="#"><i class="fa fa-search search-icon" aria-hidden="true"></i></a>-->
                <span id="filter-count"></span>
 
        </form>
        
        <ul class="qanda">
            
            <?php
                                        $t=1;
                                        $query = "SELECT * FROM tbl_Project_Category ORDER BY category_name asc";
                                        $result = mysqli_query($conn, $query);
                                                                    
                                        while($row = mysqli_fetch_array($result)){?>
                                        
                <li> <strong class="question">&nbsp; <?php echo $row['category_name']; ?></strong>
                
                <?php 
                                                                $cat = $row['category_name'];
                                                                $query1 = "SELECT * FROM tbl_Project_Services where services_category = '$cat' order by services_name asc";
                                                                $result1 = mysqli_query($conn, $query1);
                                                                                            
                                                                while($row1 = mysqli_fetch_array($result1)){?>
                
               <span class="answer">
                               <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $row1['services_name']; ?><br></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                        </span>
              <?php } ?>	
                </li>
                
            <?php } ?>	
        </ul>
               
       <!-- END CONTAINER -->
  <?php
  include "navbar/footer.php";
  ?>
  
  <style>
      body{
	 background-color:#f5f5f5;
}

#loading {
  position: fixed;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  opacity: 0.7;
  background-color: #fff;
  z-index: 99;
}

#loading-image {
  z-index: 100;
}
input.text-input {
  margin: 0 auto;
  display:block;
}

ul.qanda {
    color:#696969;
    list-style:none;
    margin:100px auto;
    width: 80%;
    padding:0;
}
.qanda li {
    border:1px solid #f5f5f5;
    margin:0em 0;
    padding:0;
}
.qanda .question {
    cursor:pointer;
    display:block;
    font-size:1.7em;
    font-weight:300;
    padding:.75em 1.25em;
    position:relative;
	 
}
.qanda .answer {
    border:1px solid #6495ED;
    display:block;
    padding:10px;
    font-size: 1.5em;
}
.qanda a {
    color:#f59e00
}
.qanda a:hover {
    color:#ec6408
}
.qanda .question {
    padding-left:1.5em;
    border: solid #e5e5e5 1px;
    color: #696969;
    transition: 250ms all linear;
	 box-shadow: 6px 6px 5px 0px rgba(0,0,0,0.05);
   -webkit-box-shadow: 6px 6px 5px 0px rgba(0,0,0,0.05);
   -moz-box-shadow: 6px 6px 5px 0px rgba(0,0,0,0.05);
	  margin-top:10px;
	  padding: 20px 15px;
}
.qanda .question.active {
    background-color: #6495ED;
    color: #fff;
    transition: 250ms all linear;
}
.qanda .question:before {
    content:"+";
    font-weight:700;
    position:absolute;
    left:.5em
}
.qanda .active:before {
    content:"-"
}
.search-container{
  width: 490px;
  display: block;
  margin: 0 auto;
}

input#filter{
  margin: 0 auto;
  width: 100%;
  height: 45px;
  padding: 0 20px;
  font-size: 1.7rem;
  border: 1px solid #D0CFCE;
  outline: none;
	margin-top:100px;
  &:focus{
    border: 1px solid #008ABF;
    transition: 0.35s ease;
    color: #008ABF;
    &::-webkit-input-placeholder{
      transition: opacity 0.45s ease; 
  	  opacity: 0;
     }
    &::-moz-placeholder {
      transition: opacity 0.45s ease; 
  	  opacity: 0;
     }
    &:-ms-placeholder {
     transition: opacity 0.45s ease; 
  	 opacity: 0;
     }    
   }
 }

.search-icon{
  position: relative;
  float: right;
  width: 75px;
  height: 75px;
  top: -62px;

}



  </style>
 <script>
 
  $(window).load(function() {
    $('#loading').hide();
  });
     $(document).ready(function () {
       $('.answer').hide();
       $(".question").click(function () {
           var a = $(this).parent('li').find('.answer');
           if (a.css('display') == 'none') {
               $('.question').removeClass('active');
               $('.answer').slideUp('fast');
               a.slideDown();
               $(this).addClass('active');
           } else {
               a.slideUp();
               $(this).removeClass('active')
           }
       });
   });

$("#filter").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
 
        // Loop through the comment list
        $(".qanda li").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
    });
 </script>