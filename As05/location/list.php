<?php
require "../require_login.php";
require "../../database.php";
?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - List of Locations", "../");
?>

<body>
    <div class="container mt-2">
        <h1>As05 - List of Locations</h1>
        <div><b>Current User: </b><?php echo $_SESSION['Username']; ?><br><b>Role: </b><?php echo $_SESSION['PermissionLevel'] >= 1 ? 'Administrator' : 'User' ?></div>
        <a href="../speaker/list.php"><button>Speakers</button></a>
        <a href="../location/list.php"><button>Locations</button></a>
        <a href="../event/list.php"><button>Events</button></a>
        <a href="../logout.php"><button class="btn btn-danger float-right">Logout</button></a>
        <a href="create.php"><button class="btn btn-success">Create</button></a>
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                    $conn = DatabaseUtil::openConnection("as05");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $query = 'SELECT * FROM Locations';
                    $preparedQuery = $conn->prepare($query);
                    $preparedQuery->execute(array());
                    DatabaseUtil::closeConnection();
                    while ($location = $preparedQuery->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $location['Name'] . "</td>";
                        echo "<td>" . $location['Description'] . "</td>";
                        if (strlen($location['Photo']) == 0) {
                            echo "<td></td>";
                        } else {
                            echo "<td><img style='max-height:30vh' src='data:" . $location['ImageType'] . ";base64,"
                            . base64_encode($location['Photo']) . "'></td>";
                        }
                        echo "<td>";
                        echo "<a href='read.php?id=" . $location['ID'] . "' ><button class='btn btn-primary'>Read</button></a>";
                        echo "<a href='update.php?id=" . $location['ID'] . "' ><button class='btn btn-dark'>Update</button></a>";
                        echo "<a href='delete.php?id=" . $location['ID'] . "' ><button class='btn btn-danger'>Delete</button></a>";

                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>