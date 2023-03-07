<?php require 'connection.php';?>
<?php require 'header.php'; ?>

<!-- code for changing password -->
<?php if(isset($_POST['log2']))
   {
        $mod_e=$_POST['passemail'];
        $pass=$_POST['pass'];
        $cpass=$_POST['cpass'];
        if($pass!=$cpass){
            // code for dislaying not matching the two passwords
         session_start();
         $_SESSION['status'] = "passwords not matching";
         $_SESSION['status_code'] = "warning";
         $_SESSION['message'] = "oops..";
         $_SESSION['page'] = "index.php";      
        }
        else{// code for updating the password
         $pass=md5($cpass);
         $sql='UPDATE login_data SET password=:pass WHERE email=:passemail';
         $statement=$connection->prepare($sql);
         if($statement->execute(['pass'=>$pass,'passemail'=>$mod_e]))  
            {// code for dislaying  password changed
                $_SESSION['status'] = "password changed";
                $_SESSION['status_code'] = "success";
                $_SESSION['message'] = "";
                $_SESSION['page'] = "index.php";
            }
            else{// code for dislaying password changing unsuccessfull
                 $_SESSION['status'] = "Unsuccessfull";
                 $_SESSION['status_code'] = "warning";
                 $_SESSION['message'] = "Failed!";
                 $_SESSION['page'] = "index.php";
            }
        }
    }
?>
<!-- code for html structure -->
<div class="container-fluid main ">
    <div class="container">
        <div class="justify-content-center h  align-items-center row">
            <!-- image div -->
            <div class="col-12 col-sm-6 i">
                <img src="images/login.png" class="img-fluid" alt="">
            </div>
            <!-- form div -->
            <div class="col-12 col-sm-6 ">
                <h1 class="text-center mb-4 text-white">Login</h1>
                <form method="Post" action="" class="form">

                 <?php if (isset($_POST['log'])) 
                 {  $email = $_POST['email'];
                    $password = md5($_POST['pass']);
                    // selecting data from database
                    $sql = "SELECT password FROM login_data WHERE email = :email";
                    $statement = $connection->prepare($sql);
                    $statement->execute([':email' => $email]);
                    $user = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($user !== false) {
                            $p = $user['password'];
                            if ($password == $p) {
                                session_start();
                                $_SESSION["user"]=$email;
                                header("Location:dash.php ");
                            }
                            else{
                                echo "<div class='alert alert-danger'>Invalid password</div>";
                            }
                        } else {

                          echo "<div class='alert alert-danger'>Invalid user </div>";
                        }
                    }?>
                    <!-- html for changing password -->
                    <div>
                        <input type="email" required class="form-control my-2" name="email" placeholder="Email">
                    </div>
                    <div>
                        <input type="password" required class="form-control my-2" name="pass" placeholder="Enter your Password">
                    </div>
                    <div>
                        <input type="submit" class="form-control my-2 btn btn-primary" name="log" value="Login">
                    </div>
                    <div>
                        <a href="register.php"><input type="text" class="form-control my-2 btn btn-info text-white" name="create" value="Create New Account"></a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-none text-decoration-underline text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Forgot password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal  -->
<div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <div style="display:flex">
                                    <input type="email" required  placeholder="Enter your email id" class="form-control w-75" id="e" name="passemail">
                                    <p id="test" class="ms-2"></p>  
                                </div>
                                <p class=" py-4 text-primary">Enter your security questions</p>
                                <div>
                                    <h6 id="qstn" class="mt-2"></h6>
                                </div>
                                <div id="answer_div" style="display:flex">
                                    <input type="text" required  placeholder="Answer" class="form-control w-75" id="ans" name="correctanswer">
                                    <p id="anstest" class="ms-2"></p>
                                </div>
                                <div id="pass_div" class="mt-3">
                                     <input type="password" required placeholder="Password" class="form-control " id="" name="pass">
                                     <input type="password" required  placeholder="Confirm Password" class="form-control mt-2" id="" name="cpass">
                                     <input type="submit" value="Submit" name="log2"  class="btn btn-success d-block mt-3 w-100" />         
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
<?php require 'footer.php'; ?>


