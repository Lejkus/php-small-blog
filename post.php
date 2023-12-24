<link rel="stylesheet" href="styles/singlepost.scss?v=<?php echo time(); ?>">
<?php 
$connect = mysqli_connect('localhost',"root","","cms");
session_start();

include 'navbar.php';
include 'ObliczCzas.php';

// if(isset($_SESSION["admin_id"])){
//     echo '<h1>zalogowano jako '.$_SESSION["admin_id"].'</h1>';
// }else{ 
//     echo '<h1>nie zalogowano</h1>';
//     echo '<p><a href="/cms/adminlogin.php">Zaloguj się jako admin</a><a href="/cms/userlogin.php">Zaloguj sie jako użytkownik</a></p>';
// };

$post_id = $_GET["id"];

//____________________________________wyświetlanie posta ____________________________________

$post = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id where posts.post_id = $post_id GROUP BY posts.post_id LIMIT 6 OFFSET 0;");

while ($row = mysqli_fetch_array($post)) {
    echo '<div class="post">';
    echo '<h1 class="post-title">'.$row['title'].'</h1><h2 class="post-data">'.czasTemu($row['date']).'</h2>';
    
    $images = mysqli_query($connect,"SELECT * FROM `images` WHERE post_id = $post_id");
    echo '<div class="images">';
        while ($row2 = mysqli_fetch_array($images)) {
            echo '<img style="height:500px;,width:700px;" src="'.$row2['src'].'">';   
        };
    echo '</div>';
    echo '<h2 class="post-title">'.$row['description'].'</h2>';
    

    echo '<form method="post">
        <input name="comment">
        <input type="submit">
        </form>';
    
    // echo '</div>';
};

//____________________________________dodawnaie komentarza____________________________________
    if(isset($_POST['comment'])){
        $comment = $_POST['comment'];
        $query = mysqli_query($connect,"INSERT INTO `comments`(`comment_id`, `description`, `post_id`, `user_id`) VALUES ('','$comment','$post_id','0')");
        if($query){
            header("Location: ".$_SERVER['PHP_SELF']."?id=$post_id");
            exit();
        }
        
    }

//____________________________________wyświetlanie komentarzy____________________________________

$comments = mysqli_query($connect,"SELECT * FROM `comments` WHERE post_id = $post_id ;");
echo '<h1>Komentarze:</h1>';
while ($row = mysqli_fetch_array($comments)) {
    echo '<hr><div class="comment">';
    if($_SESSION["admin_id"]){
        echo '<h1 class="">'.$row['description'].'</h1><h2 class="">'.czasTemu($row['date']).'</h2>
        <form style="position:absolute;" method="post">
            <button  name="delete">usuń</button>
            <input type="hidden" name="commentid" value="'.$row[0].'">
        </form>';
    }else{
        echo '<h1 class="">'.$row['description'].'</h1><h2 class="">'.czasTemu($row['date']).'</h2>';
    }
    echo '</div>';
};
//____________________________________usuwanie komentarzy____________________________________
if(isset($_POST['delete'])){
    $id = $_POST['commentid'];
    $result = mysqli_query($connect, "DELETE FROM comments WHERE comment_id = $id");
    mysqli_close($connect);
 
    if ($result) {
     // Przekierowanie na tę samą stronę po usunięciu
     header("Location: ".$_SERVER['PHP_SELF']."?id=$post_id");
     exit();
     } 
 }


?>

