<?php
    require '../As03/Database.php';
    $customerId = null;
    $eventId = null;
     
    if ( !empty($_GET['CustomerId'])) {
        $customerId = $_REQUEST['CustomerId'];
    }
     
    if ( !empty($_GET['EventId'])) {
        $eventId = $_REQUEST['EventId'];
    }

    if ( !empty($_POST)) {
        // keep track post values
        $customerId = $_POST['CustomerId'];
        $eventId = $_POST['EventId'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM Assignments WHERE CustomerId=? AND EventId=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($customerId, $eventId));
        Database::disconnect();
        header("Location: assignments.php");
         
    }
    else
    {
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
                        <h3>Delete an Assignment</h3>
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
                    <form class="form-horizontal" action="assignments-delete.php" method="post">
                      <input type="hidden" name="CustomerId" value="<?php echo $customerId;?>"/>
                      <input type="hidden" name="EventId" value="<?php echo $eventId;?>"/>
                      <p class="alert alert-error">Are you sure you want to delete?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="assignments.php">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>