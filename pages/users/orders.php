<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php require_once ROOT."db/select.php" ?>
<?php 
if(!isset($_SESSION['auth'])) {
  redirect(URL."index.php");
  die;
}

if(isset($_SESSION['auth'][2])) {
  unset($_SESSION['auth'][2]);
  unset($_SESSION['auth'][3]);
}
?>

<?php require_once ROOT."pages/inc/header.php" ?>
<?php require_once ROOT."pages/inc/navbar.php" ?>

<?php 
$order_data = select("orders.*, products.name as pro_name, products.price as pro_price, products.img as img", "orders INNER JOIN products on orders.product_id = products.id", "client_id=".$_SESSION['auth'][3]);
?>


<div class="container py-5">
<input type="text" class="form-control" placeholder="Search For Item" id="search" onkeyup="search()">
    <table class="table text-center" id="client_table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>QTY</th>
                <th>Image</th>
                <th>Remove</th>
            </tr>
        </thead>

        <tbody>
            <?php $i=0; foreach($order_data as $order): $i++?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$order['pro_name']?></td>
                    <td><?=$order['pro_price']?></td>
                    <td><?=$order['qty']?></td>
                    <td><img class="w-25" src="<?=URL."assets/uploads/products/".$order['img']?>"></td>
                    <td><a href="<?=URL."controllers/users/handleDeleteUser.php?id=".$order['id']?>" class="btn btn-danger">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function search() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("client_table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</div>

<?php require_once ROOT."pages/inc/footer.php" ?>