<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script type="text/javascript">

        $(document).ready(function(){
           
            displayStory();
            authorProfile();
            $('#err_img').hide();
            $('#success_img').hide();

        });

        function displayStory(){

            var user = "<?php echo e(Session::get('id')); ?>";
            var url = '<?php echo e(URL::to("getStoryByUser", "user")); ?>';
            var new_url = url.replace('user', user);

            $.ajax({
                type: 'GET',
                dataType : 'json',
                url: new_url,
            }).done(function( msg ) {
                
                var data = '';
                var info = '';

              $.each(msg, function(key, value){

                  if(value.visitor_like == null){
                        visitor_like = 0;
                    }else{
                          visitor_like = value.visitor_like;
                    }

                  data +=
                                    '<div class="panel panel-default">'+
                                        '<div class="panel-heading">'+value.Title+'</div>'+
                                            '<div class="panel-body">'+
                                                '<form class="form-horizontal">'+
                                                    '<div class="form-group" style="overflow-wrap: break-word;">'+
                                                        '<div class="col-md-12">'+
                                                            '<span>'+value.Body+'</span>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="form-group">'+
                                                        '<div class="col-md-12">'+
                                                           '<form method="POST" action="">'+
                                                                '<span id='+value.id+' onclick="viewAuthor(this.id)" style="cursor:pointer;"> By : '+  value.author + '</span>'+
                                                                '<input type="hidden" value='+value.id+' name="authorid" /><br>'+
                                                                '<span>'+  value.date_created + ' | a few seconds ago</span>'+
                                                                '</form>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<hr width="100%">'+
                                                    '<div class="form-group">'+
                                                        '<div class="col-md-12" align="right" style="height:8px;">'+
                                                            '<span style="align:left;" id="post_counter">'+ visitor_like +'</span>&nbsp;&nbsp;<a href="#"><span id="'+value.id+' " onclick="likePost(this.id)">Like</span></a> | '+
                                                           '<a href="#"><span id='+value.id+' onclick="removePost(this.id)">Delete</span></a> | '+
                                                           '<a href="#"><span id='+value.id+' onclick="editPost(this.id)">Edit</span></a>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</form>'+
                                            '</div>'+
                                    '</div>';

                });

                $('#post_section').append(data);
            }); 

        }

        function likePost(post_id){
            
            var datas = {
                 _token: '<?php echo e(csrf_token()); ?>',
                 post_id:post_id,
                }

                    $.ajax({
                        type: 'POST',
                        dataType : 'json',
                        data:datas,
                        url: '<?php echo e(URL::to('likeStory')); ?>',
                    }).done(function( msg ) {
                        
                         $("#post_section").children().remove();
                         displayStory();

                    }); 

        }


         function removePost(userid){
           
               if(confirm('Are you sure you want to remove this Post') == true){

                var url = '<?php echo e(URL::to("deletePost", "user")); ?>';
                var new_url = url.replace('user', userid);

                    $.ajax({
                        type: 'GET',
                        dataType : 'json',
                        url: new_url,
                    }).done(function( msg ) {
                        var data = jQuery.parseJSON(JSON.stringify(msg));
                        if(data.status == 'success'){
                            $('#err_img').hide();
                            $('#success_img').show();
                            $('#sys_msg').html('Success');
                            $("#err_msg").css("color","blue");
                            $('#err_msg').html(data.message);
                            $('#err').modal('show');
                            $("#post_section").children().remove();
                            displayStory();
                        }else{
                            alert(data.message);
                        }
                    });

            }
        }

        function editPost(post_id){
            
            $('#post_id').val(post_id);
            getUserPost(post_id)
            $('#updatestories').modal('show');

        }

        function getUserPost(post_id){

                var url = '<?php echo e(URL::to("getUserPost", "post_id")); ?>';
                var new_url = url.replace('post_id', post_id);

                $.ajax({
                    type: 'GET',
                    dataType : 'json',
                    url: new_url,
                }).done(function( msg ) {
                    
                  $.each(msg, function(key, value){
                      
                        $('#up_title').val(value.Title);
                        $('#up_body').val(value.Body);

                    });
                 });

        }


        function updateBlog(){

            var datas = {
                 _token: '<?php echo e(csrf_token()); ?>',
                 Postid:$('#post_id').val(),
                 Title:$('#up_title').val(),
                 Body:$('#up_body').val(),
                 
                }

                    $.ajax({
                        type: 'POST',
                        dataType : 'json',
                        data:datas,
                        url: '<?php echo e(URL::to('updatePost')); ?>',
                    }).done(function( msg ) {
                        
                        var data = jQuery.parseJSON(JSON.stringify(msg));
                        if(data.status == 'success'){
                            $('#err_img').hide();
                            $('#success_img').show();
                            $('#sys_msg').html('Success');
                            $("#err_msg").css("color","blue");
                            $('#err_msg').html(data.message);
                            $('#err').modal('show');
                            $('#up_title').val('');
                            $('#up_body').val('');
                            $("#post_section").children().remove();
                            displayStory();
                            $('#updatestories').modal('hide');
                        }else{
                            $('#sys_msg').html('Error');
                            $('#err_img').show();
                            $('#success_img').hide();
                            $("#err_msg").css("color","red");
                            $('#err_msg').html(data.message);
                            $('#err').modal('show');
                        }
                    }); 

        }

        function authorProfile(){

            var author = "<?php echo e(Session::get('id')); ?>";
            var url = '<?php echo e(URL::to("getUserProfile", "author")); ?>';
            var new_url = url.replace('author', author);

            $.ajax({
                type: 'GET',
                dataType : 'json',
                url: new_url,
            }).done(function( msg ) {

                var data = '';
                var img = '';

                $.each(msg, function(key, value){

                    $('#uname').val(value.username);

                    if(value.photo == null){
                        img = 'default.jpg';
                    }else{
                        img = value.photo;
                    }
                    
                    data +=
                                    '<form class="form-horizontal">'+
                                        '<div class="form-group">'+
                                            '<center>'+
                                                '<img src="/images/'+img+'" alt="profile pic" title="View Profile Photo"  height="150" width="150" class="img-responsive img-circle" style="cursor:pointer;" id='+value.photo+' onclick="viewPicture(this.id)" />'+
                                            '</center>'+
                                        '</div>'+
                                        '<div class="form-group"><center>'+
                                            '<table>'+
                                                '<tr>'+
                                                    '<td>Author :</td><td>&nbsp;'+value.fullname+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td>Birthdate :</td><td>&nbsp;'+value.birthdate+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td>Emailaddress :</td><td>&nbsp;'+value.email+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td>Visitor :</td><td>&nbsp;'+value.visitor+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td></td><td><a href="<?php echo e(action("PagesController@editProfileDetails")); ?>"><p>Update Your Profile</p> </a></td>'+
                                                '</tr>'+
                                            '</table>'+
                                        '</center></div>'+
                                    '</form>';

                });

                $('#profile').append(data);
            }); 

        }
        
        function closeMsg(){

            $('#err').modal('hide');

        }

        function viewPicture(image){

            $('#updatePhoto').modal('show');
            var img = '<img src="/images/'+image+'" alt="profile pic" title="View Profile Photo"  height="200" width="200" class="img-responsive" style="cursor:pointer;" id='+image+'/>';

            $('#profile_section').append(img);

        }

        function changePhoto(){

            var  profile = document.getElementById('profilepic').files[0];
            var uname = $('#uname').val()

             var formData = new FormData();
        
            formData.append("user", uname);
            formData.append("pic", profile);
            formData.append("_token", '<?php echo e(csrf_token()); ?>');

            $.ajax({
                    type: 'POST',
                    data:formData,
                    url: '<?php echo e(URL::to('uploadPicture')); ?>',
                    contentType:false,
                    processData:false,
                }).done(function( msg ) {
                    
                    var data = jQuery.parseJSON(JSON.stringify(msg));
                    if(data.status == 'success'){
                        $('#err_img').hide();
                        $('#success_img').show();
                        $('#sys_msg').html('Success');
                        $("#err_msg").css("color","blue");
                        $('#err_msg').html('Profile Picture Successfully changed.');
                        $('#err').modal('show');
                        $("#profile").children().remove();
                        authorProfile();
                        $('#updatePhoto').modal('hide');
                       // counter = 1
                        
                    }else{
                        $('#sys_msg').html('Error');
                        $('#err_img').show();
                        $('#success_img').hide();
                        $("#err_msg").css("color","red");
                        $('#err_msg').html(data.message);
                        $('#err').modal('show');
                    }
                }); 
        }

        function  postBlog(){
           
            var datas = {
                 _token: '<?php echo e(csrf_token()); ?>',
                 Title:$('#title').val(),
                 Body:$('#body').val(),
                 user:<?php echo e(Session::get('id')); ?>,
                 
                }

                    $.ajax({
                            type: 'POST',
                            dataType : 'json',
                            data:datas,
                            url: '<?php echo e(URL::to('createPost')); ?>',
                        }).done(function( msg ) {
                            
                            var data = jQuery.parseJSON(JSON.stringify(msg));
                            if(data.status == 'success'){
                                $('#err_img').hide();
                                $('#success_img').show();
                                $('#sys_msg').html('Success');
                                $("#err_msg").css("color","blue");
                                $('#err_msg').html(data.message);
                                $('#err').modal('show');
                                $('#title').val('');
                                $('#body').val('');
                                $("#post_section").children().remove();
                                displayStory();
                            }else{
                                $('#sys_msg').html('Error');
                                $('#err_img').show();
                                $('#success_img').hide();
                                $("#err_msg").css("color","red");
                                $('#err_msg').html(data.message);
                                $('#err').modal('show');
                            }
                        }); 

        }

</script>

<?php $__env->startSection('content'); ?>
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#f4f6f9; "><center><b>Profile</b></center></div>

                <div class="panel-body" id="profile">
                    <!--profile details here-->
                    <input type="hidden" id="uname">
                </div>
            </div>
        </div>

        <div class="col-md-8 col-md">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#f4f6f9; "><b>What's on your mind. ?</b></div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" placeholder="Title" required autofocus></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea id="body"  class="form-control" placeholder="Share something today!" name="body"  required></textarea>
                                <br>
                                    <div align="right">
                                        <button type="button" class="btn btn-primary" onclick="postBlog()">
                                            Share your story
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--start of post section -->
        <div id="post_section" class="col-md-8 col-md">
            <div class="row"></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<!--update post modal-->
<div class="modal fade" id="updatestories" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color:#f4f6f9; ">What's on your mind. ?</div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="up_title" type="text" class="form-control" name="title" placeholder="Title" required autofocus></input>
                                <input type="hidden" id="post_id"></input>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea id="up_body"  class="form-control" placeholder="Share something today!" name="body"  required></textarea>
                                <br>
                                    <div align="right">
                                        <button type="button" class="btn btn-primary" onclick="updateBlog()">
                                            Update your story
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
      </div>
  </div>
</div>
</div>
<!--end update modal-->
<!--update profile photo-->
<div class="modal fade" id="updatePhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color:#f4f6f9; ">Change Profile Picture</div>

                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-12">
                                <center><div id="profile_section"></div></center>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <center>
                                    <input id="profilepic" type="file" class="form-control" name="profilepic" required><br>
                                    <button type="button" class="btn btn-primary" onclick="changePhoto()">
                                            Upload Profile Photo
                                    </button>
                                 </center>   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
      </div>
  </div>
</div>
</div>
<!--end update profile photo-->
<!--start display message modal-->
<div class="modal fade" id="err" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">
            <img src="/images/cancel.png" id="err_img"></img>
            <img src="/images/Yes.png" id="success_img"></img>&nbsp;<span id="sys_msg"></span>
        </h5>
      </div>
        <div class="modal-body">
            <span id="err_msg"></span>
                <div align="right">
                    <button type="button" class="btn btn-primary" onclick="closeMsg()">Ok</button>
                </div>
        </div>
    </div>
  </div>
</div>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>