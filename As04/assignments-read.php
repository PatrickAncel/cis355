<?php
    require '../As03/Database.php';
    $customerId = null;
    $eventId = null;

    if ( !empty($_GET['customerId'])) {
        $customerId = $_REQUEST['customerId'];
    }
    
    if ( !empty($_GET['eventId'])) {
        $eventId = $_REQUEST['eventId'];
    }

    if ( null==$customerId || null==$eventId ) {
        header("Location: assignments.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT Name, CustomerId, EventId, Name, Email, Mobile, EventDate, EventTime, EventLocation, EventDescription 
                FROM ((Customers JOIN Assignments ON Customers.Id=Assignments.CustomerId) JOIN Events ON Assignments.EventId=Events.Id) 
                HAVING CustomerId=? AND EventId=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($customerId, $eventId));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../As03/bootstrap.min.css" rel="stylesheet">
    <script src="../As03/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Read an Event</h3>
                    </div>
                     
                    <table class="table table-bordered"><tbody>
                        <tr>
                            <th>Customer Name</th>
                            <td><?php echo $data['Name'] ?></td>
                        </tr>
                        <tr>
                            <th>Customer Email</th>
                            <td><?php echo $data['Email'] ?></td>
                        </tr>
                        <tr>
                            <th>Customer Phone Number</th>
                            <td><?php echo $data['Mobile'] ?></td>
                        </tr>
                        
                        <tr>
                            <th>Event Date</th>
                            <td><?php echo $data['EventDate']?></td>
                        </tr>
                        <tr>
                            <th>Event Time</th>
                            <td><?php echo $data['EventTime']?></td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td><?php echo $data['EventLocation']?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo $data['EventDescription']?></td>
                        </tr>
                    </tbody></table>
                    <div class="form-actions">
                        <a class="btn" href="assignments.php">Back</a>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>