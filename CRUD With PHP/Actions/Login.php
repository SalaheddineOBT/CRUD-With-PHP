<?php
    include_once('./../Database/Database.php');

    $db=new Database();
    $con=$db->Connection();

    $err=array(
        'email'=>'',
        'password'=>'',
        'error'=>''
    );
    
    $email=$password="";

    if($_SERVER["REQUEST_METHOD"] == "POST"):

        if(isset($_POST['submit']) && isset($_POST['email']) && isset($_POST['password'])):

            $email=$_POST['email'];
            $password=$_POST['password'];

            if(empty($email)):
                $err["email"]="Email is required !";

            elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)):
                $err["email"]="Email in incorrect format !";

            endif;

            if(empty($password)):
                $err["password"]="Password is required !";

            elseif(strlen($password) < 8):
                $err["password"]="Password must be at least 8 characters !";

            endif;

            if(!array_filter($err)):

                $sql="SELECT * FROM users WHERE Email='$email'";
                $stmt=$con->prepare($sql);
                $stmt->execute();

                if($stmt->rowCount()):
                    $row=$stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $check=password_verify($password,$row["Password"]);
                    if($check):

                        $_SESSION['username']=$row['UserName'];

                        header('location:Home.php');
                    
                    else:
                        $err['error']="Incorect Password !";

                    endif;

                else:
                    $err['error']="Incorect Email !";

                endif;
            
            endif;

        endif;

    endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./../Style/Style.css">
</head>
<body>
    <div class="LoginPage">
        <form action="Login.php" method="post">
            <h1>LOGIN NOW</h1>
            <br />
            <?php 
                if($err['error'] != ""): ?>
                    <div class="error"><?php echo $err['error']; ?></div>
            <?php
                endif;
            ?>
            <label for="email" class="lbld">Email</label>
            <input type="email" class="inputs" name="email" value="<?php echo $email; ?>" placeholder="Enter Your Email :" />
            <span class="err">
                <?php
                    echo $err['email'];
                ?>
            </span>
            <label for="password" class="lbld">Password</label>
            <input type="password" class="inputs" name="password" value="<?php echo $password; ?>" placeholder="Enter Your Password :" />
            <span class="err">
                <?php
                    echo $err['password'];
                ?>
            </span>
            <input type="submit" name="submit" value="Login" /><br>
            <a href="Register.php">Don't have account ?</a>
        </form>
    </div>
</body>
</html>