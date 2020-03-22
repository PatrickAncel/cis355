<?php
require "../require_login.php";
require "../../database.php";

if (empty($_GET)) {
    header("Location: list.php");
}

$id = $_GET['id'];

// Gets the Event's current data.
$conn = DatabaseUtil::openConnection("as05");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = 'SELECT Events.ID as ID, Speakers.Name as SpeakerName, Locations.Name as LocationName, EventDate, EventTime FROM ((Speakers JOIN Events ON Speakers.ID=Events.SpeakerID) JOIN Locations ON Events.LocationID=Locations.ID)';
$preparedQuery = $conn->prepare($query);
$preparedQuery->execute(array());
DatabaseUtil::closeConnection();
?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - List of Events", "../");
?>

<body>
    <div class="container mt-2">
        <h1>View Event</h1>
        <?php
            if ($event =  $preparedQuery->fetch(PDO::FETCH_ASSOC)) {
                echo "<h6>Speaker</h6>" . $event["SpeakerName"] . "<br><br>";
                echo "<h6>Location</h6>" . $event["LocationName"] . "<br><br>";
                echo "<h6>Date</h6>" . $event["EventDate"] . "<br><br>";
                echo "<h6>Time</h6>" . $event["EventTime"] . "<br><br>";
            }
        ?>
    </div>
</body>
</html>