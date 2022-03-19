<?php include('connection.php');
$id = $_POST['Name'];
$sql = "SELECT * FROM companies WHERE Name='$Name' LIMIT 1";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
?>
