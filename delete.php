<?php 
include_once '/samba/admin/vendor/autoload.php';
$classes = new MongoDB\Client('mongodb://ubuy:ubuy%40123@192.168.1.63:27017');
$db = $classes->dharmendra;
$collection ="Ubuy_testing_by_D";


if($_GET['id']){
	$_id = $_GET['id'];
	$db->$collection->deleteOne(array( '_id' => new MongoDB\BSON\ObjectId ($_id )) );
	header("Location: index.php");
}