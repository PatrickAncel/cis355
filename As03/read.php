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
        $sql = "SELECT * FROM Customers where id = ?";
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
                        <h3>Read a Customer</h3>
                    </div>
                     
                    <table class="table table-bordered"><tbody>
                      <tr>
                        <th>Name</th>
                        <td><?php echo $data['Name'];?></td>
                      </tr>
                      <tr>
                        <th>Email Address</th>
                        <td>
                            <?php echo $data['Email'];?>
                        </td>
                      </tr>
                      <tr>
                        <th>Phone Number</th>
                        <td>
                            <?php echo $data['Mobile'];?>
                        </td>
                      </tr>
                    </tbody></table>
                    <div class="form-actions">
                        <a class="btn" href="customers.php">Back</a>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>