<link rel="stylesheet" href="styles/posts.scss?v=<?php echo time(); ?>">
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

//session_destroy();
echo '<div class="posts">';

//____________________________________zapytanie o ilośc postów w bazie w celu paginacji___________________________
if(!isset($_GET["type"])){
    $zapytanie = mysqli_query($connect,"SELECT count(*) FROM `posts`");
}else{
    if($_GET["type"]=='sets'){
        $zapytanie = mysqli_query($connect,"SELECT count(*) FROM `posts` where posts.type = 'set'");
    }else if($_GET["type"]=='figs'){
        $zapytanie = mysqli_query($connect,"SELECT count(*) FROM `posts` where posts.type = 'fig'");
    }
}

while ($row = mysqli_fetch_array($zapytanie)) {
    $ilosc=$row[0];
};
//_co ile paginacja_
$amount = 6;

if(!isset($_GET["type"])){
    if(isset($_GET["site"]) ){
        $site = $_GET["site"];
        $from = $site*$amount;
        $posts = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id GROUP BY posts.post_id ORDER BY date DESC LIMIT $from,$amount;");
    }else{
        $posts = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id GROUP BY posts.post_id ORDER BY date DESC LIMIT 0,$amount;");
    }
    
}else{
    if(isset($_GET["site"]) ){
        $site = $_GET["site"];
        $from = $site*$amount;
        if($_GET["type"]=='sets'){
            $posts = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id where posts.type = 'set' GROUP BY posts.post_id ORDER BY date DESC LIMIT $from,$amount;");
        }else if($_GET["type"]=='figs'){
            $posts = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id where posts.type = 'fig' GROUP BY posts.post_id ORDER BY date DESC LIMIT $from,$amount;");
        }else{
            echo 'error'; 
        }
    }else{
        if($_GET["type"]=='sets'){
            $posts = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id where posts.type = 'set' GROUP BY posts.post_id ORDER BY date DESC LIMIT 0,$amount;");
        }else if($_GET["type"]=='figs'){
            $posts = mysqli_query($connect,"SELECT * FROM `posts` join images on images.post_id = posts.post_id where posts.type = 'fig' GROUP BY posts.post_id ORDER BY date DESC LIMIT 0,$amount;");
        }else{
            echo 'error'; 
        }
    }
}




//________________________________Wyświetlanie postów________________________________
while ($row = mysqli_fetch_array($posts)) {
    $post_id = $row['post_id'];

    echo '<div style="cursor:pointer;" class="post" onclick="location.href= `/cms/post.php?id='.$post_id.'`">';
    echo '<h3 class="post-data">'.czasTemu($row['date']).'</h3>';
    echo '<h1 class="post-title">'.$row['title'].'</h1>';

               
    $image = mysqli_query($connect,"SELECT * FROM `images` WHERE post_id = $post_id ORDER BY image_id ASC LIMIT 1;");
    while ($row2 = mysqli_fetch_array($image)) {
        echo '<img src="'.$row2["src"].'">';
    };
    

    echo '<h3 class="post-title">'.substr($row['description'], 0, 100).'...</h3>';
    // $images = mysqli_query($connect,"SELECT * FROM `images` WHERE post_id = $post_id");
    // while ($row2 = mysqli_fetch_array($images)) {
    //     echo '<img style="width:400px;" src="'.$row2['src'].'">';   
    // };
    echo '</div>';
};


echo '</div>';


//___________________________________________________Paginacja________________________________________
echo '<div class="pagination">';
    for ($i = 0; $i+1 <= ceil($ilosc/6); $i++) {
        for ($i = 0; $i+1 <= ceil($ilosc/6); $i++) {
            $isActive = (isset($_GET["site"]) and ($_GET["site"] == $i)) || (!isset($_GET["site"]) and $i == 0);
            $class = $isActive ? 'pagin-active' : 'pagin';
        
            echo "<div onclick=\"location.search+= '&site={$i}'\" class='{$class}'>".($i+1).'</div>';

        }
        
    }
echo '<div>';
?>
