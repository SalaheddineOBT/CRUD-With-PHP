<?php
    include_once("./../Database/Database.php");
    $db=new Database();
    $con=$db->Connection();

    $err=array(
        'username'=>'',
        'email'=>'',
        'password'=>'',
        'confirm'=>'',
        'success'=>'',
    );

    $username=$email=$password=$confirm="";

    if($_SERVER['REQUEST_METHOD'] == "POST"):

        if(isset($_POST['username']) && isset($_POST['submit']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm'])):

            $username=$_POST['username'];
            $email=trim($_POST['email']);
            $password=trim($_POST['password']);
            $confirm=trim($_POST['confirm']);

            if(empty($username)):
                $err['username']="Username is Required !";

            endif;

            if(empty($email)):
                $err['email']="Email is Required !";

            elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)):
                $err['email']="Email format incorrect !";

            endif;

            if(empty($password)):
                $err['password']="Password is Required !";

            elseif(strlen($password) < 8):
                $err['password']="Password must be at least 8 characters !";
                
            endif;

            if(empty($confirm)):
                $err['confirm']="Confirm password is Required !";

            elseif($confirm != $password):
                $err['confirm']="Confirm Password incorrect !";
                
            endif;

            if(!array_filter($err)):

                $sql="SELECT * FROM users WHERE Email ='$email' LIMIT 1";
                $stmt=$con->prepare($sql);
                $stmt->execute();

                if($stmt->rowCount()!= 1):
                    $sql="INSERT INTO users(UserName,Email,Password) VALUES('$username','$email','".password_hash($confirm,PASSWORD_DEFAULT)."')";

                    $stmt=$con->prepare($sql);

                    if($stmt->execute()):
                        $err['success']="You are successfully registered .";
                        $username=$email=$password=$confirm="";

                    endif;

                else:
                    $err['email']="This Email is already Existe !";
                    
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
    <title>Register Page</title>
    <link rel="stylesheet" href="./../Style/Style.css">
    <style>
        .LoginPage{
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            
            background: #00416A;
            background: -webkit-linear-gradient(to bottom, #E4E5E6, #00416A);
            background: linear-gradient(to bottom, #E4E5E6, #00416A);

        }
        .LoginPage form{
            padding: 1.5rem;
            width: 23rem;
            padding-right: 2rem;
            padding-left: 2rem;
            background:#fff
        }
        .LoginPage a{
            font-size: 1.3rem;
            color:#333;
            margin-top: 1rem;
            font-weight: 600;
        }
        .LoginPage a:hover{
            text-decoration: underline;
        }
        .inputs{
            padding: .4rem;
            outline: none;
            border: none;
            width: 100%;
            border: 1px solid #444;
            font-size: 1.2rem;
            border-radius: .4rem;
        }
    </style>
</head>
<body>
    <div class="LoginPage">
        <form action="Register.php" method="post">
            <h2>CREATE ACCOUNT</h2>
            <br />
            <?php 
                if($err['success'] != ""): ?>
                    <div class="info"><?php echo $err['success']; ?></div>
            <?php
                endif;
            ?>
            <label for="username" class="lbld">Username</label>
            <input type="text" class="inputs" name="username" value="<?php echo $username; ?>" placeholder="Enter Your User Name :" />
            <span class="err">
                <?php
                    echo $err['username'];
                ?>
            </span>
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
            <label for="confirm" class="lbld">Confirm Password</label>
            <input type="password" class="inputs" name="confirm" value="<?php echo $confirm; ?>" placeholder="Confirm Your Password :" />
            <span class="err">
                <?php
                    echo $err['confirm'];
                ?>
            </span>
            <input type="submit" name="submit" value="Register" />
            <a href="Login.php">Already have account ?</a>
            
        </form>
    </div>
</body>
</html>
