<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADMIN-PANEL - <?php echo $__env->yieldContent('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/all.css">
    <script src="https://use.fontawesome.com/b5e29b55cd.js"></script>
</head>
<body>
<?php echo $__env->make('includes.admin-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="off-canvas-content" data-off-canvas-content>
    <!--  page content-->
    <div class="title-bar">
        <div class="title-bar-left">
            <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
            <span class="title-bar-title"><?php echo e(getenv(APP_Name)); ?></span>
        </div>
    </div>
    <?php echo $__env->yieldContent('content'); ?>
</div>

<script src="public/js/all.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\workscrap-dev\resources\views/admin/layout/base2.blade.php ENDPATH**/ ?>