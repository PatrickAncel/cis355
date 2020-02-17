<?php
    require 'Database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: customers.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Events where Id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Read an Event</h3>
                    </div>
                     
                    <table class="table table-bordered"><tbody>
                        <tr>
                            <th>Date</th>
                            <td><?php echo $data['EventDate']?></td>
                        </tr>
                        <tr>
                            <th>Time</th>
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
                        <a class="btn" href="events.php">Back</a>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>