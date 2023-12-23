<link rel="stylesheet" href="styles/navbar.scss?v=<?php echo time(); ?>">
<?php

echo '<navbar>';
echo '<a href="/cms/main.php"><img src="https://i.pinimg.com/474x/39/52/5a/39525a29fb5931ffbc9eb59db3cb6e13--lego-wallpaper-letters.jpg"></a>';
echo '<div class="navdiv">';
echo '<h3>Wszystko</h3>';
echo '<h3 onclick="location.href= `/cms/main.php?type=sets`">Zestawy</h3>';
echo '<h3 onclick="location.href= `/cms/main.php?type=figs`">Figurki</h3>';

if(isset($_SESSION["admin_id"])){
    echo '<a href="/cms/admin.php"><h3>Panel administracyjny</h3></a>';
    echo '<h3>zalogowano jako id: '.$_SESSION["admin_id"].'</h3>';
}else{ 
    echo '<h3><a href="/cms/adminlogin.php">Zaloguj się jako admin</a></h3>';
    echo '<h3><a href="/cms/userlogin.php">Zaloguj sie jako użytkownik</a></h3>';
};
echo '</div>';
echo '</navbar>';
?>