<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
$servername = "localhost";
$username = "root";
$password = "root";
 $db_name = "note";
$connec1 = new mysqli($servername,$username,$password);
$connec = new mysqli($servername,$username,$password,$db_name);
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
$_SESSION['email'] = $_POST['email'];
$test = 0;
$sql2 = "SHOW DATABASES LIKE '".$_SESSION['username']."'";
$r = $connec1->query($sql2);
$r1 = $r->num_rows;
$sql3 = "SELECT * FROM user_authentication WHERE email =  '".$_SESSION['email']."'";
$r4 = $connec->query($sql3);
 $r3 =  $r4->num_rows;
$show = 0;
    if($r1!=0)
    {
        $show=$show+1;
        echo '<h1>' . 'Username already taken' . '</h1>';

                 
    }
    if($r3>0)
                    {   
                     $show=$show+1;
                     echo '<h1>' . "Email already taken" . '</h1>';

                    }

    if($show!=2){
if(!$_SESSION['username']==""){
    $test = $test + 1;
}

if(strlen($_SESSION['password']) < 8){
    echo "<div><h1>" + 'Password must contain 8 characters or more' +"</div></h1>" ;
}
else{
    $test = $test + 1;
}

if (!filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      echo $emailErr;
    }
else{
    $test = $test + 1;
}
$_SESSION['password']=hash('sha512',$_SESSION['password']);
if($test=3){
    $stmt = $connec->prepare("INSERT INTO user_authentication(username,password,email) VALUES (?,?,?)");
    $stmt->bind_param("sss",$v1,$v2,$v3);
    $v1 = $_SESSION['username'];
    $v2 = $_SESSION['password'];
    $v3 = $_SESSION['email'];
    $stmt->execute();
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $connec2 = new mysqli($servername,$username,$password);
    $v5 = $_SESSION['username'];
    $sql1 = "CREATE DATABASE IF NOT EXISTS ". $v5 ." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
    $connec2->query($sql1);
    $connec4 =  new mysqli($servername,$username,$password,$v5);
    $sql4 = "CREATE TABLE notes
    (
        topic VARCHAR(100) NOT NULL,
        subtopic VARCHAR(200) NOT NULL,
        note VARCHAR(2000) NOT NULL,
        date VARCHAR(12) NOT NULL,
        time VARCHAR(12) NOT NULL
    )";
    $connec4->query($sql4);
    session_start();
    session_destroy();
    header('Location:../login.html');
}
else{
    echo "<h2>".'Password to short'. "</h2>";
}
    }
    //DELETE FROM user_authentication WHERE email = "aaditya7739008423@gmail.com"
    //DROP DATABASE aaditya7903
?>
</body>
</html>

