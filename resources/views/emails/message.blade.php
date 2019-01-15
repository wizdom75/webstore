<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<div style="width: 600px; padding: 15px; margin: 0 auto;">

    <div style="text-align: center; width: 200px; margin: 0 auto;">
        <img src="{{getenv('APP_URL')}}/images/logos/logo.png" width="80" height="80">
    </div>

    <h2 style="color: orangered;">Hello <?=user()->fullname ?>,</h2>
    <p>Your order confirmation details:
        <span style="color: #0b97c4">
            #<?=$data['order_no']?>
        </span>
    </p>


    <table cellspacing="5" cellpadding="5" border="0" width="600" style="border: 1px solid #0a0a0a;">
        <tr style="background-color: #000000; color: white">

            <th style="text-align: left;">Product name</th>
            <th>Unit price</th>
            <th>Quantity</th>
            <th>Total</th>

        </tr>
        <?php foreach ($data['product'] as $item){ ?>

         <tr>
             <td width="450"><?=$item['name']?></td>
             <td width="100">$<?=$item['price']?></td>
             <td width="50"><?=$item['quantity']?></td>
             <td width="50">$<?=$item['total']?></td>
         </tr>

        <?php } ?>
    </table>


    <h4>Total amount: $<?=$data['total']?></h4>



    <p>Regards<br/><br/>

        Rojo Hammer team</p>

</div>

</body>
</html>