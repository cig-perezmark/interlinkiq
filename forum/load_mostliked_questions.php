<?php 
// session_start();
require_once "forum_functions.php";

//Display Forum
$user_id = $_COOKIE['ID'];
$forumFunctions = new ForumFunctions();
$displayforums = $forumFunctions->forumdisplaymostliked();


?>
 <input placeholder="Search" id="search" type="text" />
 <label style="border:solid lightgray 1px;padding:5px;border-radius:2px;"><i class="fa fa-filter" aria-hidden="true"></i> &nbsp; FILTER: <span id="current_filter">MOST LIKED</span>&nbsp; <i style="color:green;" class="fa fa-thumbs-up" aria-hidden="true"></i></label>

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
                              <span class="answer-counter engagement-figure user-posted"><span class="posted-by-text">Posted By:</span> &nbsp;<i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="postedby-name"><?php echo  $user_fname; ?></span></span>
                          </div>
                          <div class="card-body questiontitle">
                          <h5 class="card-title"><?php echo  $questiontitle; ?></h5>
                          <div class="description_holder">
                              <p class="card-text"><?php echo  $question_description; ?></p>
                          </div> <br/>
                          <a id="<?php echo $question_id;  ?>" class="btn btn-primary view_display"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a><br/>
                          
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
                            <input type="hidden" id="current_user" value="<?php echo $user_id ; ?>">
                          </div>
                   </div>
      <?php
            
       }
       ?>

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

    $("#filter_newest").click(function() {
       $("#question-display-holder").load('http://localhost/forum/load_newest_questions.php');
    });

    $("#filter_mostliked").click(function() {
       $("#question-display-holder").load('http://localhost/forum/load_mostliked_questions.php');
    });

    
    $("#filter_mostviewed").click(function() {
       $("#question-display-holder").load('http://localhost/forum/load_mostviewed_questions.php');
    });

    $("#filter_unanswered").click(function() {
       $("#question-display-holder").load('http://localhost/forum/load_unanswered_questions.php');
    });

    $("#filter_none").click(function() {
        location.reload();
    });


    

    




});

 $(".filterkeyword").click(function() {
            var valtofilter = $(this).attr("id");
            
            var refinelink =  valtofilter.replace(/ /g,"%");
            $("#question-display-holder").load('https://interlinkiq.com/forum/load_selected_question_keyword.php?tagskeyword='+ refinelink);
            
            
        });
      
        
$("#save_forum").click(function() {
  
    var question_title = $('#questiontitleinput').val();
    var question_description = $('#question_description').val();
    var question_tags = $('#tag-input1').val();
    var user_id = $('#current_user').val();
    var status = "for-approval";
    

    if( question_title != "" &&  question_description !="" ){

        $.ajax({

        url: "save_question_forum.php",

        type: "POST",

        data: {

            question_title: question_title,
            question_description: question_description,
            user_id: user_id,
            status: status,
            question_tags: question_tags

            },

        cache: false,

        success: function(dataResult){

            var dataResult = JSON.parse(dataResult);

            if(dataResult.statusCode==200){

                $("#question-display-holder").prepend('<div class="card question-display-home"><div class="card-header"><span class="like-counter engagement-figure"></span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 0</span><span class="answer-counter engagement-figure"></span><i class="fa fa-commenting-o" aria-hidden="true"></i> 0</span><span class="answer-counter engagement-figure"></span><i class="fa fa-eye" aria-hidden="true"></i> 0</span><span class="answer-counter engagement-figure user-posted"><span class="posted-by-text">Posted By:</span> &nbsp;<i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="postedby-name">'+ user_id +'</span></span></div><div class="card-body"><h5 class="card-title">'+ question_title +'</h5><p class="card-text">'+ question_description +'</p><a href="#" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</a></div></div>');


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

  