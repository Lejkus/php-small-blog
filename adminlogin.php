<form method="post">
    <input name="admin_name">
    <input type="password" name="admin_password">
    <button type="submit">Zaloguj jako administrator</button>
</form>

<?php 
$connect = mysqli_connect('localhost',"root","","cms");
session_start();
if(isset($_POST['admin_name']) and isset($_POST['admin_password'])){
    $name = $_POST['admin_name'];
    $password = $_POST['admin_password'];
    $dbpassword = mysqli_query($connect,"SELECT `admin_id`,`password` FROM `admins` WHERE `name` ='$name';");
    while ($row = mysqli_fetch_array($dbpassword)) {
        if($row['password'] == $password){
            session_start();
            $_SESSION["admin_id"] = $row['admin_id'];
            echo $_SESSION["admin_id"];
            header("location:/cms/main.php");
        }else{
            echo 'złe hasło';
        };
    };
};
?>