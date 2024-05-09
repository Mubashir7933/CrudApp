<?php
   $value = false;
   $delete = false;
   $update = false;
   $HOSTNAME = 'localhost';
   $USERNAME = 'root'; 
   $PASSWORD = '';
   $DATABASE = 'notes';
   
   $connection = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
   if(isset($_GET['delete'])){
    $Sno = $_GET['delete'];
$sql = "DELETE FROM `inotes` WHERE `inotes`.`sno` =sno";
$result = mysqli_query($connection,$sql); 

   }
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit']))
    {
        //updating record
        $sno = ($_POST['snoEdit']);
        $title = ($_POST['titleEdit']); 
        $description = ($_POST['descriptionEdit']);
        //sql query that'll be used to update data
          
        $sql = "UPDATE `inotes` SET `title` = '$title' , `description` = '$description' WHERE `inotes`.`sno` = $sno";
        $result = mysqli_query($connection,$sql);  
        if($result){
            $update = true;

        }
        else{
            echo "your note has not been added";
        }   
    }
    else{
        
        $title = ($_POST["title"]);
        $description = ($_POST["description"]);
        
        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO `inotes` (`title`, `description`) VALUES ('$title','$description')";
        
        $result = mysqli_query($connection,$sql);
        
        if ($result) {
            $value = true; // we are making value true so that if it's true we can use it to pop up success bar.
        }
        else{
            echo "your record has not been added successfully";
        }
    }
};
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" >
  

    <link rel="stylesheet" href="dataTables.css">
</head>
<body>
<!-- Button trigger modal  -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
      </div>
      <form action="/crudApp/crud.php" method="post">
      <div class="modal-body">
      <input type="hidden" name="snoEdit" id="snoEdit"><!-- taking note by using id -->
            <h2>Edit your notes</h2>
            <div class="mb-3">
                <label for="title" class="form-label">Notes Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>
           <!-- <button type="submit" class="btn btn-primary">Update</button>-->>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">NotesX!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   
    <?php
if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your record has been updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
?>

<?php
if ($value) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Your record has been added successfully.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
}
?>

<?php
if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Your record has been deleted successfully.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
} 

?>

    <div class="container mt-4">

        <form action="/crudApp/crud.php" method="post">
            
            <h2>Add your notes</h2>
            <div class="mb-3">
                <label for="title" class="form-label">Notes Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container mt-4">
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sno = 0;
                $query = "SELECT * FROM `inotes`";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno++;
                    echo "<tr>
                            <th scope='row'>".$sno."</th>
                            <td>{$row['title']}</td>
                            <td>{$row['description']}</td>
                            <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">edit</button><button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">delete</button></td>
                          </tr>";
                        }
                ?>
                
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="jquery/jquery-3.7.1.min.js"></script>
<script src="dataTables.js"></script>
<script>
         $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
    edits =document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{ //We need to convert it into array because from html class
        //we are getting classes as html collections and we can't perform event listerenrs on all of them
        // without converting it into array so that's why we need to convert it into array first then using
        //for each loop to iterate over every element
        element.addEventListener("click",(e)=>{  
            tr = e.target.parentNode.parentNode;// we are extracting grandParentNode of td which is tr
            //edit class has td parentNode and td has tr parentNode so that's
            //why we are targeting .parentNode.parentNode
            title = tr.getElementsByTagName("td")[0].innerText;
            desccription = tr.getElementsByTagName("td")[1].innerText;
            titleEdit.value =title;
            descriptionEdit.value =desccription;
            snoEdit.value = e.target.id //this is basically button tag
            console.log(e.target.id);
            $('#editModal').modal('toggle')
        })
    })

    deletes =document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{ //We need to convert it into array because from html class
        //we are getting classes as html collections and we can't perform event listerenrs on all of them
        // without converting it into array so that's why we need to convert it into array first then using
        //for each loop to iterate over every element
        element.addEventListener("click",(e)=>{  
            sno = e.target.id.substr(1,);//you are leaving first element of tr which is id so 
            if(confirm("Press to delete")){
                console.log("delete");
               window.location = `/crudApp/crud.php?delete=${sno}`;
            }
            else{

                console.log("no");
            }
            
        })
    })




</script>
   
</body>
</html>
