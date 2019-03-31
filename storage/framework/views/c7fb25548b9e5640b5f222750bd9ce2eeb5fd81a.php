<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script type="text/javascript">

        function destroySession(){
            $.ajax({
                type: 'GET',
                dataType : 'json',
                url: '<?php echo e(URL::to('removeSession')); ?>',
            });
        }

    </script>
    
</head>
<body>
    <div id="app" >
        <nav class="navbar navbar-default navbar-fixed-top" style="background-color: 18BC9C; ">
            <div class="container" >
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>" style="color: white;">
                        <?php echo e(config('app.name', "Todays Technology")); ?>

                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                      
                            <?php if(Session::has('id')): ?>
                                <li ><a href='<?php echo e(action("PagesController@home")); ?>' style="color: white;">Home</a></li>
                                <li><a href='<?php echo e(action("PagesController@profile")); ?>' style="color: white;">Profile</a></li>
                                <li onclick="destroySession()"><a href="<?php echo e(action("PagesController@login")); ?>" style="color: white;">Logout</a></li>
                            <?php else: ?>
                                <li><a href='<?php echo e(action("PagesController@login")); ?>' style="color: white;">Login</a></li>
                                <li><a href='<?php echo e(action("PagesController@userregistration")); ?>' style="color: white;">Register</a></li>

                            <?php endif; ?>
                      
                    </ul>
                </div>
            </div>
        </nav>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
