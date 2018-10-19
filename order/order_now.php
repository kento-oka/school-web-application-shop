<?php
  // Cartオブジェクトを生成する
  require_once __DIR__ . '/../classes/cart.php';
  $cart = new Cart();

  // カート内の全ての商品を取り出す
  $cartItems = $cart->getItems();

  // Orderオブジェクトを生成する
  require_once __DIR__ . '/../classes/order.php';
  $order = new Order();

  // カート内の全ての商品を注文内容として登録する
  // 注文テーブルordersと注文詳細テーブルorderdetailsに注文内容を登録する
  $orderId = $order->addOrder($cartItems);
?>
<!DOCTYPE  html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お買い上げ</title>
<link rel="stylesheet" href="../css/minishop.css">
</head>
<body>
<h3>注文</h3>
○○組　□□□番　神戸電子<br>
<hr>
<p>お買い上げありがとうございました。<br>
またのご利用をお待ちしております。</p>
<table>
<tr><th>&nbsp;</th><th>商品名</th><th>メーカー・著者<br>アーティスト</th><th>価格</th><th>注文数</th><th>金額</th></tr>
<?php
  $total = 0;
  foreach($cartItems as $item){
    $total += $item['price'] * $item['quantity'];
?>
    <tr>
    <td class="td_mini_img"><img class="mini_img" src="../images/<?= $item['image'] ?>"></td>
    <td class="td_item_name"><?= $item['name'] ?></td>
    <td class="td_item_maker"><?= $item['maker'] ?></td>
    <td class="td_right">&yen;<?= number_format($item['price']) ?></td>
    <td class="td_right"><?= $item['quantity'] ?></td>
    <td class="td_right">&yen;<?= number_format($item['price'] * $item['quantity']) ?></td>
    </tr>
<?php
  }
?>
<tr><th colspan="5">合計金額</th>
<td class="td_right">&yen;<?= number_format($total) ?></td>
</tr>
</table>
<br>
<a href="../index.php">ジャンル選択に戻る</a>&nbsp;&nbsp;<a href="order_history.php">注文履歴</a>
<?php
  // カート内の全ての商品を削除する
  $cart->clearCart();
?>
</body>
</html>
