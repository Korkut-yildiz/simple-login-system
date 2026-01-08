<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=]], initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="register.php">
        <div>
    <label>
        Username
        <input name="username" type="text">
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
$query = "INSERT INTO logintest VALUES(?,?)";
$username = filter_input(INPUT_POST,'username');
$password = filter_input(INPUT_POST,'password');   
if(isset($_POST['submit']) and mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt,'ss',$username,$password);
    if(!mysqli_stmt_execute($stmt)){
        echo '<p style="color:red"> User already exists! </p>';
        exit(mysqli_stmt_errno($stmt));
    }
    if(mysqli_stmt_affected_rows($stmt) > 0){
        echo '<p style="color:green"> You have been registered! </p>';
    } else{
        echo "Something went wrong :/";
    }

    $results = mysqli_stmt_get_result($stmt);
    

    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);

}

mysqli_close($con);
?>
    
</body>
</html>