<?php 
            session_start();
            include 'database.php';   
            $user_id = $_COOKIE['ID'];
            $firstname = $_COOKIE['first_name'];
            $selectedquestion_id = $_GET['questionid'];
            include_once '../database.php'; 



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

            
            
            $sql ="SELECT t1.* 
            ,coalesce((select DISTINCT count(distinct (liked_by)) from questions_like t2 where t1.id= t2.question_id group by question_id),0) as count_like
            ,coalesce((select count(viewed_by) from questions_view t3 where t1.id=t3.question_id),0) as count_view
            ,coalesce((select count(commented_by) from questions_comment t4 where t1.id=t4.question_id),0) as count_comment
            FROM `questions` t1
            WHERE 1=1 AND t1.id = '$selectedquestion_id' ";
            
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                
                $totalcomment = $row["count_comment"];
                $totallike = $row["count_like"];
                $totalview = $row["count_view"];
                $selectedtitle =  $row["question_title"];
                $selectedcontent=  $row["content"];
                $askedby = $row["asked_by"];
                $user_fname =  $row["user_fname"];
                $keywordtags = $row["question_tags"];
                $arraykeyword = explode(',',$keywordtags);

              }
          ?>
          
          
          <div class="selected_question" style="text-align:left;">
          <h1><?php echo $selectedtitle; ?></h1> 
          <span id="<?php echo $selectedquestion_id;  ?>" class="liked_display"><i class="fa fa-thumbs-up " aria-hidden="true">( <span id="likecount_<?php echo $selectedquestion_id; ?>"><?php echo $totallike; ?></span> likes) </i> </span>
          <i class="fa fa-eye" aria-hidden="true"> (<?php echo $totalview; ?> views) </i>
          <i class="fa fa-commenting-o" aria-hidden="true">(<?php echo $totalcomment ;?> comments) </i>
          &nbsp;&nbsp; Posted By:<i class="fa fa-user-circle" aria-hidden="true"> &nbsp; <?php echo $user_fname; ?></i> <br/>
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
                                

          
          <br/> <br/>
          
                <p style="border-bottom:solid lightgray 1px;padding-bottom:10px;">
                <?php echo $selectedcontent; ?>
                </p>

            <h1><span><?php echo $totalcomment; ?></span> &nbsp;Answers</h1> 

            <div id="entirecommentholder" style="height:auto;">
            <?php 
    
            $sql ="SELECT * FROM `questions_comment` WHERE question_id = '$selectedquestion_id' ";
            
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                
          
            ?>

   
    
            <div class="answer_holder" style="border:solid lightgray 1px; border-radius:5px;padding:10px;box-sizing:border-box;margin-top:10px;">
             <?php echo $row['comment_content'];  ?>
                <div class="comment_postedby" style="text-align:right;">
                            <input type="hidden" id="currentuser" value="1">
                            <span style="border:solid lightgray 1px;border-radius:2px;padding:2px;" > <i style="color:lightgray;" class="fa fa-calendar" aria-hidden="true"><?php echo $row['comment_date'];  ?></i> &nbsp; By:<i class="fa fa-user-circle" aria-hidden="true"> &nbsp; <?php echo $row['user_fname'];  ?></i></span>
                            <input type="hidden" id="current_user" value="<?php echo $user_id ; ?>">
                            <input type="hidden" id="current_userfname" value="<?php echo $firstname ; ?>">
                            
                </div>
            </div>
          
        <?php
              }
          ?>
        </div>

            <div class="comment_box" style="margin-top:20px;">
                <div class="form-outline">
                    <textarea placeholder="Post an answer..." class="form-control" id="commentContent" rows="4"></textarea>
                    <input id="selected_id" type="hidden" value="<?php echo $selectedquestion_id;  ?>" >
                <div style="text-align:right;margin-top:10px;">
                    <button id="post_answer" class="btn btn-primary" type="submit">Post my Answer</button>
                </div>
            </div>
 


            <script>
                 $(document).ready(function(){
                     
                $(".filterkeyword").click(function() {
                    var valtofilter = $(this).attr("id");
                    
                    var refinelink =  valtofilter.replace(/ /g,"%");
                    $("#question-display-holder").load('https://interlinkiq.com/forum/load_selected_question_keyword.php?tagskeyword='+ refinelink);
                    
                    
                });

                $("#post_answer").click(function() {
                    var commentcontent = $('textarea#commentContent').val();
                    var selectedid = $('input#selected_id').val();
                    var currentuser = $('#current_user').val();
                    var userfname = $('#current_userfname').val();


                    $.ajax({

                        url: "save_comment_forum.php",

                        type: "POST",

                        data: {

                            commentcontent: commentcontent,
                            selectedid: selectedid,
                            userfname: userfname,
                            currentuser: currentuser
                            },

                        cache: false,

                        success: function(dataResult){

                            var dataResult = JSON.parse(dataResult);

                            if(dataResult.statusCode==200){
                                // alert("comment is now saved!");
                               $("#entirecommentholder").append('<div class="answer_holder" style="border:solid lightgray 1px; border-radius:5px;padding:10px;box-sizing:border-box;margin-top:10px;">'+ commentcontent +'<div class="comment_postedby" style="text-align:right;"><input type="hidden" id="currentuser" value="1"><span style="border:solid lightgray 1px;border-radius:2px;padding:2px;" >By:<i class="fa fa-user-circle" aria-hidden="true"> &nbsp; '+ userfname +'</i></span></div></div>');
                               $('textarea#commentContent').val("");

                            }

                            else if(dataResult.statusCode==201){

                                    alert("you need to login or register to interlinkiq.com before you can do that action..");
        window.location.href = "https://interlinkiq.com/login";

                            }

                            

                        }

                        });

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



                });
                
            </script>
