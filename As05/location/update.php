<?php
require "../require_login.php";
require "../shorthand.php";
require "../../database.php";

$name = null;
$description = null;

$nameError = null;
$descriptionError = null;
$photoError = null;
$valid = true;

if (empty($_GET)) {
    header("Location: list.php");
}

$id = $_GET['id'];

// Gets the current data.
$conn = DatabaseUtil::openConnection("as05");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = 'SELECT * FROM Locations WHERE ID=?';
$preparedQuery = $conn->prepare($query);
$preparedQuery->execute(array($id));
DatabaseUtil::closeConnection();
$location = $preparedQuery->fetch(PDO::FETCH_ASSOC);

if (!$location) {
    header("Location: list.php");
}

$name = $location['Name'];
$description = $location['Description'];
$fileType = $location['ImageType'];
$content = $location['Photo'];

if (!empty($_POST)) {

    $name = $_POST['name'];
    $description = $_POST['description'];

    // Validates location name and description.
    if (strlen($name) == 0) {
        $nameError = "Location name must be provided";
        $valid = false;
    }
    if (strlen($description) == 0) {
        $descriptionError = "Must have description";
        $valid = false;
    }

    // Validates uploaded file.
    $types = array('image/jpeg', 'image/png');
    if ($_FILES['photo']['size'] > 0) {

        $filename = $_FILES['photo']['name'];
        $tmpName = $_FILES['photo']['tmp_name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];
        $content = file_get_contents($tmpName);

        if (!in_array($fileType, $types) || $fileSize > 4294967295) {
            $photoError = "Image must be a JPEG or PNG";
            $valid = false;
        }
    }

    if ($valid) {
        $conn = DatabaseUtil::openConnection("as05");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = 'UPDATE Locations SET Name=?, Description=?, Photo=?, ImageType=? WHERE ID=?';
        $preparedQuery = $conn->prepare($query);
        $preparedQuery->execute(array($name, $description, $content, $fileType, $id));
        DatabaseUtil::closeConnection();

        header("Location: list.php");
    }
    
}

?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - Edit Location", "../");
?>
<body>
    <div class="container mt-2">
        <h1>Edit Location</h1>
        <form method="post" enctype="multipart/form-data">
            <?php
            Shorthand::echoTextInputFormGroup("Location Name", "name", $nameError, $name);
            Shorthand::echoTextInputFormGroup("Description of Location", "description", $descriptionError, $description);
            Shorthand::echoImageFormGroup("photo", $photoError);
            ?>
            <button type="submit" class="btn btn-primary float-left">Submit</button>
        </form>
    </div>
</body>
</html>