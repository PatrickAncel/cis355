<?php
require "../require_login.php";
require "../shorthand.php";
require "../../database.php";

if (empty($_GET)) {
    header("Location: list.php");
}

$id = $_GET['id'];

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
    echoHTMLHead("As05 - View Location", "../");
?>
<body>
    <div class="container mt-2">
        <h1>View Location</h1>
        <div>
            <?php
                echo "<div><h6>Name: </h6>" . $location['Name'] . "</div><br>";
                echo "<div><h6>Description: </h6>" . $location['Description'] . "</div><br>";
                echo "<div><h6>Photo: </h6><img src='data:" . $location['ImageType'] . ";base64,"
                . base64_encode($location['Photo']) . "'></div><br>";
            ?>
        </div>
    </div>
</body>
</html>