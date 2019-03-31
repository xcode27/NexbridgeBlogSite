@extends('layouts.app')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">

    var counter = ''
    $(document).ready(function(){

         $('#err_img').hide();
         $('#success_img').hide();

    });

    function registerUser(){
        
        var datas = {
                 _token: '{{csrf_token()}}',
                 Userid:'{{ Session::get('id')}}',
                 Fullname:$('#fname').val(),
                 Birthdate:$('#bdate').val(),
                }

                    $.ajax({
                        type: 'POST',
                        dataType : 'json',
                        data:datas,
                        url: '{{URL::to('updateUser')}}',
                    }).done(function( msg ) {
                         

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

            window.location = '{{ action("PagesController@profile") }}';

        }

        $('#err').modal('hide');

    }

</script>
@section('content')<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" id="signup">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#f4f6f9; ">Edit Details</div>

                <div class="panel-body">
                    <form class="form-horizontal">
                    	<div class="form-group">
                            <label for="fname" class="col-md-4 control-label">Fullname</label>

                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control" name="fname"  required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bdate" class="col-md-4 control-label">Birthdate</label>

                            <div class="col-md-6">
                                <input id="bdate" type="date" class="form-control" name="bdate"  required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-primary" onclick="registerUser()">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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