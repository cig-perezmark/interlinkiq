
<?php 

$refinename = str_replace('%',' ',$_GET['usernameclicked']);

?>

<div class="card question-display-home cardholderforsearching" style="width:100%;text-align:center;border:none;">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
        <div class="card">
            <div class="text">
                <img src="https://www.shareicon.net/data/128x128/2016/06/01/577219_user_128x128.png" alt="">
                <h3><?php echo $refinename; ?></h3>
                <!--<p>Student | Coder</p>-->
                <!--<p>-->
                <!--    Lorem ipsum dolor sit amet, consectetur adipiscing -->
                <!--    elit, sed do eiusmod tempor incididunt ut labore -->
                <!--    et dolore magna aliqua. Ut enim ad minim veniam, -->
                <!--    quis nostrud exercitation ullamco laboris nisi ut.-->
                <!--</p>-->
   
            <!--<div class="links">-->
            <!--    <a target="_blank" href="https://codepen.io/l-e-e/"><i class="fab fa-codepen"></i></a>-->
            <!--    <a target="_blank" href="https://github.com/Leena26"><i class="fab fa-github"></i></a>-->
            <!--    <a target="_blank" href="https://www.youtube.com/channel/UCPOyUi82bRcPTdpDuSHVNbw"><i class="fab fa-youtube"></i></a>-->
            <!--</div>-->
</div>
    
             
</div>



<style>
    /* https://www.youtube.com/watch?v=NuYMMNK4wzA */
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400&display=swap');


.card {
    box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
    padding: 30px;
    align-items: center;
    width: 500px;
}



.card .text img{
    height: 170px;
    border-radius: 50%;
    margin-bottom:10px;
}

.card .text h3{
    font-size: 40px;
    font-weight: 400;
}

.card .text p:nth-of-type(1){
    color: rgb(35, 182, 219);
    font-size: 15px;
    margin-top: -5px;
}

.card .text p:nth-of-type(2){
    margin: 10px;
    width: 90%;
    text-align: center;
}

.card .links{
    width: 30%;
    justify-content: space-evenly;
}

.card .links i{
    color: rgb(35, 182, 219);
    font-size: 20px;
    cursor: pointer;
}

.card .links i:hover{
    color:rgb(29, 157, 189) ;
}


</style>
