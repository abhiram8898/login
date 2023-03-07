<?php require 'connection.php'; ?>
<?php require 'header.php'; ?>
<?php session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
} else {

    $e = $_SESSION['user'];
    $sql = 'SELECT * FROM login_data WHERE email=:email';
    $statement = $connection->prepare($sql);
    $statement->execute([':email' => $e]);
    $user = $statement->fetch(PDO::FETCH_OBJ);
}?>
<!-- code for html structure -->
<div class="container-fluid main">
    <div class="container row vh-100 align-items-center justify-content-center mx-auto">
        <div class="text-end"> 
       <!-- Button trigger modal -->
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Logout
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content text-center">
         <div class="modal-header border-0">
             <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
      <div class="modal-body">
             <h4>Are you sure  ?</h4>
      </div>
      <div class="modal-footer border-0  ">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <a href="logout.php"> <button type="button"  class="btn btn-danger my-2"> Yes </button></a>
      </div>
    </div>
  </div>
</div>
</div>
        <div class="col-12 col-sm-6">
            <div>
                <img class="img-fluid rounded-5" src="uploads/<?= $user->url ?>">
            </div>
        </div>
        <div class="col-12 col-sm-6 row text-center">
            <div class="row">
                <h1>Welcome</h1>
                <h1><?php echo $user->firstname; ?>&nbsp;<?php echo  $user->lastname; ?></h1>
                <h1><?php echo $user->email; ?></h1>       
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>