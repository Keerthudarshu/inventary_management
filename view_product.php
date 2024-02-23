<?php
$page_title = 'View Product';
require_once('includes/load.php');
// Remove the permission check if you want all users to view the product
// page_require_level(2);
?>
<?php
$product = find_by_id('products', (int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if (!$product) {
    $session->msg("d", "Missing product id.");
    redirect('product.php');
}
?>

<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
       $p_buy   = remove_junk($db->escape($_POST['buying-price']));
       $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}',media_id='{$media_id}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row ">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>PRODUCT NAME : <?php echo remove_junk($product['name']); ?></span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-th-large"></i>
                            </span>
                            <p class="form-control" name="product-title"><?php echo remove_junk($product['name']); ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if ($product['media_id']): ?>
                                    <?php
                                    $selectedPhoto = find_by_id('media', (int)$product['media_id']);
                                    if ($selectedPhoto) {
                                        $imagePath = "uploads/products/" . $selectedPhoto['file_name'];
                                        if (file_exists($imagePath)) {
                                    ?>
                                            <img src="<?php echo $imagePath; ?>" alt="Product Image" class="img-thumbnail">
                                        <?php } else { ?>
                                            <p>Error: Image file not found</p>
                                        <?php }
                                    } else { ?>
                                        <p>Error: Media record not found</p>
                                    <?php } ?>
                                <?php else: ?>
                                    <p>No image selected</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Rest of the form fields... -->
                    <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                    <option value=""> Select a categorie</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> style="border-radius: 5px;  border: 1px solid #ff0000;">
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  </div>
              </div>
              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <P class="form-control" name="product-quantity" style="border-radius: 5px;  border: 1px solid #ff0000;"><?php echo remove_junk($product['quantity']); ?></P>
                   </div>
                  </div>
                 </div>
                  </div>
                 </div>
                 
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Buying price</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <P class="form-control" name="buying-price" style="border-radius: 5px;  border: 1px solid #ff0000;" ><?php echo remove_junk($product['buy_price']);?></P>
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Selling price</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <P class="form-control" name="saleing-price" style="border-radius: 5px;  border: 1px solid #ff0000;" ><?php echo remove_junk($product['sale_price']);?></P>
                       <span class="input-group-addon d-flex justify-content-center highlight-span" >.00</span>
                    </div>
                   </div>
                  </div>
               </div>
              </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>


