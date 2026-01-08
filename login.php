<?php
@session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=]], initial-scale=1.0">
    <title>Document</title>
</head>
<?php if(!isset($_SESSION['username'])): ?>
<body>
    <form method="post" action="login.php">
        <div>
    <label>
        Username
        <input name="username" type="text" maxlength="20">
    </label>
        </div>
        <div>
    <label>
        password
        <input name="password"type="password">
    </label>
</div>
    <button type="submit" name="submit">submit</button>
</form>
<?php
$con = mysqli_connect('localhost','root','','fi');
if(!$con){
    echo '<p style="color:"red"> There was a problem with the database connection.</p>';
    die("Error db connection");
}
$stmt = mysqli_stmt_init($con);
$query = "SELECT * FROM logintest where username = ?";
$username = filter_input(INPUT_POST,'username');
$password = filter_input(INPUT_POST,'password');   
if(isset($_POST['submit']) and mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt,'s',$username);
    mysqli_stmt_execute($stmt);

    $results = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($results)){
        if($username == $row['username'] and $password == $row['password']){
            header("Location: login.php");
        }
        else{
            echo '<p style="color:red"> Invalid password</p>';
        }
    }
    else{
        echo '<p style="color:red"> User does not exist </p>';
    }

    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);

}

mysqli_close($con);

else:
    ?>
    <p style="color:green"> You are logged in!</p>
    <a href="main.php">Home</a>
    <?php
endif;
?>
    
</body>
</html>