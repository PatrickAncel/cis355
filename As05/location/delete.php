<?php
require "../require_login.php";
require "../shorthand.php";
require "../../database.php";

if (!empty($_POST)) {
    $id = $_POST['id'];

    // Deletes all events for this location.
    $conn = DatabaseUtil::openConnection("as05");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'DELETE FROM Events WHERE LocationID=?';
    $preparedQuery = $conn->prepare($query);
    $preparedQuery->execute(array($id));
    DatabaseUtil::closeConnection();

    // Deletes the location.
    $conn = DatabaseUtil::openConnection("as05");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'DELETE FROM Locations WHERE ID=?';
    $preparedQuery = $conn->prepare($query);
    $preparedQuery->execute(array($id));
    DatabaseUtil::closeConnection();

    header("Location: list.php");
}

// if (empty($_GET)) {
//     header("Location: list.php");
// }

if (!empty($_GET)) {
    $id = $_GET['id'];
}

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

?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - Delete Location", "../");
?>
<body>
    <div class="container mt-2">
        <h1>Delete Location</h1>
        <div>
            <?php
                echo "<div><h6>Name: </h6>" . $location['Name'] . "</div><br>";
                echo "<div><h6>Description: </h6>" . $location['Description'] . "</div><br>";
                echo "<div><h6>Photo: </h6><img src='data:" . $location['ImageType'] . ";base64,"
                . base64_encode($location['Photo']) . "'></div><br>";
            ?>
        </div>
        <form method="post">
            <input hidden name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</body>
</html>