<?php
    include_once('./../Database/Database.php');
    $db=new Database();
    $con=$db->Connection();
    $err=array(
        "username"=>'',
        "email"=>'',
        "password"=>'',
        "confirm"=>'',
        'err'=>'',
        'success'=>''
    );
    $username=$email=$password=$confirm='';

    if($_SERVER['REQUEST_METHOD'] == "POST"):
        
        if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm'])):
           
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $confirm=$_POST['confirm'];

            if(empty($username)):
                $err["username"]="User Name is Required !"; 
            endif;
    
            if(empty($email)):
                $err["email"]="Email is Required !"; 
            elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)):
                $err["email"]="Email Format is Incorrect !"; 
            endif;
    
            if(empty($password)):
                $err["password"]='Password is Required !';
            elseif(strlen($password) < 8):
                $err["password"]='Password must be at least 8 characters !';
            endif;
    
            if(empty($confirm)):
                $err["confirm"]='Confirm Password is Required !';
            elseif($password!=$confirm):
                $err["confirm"]='Confirm Password is Incorrect !';
            endif;

            $sql='SELECT * FROM users WHERE Email="'.$email.'"';
            $stmt=$con->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()):
                $err["email"]="Email already exists !"; 
            endif;

            if(!array_filter($err)):
                $sql='insert into users(UserName,Email,Password) values("'.$username.'","'.$email.'","'.password_hash($confirm,PASSWORD_DEFAULT).'")';
                $stmt=$con->prepare($sql);
                if($stmt->execute()):
                    //header('location:Home.php');
                    $err['success']='Success Creation .';
                    $username=$email=$password=$confirm='';
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
    <title>Create New User</title>
    <link rel="stylesheet" href="./../Style/Style.css">
    <style>
        .Create label{
            font-size: 1.35em;
            font-weight: 600;
            color: rgb(14, 0, 0);
            padding-bottom: .4rem;
            padding-top: .4rem;
        }
        .Create input[type="text"],
        .Create input[type="password"],
        .Create input[type="email"]{
            padding: .3rem;
            outline: none;
            border: none;
            font-weight:600;
            font-size: 1.1rem;
            border-radius: .4rem;
        }
        .Create input[type='submit']{
            width: 10rem;
            padding:.6rem;
            margin: auto;
            margin-top: 1.3rem;
            border-radius: .3rem;
            border:none;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .lbld{
            font-size: 1.3rem;
            font-weight: 600;
            padding-bottom:.5rem;
            padding-top:.3rem;
            color: #222;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="Create.php" class="Create" method="post" >
            <h1>Add New User</h1><br />
            <?php 
                if($err['success'] != ""): ?>
                    <div class="info"><?php echo $err['success']; ?></div>
            <?php
                endif;
            ?>
            <label for="username">User Name :</label>     
            <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter Your User Name :" />
            <span class="err"><?php echo $err["username"] ?></span>
            <label for="email">Email :</label>
            <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter Your Email :" />
            <span class="err"><?php echo $err["email"] ?></span>
            <label for="password">Password :</label>    
            <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Enter Your Password :" />
            <span class="err"><?php echo $err["password"] ?></span>     
            <label for="confirm">Confirm Password :</label>
            <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="Confirm Your Password :" />
            <span class="err"><?php echo $err["confirm"] ?></span>
            <input type="submit" name="submit" value="Ajouter" class="btn" />
            <a href='Home.php'><< &nbsp; Back to the home</a>  
        </form>
    </div>
</body>
</html>