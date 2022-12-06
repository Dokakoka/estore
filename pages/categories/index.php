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
$category_data = select("*", "categories", 1);
if(empty($category_data)) {
    redirect(URL."pages/categories/addCategory.php");
    die;
}
?>

<div class="content-wrapper">
    <h1 class="text-center py-5">Manage Categories</h1>

    <div class="container">
      <input type="text" class="form-control mb-3" placeholder="Search For Categories" id="search" onkeyup="search()">

        <table class="table text-center" id="categories_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <?php if($_SESSION['auth'][1] == 'admin'): ?>
                        <th>Edit</th>
                        <th>Delete</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody>
                <?php $i=0; foreach($category_data as $category): $i++?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$category['name']?></td>
                        <?php if($_SESSION['auth'][1] == 'admin'): ?>
                            <td><a href="<?=URL."pages/categories/updateCategory.php?id=".$category['id']?>" class="btn btn-success">Edit</a></td>
                            <td><a href="<?=URL."controllers/categories/handleDeleteCategory.php?id=".$category['id']?>" class="btn btn-danger">Delete</a></td>
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
        var data = document.getElementById('categories_table');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: 'xlsx', bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'categoriesReport.xlsx');
  }
</script>

<script>
function search() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("categories_table");
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
