<?php
    include_once('./../Database/Database.php');
    $db=new Database();
    $con=$db->Connection();
    if(!isset($_REQUEST['id']) || empty($_REQUEST['id'])):
        header('location:Home.php');
    else:
        if(isset($_POST['delete'])):

            $id=$_REQUEST['id'];
            if($_SESSION['ID']==$id):
                $sql="DELETE FROM users WHERE ID=$id";
                $stmt=$con->prepare($sql);
                if($stmt->execute()):
                    session_destroy();
                    header('location:Login.php');
                endif;
            else:
                $sql="DELETE FROM users WHERE ID=$id";
                $stmt=$con->prepare($sql);
                if($stmt->execute()):
                    header('location:Home.php');
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
    <title>Delete User</title>
    <link rel="stylesheet" href="./../Style/Style.css">
    <style>
        .Delete:hover{
            background: rgb(211, 37, 14);
            color: white;
        }
        .Delete{
            border: 2px solid rgb(211, 37, 14);
            color: rgb(211, 37, 14);
            padding: .5rem;
            cursor: pointer;
            background:none;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .no{
            border: 2px solid #000;
            color: #000;
            padding: .4rem;
            cursor: pointer;
            margin-left:.5rem;
            background:none;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .no:hover{
            background: #000;
            color: white;
        }
        .boite{
            padding:2rem;
            display:flex;
            align-items:center;
            justify-content:center;
            width:100%;
            height:100vh;
        }
        .frm{
            margin-top:-16rem;
            background:#EEE;
            padding:1.5rem;
            border-radius:.5rem;
        }
        h3{
            padding-bottom:1.2rem;
        }
    </style>
</head>
<body>
    <div class="boite">
        <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="post" class="frm">
            <h3>Voulez Vous Vraiment Supprimer Cette User ?</h3>
            <input type="submit" class="Delete" name="delete" value="Yes" />
            <a href='Home.php' class="no" >No</a>
        </form>
    </div>
</body>
</html>