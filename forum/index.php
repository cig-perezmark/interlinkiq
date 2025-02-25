<?php 

require_once "forum_functions.php";
include_once '../database.php'; 
//Display Forum

if (!isset($_COOKIE['ID'])) {
    $user_id = "";
    $current_userFName = "";
}
else{
$user_id = $_COOKIE['ID'];
$user_fname_active = $_COOKIE['first_name'];
$selectUser = mysqli_query( $conn,"SELECT * from tbl_user WHERE ID = $user_id" );
        if ( mysqli_num_rows($selectUser) > 0 ) {
            $rowUser = mysqli_fetch_array($selectUser);
            $current_userID = $rowUser['ID'];
            $current_userEmployeeID = $rowUser['employee_id'];
            $current_userFName = $rowUser['first_name'];
            $current_userLName = $rowUser['last_name'];
            $current_userEmail = $rowUser['email'];
            $current_userType = $rowUser['type'];
        }    
}


$forumFunctions = new ForumFunctions();
$displayforums = $forumFunctions->forumdisplay();
$top5likedquestions = $forumFunctions->top5likedquestions();
$top5commentedquestions = $forumFunctions->top5commentedquestions();
$top5viewedquestions = $forumFunctions->top5viewedquestions();
$uniquekeyword = $forumFunctions->uniquekeyword();
$allquestioncount = $forumFunctions->allquestioncount();
$totalunanswered = $forumFunctions->totalunansweredcount();



foreach ($totalunanswered as $row) {
    $totalunansweredcount = $row['total_unanswered'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="forum_style.css">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="../assets/img/interlink icon.png" />

</head>
<body>


    <div class="main-section">
         <input type="hidden" id="usernameactivejavascriptvar" value="<?php echo $user_fname_active; ?>">
         <div class="header">
		<div class="container">
			<h2 class="logo"> <a class="navbar-brand" href="https://interlinkiq.com/"><img src="../LandingPageFiles/img/iqlogo_small.png" alt="" width="30%"></a></h2>
			<a id="menu-icon">&#9776;</a>
			<nav class="navbar">
				<ul class="menu">
				     	<li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="//consultareinc.com/shop">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="management_services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="directory">Directory</a></li>
                        <li class="nav-item"><a class="nav-link"  href="https://interlinkiq.com/blog_posts_table">Blog</a></li>
                        <li class="nav-item"><a class="nav-link" style="font-size:14px !important;" href="//www.youtube.com/@AllAboutCompliance/videos">Vlog</a></li>
                        <li class="nav-item active"><a class="nav-link" href="forum/index">Forum</a></li>
                        <li class="nav-item"><a class="nav-link" style="font-size:14px !important;" href="specialist">Specialist</a></li>
                        <li class="nav-item d-none"><a class="nav-link" style="font-size:14px !important;" href="marketplace">Marketplace</a></li>
                        <li class="nav-item"><a class="nav-link" style="font-size:14px !important;" href="grant">Grant Services</a></li>
                        <li class="nav-item"><a class="nav-link" style="font-size:14px !important;" href="contact">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="login"> <i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;Login</a></li>
				</ul>
			</nav>

		</div>
	</div>
   
        
            <div class="card1">
                <div class="content-main-header">
                    <div class="question-counter-details">
                        <span class="question-count"  style="border:solid lightgray 1px;padding:10px;border-radius:5px;">Questions Count: <span id="question-count">
                        <?php foreach ($allquestioncount as $row) {    
                            echo $row['all_count'];
                        }
                        ?>
                        </span></span>

                        <button class="button4" id="filter_none"><i class="fa fa-home" aria-hidden="true"></i> Home</button>
                        <button class="button4" id="filter_newest">Newest</button>
                        <button class="button4" id="filter_mostliked">Most Liked</button>
                        <button class="button4" id="filter_mostviewed">Most Viewed</button>
                        <button class="button4" id="filter_unanswered"><span><?php echo "( ".$totalunansweredcount." )";?></span> Unanswered</button>
                    </div>
                </div>
    <div class="question-display-holder" id="question-display-holder">
     <input placeholder="Search" id="search" type="text" />
     <label style="border:solid lightgray 1px;padding:5px;border-radius:2px;"><i class="fa fa-filter" aria-hidden="true"></i> &nbsp; FILTER: <span id="current_filter">NONE</span></label>
                <?php 
        
              foreach ($displayforums as $row) {
                  
                  $question_id = $row["id"];
                  $questiontitle =  $row["question_title"];
                  $question_description =  $row["content"];
                  $asked_by = $row["asked_by"];
                  $question_tags = $row["question_tags"];
                  $question_date_posted = $row["date_posted"];
                  $question_status = $row["status"];
                  $count_like =  $row["count_like"];
                  $count_view =  $row["count_view"];
                  $count_comment =  $row["count_comment"];
                  $user_fname = $row["user_fname"];
                  $keywordtags = $row["question_tags"];
                  $arraykeyword = explode(',',$keywordtags);
            ?>
                     <div class="card question-display-home cardholderforsearching">
                                <div class="card-header">
                                    <span id="<?php echo $question_id;  ?>" class="like-counter engagement-figure liked_display"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span id="likecount_<?php echo $question_id; ?>"><?php echo $count_like ; ?></span></span>
                                    <span class="answer-counter engagement-figure"><i class="fa fa-commenting-o" aria-hidden="true"></i> <?php echo $count_comment ; ?></span>
                                    <span  class="answer-counter engagement-figure "><i class="fa fa-eye" aria-hidden="true"></i> <span id="viewcount_<?php echo $question_id; ?>"><?php echo $count_view ; ?></span></span>
                                    <span class="answer-counter engagement-figure user-posted user_posted_by_name" id="<?php echo $user_fname; ?>"><span class="posted-by-text">Posted By:</span> &nbsp;<i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="postedby-name"><?php echo  $user_fname; ?></span></span>
                                </div>
                                <div class="card-body questiontitle">
                                <h5 class="card-title"><?php echo  $questiontitle; ?></h5>
                                <div class="description_holder">
                                    <p class="card-text"><?php echo  $question_description; ?></p>
                                </div> <br/>
                                <a id="<?php echo $question_id;  ?>" class="btn btn-primary view_display"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a> <br/>
                                
                                <?php 
                                    foreach($arraykeyword as $tags)
                                    {
                                ?>
                                <?php 
                                    if($tags == ""){
                                        echo "";
                                ?>
                                <?php 
                                    }
                                else{
                                ?>
                                <button id="<?php echo $tags ?>" style="margin-top:10px;" type="button" class="btn btn-outline-secondary filterkeyword"><?php echo $tags ?></button>
                                <?php 
                                }
                                   }
                                ?>
                                
                                <div style="text-align:right;">
                                    <span  style="color:lightgray;"><?php echo $question_date_posted; ?></span>
                                </div>
                                </div>
                         </div>
            <?php
                  
             }
        
            ?>
           
              </div>
            </div>
      
            <div class="card2">
                <div class="ask-question-button">
                    <div class="button">
                        <a href="#openModal-about" id="askbutton" style="text-decoration:none;color:white;">Ask a Question</a>
                        <i id="questionmark" class="fa fa-question"></i>
                    </div>
                    <div class="card card-right-panel" style="width:100%;margin-top: 20px;text-align: left;">
                        <div class="card-body">
                          <h5 class="card-title"><i class="fa fa-thumbs-up" aria-hidden="true" style="color:#228B22;"></i> &nbsp;Most Liked Questions</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Top 5 most liked questions by all interlinkiq users</h6>
                            
                          <?php foreach ($top5likedquestions as $row) {
                            ?>
                                 <p id="<?php echo $row['id']; ?>" class="card-text-mostlike view_display"><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;<i class="fa fa-thumbs-up" aria-hidden="true" style="color:#6495ED;"> &nbsp;(<?php echo $row['count_like']." likes"; ?>)</i> <?php echo $row['question_title']; ?></p>
                         <?php
                          }
                            ?>
                        </div>
                    </div>
    
                    <div class="card card-right-panel" style="width:100%;margin-top: 20px;text-align: left;">
                        <div class="card-body">
                          <h5 class="card-title"><i class="fa fa-commenting-o" aria-hidden="true" style="color:#228B22;"></i> &nbsp;Most Active Questions</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Top 5 most active questions by all interlinkiq users</h6>

                    

                          <?php foreach ($top5commentedquestions as $row) {
                            ?>
                                 <p id="<?php echo $row['id']; ?>" class="card-text-mostlike view_display"><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;<i class="fa fa-commenting-o" aria-hidden="true" style="color:#6495ED;"> &nbsp; (<?php echo $row['count_comments']." comments"; ?>)</i> <?php echo $row['question_title']; ?></p>
                         <?php
                          }
                          ?>
            
                        </div>
                    </div>

                    <div class="card card-right-panel" style="width:100%;margin-top: 20px;text-align: left;">
                        <div class="card-body">
                          <h5 class="card-title"><i class="fa fa-eye" aria-hidden="true" style="color:#228B22;"></i> &nbsp;Most Viewed Questions</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Top 5 most viewed questions by all interlinkiq users</h6>

                          <?php foreach ($top5viewedquestions as $row) {
                            ?>
                                 <p id="<?php echo $row['id']; ?>" class="card-text-mostlike view_display"><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;<i class="fa fa-eye" aria-hidden="true" style="color:#6495ED;"> &nbsp; (<?php echo $row['count_viewed']." views"; ?>)</i> <?php echo $row['question_title']; ?></p>
                         <?php
                          }
                          ?>
            

                        </div>
                    </div>
                    
                    <div class="card card-right-panel" style="width:100%;margin-top: 20px;text-align: left;">
                        <div class="card-body">
                          <h5 class="card-title"><i class="fa fa-eye" aria-hidden="true" style="color:#228B22;"></i> &nbsp;Filter with Keywords</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Click keywords below to filter the questions</h6>

                          <?php foreach ($uniquekeyword as $row) {
                              
                              $string = $row['uniquetags'];
                            ?>
                            
                         <?php
                          }
                          
                          $array = explode(',', $string);
                          foreach($array as $value){
                          ?>
                          <button id="<?php echo $value ?>" style="margin-top:10px;" type="button" class="btn btn-outline-secondary filterkeyword"><?php echo $value ?></button>
                         
                         <?php
                          }
                         ?>    

                        </div>
                    </div>

                </div>
        </div>
    </div>
<!--modals-->
  <div id="openModal-about" class="modalDialog">
      <div>
         <a href="#close" title="Close" class="close">X</a>
         <h2>Ask a Public Question</h2>
         
         <form>
            <div class="form-group">
              <label for="exampleInputEmail1"><span style="color:red;">*</span>Write Your Question:</label>
              <input type="email" class="form-control" id="questiontitleinput" aria-describedby="emailHelp" placeholder="Enter your question here.." required>
              <small id="emailHelp" class="form-text text-muted">Please use correct keyword for us to properly categorized your question</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1"><span style="color:red;">*</span>Ellaborate Your Question</label>
              <textarea id="question_description" class="form-control" placeholder="enter description" rows="10" required> </textarea>
              <small id="emailHelp" class="form-text text-muted">Explain more details for the community to correctly respond and answer your question</small>
            </div>
            
            <br/>
            <label for="exampleInputPassword1">Tags/Keyword</label>
            <input class="form-control" required type="text" id="tag-input1" placeholder="Enter keywords separated by comma(,)">
            <small id="emailHelp" class="form-text text-muted">Enter keywords separated by comma(,)</small><br/>
            <small id="emailHelp" class="form-text text-muted">This/These tags will be use in helping our community to find your question easily</small>
            <input type="hidden" value ="<?php echo $user_id; ?>" id="current_user">
            <input type="hidden" value ="<?php echo $user_fname_active; ?>" id="current_user_fname">
            <br/>
            <div class="modal-footer">
                <a href="#close"><button  id="save_forum" type="button" class="btn btn-primary">Post to Public</button></a>
            </div>
          </form>

       </div>
   </div>
</body>
</html>

<script src="forum.js"></script>


<script>


$(function() {
  function filter(e) {
    var term = $(e.target).val().toUpperCase();
    if (term.length < 3) {
      $(".cardholderforsearching").show();
      return;
    }
    $(".cardholderforsearching").each(function(i, el) {
      if ($(".questiontitle", el).text().toUpperCase().indexOf(term) >= 0) {
        $(el).show();
      } else {
        $(el).hide();
      }
    });
  }
  $("#search").keyup(filter);
});





        $(document).ready(function(){
            
            jQuery('#menu-icon').on('click', function() {
				jQuery('.navbar').toggleClass('expand');
				return false;
			});

            $("#filter_newest").click(function() {
               $("#question-display-holder").load('https://interlinkiq.com/forum/load_newest_questions.php');
            });

            $("#filter_mostliked").click(function() {
               $("#question-display-holder").load('https://interlinkiq.com/forum/load_mostliked_questions.php');
            });

            
            $("#filter_mostviewed").click(function() {
               $("#question-display-holder").load('https://interlinkiq.com/forum/load_mostviewed_questions.php');
            });

            $("#filter_unanswered").click(function() {
               $("#question-display-holder").load('https://interlinkiq.com/forum/load_unanswered_questions.php');
            });

            $("#filter_none").click(function() {
                location.reload();
            });

        
        });
        
        
        
        $("#askbutton").click(function() {

        $("#save_forum").removeAttr("disabled");
        });
        
                
        $("#save_forum").click(function() {
            
            $("#save_forum").attr("disabled", true);
            var question_title = $('#questiontitleinput').val();
            var question_description = $('#question_description').val();
            var question_tags = $('#tag-input1').val();
            var user_id = $('#current_user').val();
            var status = "for-approval";
            var user_fname = $('#current_user_fname').val();
            
            
            if (user_id !=""){
                

            if( question_title != "" &&  question_description !="" ){

                $.ajax({

                url: "save_question_forum.php",

                type: "POST",

                data: {

                    question_title: question_title,
                    question_description: question_description,
                    user_id: user_id,
                    status: status,
                    question_tags: question_tags,
                    user_fname: user_fname

                    },

                cache: false,

                success: function(dataResult){

                    var dataResult = JSON.parse(dataResult);

                    if(dataResult.statusCode==200){
                        
                                    $('#questiontitleinput').val("");
                                    $('#question_description').val("");
                                    $('#tag-input1').val("");
                                    $("#question-display-holder").prepend('<div class="card question-display-home"><div class="card-header"><span class="like-counter engagement-figure"></span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 0</span><span class="answer-counter engagement-figure"></span><i class="fa fa-commenting-o" aria-hidden="true"></i> 0</span><span class="answer-counter engagement-figure"></span><i class="fa fa-eye" aria-hidden="true"></i> 0</span><span class="answer-counter engagement-figure user-posted"><span class="posted-by-text">Posted By:</span> &nbsp;<i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="postedby-name">'+ user_fname +'</span></span></div><div class="card-body"><h5 class="card-title">'+ question_title +'</h5><p class="card-text">'+ question_description +'</p><a href="#" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a></div></div>');
          

                    }

                    else if(dataResult.statusCode==201){

                            alert("you need to login or register to interlinkiq.com before you can do that action..");
        window.location.href = "https://interlinkiq.com/login";

                    }

                    

                }

                });

            }
            else{
                alert("Please fill in required information..");
            }
            
            }
            else{
        alert("you need to login or register to interlinkiq.com before you can do that action..");
        window.location.href = "https://interlinkiq.com/login";
            }


        });
        
        
        
         $(".user_posted_by_name").click(function() {
        
           var usernameactive =  $(this).attr('id');
           var refinelink =  usernameactive.replace(/ /g,"%");    
            $("#question-display-holder").load('https://interlinkiq.com/forum/profile_dashboard.php?usernameclicked='+ refinelink);
            
            
        });

        
        $(".filterkeyword").click(function() {
            var valtofilter = $(this).attr("id");
            
            var refinelink =  valtofilter.replace(/ /g,"%");
            $("#question-display-holder").load('https://interlinkiq.com/forum/load_selected_question_keyword.php?tagskeyword='+ refinelink);
            
            
        });
        

        

        
        $(".liked_display").click(function() {
            var questionid = $(this).attr("id");
            var currentcount = parseInt($('#likecount_' + questionid).text());
            var newlikecount = currentcount + 1;
            var liked_by = $('#current_user').val();



            
            $.ajax({

            url: "save_like_forum.php",

            type: "POST",

            data: {

                question_id: questionid,
                liked_by: liked_by
                },

            cache: false,

            success: function(dataResult){

                var dataResult = JSON.parse(dataResult);

                if(dataResult.statusCode==200){
                    $('#likecount_' + questionid).text(""+newlikecount+"");
                   $(this).css("pointer-events", "none");

                }

                else if(dataResult.statusCode==201){

                       alert("you need to login or register to interlinkiq.com before you can do that action..");
        window.location.href = "https://interlinkiq.com/login";

                }

                

            }

            });

        });

        $(".view_display").click(function() {
            var questionid = $(this).attr("id");
            var currentcount = parseInt($('#viewcount_' + questionid).text());
            var newcount = currentcount + 1;
            var viewed_by = $('#current_user').val();



            
            $.ajax({

            url: "save_view_forum.php",

            type: "POST",

            data: {

                question_id: questionid,
                viewed_by: viewed_by
                },

            cache: false,

            success: function(dataResult){

                var dataResult = JSON.parse(dataResult);

                if(dataResult.statusCode==200){
                    $('#viewcount_' + questionid).text(""+newcount+"");
                    $(this).css("pointer-events", "none");
                    $("#question-display-holder").load('https://interlinkiq.com/forum/load_selected_question.php?questionid='+ questionid);

                }

                else if(dataResult.statusCode==201){

                        alert("you need to login or register to interlinkiq.com before you can do that action..");
        window.location.href = "https://interlinkiq.com/login";

                }

                

            }

            });

        });

        

        



</script>
