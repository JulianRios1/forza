<?php
//Database connection by using PHP PDO
include('conexion.php');

extract($_POST);
//$accion = 'Select';
//if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
if(isset($action))
{
 //For Load All Data
 if($action == "Load") 
 {
  $statement = $mysqli->query("SELECT * FROM usuarios ORDER BY id DESC");  
  $num_reg = mysqli_num_rows($statement);
  $row = mysqli_fetch_array($statement) ; 


  ////$statement->execute();
  //$result = $statement->fetchAll();
  $output = '';
  $output .= '
   <table class="table table-bordered">
    <tr>
     <th width="40%">First Name</th>
     <th width="40%">Last Name</th>
     <th width="10%">Update</th>
     <th width="10%">Delete</th>
    </tr>
  ';
  if($num_reg > 0)
  {
   while ($row = mysqli_fetch_array($statement)) 
   {
    $output .= '
    <tr>
     <td>'.$row["nom"].'</td>
     <td>'.$row["ape1"].'</td>
     <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button></td>
     <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td align="center">Data not Found</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }



 //This code for Create new Records
 if($action == "Create")
 {
  $statement = $connection->prepare("
   INSERT INTO customers (first_name, last_name) 
   VALUES (:first_name, :last_name)
  ");
  $result = $statement->execute(
   array(
    ':first_name' => $_POST["firstName"],
    ':last_name' => $_POST["lastName"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Inserted';
  }
 }

 //This Code is for fetch single customer data for display on Modal
 if($action == "Select")
 {
  $output = array();
  /*$statement = $connection->prepare(
   "SELECT * FROM customers 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
  );
  $statement->execute();*/

  $resultado = $mysqli->query("SELECT * FROM usuarios WHERE id = 1");    
  $row = mysqli_fetch_array($resultado) ; 

  //$result = $mysqli->fetchAll();
  foreach($row as $rows)
  {
   $output["nom"] = $row["nom"];
   $output["ape1"] = $row["ape1"];
  }
  echo json_encode($output);
 }



 if($action == "Update")
 {
  $statement = $connection->prepare(
   "UPDATE customers 
   SET first_name = :first_name, last_name = :last_name 
   WHERE id = :id
   "
  );
  $result = $statement->execute(
   array(
    ':first_name' => $_POST["firstName"],
    ':last_name' => $_POST["lastName"],
    ':id'   => $_POST["id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Updated';
  }
 }




 if($action == "Delete")
 {
  $statement = $connection->prepare(
   "DELETE FROM customers WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Deleted';
  }
 }

}
else{
  echo 'no hay nada';
}
?>