<?php
  $page_title = 'Product Cards';
  require_once('includes/load.php');
  // Check user permission level
  page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>

<style>
  .card-img-top {
    object-fit: cover; /* Ensure images cover the entire space of the container */
    height: 200px; /* Set a fixed height for the images */
  }
</style>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <?php foreach ($products as $product): ?>
    <div class="col-md-4">
      <div class="card h-100">
        <img class="card-img-top" src="<?php echo ($product['media_id'] === '0') ? 'uploads/products/no_image.jpg' : 'uploads/products/' . $product['image']; ?>" alt="Product Image">
        <div class="card-body">
          <h5 class="card-title"><?php echo remove_junk($product['name']); ?></h5>
          <p class="card-text">
            <strong>Category:</strong> <?php echo remove_junk($product['categorie']); ?><br>
            <strong>In Stock:</strong> <?php echo remove_junk($product['quantity']); ?><br>
            <strong>Buying Price:</strong> <?php echo remove_junk($product['buy_price']); ?><br>
            <strong>Selling Price:</strong> <?php echo remove_junk($product['sale_price']); ?><br>
            <strong>Product Added:</strong> <?php echo read_date($product['date']); ?>
          </p>
          <div class="btn-group">
            <a href="view_product.php?id=<?php echo (int)$product['id']; ?>" class="btn btn-primary" title="View" data-toggle="tooltip">
              <span class="glyphicon glyphicon-eye-open"></span> View
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include_once('layouts/footer.php'); ?>
