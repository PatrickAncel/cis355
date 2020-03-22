<?php
require "../require_login.php";
require "../shorthand.php";
require "../../database.php";

if (!empty($_POST)) {
    $id = $_POST['id'];

    // Deletes all events for this speaker.
    $conn = DatabaseUtil::openConnection("as05");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'DELETE FROM Events WHERE SpeakerID=?';
    $preparedQuery = $conn->prepare($query);
    $preparedQuery->execute(array($id));
    DatabaseUtil::closeConnection();

    // Deletes the speaker.
    $conn = DatabaseUtil::openConnection("as05");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'DELETE FROM Speakers WHERE ID=?';
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
$query = 'SELECT * FROM Speakers WHERE ID=?';
$preparedQuery = $conn->prepare($query);
$preparedQuery->execute(array($id));
DatabaseUtil::closeConnection();

$speaker = $preparedQuery->fetch(PDO::FETCH_ASSOC);

if (!$speaker) {
    header("Location: list.php");
}

?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - Delete Speaker", "../");
?>
<body>
    <div class="container mt-2">
        <h1>Delete Speaker</h1>
        <div>
            <?php
                echo "<div><h6>Name: </h6>" . $speaker['Name'] . "</div><br>";
                echo "<div><h6>Description: </h6>" . $speaker['Description'] . "</div><br>";
                echo "<div><h6>Photo: </h6><img src='data:" . $speaker['ImageType'] . ";base64,"
                . base64_encode($speaker['Photo']) . "'></div><br>";
            ?>
        </div>
        <form method="post">
            <input hidden name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</body>
</html>