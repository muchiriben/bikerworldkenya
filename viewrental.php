<?php
session_start();
require 'inc/conn.php';
$_SESSION['from'] = "viewrental";

$data = $_GET['v'];
/*decrypt url*/
  $data2 = base64_decode(urldecode($data));
  $decrypt = $data2/201820192020007;
  $r_id = $decrypt;

$list = "SELECT * FROM rentals WHERE rid = '$r_id'";
 $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$by_id = $row["by_id"];
$usertype = $row["user_type"];
$make = $row["make"];
$model =$row["model"];
$year = $row["year"];
$eng_size = $row["eng_size"];
$price = $row["price"];
$contact = $row["contact"];
$description = $row["description"];
$img1 = $row["leftim"];
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];
}
 }

if($usertype == 'user') {
    $sidq = "SELECT uname FROM users WHERE sid =? ";
  //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sidq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $by_id);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $name = $row["uname"];
            }
         } 
} elseif ($usertype == 'dealer') {
    $sidq = "SELECT dname FROM dealers WHERE did =? ";
  //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sidq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $by_id);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $name = $row["dname"];
            }
         } 
}

 ?>

<!DOCTYPE html>
<html>
<head>
   <title>Rentals</title>
   <link rel="stylesheet" type="text/css" href="view.css">
   <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <header class="header">
      <?php require_once 'inc/nav.php'; ?>
      <div class="name">
         <h1><?php echo "Post by: " .$name; ?></h1>
      </div>   
<div class="image">
<?php
echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img4 ).'" height="280px" width="380px">
  </div>';
echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img3 ).'" height="280px" width="380px">
  </div><br>';
  echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img2 ).'" height="280px" width="380px">
  </div>';
  echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img1 ).'" height="280px" width="380px">
  </div>';
?>
</div>
<table>
  <thead>
    <tr>
    <th scope="col">CATEGORY</th>
    <th scope="col">DETAILS</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <th scope="row">MAKE</th>
    <td><?php echo $make; ?></td>
  </tr>
  <tr>
    <th scope="row">MODEL</th>
    <td><?php echo $model; ?></td>
  </tr>
  <tr>
    <th scope="row">YEAR</th>
    <td><?php echo $year ;?></td>
    </tr>
  <th scope="row">ENGINE SIZE</th>
    <td><?php echo $eng_size. "cc" ;?></td>
    </tr> 
  <tr>
    <th scope="row">PRICE</th>
    <td><?php echo "Ksh." .$price. "/="; ?></td>
    </tr> 
    <tr>
    <th scope="row">CONTACT</th>
    <td><?php echo $contact;?></td>
    </tr>
    <tr>
      <th></th>
        <td><?php
/* encrypt url */
$data = $by_id;
$encrypt = $data*201820192020007;
if($usertype == 'user') { 
   $encode = "myprofile?v=" .urlencode(base64_encode($encrypt));
} elseif ($usertype == 'dealer') { 
   $encode = "dealer_profile?v=" .urlencode(base64_encode($encrypt)); 
}
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Profile</a></td>
    </tr>   
  </tbody>
  <tfoot>
     <tr>
    <th scope="col" colspan="2">DESCRIPTION</th>
    </tr>
    <tr>
      <td colspan="2"><?php echo $description;?></td>
    </tr>
  </tfoot>
</table>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>