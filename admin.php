<?php
$connect = mysqli_connect('localhost',"root","","cms");
session_start();

include 'navbar.php';

//echo $_POST['photos'][1];

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
            };
            
        }else{
            echo 'wszystko wpisz';
        }
    }
    
}

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

if(isset($_POST['delete'])){
   $id = $_POST['id'];
   mysqli_query($connect, "DELETE FROM posts WHERE post_id = $id");
   mysqli_close($connect);

}

if(isset($_POST['edit'])){
    echo $_POST['id'];
}

?>
<script></script>
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