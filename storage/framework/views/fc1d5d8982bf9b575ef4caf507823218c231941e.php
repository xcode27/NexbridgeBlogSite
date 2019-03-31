<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
           
            authorProfile();

        });

        function authorProfile(){

            var author = "<?php echo e($user_id); ?>";
            var url = '<?php echo e(URL::to("getUserProfile", "author")); ?>';
            var new_url = url.replace('author', author);

            $.ajax({
                type: 'GET',
                dataType : 'json',
                url: new_url,
            }).done(function( msg ) {

                var data = '';

                $.each(msg, function(key, value){
               
                  data +=
                                    '<form class="form-horizontal">'+
                                        '<div class="form-group">'+
                                            '<center>'+
                                                '<img src="/images/'+value.photo+'" alt=""  height="150" width="150" class="img-responsive img-circle" />'+
                                            '</center>'+
                                        '</div>'+
                                        '<div class="form-group">'+
                                            '<table>'+
                                                '<tr>'+
                                                    '<td>Author :</td><td>'+value.fullname+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td>Birthdate :</td><td>'+value.birthdate+'</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<td>Visitor :</td><td>'+value.visitor+'</td>'+
                                                '</tr>'+
                                            '</table>'+
                                        '</div>'+
                                    '</form>';
                });

                $('#profile').append(data);
            }); 

        }


        function postBlog(){
           
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
                            alert(data.message);
                            $("#post_section").children().remove();
                            displayStory();
                        }else{
                            alert(data.message);
                        }
                    }); 

        }



</script>
<?php $__env->startSection('content'); ?>
<br><br><br>
<div class="container">
    <center>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#f4f6f9; "></div>
                    <div class="panel-body" id="profile"></div>
                </div>

            </div>
        </div>
    </center>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>