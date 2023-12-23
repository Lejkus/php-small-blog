<link rel="stylesheet" href="styles/posts.scss?v=<?php echo time(); ?>">
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

//session_destroy();
echo '<div class="posts">';


$posts = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id GROUP BY posts.post_id ORDER BY images.image_id;");



while ($row = mysqli_fetch_array($posts)) {
    $post_id = $row['post_id'];

    echo '<div style="cursor:pointer;" class="post" onclick="location.href= `/cms/post.php?id='.$post_id.'`">';
    echo '<h3 class="post-data">'.substr($row['date'], 0, -9).'</h3>';
    echo '<h1 class="post-title">'.$row['title'].'</h1>';

               
    $image = mysqli_query($connect,"SELECT * FROM `images` WHERE post_id = $post_id ORDER BY image_id ASC LIMIT 1;");
    while ($row2 = mysqli_fetch_array($image)) {
        echo '<img style="width:500px;" src="'.$row2["src"].'">';
    };
    

    echo '<h3 class="post-title">'.substr($row['description'], 0, 100).'...</h3>';
    // $images = mysqli_query($connect,"SELECT * FROM `images` WHERE post_id = $post_id");
    // while ($row2 = mysqli_fetch_array($images)) {
    //     echo '<img style="width:400px;" src="'.$row2['src'].'">';   
    // };
    echo '</div>';
};
echo '</div>'

?>