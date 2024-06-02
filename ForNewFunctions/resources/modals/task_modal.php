   <div class="modal fade" id="collaborator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                   <h4 class="modal-title">Warning!</h4>
               </div>
               <div class="modal-body">
                   <div class="ShareModalInvitePage">
                       <div class="ShareModalMembersPage-inviteSection">
                           <h5 class="Typography Typography--colorDefault Typography--h5 Typography--fontWeightMedium">Invite with email</h5>
                           <div class="row">
                               <div class="col-md-10">
                                   <input type="text" class="form-control" placeholder="Add members by name or email...">
                               </div>
                               <div class="col-md-2">
                                   <button class="btn btn-primary">Invite</button>
                               </div>
                           </div>
                       </div>
                       <hr>
                       <div class="row">
                           <div class="col-md-8 offset-md-2 ShareModalContent-footer">
                               <button class="btn btn-secondary">Cancel</button>
                               <button class="btn btn-primary" disabled>Next</button>
                           </div>
                       </div>
                   </div>
               </div>

           </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
   <!-- end of collaborator -->
   <div class="modal fade" id="modalAddActionItem" tabindex="-1" role="basic" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <form method="post" id="actionItem" class="form-horizontal modalForm modalAddActionItem">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h4 class="modal-title">New Action Item</h4>
                   </div>
                   <div class="modal-body" id="newparent"></div>
                   <div class="modal-footer">
                       <input type="button" class="btn dark btn-outline" data-dismiss="modal" value="Close" />
                       <button type="submit" class="btn green ladda-button" name="btnSave_History" id="btnSave_History" data-style="zoom-out"><span class="ladda-label">Submit</span></button>
                   </div>
               </form>
           </div>
       </div>
   </div>
   <!-- add new parent -->
   <div class="modal right fade bs-modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
       <div class="modal-dialog" role="document">
           <div class="modal-content">

               <div class="modal-dialog">
                   <div class="modal-content scroller" style="height:100%;padding:20px;" data-always-visible="1" data-rail-visible="0">
                       <div class="modal-header">
                           <p class="todo-task-modal-title todo-inline">
                               <a class="todo-inline todo-task-assign btn-circle"><i class="fa fa-check-circle-o"></i>&nbsp;Mark Complete</a>

                           </p>
                           <a class="todo-inline todo-task-assign btn-circle pull-right" data-dismiss="modal">
                               <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                   <path d="M5.35008 14.6667L4.16675 13.4833L9.65008 7.99999L4.16675 2.51666L5.35008 1.33333L12.0167 7.99999L5.35008 14.6667Z" fill="#C6BFBF" />
                               </svg>
                           </a>
                       </div>
                       <div class="modal-body todo-task-modal-body">
                           <h3 class="todo-task-modal-bg">Task Title Here...</h3>
                           <div class="todo-task-modal-bg">
                               <div class="row align-items-center">
                                   <div class="col-auto" style="padding-top: 10px;">
                                       <span>Assignee:</span>&nbsp;
                                       <span class="photo">
                                           <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt="" width="20px" height="20px">
                                       </span>
                                       <span>Brandon Jake Sullano</span>
                                   </div>
                                   <div class="col-auto" style="padding-top: 10px;">
                                       <span>Due Date:</span>
                                       <span>&nbsp;<i style="font-size:20px" class="fa fa-calendar"></i></span>
                                       <span>2023-05-25</span>
                                   </div>
                                   <div class="col-auto" style="padding-top: 10px;">
                                       <span>Status:</span>
                                       <span>Not-Started</span>
                                   </div>
                                   <div class="col-auto" style="padding-top: 10px;">
                                       <span>Account:</span>
                                       <span>ConsultareInc <i class="fa fa-caret-down"></i></span>
                                   </div>
                               </div>
                           </div>
                           <hr>
                           <h4>Task Description:</h4>
                           <p class="todo-task-modal-bg">
                               Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur alias quas iste consequuntur repudiandae omnis nisi vitae earum eaque animi minus enim delectus, sunt nemo dicta illo, deleniti quis natus.
                           </p>
                           <hr>
                           <div class="btn-group">
                               <button type="button" class="btn btn-circle btn-outline gray dropdown-toggle" data-toggle="dropdown">
                                   <i class="fa fa-plus"></i>&nbsp;
                                   <span class="hidden-sm hidden-xs"><i></i>Sub Tasks&nbsp;</span>
                               </button>
                           </div>
                           <div class="mt-actions">
                               <div class="scroller" style="height:225px;" data-always-visible="1" data-rail-visible1="1">
                                   <div class="mt-action">
                                       <div class="mt-action-body">
                                           <div class="mt-action-row">
                                               <div class="mt-action-info ">
                                                   <div class="mt-action-img">
                                                       <i class="fa fa-check-square-o"></i>
                                                   </div>
                                                   <div class="mt-action-details ">
                                                       <span class="mt-action-author">Sub tasks number one lorem ipsum sample text</span>
                                                   </div>
                                               </div>
                                               <div class="mt-action-datetime">
                                                   <span class="photo">
                                                       <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt="" width="23px" height="25px">
                                                   </span>
                                                   <span class="mt-action-dot bg-green"></span>
                                                   <span class="mt=action-time"><i class="fa fa-calendar"></i>&nbsp;9:30-13:00</span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <hr>
                                   <div class="mt-action">
                                       <div class="mt-action-body">
                                           <div class="mt-action-row">
                                               <div class="mt-action-info ">
                                                   <div class="mt-action-img">
                                                       <i class="fa fa-check-square-o"></i>
                                                   </div>
                                                   <div class="mt-action-details ">
                                                       <span class="mt-action-author">Sub tasks number one lorem ipsum sample text</span>
                                                   </div>
                                               </div>
                                               <div class="mt-action-datetime">
                                                   <span class="photo">
                                                       <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt="" width="23px" height="25px">
                                                   </span>
                                                   <span class="mt-action-dot bg-green"></span>
                                                   <span class="mt=action-time"><i class="fa fa-calendar"></i>&nbsp;9:30-13:00</span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <hr>
                                   <div class="mt-action">
                                       <div class="mt-action-body">
                                           <div class="mt-action-row">
                                               <div class="mt-action-info ">
                                                   <div class="mt-action-img">
                                                       <i class="fa fa-check-square-o"></i>
                                                   </div>
                                                   <div class="mt-action-details ">
                                                       <span class="mt-action-author">Sub tasks number one lorem ipsum sample text</span>
                                                   </div>
                                               </div>
                                               <div class="mt-action-datetime">
                                                   <span class="photo">
                                                       <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt="" width="23px" height="25px">
                                                   </span>
                                                   <span class="mt-action-dot bg-green"></span>
                                                   <span class="mt=action-time"><i class="fa fa-calendar"></i>&nbsp;9:30-13:00</span>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="btn-group">
                                   <button type="button" class="btn btn-circle btn-outline gray">
                                       <i class="fa fa-plus"></i>&nbsp;
                                       <span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
                                   </button>
                               </div>
                               <div class="mt-actions">
                                   <div class="scroller" style="height:225px;" data-always-visible="1" data-rail-visible1="1">
                                       <div class="mt-action">
                                           <div class="mt-action-body">
                                               <div class="mt-action-row">
                                                   <div class="mt-action-info ">
                                                       <div class="mt-action-img">
                                                           <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                               <path d="M19.581 15.35L8.51196 13.4V27.809C8.51209 27.9655 8.54306 28.1205 8.60308 28.2651C8.66311 28.4096 8.75102 28.541 8.8618 28.6516C8.97258 28.7622 9.10406 28.8499 9.24873 28.9096C9.3934 28.9694 9.54843 29.0001 9.70496 29H28.805C28.9617 29.0004 29.1169 28.9699 29.2618 28.9102C29.4067 28.8506 29.5384 28.7629 29.6494 28.6523C29.7604 28.5417 29.8485 28.4102 29.9087 28.2655C29.9688 28.1208 29.9998 27.9657 30 27.809V22.5L19.581 15.35Z" fill="#185C37" />
                                                               <path d="M19.581 3H9.70496C9.54843 2.99987 9.3934 3.03057 9.24873 3.09035C9.10406 3.15014 8.97258 3.23783 8.8618 3.34842C8.75102 3.45902 8.66311 3.59035 8.60308 3.73492C8.54306 3.87949 8.51209 4.03446 8.51196 4.191V9.5L19.581 16L25.442 17.95L30 16V9.5L19.581 3Z" fill="#21A366" />
                                                               <path d="M8.51196 9.5H19.581V16H8.51196V9.5Z" fill="#107C41" />
                                                               <path opacity="0.1" d="M16.434 8.20001H8.51196V24.45H16.434C16.7496 24.4484 17.052 24.3226 17.2755 24.0996C17.4989 23.8767 17.6256 23.5747 17.628 23.259V9.39101C17.6256 9.07535 17.4989 8.77333 17.2755 8.5504C17.052 8.32747 16.7496 8.20158 16.434 8.20001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.783 8.85001H8.51196V25.1H15.783C16.0986 25.0984 16.401 24.9725 16.6245 24.7496C16.8479 24.5267 16.9746 24.2247 16.977 23.909V10.041C16.9746 9.72534 16.8479 9.42333 16.6245 9.2004C16.401 8.97747 16.0986 8.85158 15.783 8.85001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.783 8.85001H8.51196V23.8H15.783C16.0986 23.7984 16.401 23.6725 16.6245 23.4496C16.8479 23.2267 16.9746 22.9247 16.977 22.609V10.041C16.9746 9.72534 16.8479 9.42333 16.6245 9.2004C16.401 8.97747 16.0986 8.85158 15.783 8.85001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.132 8.85001H8.51196V23.8H15.132C15.4476 23.7984 15.75 23.6725 15.9735 23.4496C16.1969 23.2267 16.3236 22.9247 16.326 22.609V10.041C16.3236 9.72534 16.1969 9.42333 15.9735 9.2004C15.75 8.97747 15.4476 8.85158 15.132 8.85001Z" fill="black" />
                                                               <path d="M3.194 8.85001H15.132C15.4482 8.84974 15.7516 8.97504 15.9755 9.19837C16.1994 9.4217 16.3255 9.72478 16.326 10.041V21.959C16.3255 22.2752 16.1994 22.5783 15.9755 22.8016C15.7516 23.025 15.4482 23.1503 15.132 23.15H3.194C3.03738 23.1503 2.88224 23.1197 2.73746 23.0599C2.59267 23.0002 2.46108 22.9125 2.35019 22.8019C2.2393 22.6913 2.1513 22.56 2.09121 22.4153C2.03113 22.2707 2.00013 22.1156 2 21.959V10.041C2.00013 9.88439 2.03113 9.72933 2.09121 9.58469C2.1513 9.44006 2.2393 9.30868 2.35019 9.19808C2.46108 9.08747 2.59267 8.9998 2.73746 8.94007C2.88224 8.88035 3.03738 8.84974 3.194 8.85001Z" fill="url(#paint0_linear_1_404)" />
                                                               <path d="M5.69995 19.873L8.21095 15.989L5.91095 12.127H7.75795L9.01295 14.6C9.12895 14.834 9.21295 15.008 9.25095 15.124H9.26795C9.34995 14.936 9.43695 14.755 9.52795 14.578L10.87 12.131H12.57L10.211 15.971L12.63 19.876H10.821L9.37095 17.165C9.30363 17.0485 9.24642 16.9263 9.19995 16.8H9.17595C9.13367 16.9231 9.0773 17.0409 9.00795 17.151L7.51495 19.873H5.69995Z" fill="white" />
                                                               <path d="M28.8061 3H19.5811V9.5H30.0001V4.191C29.9999 4.03438 29.9689 3.87932 29.9088 3.73469C29.8488 3.59005 29.7608 3.45868 29.6499 3.34807C29.539 3.23746 29.4074 3.14979 29.2626 3.09007C29.1178 3.03034 28.9627 2.99974 28.8061 3Z" fill="#33C481" />
                                                               <path d="M19.5811 16H30.0001V22.5H19.5811V16Z" fill="#107C41" />
                                                               <defs>
                                                                   <linearGradient id="paint0_linear_1_404" x1="4.494" y1="7.91401" x2="13.832" y2="24.086" gradientUnits="userSpaceOnUse">
                                                                       <stop stop-color="#18884F" />
                                                                       <stop offset="0.5" stop-color="#117E43" />
                                                                       <stop offset="1" stop-color="#0B6631" />
                                                                   </linearGradient>
                                                               </defs>
                                                           </svg>
                                                       </div>
                                                       <div class="mt-action-details ">
                                                           <span class="mt-action-author">Document name here sample display...</span>
                                                       </div>
                                                   </div>
                                                   <div class="mt-action-datetime">
                                                       <span class="photo">
                                                           <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt="" width="23px" height="25px">
                                                       </span>
                                                       <div class="btn-group">
                                                           <button type="button" class="btn btn-circle btn-outline gray">
                                                               <i class="fa fa-download"></i>&nbsp;
                                                               <span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
                                                           </button>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <hr>
                                       <div class="mt-action">
                                           <div class="mt-action-body">
                                               <div class="mt-action-row">
                                                   <div class="mt-action-info ">
                                                       <div class="mt-action-img">
                                                           <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                               <path d="M19.581 15.35L8.51196 13.4V27.809C8.51209 27.9655 8.54306 28.1205 8.60308 28.2651C8.66311 28.4096 8.75102 28.541 8.8618 28.6516C8.97258 28.7622 9.10406 28.8499 9.24873 28.9096C9.3934 28.9694 9.54843 29.0001 9.70496 29H28.805C28.9617 29.0004 29.1169 28.9699 29.2618 28.9102C29.4067 28.8506 29.5384 28.7629 29.6494 28.6523C29.7604 28.5417 29.8485 28.4102 29.9087 28.2655C29.9688 28.1208 29.9998 27.9657 30 27.809V22.5L19.581 15.35Z" fill="#185C37" />
                                                               <path d="M19.581 3H9.70496C9.54843 2.99987 9.3934 3.03057 9.24873 3.09035C9.10406 3.15014 8.97258 3.23783 8.8618 3.34842C8.75102 3.45902 8.66311 3.59035 8.60308 3.73492C8.54306 3.87949 8.51209 4.03446 8.51196 4.191V9.5L19.581 16L25.442 17.95L30 16V9.5L19.581 3Z" fill="#21A366" />
                                                               <path d="M8.51196 9.5H19.581V16H8.51196V9.5Z" fill="#107C41" />
                                                               <path opacity="0.1" d="M16.434 8.20001H8.51196V24.45H16.434C16.7496 24.4484 17.052 24.3226 17.2755 24.0996C17.4989 23.8767 17.6256 23.5747 17.628 23.259V9.39101C17.6256 9.07535 17.4989 8.77333 17.2755 8.5504C17.052 8.32747 16.7496 8.20158 16.434 8.20001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.783 8.85001H8.51196V25.1H15.783C16.0986 25.0984 16.401 24.9725 16.6245 24.7496C16.8479 24.5267 16.9746 24.2247 16.977 23.909V10.041C16.9746 9.72534 16.8479 9.42333 16.6245 9.2004C16.401 8.97747 16.0986 8.85158 15.783 8.85001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.783 8.85001H8.51196V23.8H15.783C16.0986 23.7984 16.401 23.6725 16.6245 23.4496C16.8479 23.2267 16.9746 22.9247 16.977 22.609V10.041C16.9746 9.72534 16.8479 9.42333 16.6245 9.2004C16.401 8.97747 16.0986 8.85158 15.783 8.85001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.132 8.85001H8.51196V23.8H15.132C15.4476 23.7984 15.75 23.6725 15.9735 23.4496C16.1969 23.2267 16.3236 22.9247 16.326 22.609V10.041C16.3236 9.72534 16.1969 9.42333 15.9735 9.2004C15.75 8.97747 15.4476 8.85158 15.132 8.85001Z" fill="black" />
                                                               <path d="M3.194 8.85001H15.132C15.4482 8.84974 15.7516 8.97504 15.9755 9.19837C16.1994 9.4217 16.3255 9.72478 16.326 10.041V21.959C16.3255 22.2752 16.1994 22.5783 15.9755 22.8016C15.7516 23.025 15.4482 23.1503 15.132 23.15H3.194C3.03738 23.1503 2.88224 23.1197 2.73746 23.0599C2.59267 23.0002 2.46108 22.9125 2.35019 22.8019C2.2393 22.6913 2.1513 22.56 2.09121 22.4153C2.03113 22.2707 2.00013 22.1156 2 21.959V10.041C2.00013 9.88439 2.03113 9.72933 2.09121 9.58469C2.1513 9.44006 2.2393 9.30868 2.35019 9.19808C2.46108 9.08747 2.59267 8.9998 2.73746 8.94007C2.88224 8.88035 3.03738 8.84974 3.194 8.85001Z" fill="url(#paint0_linear_1_404)" />
                                                               <path d="M5.69995 19.873L8.21095 15.989L5.91095 12.127H7.75795L9.01295 14.6C9.12895 14.834 9.21295 15.008 9.25095 15.124H9.26795C9.34995 14.936 9.43695 14.755 9.52795 14.578L10.87 12.131H12.57L10.211 15.971L12.63 19.876H10.821L9.37095 17.165C9.30363 17.0485 9.24642 16.9263 9.19995 16.8H9.17595C9.13367 16.9231 9.0773 17.0409 9.00795 17.151L7.51495 19.873H5.69995Z" fill="white" />
                                                               <path d="M28.8061 3H19.5811V9.5H30.0001V4.191C29.9999 4.03438 29.9689 3.87932 29.9088 3.73469C29.8488 3.59005 29.7608 3.45868 29.6499 3.34807C29.539 3.23746 29.4074 3.14979 29.2626 3.09007C29.1178 3.03034 28.9627 2.99974 28.8061 3Z" fill="#33C481" />
                                                               <path d="M19.5811 16H30.0001V22.5H19.5811V16Z" fill="#107C41" />
                                                               <defs>
                                                                   <linearGradient id="paint0_linear_1_404" x1="4.494" y1="7.91401" x2="13.832" y2="24.086" gradientUnits="userSpaceOnUse">
                                                                       <stop stop-color="#18884F" />
                                                                       <stop offset="0.5" stop-color="#117E43" />
                                                                       <stop offset="1" stop-color="#0B6631" />
                                                                   </linearGradient>
                                                               </defs>
                                                           </svg>
                                                       </div>
                                                       <div class="mt-action-details ">
                                                           <span class="mt-action-author">Document name here sample display...</span>
                                                       </div>
                                                   </div>
                                                   <div class="mt-action-datetime">
                                                       <span class="photo">
                                                           <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt="" width="23px" height="25px">
                                                       </span>
                                                       <div class="btn-group">
                                                           <button type="button" class="btn btn-circle btn-outline gray">
                                                               <i class="fa fa-download"></i>&nbsp;
                                                               <span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
                                                           </button>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <hr>
                                       <div class="mt-action">
                                           <div class="mt-action-body">
                                               <div class="mt-action-row">
                                                   <div class="mt-action-info ">
                                                       <div class="mt-action-img">
                                                           <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                               <path d="M19.581 15.35L8.51196 13.4V27.809C8.51209 27.9655 8.54306 28.1205 8.60308 28.2651C8.66311 28.4096 8.75102 28.541 8.8618 28.6516C8.97258 28.7622 9.10406 28.8499 9.24873 28.9096C9.3934 28.9694 9.54843 29.0001 9.70496 29H28.805C28.9617 29.0004 29.1169 28.9699 29.2618 28.9102C29.4067 28.8506 29.5384 28.7629 29.6494 28.6523C29.7604 28.5417 29.8485 28.4102 29.9087 28.2655C29.9688 28.1208 29.9998 27.9657 30 27.809V22.5L19.581 15.35Z" fill="#185C37" />
                                                               <path d="M19.581 3H9.70496C9.54843 2.99987 9.3934 3.03057 9.24873 3.09035C9.10406 3.15014 8.97258 3.23783 8.8618 3.34842C8.75102 3.45902 8.66311 3.59035 8.60308 3.73492C8.54306 3.87949 8.51209 4.03446 8.51196 4.191V9.5L19.581 16L25.442 17.95L30 16V9.5L19.581 3Z" fill="#21A366" />
                                                               <path d="M8.51196 9.5H19.581V16H8.51196V9.5Z" fill="#107C41" />
                                                               <path opacity="0.1" d="M16.434 8.20001H8.51196V24.45H16.434C16.7496 24.4484 17.052 24.3226 17.2755 24.0996C17.4989 23.8767 17.6256 23.5747 17.628 23.259V9.39101C17.6256 9.07535 17.4989 8.77333 17.2755 8.5504C17.052 8.32747 16.7496 8.20158 16.434 8.20001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.783 8.85001H8.51196V25.1H15.783C16.0986 25.0984 16.401 24.9725 16.6245 24.7496C16.8479 24.5267 16.9746 24.2247 16.977 23.909V10.041C16.9746 9.72534 16.8479 9.42333 16.6245 9.2004C16.401 8.97747 16.0986 8.85158 15.783 8.85001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.783 8.85001H8.51196V23.8H15.783C16.0986 23.7984 16.401 23.6725 16.6245 23.4496C16.8479 23.2267 16.9746 22.9247 16.977 22.609V10.041C16.9746 9.72534 16.8479 9.42333 16.6245 9.2004C16.401 8.97747 16.0986 8.85158 15.783 8.85001Z" fill="black" />
                                                               <path opacity="0.2" d="M15.132 8.85001H8.51196V23.8H15.132C15.4476 23.7984 15.75 23.6725 15.9735 23.4496C16.1969 23.2267 16.3236 22.9247 16.326 22.609V10.041C16.3236 9.72534 16.1969 9.42333 15.9735 9.2004C15.75 8.97747 15.4476 8.85158 15.132 8.85001Z" fill="black" />
                                                               <path d="M3.194 8.85001H15.132C15.4482 8.84974 15.7516 8.97504 15.9755 9.19837C16.1994 9.4217 16.3255 9.72478 16.326 10.041V21.959C16.3255 22.2752 16.1994 22.5783 15.9755 22.8016C15.7516 23.025 15.4482 23.1503 15.132 23.15H3.194C3.03738 23.1503 2.88224 23.1197 2.73746 23.0599C2.59267 23.0002 2.46108 22.9125 2.35019 22.8019C2.2393 22.6913 2.1513 22.56 2.09121 22.4153C2.03113 22.2707 2.00013 22.1156 2 21.959V10.041C2.00013 9.88439 2.03113 9.72933 2.09121 9.58469C2.1513 9.44006 2.2393 9.30868 2.35019 9.19808C2.46108 9.08747 2.59267 8.9998 2.73746 8.94007C2.88224 8.88035 3.03738 8.84974 3.194 8.85001Z" fill="url(#paint0_linear_1_404)" />
                                                               <path d="M5.69995 19.873L8.21095 15.989L5.91095 12.127H7.75795L9.01295 14.6C9.12895 14.834 9.21295 15.008 9.25095 15.124H9.26795C9.34995 14.936 9.43695 14.755 9.52795 14.578L10.87 12.131H12.57L10.211 15.971L12.63 19.876H10.821L9.37095 17.165C9.30363 17.0485 9.24642 16.9263 9.19995 16.8H9.17595C9.13367 16.9231 9.0773 17.0409 9.00795 17.151L7.51495 19.873H5.69995Z" fill="white" />
                                                               <path d="M28.8061 3H19.5811V9.5H30.0001V4.191C29.9999 4.03438 29.9689 3.87932 29.9088 3.73469C29.8488 3.59005 29.7608 3.45868 29.6499 3.34807C29.539 3.23746 29.4074 3.14979 29.2626 3.09007C29.1178 3.03034 28.9627 2.99974 28.8061 3Z" fill="#33C481" />
                                                               <path d="M19.5811 16H30.0001V22.5H19.5811V16Z" fill="#107C41" />
                                                               <defs>
                                                                   <linearGradient id="paint0_linear_1_404" x1="4.494" y1="7.91401" x2="13.832" y2="24.086" gradientUnits="userSpaceOnUse">
                                                                       <stop stop-color="#18884F" />
                                                                       <stop offset="0.5" stop-color="#117E43" />
                                                                       <stop offset="1" stop-color="#0B6631" />
                                                                   </linearGradient>
                                                               </defs>
                                                           </svg>
                                                       </div>
                                                       <div class="mt-action-details ">
                                                           <span class="mt-action-author">Document name here sample display...</span>
                                                       </div>
                                                   </div>
                                                   <div class="mt-action-datetime">
                                                       <span class="photo">
                                                           <img src="assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt="" width="23px" height="25px">
                                                       </span>
                                                       <div class="btn-group">
                                                           <button type="button" class="btn btn-circle btn-outline gray">
                                                               <i class="fa fa-download"></i>&nbsp;
                                                               <span class="hidden-sm hidden-xs"><i></i>Documents&nbsp;</span>
                                                           </button>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <!-- BEGIN PORTLET-->
                           <div class="portlet light ">
                               <div class="portlet-title">
                                   <div class="caption">
                                       <i class="icon-bubble font-hide hide"></i>
                                       <span class="caption-subject font-hide bold uppercase">Comments</span>
                                   </div>
                                   <div class="actions">
                                       <div class="portlet-input input-inline">
                                           <div class="input-icon right">
                                               <i class="icon-magnifier"></i>
                                               <input type="text" class="form-control input-circle" placeholder="search...">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="portlet-body" id="chats">
                                   <div class="scroller" style="height: 225px;" data-always-visible="1" data-rail-visible1="1">
                                       <ul class="chats">
                                           <li class="in">
                                               <img class="avatar" alt="" src="assets/layouts/layout/img/avatar1.jpg" />
                                               <div class="message">
                                                   <span class="arrow"> </span>
                                                   <a href="javascript:;" class="name"> Bob Nilson </a>
                                                   <span class="datetime"> at 20:30 </span>
                                                   <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                               </div>
                                           </li>
                                           <li class="in">
                                               <img class="avatar" alt="" src="assets/layouts/layout/img/avatar1.jpg" />
                                               <div class="message">
                                                   <span class="arrow"> </span>
                                                   <a href="javascript:;" class="name"> Bob Nilson </a>
                                                   <span class="datetime"> at 20:30 </span>
                                                   <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                               </div>
                                           </li>
                                           <li class="in">
                                               <img class="avatar" alt="" src="assets/layouts/layout/img/avatar3.jpg" />
                                               <div class="message">
                                                   <span class="arrow"> </span>
                                                   <a href="javascript:;" class="name"> Richard Doe </a>
                                                   <span class="datetime"> at 20:35 </span>
                                                   <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                               </div>
                                           </li>
                                       </ul>
                                   </div>
                                   <div class="chat-form">
                                       <div class="input-cont">
                                           <input class="form-control" type="text" placeholder="Type a message here..." />
                                       </div>
                                       <div class="btn-cont">
                                           <span class="arrow"> </span>
                                           <a href="" class="btn blue icn-only">
                                               <i class="fa fa-check icon-white"></i>
                                           </a>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <!-- END PORTLET-->
                           <div class="modal-footer">
                               <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
                               <!-- <button class="btn green" data-dismiss="modal">Submit</button> -->
                           </div>
                       </div>
                   </div>
               </div>
               <div id="todo-members-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel10" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                               <h4 class="modal-title">Select a Member</h4>
                           </div>
                           <div class="modal-body">
                               <form action="#" class="form-horizontal" role="form">
                                   <div class="form-group">
                                       <label class="control-label col-md-4">Selected Members</label>
                                       <div class="col-md-8">
                                           <select id="select2_sample2" class="form-control select2 select-height" multiple>
                                               <optgroup label="Senior Developers">
                                                   <option>Rudy</option>
                                                   <option>Shane</option>
                                                   <option>Sean</option>
                                               </optgroup>
                                               <optgroup label="Technical Team">
                                                   <option>Kathy</option>
                                                   <option>Luke</option>
                                                   <option>John</option>
                                                   <option>Darren</option>
                                               </optgroup>
                                               <optgroup label="Design Team">
                                                   <option>Bob</option>
                                                   <option>Carolina</option>
                                                   <option>Randy</option>
                                                   <option>Michael</option>
                                               </optgroup>
                                               <optgroup label="Testers">
                                                   <option>Chris</option>
                                                   <option>Louis</option>
                                                   <option>Greg</option>
                                                   <option>Ashe</option>
                                               </optgroup>
                                           </select>
                                       </div>
                                   </div>
                               </form>
                           </div>
                           <div class="modal-footer">
                               <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
                               <button class="btn green" data-dismiss="modal">Submit</button>
                           </div>
                       </div>
                   </div>
               </div>

           </div><!-- modal-content -->
       </div><!-- modal-dialog -->
   </div><!-- modal -->