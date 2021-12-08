<?php
    include_once('./../Database/Database.php');
    $db=new Database();
    $con=$db->Connection();

    if(empty($_REQUEST['id'])):
        header('location:Home.php');
    else:
        $id=$_REQUEST['id'];

        $sql="SELECT * FROM users WHERE ID=$id LIMIT 1";
        $stmt=$con->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount()):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read User</title>
    <style>
        .thh{
            text-align: left;
        }
        body{
            display:flex;
            align-items:center;
            justify-content:center;
            height:70vh;
            background: #076685c2;
            background: -webkit-linear-gradient(to left, #ccc, #076685c2);
            background: linear-gradient(to left, #ccc, #076685c2);
        }
        .container{
            width:30rem;
            padding:1rem;
            padding-bottom:3rem;
            margin-top:6rem;
            background: #3a6186e1;
            background: -webkit-linear-gradient(to top, #89253e94, #3a61869a);
            background: linear-gradient(to top, #89253e94, #3a6186b2);
            border-radius:.8rem;
            box-shadow:2px 0px 24px 4px #222;
        }
        h1{
            text-align:center;
            font-family: Georgia, serif;
            font-size: 28px;
            letter-spacing: -1.4px;
            word-spacing: -0.2px;
            color:#fff;
            font-weight: 700;
            text-decoration: none solid rgb(68, 68, 68);
            font-style: italic;
            font-variant: normal;
            text-transform: none;
            margin-bottom:2.5rem;
        }
        table{
            margin:auto;
            margin-bottom:2rem;
        }
        th,td{
            color:#fff;
            font-size:1.5rem;
            padding:.4rem;
        }
        .btn{
            color: #fff;
            padding: .6rem;
            font-size:1.2rem;
            border: 2px solid #fff;
            margin-top: 6rem;
            text-decoration:none;
            margin-left:2.5rem;
            font-weight:700;
        }
        .btn:hover{
            background: #fff;
            color: #7B4C63;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Information</h1>
        <table>
            <?php while($row=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <th class="thh">ID :</th>
                <td>
                    <?php echo $row['ID']; ?>
                </td>
            </tr>
            <tr>
                <th class="thh">User Name :</th>
                <td>
                    <?php echo $row['UserName']; ?>
                </td>
            </tr>
            <tr>
                <th class="thh">Email </th>
                <td>
                    <?php echo $row['Email']; ?>
                </td>
            </tr>
            <tr>
                <th class="thh">Date Creation :</th>
                <td>
                    <?php echo $row['CreateDate']; ?>
                </td>
            </tr>
        </table>
        <a href="Home.php" class="btn" >Back to Home</a>
    </div>
<?php
            endwhile;
        endif;
    endif;
?>
</body>
</html>