<body>
    <table border = "2px">
	<tr>
	<th>Id</th>
	<th>Name</th>
	<th>Password</th>
	<th>Delete</th>
	<th>Edit</th>
	 </tr>
	 
	 
	 
  
</body>

<?php
   include "connection.php";
   // include "insert.php";

  if(isset($_GET['did'])){
	 $gid = $_GET['did'];
	 
    $sql = "DELETE FROM users WHERE id=$gid";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}
   
 }
   
$squli = "select *from users";
$result = $conn->query($squli);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
$mid = $row ["id"];
  
  ?>

<tr>
   <td><?php echo $row["id"] ?></td><br>
   <td><?php echo $row["name"] ?></td><br>
   <td><?php echo $row["password"] ?></td><br>
  <td><a href="select.php?did=<?php echo $row['id']; ?>" class="del_btn">Delete</a></td>
  <td><a href="insert.php?eid=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a></td> 
   
   
   </tr><br>
   
<?php
     // echo "id: " . $row["id"]. "  " . $row["name"]. " " . $row["password"]. "<br>";
  }
} else {
  echo "0 results";
}
  
  

?>

</table>

