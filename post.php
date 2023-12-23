<?php 
$connect = mysqli_connect('localhost',"root","","cms");
session_start();

include 'navbar.php';

// if(isset($_SESSION["admin_id"])){
//     echo '<h1>zalogowano jako '.$_SESSION["admin_id"].'</h1>';
// }else{ 
//     echo '<h1>nie zalogowano</h1>';
//     echo '<p><a href="/cms/adminlogin.php">Zaloguj się jako admin</a><a href="/cms/userlogin.php">Zaloguj sie jako użytkownik</a></p>';
// };

$post_id = $_GET["id"];

$post = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id where posts.post_id = $post_id GROUP BY posts.post_id;");
while ($row = mysqli_fetch_array($post)) {
    echo '<div class="post">';
    echo '<h2 class="post-title">'.$row['title'].'</h2>';
    
    $images = mysqli_query($connect,"SELECT * FROM `images` WHERE post_id = $post_id");
    while ($row2 = mysqli_fetch_array($images)) {
        echo '<img style="height:500px;,width:700px;" src="'.$row2['src'].'">';   
    };
    echo '<h3 class="post-data">'.substr($row['date'], 0, -9).'</h3>';
    echo '<h3 class="post-title">'.$row['description'].'</h3>';
    
    echo '</div>';
};
?>
