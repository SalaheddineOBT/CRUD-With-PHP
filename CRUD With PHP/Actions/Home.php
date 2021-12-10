<?php 
    include_once('./../Database/Database.php');
    if(empty($_SESSION['username'])):
        header('location:Login.php');
    endif;
    $db=new Database();
    $con=$db->Connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./../Style/Style.css">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        table{
            background:black;
            overflow:scroll;
            margin:auto;
            width:100%;
            border-collapse: collapse;
        }
        h1{
            text-align: center;
            color:#fff;
            margin-bottom:1rem;
        }
        .tbl{
            width:100%;
            height: 55.6vh;
            margin: auto;
            overflow-y: auto;
            margin-top:2rem ;
        }
        th{
            padding-top: .8rem;
            padding-bottom: .8rem;
            color:#fff;
            font-size:1.15rem;
            background-color: #255176;
        }
        tr:nth-child(even){
            background: #00416A;
        }
        td:first-child{
            padding-left:1rem;
            padding-right:1rem;
        }
        td{
            background: #fff;
            padding-top: 1rem;
            padding-bottom: 1rem;
            font-size:1.15rem;
            padding-left:.2rem;
            padding-right:.2rem;
            text-align: center;
        }
        a{
            font-size: 1.1rem;
            font-weight: 600;
        }
        .frm{
            margin: 2rem;
            position: relative;
        }
        .Updatee{
            border: 2px solid rgb(10, 190, 160);
            color: rgb(10, 190, 160);
            padding: .4rem;
            margin-right: .3rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .Delete{
            border: 2px solid rgb(211, 37, 14);
            color: rgb(211, 37, 14);
            padding: .4rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .Updatee:hover{
            background: rgb(10, 190, 160);
            color: white;
        }
        .Delete:hover{
            background: rgb(211, 37, 14);
            color: white;
        }
        .create{
            position: relative;
            padding: .6rem;
            border: 2px solid #255176;
            background: #255176;
            width:30%;
            text-align:center;
            cursor:pointer;
            color: white;
            box-shadow:.5px .5px .2px #eee;
       }
        .create:hover{
            background:#fff;
            color:#072C4D;
        }
        .inform{
            background: rgba(238, 238, 238, 0.89);
            padding:1.1rem;
            display:grid;
            grid-template-columns:.5fr 2fr .5fr;
            
        }
        .inform a{
            margin-left:1rem;
        }
        .g{
            color:#B47263;
        }
        .i{
            text-align:center;
            font-size:1.4rem;
            font-weight:700;
        }
        .Read{
            border: 2px solid #000;
            color: #000;
            padding: .4rem;
            cursor: pointer;
            background:none;
            padding-left: 1rem;
            padding-right: 1rem;
            margin-right:.3rem;
        }
        .Read:hover{
            background: #000;
            color: white;
        }
        .logout{
            text-align:right;
            margin-right:3rem;
            font-size:1.5rem;
        }
        .logout:hover{
            text-decoration:underline;
        }
        .tit{
            text-align:left;
            margin-left:1rem;
            font-size:1.5rem;
            font-weight:700;
        }
        .hi{
            background: #757F9A;
            background: -webkit-linear-gradient(to top, #D7DDE8, #757F9A);
            background: linear-gradient(to top, #D7DDE8, #757F9A);
             width: 100%;
            height:100vh;
        }
        .cont{
            display:grid;
            grid-template-columns: 1fr 1fr;
        }
        .bx{
            text-align:right;
        }
        input[type="text"]{
            width: 16rem;
            padding:.5rem;
            margin: auto;
            margin-top: 1.3rem;
            border-radius: .3rem;
            border:none;
            font-weight: 600;
            font-size: 1.1rem;   
            box-shadow: .1px .3px .2px .5px #000;
        }
</style>
</head>
<body>
<?php
    $sql="SELECT * FROM users";
    $stmt=$con->prepare($sql);
    $stmt->execute(); 
?>

    <div class="hi">
    <div class="inform">
    <span class="tit">Dashboard</span>
    <span class="i">User Connecté : <span class="g"><?php echo $_SESSION['username']; ?></span></span> 
    <a href="logout.php" class="logout">Logout</a> 
</div>
    <form action="Home.php" method="post" class="frm">
        <h1>Users Détails</h1>
        <a href="Create.php" class="create">Add New User</a>
        <div class="tbl">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Date de Création</th>
                <th>Opérations</th>
            </tr>
<?php
        if($stmt->rowCount()):
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)):
            echo '<tr>';
            echo '<td>'.$row['ID'].'</td>';
            echo '<td>'.$row['UserName'].'</td>';
            echo '<td>'.$row['Email'].'</td>';
            echo '<td>'.$row['CreateDate'].'</td>';
            echo '<td><a class="Read" href="Read.php?id='.$row['ID'].'" title="Read User" >Read</a> <a class="Updatee" href="Update.php?id='.$row['ID'].'" title="Update User" >Editer</a> <a class="Delete" id="btndel" title="Delete User" href="Delete.php?id='.$row['ID'].'" >Delete</a></a></td>';
            echo '</tr>';
        endwhile;
    else:
        echo "<tr>";
        echo "<td colspan='5'>Empty DataBase</td>";
        echo "</tr>";
    endif;

?>
        </table>
        </div>
    </form>
    </div>
</body>
</html>



