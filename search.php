
   <?php require 'connection.php'; ?>
 
   <?php
   
        $input=$_POST['email'];
        $sql='SELECT * FROM login_data WHERE (email=:email2)';
        $statement=$connection->prepare($sql);
        $statement->execute([':email2'=>$input]);
        $result=$statement->fetch(PDO::FETCH_OBJ);

        if($statement->rowCount()!=0){
            echo json_encode($result);
           
        }
        else{
            echo 0;
        }
    
?>