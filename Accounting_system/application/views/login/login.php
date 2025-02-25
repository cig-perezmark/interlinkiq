<!DOCTYPE html>  
 <html>  
 <head>  
      <title>HR+Payroll System</title>  
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />  
 </head>  
 <body>  
     


      <div class="container" style="margin-top:200px">
          <div class="row">
               <div class="col-md-3"></div>
               <div class="col-md-6" style="border:solid 1px #eeeeee;height:600px">
                    <div class="loader-logo" style="display: flex;justify-content: center;margin-top:40px"><img src="<?php echo base_url(); ?>css/vendors/images/Logo.png" alt=""></div>
                    <form method="post" action="<?php echo site_url('Login/login_validation'); ?>" style="margin-top:40px">  
                <div class="form-group">  
                     <label>Enter Username</label>  
                     <input type="text" name="username" class="form-control" />  
                     <span class="text-danger"><?php echo form_error('username'); ?></span>                 
                </div>  
                <div class="form-group">  
                     <label>Enter Password</label>  
                     <input type="password" name="password" class="form-control" />  
                     <span class="text-danger"><?php echo form_error('password'); ?></span>  
                </div>  
                <div class="form-group">  
                     <input type="submit" name="insert" value="Login" class="btn btn-info" />  
                     <?php  
                          echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  
                     ?>  
                </div>  
           </form> 
               </div>
               <div class="col-md-3"></div>
          </div>
      </div>
 </body>  
 </html>
