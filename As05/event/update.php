<?php
require "../require_login.php";
require "../shorthand.php";
require "../../database.php";

$speakerID = null;
$locationID = null;
$date = null;
$time = null;

$speakerError = null;
$locationError = null;
$dateError = null;
$timeError = null;

$valid = true;

$id = $_GET['id'];

// Gets the Event's current data.
$conn = DatabaseUtil::openConnection("as05");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = 'SELECT * FROM Events';
$preparedQuery = $conn->prepare($query);
$preparedQuery->execute(array());
DatabaseUtil::closeConnection();

if ($event = $preparedQuery->fetch(PDO::FETCH_ASSOC)) {
    $speakerID = $event['SpeakerID'];
    $locationID = $event['LocationID'];
    $date = $event['EventDate'];
    $time = $event['EventTime'];
}

if (!empty($_POST)) {

    $speakerID = $_POST['speaker'];
    $locationID = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Validates input.
    if (empty($speakerID)) {
        $speakerError = "Must select Speaker";
        $valid = false;
    }
    if (empty($locationID)) {
        $locationError = "Must select Location";
        $valid = false;
    }
    if (empty($date)) {
        $dateError = "Invalid Date";
        $valid = false;
    }
    if (empty($time)) {
        $timeError = "Invalid Time";
        $valid = false;
    }


    if ($valid) {
        $conn = DatabaseUtil::openConnection("as05");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = 'UPDATE Events SET SpeakerID=?, LocationID=?, EventDate=?, EventTime=? WHERE ID=?';
        $preparedQuery = $conn->prepare($query);
        $preparedQuery->execute(array($speakerID, $locationID, $date, $time, $id));
        DatabaseUtil::closeConnection();

        header("Location: list.php");
    }

}



?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - Update Event", "../");
?>
<body>
    <div class="container mt-2">
        <h1>Update Event</h1>
        <?php
            if (!$valid) {
                echo '<div class="card text-white bg-danger mb-3"><div class="card-body">';
                echo $speakerError ? $speakerError . "<br>" : "";
                echo $locationError ? $locationError . "<br>" : "";
                echo $dateError ? $dateError . "<br>" : "";
                echo $timeError ? $timeError . "<br>" : "";
                echo '</div></div>';
            }
        ?>
        <form method="post">
            <select name="speaker">
            <?php
                $conn = DatabaseUtil::openConnection("as05");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = 'SELECT ID, Name FROM Speakers';
                $preparedQuery = $conn->prepare($query);
                $preparedQuery->execute(array());
                DatabaseUtil::closeConnection();
                while ($speaker = $preparedQuery->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option " . ($speaker['ID'] == $speakerID ? " selected " : "") . " value='" . $speaker['ID'] . "'>" . $speaker['Name'] . "</option>";
                }
            ?>
            </select>
            <select name="location">
            <?php
                $conn = DatabaseUtil::openConnection("as05");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = 'SELECT ID, Name FROM Locations';
                $preparedQuery = $conn->prepare($query);
                $preparedQuery->execute(array());
                DatabaseUtil::closeConnection();
                while ($location = $preparedQuery->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option " . ($location['ID'] == $locationID ? " selected " : "") . " value='" . $location['ID'] . "'>" . $location['Name'] . "</option>";
                }
            ?>
            </select>
            <input type="date" name="date" value="<?php echo $date; ?>">
            <input type="time" name="time" value="<?php echo $time; ?>">
            <button type="submit" class="btn btn-primary float-left">Submit</button>
        </form>
    </div>
</body>
</html>