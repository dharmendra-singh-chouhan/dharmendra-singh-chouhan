<?php error_reporting(E_ALL);
ini_set('display_errors', true);
include_once '/samba/admin/vendor/autoload.php';
$classes = new MongoDB\Client('mongodb://ubuy:ubuy%40123@192.168.1.63:27017');


$db = $classes->dharmendra;
// $db->createCollection("Ubuy_testing_by_D");
$collection = "Ubuy_testing_by_D";
$resultid = $error = '';

if(isset($_POST['submit'])){

	$data = array();
	$data['Name'] = $_POST['fname'];
	$data['S.Name'] = $_POST['sname'];
    $data['No.'] = $_POST['no'];
	$data['Email'] = $_POST['email'];
    
if ($_FILES) {
    $fileName = $_FILES['fileToUpload']['name'];
    
    
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'],'uploads/'.$fileName);
}
	$data['image'] = $_FILES["fileToUpload"]["name"];
	if(!empty($data['Name'])){
       
		$result = $db->$collection->insertOne($data); 
		$resultid = $result->getInsertedId();
		 header("Location: index.php?id=".$resultid.""); 
	}

}
$display_data = array();
$display_data = $db->$collection->find();
$value = '';

// $allCorp = ['$match'=>['No.'=> ['$gt'=> 100]]];
// $result = $db->$collection->aggregate(
// [
// $allCorp
// ]
// );
// echo "<pre>";
// print_r($result);
// echo "</pre>";
if(isset($_POST['delete'])){

	$db->$collection->deleteMany([]);
    header("Location: index.php");
	
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>
<body>
<!-- CSS only -->

<style>
	.inserted{
		text-align: center;
	}
	#inse-h-s{
		background-color: greenyellow;
		color: black;
		padding: 5px;
		border-radius: 10px;
	}
	#sort{
		width: 48px;
	}
	#filter{
		float: right;
		background: black;
		color: #fff;
		border-radius: 10px;
		padding: 6px;
		width: 72px;
	}

</style>
<div class="container mt-2">
	<div class='inserted'>
        <?php if(!empty($_GET['id'])){
            ?>
            <span id='inse-h-s' >Inserted as Oid <?php echo $_GET['id']; ?></span>
        <?php } ?>    
    </div>
	<form method="post" id="form" enctype="multipart/form-data">
		<div class="mb-3">
			<input class='form-control' type="text" value='' placeholder="First Name" name="fname" />
		</div>
		<div class="mb-3">
			<input class='form-control' type="text" value='' placeholder="Last Name" name="sname" />
		</div>
        <div class="mb-3">
			<input class='form-control' type="number" value='' placeholder="number" name="no" />
		</div>
		<div class="mb-3">
			<input class="form-control" type="email" value="" placeholder="Email" name='email' />
		</div>
		<div class="mb-3">
			<input type="file" name="fileToUpload" id="fileToUpload">
		</div>
		<div class="mb-3">
			<button type="submit"  id="add" class="btn btn-primary" name="submit">Click</button>
			<button class="btn btn-danger" type="submit" name="delete">Delete All</button>
			
		</div>

	
	<table class="table table-dark table-striped">
  	
  	<tr><th>_Id</th><th>First Name</th><th>Last Name</th><th>No.</th><th>Document</th><th>Email</th><th style="text-align:center">Delete</th></tr>
  	
  	<?php 
  	$data_test = false;
  		foreach($display_data as $data){
  			
  			if(!empty($data['_id']) || !empty($data['Name']) || !empty($data['S.Name']) || !empty($data['Email'])){
  				$data_test = true;
  			}
	?>
  	<tr>
  		
  		<td><?php echo $data['_id']; ?></td>
  		<td><?php echo $data['Name']; ?></td>
  		<td><?php echo $data['S.Name']; ?></td>
  		<td><?php echo $data['No.']; ?></td>
  		<td>
            <?php
            if (array_key_exists(1, explode(".", $data['image']))) {
                $fileType = explode(".", $data['image'])[1];

                ?>
            <a href="uploads/<?php echo $data['image']; ?>" target="_blank">
                <img style="width:50px;height: 50px;" src='uploads/<?php echo ($fileType == 'php') ? 'php.png' : $data['image']; ?>' />
            </a>
            <?php }else{
                ?>
                <img style="width: 50px;height: 50px;" src='uploads/no-image.png  ' />
            <?php } ?>
        </td>
  		<td><?php echo $data['Email']; ?></td>
  		<td style="text-align:center"><a  href="delete.php?id=<?php echo $data['_id']; ?>" >&#9940;</a></td>
  	</tr>
	<?php }
	if($data_test !== true){
		
  				echo "<div style='text-align:center;margin: 15px;'><h1><span style='font-size:32px'>&#128517;</span>Data not Found!</h1></div>";
  				
  		
	} ?>
	</table>
	<button type='submit' name='filter' id='filter'>Filter</button>
	</form>

</div>

</body>
<script>
	$(document).ready(function(){
		$('#add').click(function(){
			$('#form').reset();
		})
        setTimeout(()=>{
            $('.inserted').hide();
        }, 3000)
	})
	</script>
</html>
