<?php
require_once("../../../gallery-files/includes/initialize.php");
if(!$session->is_logged_in()) {redirect_to("login.php");}
get_template("admin-header.php");
?>
<h2>Photographs</h2>
<?php echo output_message($message); ?>
<div class="row">

<?php $photos = new PhotoGraph();
$allPhotos =& $photos->findAllAdmin();
foreach($allPhotos as $photo): ?>
   <div class="col-md-4">
      <p><?php echo $photo->filename.", ".$photo->caption; ?></p>
		<img src="<?php echo $photo->imagePath("../"); ?>" style="width:150px;height:150px">
		<p>Size: <?php echo $photo->photo_size(); ?></p>
		<a href="delete-photo.php?id=<?php echo $photo->id; ?>"> Delete Photo</a>
   </div>
<?php endforeach; ?>
</div>
<br>
<p style="text-align:center;"><a href="photo-upload.php" class="thumbnail"> Upload new photo</a></p>
<?php get_template("footer.php"); ?>
