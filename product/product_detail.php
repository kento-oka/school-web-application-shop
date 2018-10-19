<?php
require_once __DIR__ . "/../classes/product.php";
require_once __DIR__ . "/../header.php";

$product    = new Product();
$ident      = $_GET["ident"];
$item       = $product->getItem($ident);
?>
            <h3>商品詳細</h3>
            <hr>
            <form method="POST" action="../cart/cart_add.php">
                <input type="hidden" name="ident" value="<?= $item["ident"] ?>">
                <table>
                    <tr>
                        <th>商品名</th>
                        <td><?= $item["name"] ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="td_center">
                                <img class="detail_img" src="../images/<?= $item["image"] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>メーカー・著者<br>アーティスト</th>
                        <td><?= $item["maker"] ?></td>
                    </tr>
                    <tr>
                        <th>価　格</th>
                        <td>&yen;<?= number_format($item["price"]) ?></td>
                    </tr>
                    <tr>
                        <th>注文数</th>
                        <td>
                            <select name="quantity">
                                <?php for($i = 1; $i <= 10; ++$i): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2"><input type="submit" value="カートに入れる"></th>
                    </tr>
                </table>
            </form>
            <a href="product_select.php?genre=<?= $item["genre"] ?>"><span class="button_image">ジャンル別商品一覧に戻る</span></a>
            <br>
            <br>
<?php require_once __DIR__ . "/../footer.php"; ?>