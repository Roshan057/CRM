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

$sql = "INSERT INTO `companies` (`Name`,`Website`,`PhoneNumber`,`Address`,`city`,`State`,`Country`,`Industry`) values ('$Name', '$Website', '$PhoneNumber', '$City' , '$State, '$Country','$Industry')";
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