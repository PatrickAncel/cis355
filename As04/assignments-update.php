<?php
    
    require '../As03/Database.php';
    $oldCustomerId = null;
    $oldEventId = null;
    $newCustomerId = null;
    $newEventId = null;

    if ( !empty($_GET['oldCustomerId'])) {
        $oldCustomerId = $_REQUEST['oldCustomerId'];
    }

    if ( !empty($_GET['oldEventId'])) {
        $oldEventId = $_REQUEST['oldEventId'];
    }

    if (!empty($_POST)) {
        // Keep track of validation errors.
        $customerIdError = null;
        $eventIdError = null;
        $alreadyExistsError = null;

        // Keep track of POST values.
        $newCustomerId = $_POST['newCustomerId'];
        $newEventId = $_POST['newEventId'];
        $oldCustomerId = $_POST['oldCustomerId'];
        $oldEventId = $_POST['oldEventId'];
        
        // Validate input.
        $valid = true;
        if (empty($newCustomerId) || $newCustomerId == '-1') {
            $customerIdError = "Please select a Customer";
            $valid = false;
        }
        if (empty($newEventId) || $newEventId == '-1') {
            $eventIdError = "Please select an Event";
            $valid = false;
        }
        
        
        if ($valid) {
            // Tests if the selected Customer is already assigned to the selected Task.
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) AS AssignmentCount FROM Assignments WHERE CustomerId=? AND EventId=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($newCustomerId, $newEventId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

            if (0 + $data['AssignmentCount'] > 0) {
                $alreadyExistsError = "The selected person is already assigned to the selected task";
                $valid = false;
            }
        }
        // Update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE Assignments SET CustomerId=?, EventId=? WHERE CustomerId=? AND EventId=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($newCustomerId, $newEventId, $oldCustomerId, $oldEventId));
            Database::disconnect();
            // echo "UPDATE Assignments SET CustomerId=$newCustomerId, EventId=$newEventId WHERE CustomerId=$oldCustomerId AND EventId=$oldEventId";
            header("Location: assignments.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="../As03/bootstrap.min.css" rel="stylesheet">
        <script src="../As03/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="span10 offset1">
                <div class="row">
                    <h3>Update an Assignment</h3>
                </div>
                <?php if (!empty($alreadyExistsError)) { ?> 
                    <div class="alert alert-danger" role="alert">
                        <?php echo $alreadyExistsError; ?>
                    </div>
                 <?php } ?>
                <form class="form-horizontal" action="assignments-update.php" method="post">
                    <input name="oldCustomerId" value="<?php echo $oldCustomerId; ?>" hidden readonly />
                    <input name="oldEventId" value="<?php echo $oldEventId; ?>" hidden readonly />
                    <div class="form-group <?php echo !empty($customerIdError) ? 'error' : ''; ?>">
                        <label>Select Customer</label>
                        <select class="form-control" name="newCustomerId">
                            <?php
                                $pdo = Database::connect();
                                $sql = 'SELECT Name, Id FROM Customers';
                                foreach ($pdo->query($sql) as $row) {
                                    echo "<option value='" . $row['Id'] . "'" . ($row['Id'] == $oldCustomerId ? " selected " : "" ) . ">" . $row['Name'] . "</option>";
                                }
                                Database::disconnect();
                            ?>
                        </select>
                    </div>
                    <div class="form-group <?php echo !empty($eventIdError) ? 'error' : ''; ?>">
                        <label>Select Event</label>
                        <select class="form-control" name="newEventId">
                            <?php
                                $pdo = Database::connect();
                                $sql = 'SELECT EventDescription, Id FROM Events';
                                foreach ($pdo->query($sql) as $row) {
                                    echo "<option value='" . $row['Id'] . "'" . ($row['Id'] == $oldEventId ? " selected " : "" ) . ">" . $row['EventDescription'] . "</option>";
                                }
                                Database::disconnect();
                            ?>
                        </select>
                    </div>
                    

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a class="btn" href="assignments.php">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>