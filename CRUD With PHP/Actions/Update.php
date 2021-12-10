<?php
    include_once('./../Database/Database.php');
    $username=$email=$created='';
    $err=array(
        "username"=>'',
        "email"=>'',
        'created'=>''
    );
    if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])):
        $db=new Database();
        $con=$db->Connection();
        $id=$_REQUEST['id'];
        $sql="SELECT * FROM users WHERE ID=$id";
        $stmt=$con->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount()):
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="./../Style/Style.css">
    <style>
        .Update{
            background: #00416A;
            background: -webkit-linear-gradient(to top, #E4E5E6,#00416A);
            background: linear-gradient(to bottom, #E4E5E6, #00416A);
            display: grid;
            grid-template-columns: 100%;
            padding: 2rem;
            width: 25rem;
            box-shadow:2px 3px 13px 7px rgba(0,0,0,0.53);
        }
        label{
            color:#FFF;
        }
    </style>
</head>
<body>
<div class="container">

    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" class="Update" method="post">
        <h1>Edite User</h1>
        <?php while($row=$stmt->fetch(PDO::FETCH_ASSOC)): ?> 
            <label for="id">ID :</label>
            <input type="text" name="id" value="<?php echo $row['ID'];?>" disabled/>
            <label for="username">User Name :</label>
            <input type="text" name="username" value="<?php echo $row['UserName']; ?>" />
            <span class="err"><?php echo $err["username"]; ?></span>
            <label for="email">Email :</label>
            <input type="email" name="email" value="<?php echo $row['Email']; ?>"/>
            <span class="err"><?php echo $err["email"]; ?></span>
            <label for="created">Date de la Création :</label>
            <input type="datetime-local" name="created" value="<?php echo date("Y-m-d\TH:i:s", strtotime($row['CreateDate'])); ?>" />
            <span class="err"><?php echo $err["created"]; ?></span>
        <input type="submit" name="submit" value="Update" />
<?php 
                endwhile;
            endif;
        else:
            header('location:Home.php');
        endif;
?>
    </form>
    </div>
</body>
</html>
<?php
    if(isset($_POST['submit'])):
        $username=$_POST['username'];
        $email=$_POST['email'];
        $created=$_POST['created'];

        if(empty($username)):
            $err["username"]="User Name is Required "; 
        endif;

        if(empty($email)):
            $err["email"]="Email is Required "; 
        endif;

        if(empty($created)):
            $err["created"]='Created Date is Required !';
        endif;

        if(!array_filter($err)):
            $sql='UPDATE users SET UserName="'.$username.'",Email="'.$email.'",CreateDate="'.$created.'" WHERE ID='.$id;
            $stmt=$con->prepare($sql);
            if($stmt->execute()):
                header("location:Home.php");
            endif;
        endif;
    endif;
?>