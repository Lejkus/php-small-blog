<link rel="stylesheet" href="styles/admin.scss?v=<?php echo time(); ?>">

<?php
$connect = mysqli_connect('localhost',"root","","cms");
session_start();

include 'navbar.php';
echo "<div class='admin'>";
echo '<a class="logout" href="Logout.php">Wyloguj się</a>';
//____________________________________dodawanie postu____________________________________
if(!isset($_SESSION["admin_id"])){
    echo '<h3>Brak dostępu do tej strony</h3>';
}else{
    if(!empty($_POST['title'])){
        if(isset($_POST['title']) and isset($_POST['description']) and isset($_POST['nazwa']) and isset($_POST['photos'])){
            $title = $_POST['title'];
            $description = $_POST['description'];
            $nazwa = $_POST['nazwa'];
            mysqli_query($connect,"INSERT INTO `posts`(`post_id`, `title`, `description`, `type`) VALUES ('','$title','$description','$nazwa')");
            $id = mysqli_query($connect,"SELECT post_id FROM `posts` WHERE title ='$title';");
            while ($row = mysqli_fetch_array($id)) {
                //echo $row[0];
                //echo sizeof($_POST['photos']);
                for ($i=0; $i <sizeof($_POST['photos']) ; $i++) { 
                    mysqli_query($connect,"INSERT INTO `images`(`image_id`, `src`, `post_id`) VALUES ('','".$_POST['photos'][$i]."','".$row[0]."')");
                }
            }
        }else{
            echo 'wszystko wpisz';
        }
    }
    
}

//____________________________________tabelka postów____________________________________
$posts = mysqli_query($connect,"SELECT * FROM `posts`");
echo "<table>
<tr>
    <th>ID</th>
    <th>Tytuł</th>
    <th>Typ</th>
    <th>Usuń</th>
    <th>Edytuj</th>
</tr>";

while ($row = mysqli_fetch_array($posts)) {
    echo    "<form method='post'>";
    echo    "<tr>";
    echo    "<td >".$row[0]."</td>";
    echo    "<td>".$row[1]."</td>";
    echo    "<td>".$row[4]."</td>";
    echo    "<td><button name='delete' >X</button></td>";
    echo    "<td><button name='edit' >E</button></td>";
    echo            "<input type='hidden' name='id' value='".$row[0]."'>";
    echo    "</tr>";
    echo    "</form>";
}

echo "</table>";


//____________________________________usuwanie edytowanie postu__________________
if(isset($_POST['delete'])){
   $id = $_POST['id'];
   $result = mysqli_query($connect, "DELETE FROM posts WHERE post_id = $id");
   mysqli_close($connect);

   if ($result) {
    // Przekierowanie na tę samą stronę po usunięciu
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
    } 
}

//___________________________________dodawanie pola do  edytowania postu__________________
if(isset($_POST['edit'])){
    $id =  $_POST['id'];
    $post = mysqli_query($connect,"SELECT * FROM `posts` WHERE post_id =$id;");
    while ($row = mysqli_fetch_array($post)) {
    echo '<div class="post-form"><form method="post">
            <input type="hidden" name="edit-id" value="'.$row[0].'">
            <input placeholder="tytul" name="edit-title" value="'.$row[1].'">
        
            <input placeholder="opis" name="edit-description" value="'.$row[2].'">
        
            <select name="edit-nazwa">';
            if ($row[4] == "fig") {
                echo '<option value="set">zestaw</option>
                      <option selected value="fig">figurka</option>';
            } else {
                echo '<option selected value="set">zestaw</option>
                      <option value="fig">figurka</option>';
            }
            echo '</select>
        
            <button type="submit">Zmień post </button>
        </form></div>';
    }
}
//___________________________________edytowanie postu__________________
if(isset($_POST['edit-title']) and isset($_POST['edit-description']) and isset($_POST['edit-nazwa'])){
    $id = $_POST['edit-id'];
    $title = $_POST['edit-title'];
    $description = $_POST['edit-description'];
    $nazwa = $_POST['edit-nazwa'];

    $result = mysqli_query($connect, "UPDATE `posts` SET `title`='$title',`description`='$description',`type`='$nazwa' WHERE post_id = $id");
    mysqli_close($connect);
 
    if ($result) {
     // Przekierowanie na tę samą stronę po usunięciu
     header("Location: ".$_SERVER['PHP_SELF']);
     exit();
    } 
 }
?>
<div class="post-form">
<form method="post">
    <input placeholder="tytul" name="title">

    <input placeholder="opis" name="description">

    <select name="nazwa">
		<option value="set">zestaw</option>
		<option value="fig">figurka</option>
    </select>

    <button type="button" id="btn-photo">Dodaj pole zdjęcia</button>
    <div id="photos">
    </div>

    <button type="submit">Dodaj post </button>

    <script>

        var photos = document.getElementById('photos');
        var btn_photo = document.getElementById('btn-photo');

    
        btn_photo.addEventListener('click', () => {
        let allChildren = photos.getElementsByTagName('*').length;

        // Stworzenie nowego elementu input
        let newInput = document.createElement('input');
        newInput.setAttribute('name', 'photos[]');
        newInput.setAttribute('class', `img img-${allChildren}`);

        // Stworzenie nowego elementu <br>
        let lineBreak = document.createElement('br');

        // Dodanie nowych elementów do kontenera photos
        photos.appendChild(newInput);
        photos.appendChild(lineBreak);
    });
    </script>
</form>
</div>
</div>