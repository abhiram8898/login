<?php require 'connection.php'; ?>
<?php require 'header.php'; ?>
<!-- code for form -->

<div class="container-fluid main vh-100">
    <div class="container ">
        <div class="justify-content-center  vh-100 align-items-center row">
            <div class="col-12 col-md-6">
                <img src="images/register.png" class="img-fluid" alt="">
            </div>
            <div class="col-12 col-md-6">
                <form method="POST" action="" class="form" enctype="multipart/form-data">
                    <h1 class="text-center text-white mb-4">Register</h1>
                    <!-- code for getting values -->
                    <?php if (isset($_POST['log'])) {
                        $first_name = $_POST['fname'];
                        $last_name = $_POST['lname'];
                        $email = $_POST['email'];
                        $password = md5($_POST['pass']);
                        $password1 = md5($_POST['pass1']);
                        $pic = $_FILES['pic']['name'];
                        $temp = $_FILES['pic']['tmp_name'];
                        $question = ($_POST['ques']);
                        $answer = $_POST['ans'];
                        $errors = array();
                        // validation
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            array_push($errors, "Email is not valid");
                        }
                        if (count($errors) > 0) {
                            foreach ($errors as $error) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        }
                        if ($password != $password1) {
                            session_start();
                            $_SESSION['status'] = "password no matching";
                            $_SESSION['status_code'] = "warning";
                            $_SESSION['message'] = "oops..";
                            $_SESSION['page'] = "register.php";
                        } else {
                            $sql = 'SELECT * FROM login_data WHERE email=:email';
                            $statement = $connection->prepare($sql);
                            $statement->execute([':email' => $email]);
                            $user = $statement->fetch(PDO::FETCH_OBJ);
                            if ($user) {
                                echo "<div class='alert alert-danger'>user already exits</div>";
                            } else {

                                $sql = 'INSERT INTO login_data(url,email,password,firstname,lastname,question,answer)VALUES(:url,:email,:pass,:fname,:lname,:ques,:ans)';
                                $statement = $connection->prepare($sql);

                                if ($statement->execute([':url' => $pic, ':email' => $email, ':fname' => $first_name, ':lname' => $last_name, ':pass' => $password, ':ques' => $question, ':ans' => $answer])) {

                                    $target = "uploads/" . basename($pic);

                                    $move_pic = move_uploaded_file($temp, $target);
                                    $_SESSION['status'] = "Data recorded successfully";
                                    $_SESSION['status_code'] = "success";
                                    $_SESSION['message'] = "";
                                    $_SESSION['page'] = "register.php";                                  
                                }
                            }
                        }
                    } ?>
                    <!-- html form for regristration -->
                   <div>
                        <input type="text" class="form-control my-2" name="fname" placeholder="First Name">
                    </div>
                    <div>
                        <input type="text" class="form-control my-2" name="lname" placeholder="Last Name">
                    </div>
                    <div>
                        <input type="email" required class="form-control my-2" name="email" placeholder="Email">
                    </div>
                    <div>
                        <input type="file" required class="form-control my-2" name="pic" placeholder="Choose file">
                    </div>
                    <div>
                        <input type="password" required class="form-control my-2" name="pass" placeholder="Password">
                    </div>
                    <div>
                        <input type="password" required class="form-control my-2" name="pass1" placeholder="Confirm Password">
                    </div>
                    <div>
                        <select class="form-select" name="ques" aria-label="Default select example">
                            <option selected>Choose one security question</option>
                            <option value="Your nick name">Your nick name</option>
                            <option value="Your pet name">Your pet name</option>
                            <option value="Your favourite 4 digit">Your favourite 4 digit</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" class="form-control my-2" name="ans" placeholder="Your Answer">
                    </div>
                    <div>
                        <input type="submit" class="form-control my-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" name="log" value="Submit">
                    </div>
                    <div>
                        <a href="index.php">
                        <input type="text" class="form-control my-2 btn btn-info text-white" name="create" value="Already had an Account ?"></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>