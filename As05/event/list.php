<?php
require "../require_login.php";
require "../../database.php";
?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - List of Events", "../");
?>

<body>
    <div class="container mt-2">
        <h1>As05 - List of Events</h1>
        <div><b>Current User: </b><?php echo $_SESSION['Username']; ?><br><b>Role: </b><?php echo $_SESSION['PermissionLevel'] >= 1 ? 'Administrator' : 'User' ?></div>
        <a href="../speaker/list.php"><button>Speakers</button></a>
        <a href="../location/list.php"><button>Locations</button></a>
        <a href="../event/list.php"><button>Events</button></a>
        <a href="../logout.php"><button class="btn btn-danger float-right">Logout</button></a>
        <a href="create.php"><button class="btn btn-success">Create</button></a>
        <table class="table">
            <thead>
                <th>Speaker</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                    $conn = DatabaseUtil::openConnection("as05");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $query = 'SELECT Events.ID as ID, Speakers.Name as SpeakerName, Locations.Name as LocationName, EventDate, EventTime FROM ((Speakers JOIN Events ON Speakers.ID=Events.SpeakerID) JOIN Locations ON Events.LocationID=Locations.ID)';
                    $preparedQuery = $conn->prepare($query);
                    $preparedQuery->execute(array());
                    DatabaseUtil::closeConnection();
                    while ($event = $preparedQuery->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $event['SpeakerName'] . "</td>";
                        echo "<td>" . $event['LocationName'] . "</td>";
                        echo "<td>" . $event['EventDate'] . "</td>";
                        echo "<td>" . $event['EventTime'] . "</td>";
                        
                        echo "<td>";
                        echo "<a href='read.php?id=" . $event['ID'] . "' ><button class='btn btn-primary'>Read</button></a>";
                        echo "<a href='update.php?id=" . $event['ID'] . "' ><button class='btn btn-dark'>Update</button></a>";
                        echo "<a href='delete.php?id=" . $event['ID'] . "' ><button class='btn btn-danger'>Delete</button></a>";

                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>