<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<div style="width: 600px; padding: 15px; margin: 0 auto; background-color: #2B81AF; color: white">

    <div style="text-align: center; width: 200px; margin: 0 auto;">
        <img src="{{ getenv('APP_URL') }}/images/logos/logo.png" width="200" height="52">
    </div>

    <h2 style="color: orangered;">Hello <?=$data['name'] ?>,</h2>
   <p>
       <?php echo $data?>
   </p>

    <p>Regards<br/><br/>

        Rojo Hammer team</p>

</div>

</body>
</html>