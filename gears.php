<?php 
session_start();
$_SESSION['from'] = "gears";
require_once "inc/conn.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
	<link rel="stylesheet" type="text/css" href="shop.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function(){
    $("select.category").change(function(){
        var selectedCategory = $(this).children("option:selected").val();
        if (selectedCategory == "gears") {
        	location.replace("gears");
        }
        else if(selectedCategory == "bikes"){
            location.replace("shop");
        }
        else if(selectedCategory == "parts"){
        	location.replace("parts");
        }
        
    });
});
</script>
</head>
<body>
<header class="header">
	<?php require_once "inc/nav.php"; ?>
	<div class="cat">
		<select class="category">
			<option class="option" value="" selected="">Category</option>
			<option class="option" value="bikes">Bikes</option>
			<option class="option" value="gears">Gears</option>
			<option class="option" value="parts">Parts</option>
		</select>
		<a href="makead.php">SellGear</a>
	</div>

	<div class="cont">
    <h1>Motorcycle Gear</h1>
    <?php           
       $list = "SELECT * FROM guploads ORDER BY rand()";
       //create prepared statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {

          echo "SQL STATEMENT FAILED";

       } else {

           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           
            while($row = mysqli_fetch_assoc($result)) {
$gid = $row["gid"];
$sid = $row["sid"];
$cate = $row["cate"];
$type =$row["type"];
$brand = $row["brand"];
$gname = $row["gname"];
$price = $row["price"];
$contact = $row["contact"];
$img1 = $row["leftim"]; 
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];  

   ?>
  
<div class="listings">  
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img4 ).'" height="240px" width="440px">';
?>
</div>

<div class="desc">
 <p><?php echo "Category:\t" .$cate; ?></p><br>
 <p><?php echo "Type:\t" .$type; ?></p><br>
 <p><?php echo "Brand:\t" .$brand; ?></p><br>
 <p><?php echo "Name:\t" .$gname; ?></p><br>
 <p><?php echo "Price:\t" .$price; ?></p><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br>


<?php
/* encrypt url */
$data = $row["gid"];
$encrypt = $data*201820192020007;
$encode = "vgear?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Listing</a>
</div>
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img3 ).'" height="240px" width="440px">';
?>
</div>
</div>

<?php
}
}
?>
</div>
	</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>
