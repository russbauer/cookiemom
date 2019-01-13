
<h2>Order Confirmation</h2>
<p>You have completed your cookie order!  The cookies will be available for pickup soon.</p>
<hr/>
<table id="orders" style="border: 1px solid black;">
    <tr style="border: 1px solid black;">
        <th style="border: 1px solid black;">Cookie</th>
        <th style="border: 1px solid black;">Quantity</th>
        <th style="border: 1px solid black;">Digital</th>
    </tr>
    <?php foreach ($orders as $order) :?>
    <tr>
        <td style="border: 1px solid black;padding: 1em;"><?= $order['cookie_name'] ?></td>
        <td style="border: 1px solid black;padding: 1em;"><?= $order['quantity'] ?></td>
        <td style="border: 1px solid black;padding: 1em;"><?= isset($order['digital']) ?  'Yes': '' ?></td>
    </tr>
    <?php endforeach;?>
</table>
<br/>
<p>Order Boxes: <?=$totalCookies?></p>
<p>Order Total: $<?=$totalMoney?></p>
<hr/>
<p>This is your receipt.  Please keep for you records.</p>

<p>-TCM</p>
