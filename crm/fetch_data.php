<?php include('connection.php');

$output= array();
$sql = "SELECT * FROM companies ";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'Name',
	1 => '',
	2 => 'email',
	3 => 'mobile',
	4 => 'city',
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE Name like '%".$search_value."%'";
	$sql .= " OR Website like '%".$search_value."%'";
	$sql .= " OR Phone Number like '%".$search_value."%'";
	$sql .= " OR Address '%".$search_value."%'";
	$sql .= " OR City '%".$search_value."%'";
	$sql .= " OR State '%".$search_value."%'";
	$sql .= " OR Country '%".$search_value."%'";
	$sql .= " OR Industry '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY Name desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = $row['Name'];
	$sub_array[] = $row['Website'];
	$sub_array[] = $row['Phone Number'];
	$sub_array[] = $row['City'];
	$sub_array[] = $row['State'];
	$sub_array[] = $row['Country'];
	$sub_array[] = $row['Industry'];
	$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-info btn-sm editbtn" >Edit</a>  <a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-danger btn-sm deleteBtn" >Delete</a>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
