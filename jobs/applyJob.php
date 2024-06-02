
<form  method="post" class="form-horizontal" id="modalApplyJobForm">
            <input type="hidden" id="jobid" name="jobid" >
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Application Letter</label>
                    <div class="col-md-8">
                        <textarea class="form-control" rows="3" id="appLetter"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">File input</label>
                    <div class="col-md-8">
                        <input type="file" id="upload">
                    <p class="help-block"> some help text here.PDF File only </p>
                    </div>
                </div>
            </div>
            <!--<div class="form-actions">-->
            <!--    <div class="row">-->
            <!--        <div class="col-md-offset-3 col-md-9">-->
            <!--            <button type="submit" class="btn green" >Submit</button>-->
            <!--            <button type="button" class="btn default" data-dismiss="modal">Cancel</button>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
           <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitJob">Save changes</button>
              </div>
        </form>
        
<script>
    $(document).ready(function(){
        $("#submitJob").click(function(){
            // alert("CLicker");
             var file_data=$('#upload').prop('files')[0];
             var form_data= new FormData();
             var jobId=$('.applyBtn').data("id");
             var jobuserId=$('.applyBtn').data("uid");
             var appLetter=$('#appLetter').val();
                form_data.append('file', file_data);
                form_data.append('appLetter', appLetter);
                form_data.append('jobId', jobId);
                
                form_data.append('jobuserId',jobuserId);
                if(file_data==null||appLetter==null){
                    alert("Please complete all the required data")
                }
                else{
                $.ajax({
                     type: "POST",
                     data: form_data,
                     url: "action.php",
                     dataType: "script",
                     contentType:false,
                     cache:false,
                     processData:false,
                     success: function(data){
                        //  alert(data);
                     }
                 });
                //  alert(jobuserId);
                 
                var data=$(this).serialize()+ "&jobuserid&id="+jobuserId+"&appLetter="+appLetter;
                $.ajax({
                    type: "POST",
                    data: data,
                    url: "action.php",
                    dataType: "json",
                    success: function(data){
                    //  form_data.append('myEmail', data.email);
                    // alert(data);
                    }
                });
                 $('#modalApplyJob').modal('hide');
                 $('#appLetter').val("");
                 
                }
        });
    });
</script>