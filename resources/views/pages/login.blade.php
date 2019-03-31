@extends('layouts.app')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">

    var counter = '';

    $(document).ready(function(){
        
        $('#password').keypress(function(e){

            var key = e.which;
             if(key == 13)  // the enter key code
              {
                login();
              }
            
        });

        $('#err_img').hide();
        $('#success_img').hide();
        
    })

    function login(){

        var datas = {
                 _token: '{{csrf_token()}}',
                 Username:$('#uname').val(),
                 Password:$('#password').val(),
                 
                 
                }

                    $.ajax({
                        type: 'POST',
                        dataType : 'json',
                        data:datas,
                        url: '{{URL::to('LoginUser')}}',
                    }).done(function( msg ) {
                       
                        var data = jQuery.parseJSON(JSON.stringify(msg));
                         var data = jQuery.parseJSON(JSON.stringify(msg));
                        if(data.status == 'success'){
                            $('#err_img').hide();
                            $('#success_img').show();
                            $('#sys_msg').html('Success');
                            $("#err_msg").css("color","blue");
                            $('#err_msg').html(data.message);
                            $('#err').modal('show');
                            counter = 1
                            
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

    function closeMsg(){

        if(counter == 1){
            window.location = '{{ action("PagesController@home") }}';
        }
        $('#err').modal('hide');

    }

</script>
@section('content')
<br><br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#f4f6f9; ">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="uname" class="col-md-4 control-label">Username :</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                </div>
                                <div class="col-md-6">
                                    <input id="uname" type="text" class="form-control" name="uname"  required autofocus>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password :</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="button" class="btn btn-primary" onclick="login()">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <sup>Powered By</sup><br>
            <img src="/images/laravel-logo.png" alt=""  height='100' width='180' />
            <img src="/images/bootstrap-logo.png" alt=""  height='100' width='180' />
            <img src="/images/jquery.png" alt=""  height='100' width='180' />
            <img src="/images/sql.png" alt=""  height='100' width='160' /><br><br>
            <center><span>Copyright © Nexbridge <?php echo date("Y"); ?></span></center>
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