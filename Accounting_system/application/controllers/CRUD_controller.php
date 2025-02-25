<?php  
   class Crud extends CI_Controller  
   {  
      public function savedata()
      {
         /*load registration view form*/
         $this->load->view('insert');
      
         /*Check submit button */
         if($this->input->post('save'))
         {
            $data['name']=$this->input->post('name');
            $data['address']=$this->input->post('address');
            $data['phone']=$this->input->post('phone');
            $response=$this->User_model->saverecords($data);
            if($response==true){
                    echo "Records Saved Successfully";
            }
            else{
                  echo "Insert error !";
            }
         }
      }

    

   }  
?>
