<?php 
include('connection.php');
$Name = $_POST['Name'];
$Website = $_POST['Website'];
$PhoneNumber = $_POST['PhoneNumber'];
$Address = $_POST['Address'];
$City = $_POST['City'];
$State = $_POST['State'];
$Country = $_POST['Country'];
$Industry = $_POST['Industry'];


$sql = "UPDATE `Companies` SET  `Website`='$Website' , `PhoneNumber`= '$PhoneNumber', `Address`='$Address',  `City`='$City' , `State`='$State', `Country`='$Country' , `Industry`='$Industry'WHERE Name='$Name' ";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
      
    );

    echo json_encode($data);
} 

?>