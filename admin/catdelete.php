<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/category.php';
?>

<?php
// CHECK LOGIN ADMIN
$cat = new category();

if (isset($_GET['catId']) && $_GET['catId'] != NULL) {
    $id = $_GET['catId'];
    $deleteCat = $cat->delete_category($id);
}
?>
