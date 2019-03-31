@extends('layouts.app')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function(){
       
            displayStory();
            authorProfile()
            $('#err_img').hide();
            $('#success_img').hide();

    });

        function displayStory(){

           
            $.ajax({
                type: 'GET',
                dataType : 'json',
                url: '{{ URL::to('getStory') }}',
            }).done(function( msg ) {

                var data = '';

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
                                                    '<div class="form-group">'+
                                                        '<div class="col-md-6">'+
                                                            '<span>'+value.Body+'</span>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="form-group">'+
                                                        '<div class="col-md-12">'+
                                                           '<form method="POST" action="">'+
                                                                '<span id='+value.id+' title="View Author" onclick="viewAuthor(this.id)" style="cursor:pointer;"> By : '+  value.author + '</span>'+
                                                                '<input type="hidden" value='+value.id+' name="authorid" /><br>'+
                                                                '<span>'+  value.date_created + ' | a few seconds ago</span>'+
                                                                '</form>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<hr width="100%">'+
                                                    '<div class="form-group">'+
                                                        '<div class="col-md-12" align="right" style="height:8px;">'+
                                                            '<span style="align:left;">'+visitor_like+'</span>&nbsp;&nbsp;<a href="#"><span id='+value.postId+' onclick="likePost(this.id)">Like</span></a>'+
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
                 _token: '{{csrf_token()}}',
                 post_id:post_id,
                }

                    $.ajax({
                        type: 'POST',
                        dataType : 'json',
                        data:datas,
                        url: '{{URL::to('likeStory')}}',
                    }).done(function( msg ) {
                        
                        var data = jQuery.parseJSON(JSON.stringify(msg));
                         $("#post_section").children().remove();
                         displayStory();
                         
                    }); 
        }
 
       function viewAuthor(authorid){

            var datas = {
                 _token: '{{csrf_token()}}',
                 authorid:authorid,
                }

                    $.ajax({
                        type: 'POST',
                        dataType : 'json',
                        data:datas,
                        url: '{{URL::to('countVisitor')}}',
                    }).done(function( msg ) {

                         var data = jQuery.parseJSON(JSON.stringify(msg));

                         if(data.status == 'success'){

                            var mod_url = "{{ url('/') }}" + `/userProfile` +'/'+ authorid;
                            window.location.href = mod_url;

                         }else{

                            var mod_url = "{{ url('/') }}" + `/userProfile` +'/'+ authorid;
                            window.location.href = mod_url;
                         }
                         

                    }); 

       }

        function closeMsg(){

            $('#err').modal('hide');

        }

        function authorProfile(){

            var author = "{{ Session::get('id')}}";
            var url = '{{ URL::to("getUserProfile", "author") }}';
            var new_url = url.replace('author', author);

                $.ajax({
                    type: 'GET',
                    dataType : 'json',
                    url: new_url,
                }).done(function( msg ) {

                    var data = '';
                    var photo = '';
                    $.each(msg, function(key, value){

                        if(value.photo == null){
                            photo = 'default.jpg';
                        }else{
                            photo = value.photo;
                        }

                        var img = '<img src="/images/'+photo+'" alt="profile pic" title=" Profile Photo"  height="200" width="200" class="img-responsive" />';

                        $('#profile_section').append(img);

                    });

                    
                });
        }


        function  postBlog(){
           
            var datas = {
                 _token: '{{csrf_token()}}',
                 Title:$('#title').val(),
                 Body:$('#body').val(),
                 user:{{ Session::get('id')}},
                 
                }

                    $.ajax({
                        type: 'POST',
                        dataType : 'json',
                        data:datas,
                        url: '{{URL::to('createPost')}}',
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

@section('content')
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#f4f6f9; "><br></div>

                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                                <center><div id="profile_section"></div></center>
                        </div>
                        <div class="form-group">
                            
                            
                        </div>

                        <div class="form-group">
                            
                        </div>
                    </form>
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

@endsection

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