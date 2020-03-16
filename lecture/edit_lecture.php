<?php
$imageFile = $_POST['imageFile'];

error_reporting(E_ALL);
ini_set("display_errors", 1);
$target_dir = "file_uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
if($_FILES["fileToUpload"]["name"]==""){
    $db_name = $imageFile;
} else {
    $db_name = basename($_FILES["fileToUpload"]["name"]);
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
// if (file_exists($target_file)) {
//     echo "Sorry, file already exists.";
//     $uploadOk = 0;
// }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

session_start();

$finished = $_POST['finished'];
$title = $_POST['title'];
$content = $_POST['content'];
$lectureDay = $_POST['lectureDay'];
$idx = $_POST['idx'];
$url = 'Location: http://localhost/template2/lecture/lecture_view.php?idx='.$idx;
$conn = mysqli_connect("localhost", "sangjin", "tkdwls12!Q", "db");
$sql = "
  UPDATE lectureboard
    SET
        title = '$title',
        content = '$content',
        imageFile = '$db_name',
        finished = '$finished',
        lectureDay = '$lectureDay',
        modified = NOW()
    WHERE
        idx = '$idx' ";
    
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '수정하는 과정에서 문제가 생겼습니다.';
    }else{
        echo '성공했습니다.';
        header($url);
    }

?>
