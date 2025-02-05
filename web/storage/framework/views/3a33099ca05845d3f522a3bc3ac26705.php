<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inici | uEscapes</title>
    <link rel="icon" href="<?php echo e(asset('img/urbana.ico')); ?>" type="image/x-icon">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/main.scss']); ?>
</head>

<body>

    <div id="header" class="m-auto"></div>
    <div id="hero" class="m-auto"></div>
    <div id="searchbar" class="m-auto"></div>
    <div id="valorscorporatius" class="m-auto"></div>
    <div id="ofertas" class="m-auto"></div>
    <div id="noticies" class="m-auto"></div>
    <div id="footer" class="m-auto"></div>
    
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
</body>

</html>
<?php /**PATH /home/jon-perea/Documentos/grup6-hotel/web/resources/views/landing.blade.php ENDPATH**/ ?>