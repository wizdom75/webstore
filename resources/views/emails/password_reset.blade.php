<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset your password</title>
</head>
<body>

<div style="width: 600px; padding: 15px; margin: 0 auto;">

    <div style="text-align: center; width: 200px; margin: 0 auto;">
        <img src="{{ getenv('APP_URL') }}/images/logos/logo.png" width="200" height="52">
    </div>

    <h2 style="color: orangered;">Hello <?=$data['name'] ?>,</h2>
    <p>Click the link below to rest your password:
        <span style="color: #0b97c4">
            <?=$data['link']?>
        </span>
    </p>


    <p>Regards<br/><br/>

        Rojo Hammer team</p>

</div>

</body>
</html>