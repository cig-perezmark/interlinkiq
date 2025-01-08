<?php

include "DBController.php";



class ForumFunctions {


    

    function forumdisplay(){

        $db_handle = new DBController();

        $query = "SELECT t1.* 
                ,coalesce((select DISTINCT count(distinct (liked_by)) from questions_like t2 where t1.id= t2.question_id group by question_id),0) as count_like
                ,coalesce((select count(viewed_by) from questions_view t3 where t1.id=t3.question_id),0) as count_view
                ,coalesce((select count(commented_by) from questions_comment t4 where t1.id=t4.question_id),0) as count_comment
                FROM `questions` t1
                WHERE 1=1 AND t1.user_fname !=''  ORDER BY date_posted DESC ";

        $result = $db_handle->runBaseQuery($query);

        return $result;

        
    }

    function forumdisplaynewest(){

        $db_handle = new DBController();

        $query = "SELECT t1.* 
                ,coalesce((select DISTINCT count(distinct (liked_by)) from questions_like t2 where t1.id= t2.question_id group by question_id),0) as count_like
                ,coalesce((select count(viewed_by) from questions_view t3 where t1.id=t3.question_id),0) as count_view
                ,coalesce((select count(commented_by) from questions_comment t4 where t1.id=t4.question_id),0) as count_comment
                FROM `questions` t1
                WHERE 1=1 AND t1.user_fname !='' ORDER BY date_posted DESC";

        $result = $db_handle->runBaseQuery($query);

        return $result;
    }
    
    
    
    function uniquekeyword(){

        $db_handle = new DBController();

        // $query = "SELECT *  FROM `questions` order by question_tags ASC ";
        $query ="SELECT GROUP_CONCAT(distinct(question_tags)) as uniquetags from questions WHERE question_tags !='' ";
        

        $result = $db_handle->runBaseQuery($query);

        return $result;
    }
    
    function forumdisplaymostliked(){

       
        $db_handle = new DBController();

        $query = "SELECT t1.* 
                ,coalesce((select DISTINCT count(distinct (liked_by)) from questions_like t2 where t1.id= t2.question_id group by question_id),0) as count_like
                ,coalesce((select count(viewed_by) from questions_view t3 where t1.id=t3.question_id),0) as count_view
                ,coalesce((select count(commented_by) from questions_comment t4 where t1.id=t4.question_id),0) as count_comment
                    FROM `questions` t1
                    WHERE  1=1 AND t1.user_fname !=''
                    ORDER BY count_like DESC";

        $result = $db_handle->runBaseQuery($query);

        return $result;
    }

    function forumdisplaymostviewed(){

       
        $db_handle = new DBController();

        $query = "SELECT t1.* 
                ,coalesce((select DISTINCT count(distinct (liked_by)) from questions_like t2 where t1.id= t2.question_id group by question_id),0) as count_like
                ,coalesce((select count(viewed_by) from questions_view t3 where t1.id=t3.question_id),0) as count_view
                ,coalesce((select count(commented_by) from questions_comment t4 where t1.id=t4.question_id),0) as count_comment
                FROM `questions` t1
                WHERE 1=1 AND t1.user_fname !='' ORDER BY count_view DESC";

        $result = $db_handle->runBaseQuery($query);

        return $result;
    }
    
    function totalunansweredcount(){
          
        $db_handle = new DBController();

        $query = "SELECT count(t1.id) as total_unanswered 
                from (
                	SELECT t1.* 
                	,coalesce((select DISTINCT count(distinct (liked_by)) from questions_like t2 where t1.id= t2.question_id group by question_id),0) as count_like
                	,coalesce((select count(viewed_by) from questions_view t3 where t1.id=t3.question_id),0) as count_view
                	,coalesce((select count(commented_by) from questions_comment t4 where t1.id=t4.question_id),0) as count_comment
                	FROM `questions` t1
                ) t1
                WHERE 1=1  
                AND t1.count_comment=0 
                AND t1.user_fname !=''
                ORDER BY t1.date_posted ASC";

        $result = $db_handle->runBaseQuery($query);

        return $result;

    }

    function forumdisplayunanswered(){

       
        $db_handle = new DBController();

        $query = "SELECT t1.* 
                    from (
                        SELECT t1.* 
                        ,coalesce((select DISTINCT count(distinct (liked_by)) from questions_like t2 where t1.id= t2.question_id group by question_id),0) as count_like
                         ,coalesce((select count(viewed_by) from questions_view t3 where t1.id=t3.question_id),0) as count_view
                        ,coalesce((select count(commented_by) from questions_comment t4 where t1.id=t4.question_id),0) as count_comment
                        FROM `questions` t1
                    ) t1
                    WHERE 1=1  
                    AND t1.count_comment=0 
                    AND t1.user_fname !=''
                    ORDER BY t1.date_posted ASC";

        $result = $db_handle->runBaseQuery($query);

        return $result;
    }

    function allquestioncount(){

        $db_handle = new DBController();

        $query = "SELECT count(*) as all_count  from questions";

        $result = $db_handle->runBaseQuery($query);

        return $result;

    }


    



    function top5likedquestions(){

        $db_handle = new DBController();

        $query = "SELECT t1.id, t1.question_title, count(distinct (t2.liked_by)) as count_like 
                from questions t1 
                    left join questions_like t2 on t1.id=t2.question_id
                where 1=1
                group by t1.id, t1.question_title
                order by 3 desc
                limit 5";

        $result = $db_handle->runBaseQuery($query);

        return $result;

    }

    function top5commentedquestions(){

        $db_handle = new DBController();

        $query = "SELECT t1.id, t1.question_title, count(t2.commented_by) as count_comments 
                from questions t1 
                    left join questions_comment t2 on t1.id=t2.question_id
                where 1=1
                group by t1.id, t1.question_title
                order by 3 desc
                limit 5";

        $result = $db_handle->runBaseQuery($query);

        return $result;

    }

    function top5viewedquestions(){

        $db_handle = new DBController();

        $query = "SELECT t1.id, t1.question_title, count(t2.viewed_by) as count_viewed 
                from questions t1 
                    left join questions_view t2 on t1.id=t2.question_id
                where 1=1
                group by t1.id, t1.question_title
                order by 3 desc
                limit 5";

        $result = $db_handle->runBaseQuery($query);

        return $result;

    }
    

}

?>