<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."db/select.php" ?>
<?php require_once ROOT."core/functions.php" ?>
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
$product_data = select("products.*, categories.name AS category_name, users.name AS user_name", "products INNER JOIN categories ON categories.id = products.category_id
INNER JOIN users on users.id = products.user_id", 1);
if(empty($product_data)) {
    redirect(URL."pages/products/addProduct.php");
    die;
}
?>

<div class="content-wrapper">
  <?php if($_SESSION['auth'][1] == 'admin'): ?>
      <h1 class="text-center pt-5">Manage Products</h1>
  <?php endif; ?>
  <div class="container py-5">
      <input type="text" class="form-control mb-3" placeholder="Search For Products" id="search" onkeyup="search()">
      <table class="table text-center" id="products_table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Product Price</th>
                  <th>QTY</th>
                  <th>Image</th>
                  <th>Category Name</th>
                  <?php if($_SESSION['auth'][1] == 'admin'): ?>
                      <th>Username</th>
                      <th>Edit</th>
                      <th>Delete</th>
                  <?php endif; ?>
              </tr>
          </thead>

          <tbody>
              <?php $i=0; foreach($product_data as $product): $i++?>
                  <tr>
                      <td><?=$i?></td>
                      <td><?=$product['name']?></td>
                      <td><?=$product['price']?></td>
                      <td><?=$product['qty']?></td>
                      
                      <td>
                        <?php if(!empty($product['img'])): ?>
                        <?php if(file_exists(ROOT."assets/uploads/products/".$product['img'])):?>
                            <img class="w-25" src="<?=URL."assets/uploads/products/".$product['img']?>">
                        <?php endif;?>
                        <?php else: ?>
                            <img class="w-25 h-25" src="<?=URL."assets/uploads/products/image-not-available.png"?>" class="img-circle elevation-2" alt="User Image">
                        <?php endif; ?>
                      </td>
                      <td><?=$product['category_name']?></td>
                      
                      <?php if($_SESSION['auth'][1] == 'admin'): ?>
                          <td><?=$product['user_name']?></td>
                      <td><a href="<?=URL."pages/products/updateProduct.php?id=".$product['id']?>" class="btn btn-success">Edit</a></td>
                      <td><a href="<?=URL."controllers/products/handleDeleteProduct.php?id=".$product['id']."&img=".$product['img']?>" class="btn btn-danger">Delete</a></td>
                    <?php endif; ?>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
      <div class="d-flex justify-content-center">
        <button class="btn btn-success" onclick="genExcel()">Generate Excel <i class="far fa-file-excel"></i></button>
      </div>
  </div>
</div>

<script>
  function genExcel() {
        var data = document.getElementById('products_table');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: 'xlsx', bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'productsReport.xlsx');
  }
</script>
<script>

function search() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("products_table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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
<?php require_once ROOT."pages/inc/footer.php" ?>
