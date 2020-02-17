<?php
    
    require 'Database.php';
    
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: events.php");
    }
    
    if (!empty($_POST)) {
        // Keep track of validation errors.
        $dateError = null;
        $timeError = null;
        $locationError = null;
        $descriptionError = null;
        
        // Keep track of POST values.
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        
        // Validate input.
        $valid = true;
        if (empty($date)) {
            $dateError = "Please enter Event Date";
            $valid = false;
        }
        if (empty($time)) {
            $timeError = "Please enter Event Time";
            $valid = false;
        }
        
        if (empty($location)) {
            $locationError = "Please enter Event Location";
            $valid = false;
        }
        
        if (empty($description)) {
            $descriptionError = "Please enter Event Description";
            $valid = false;
        }
        
        // Insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE Events SET EventDate = ?, EventTime = ?, EventLocation = ?, EventDescription = ? WHERE Id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($date,$time,$location,$description,$id));
            Database::disconnect();
            header("Location: events.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Events where Id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $date = $data['EventDate'];
        $time = $data['EventTime'];
        $location = $data['EventLocation'];
        $description = $data['EventDescription'];
        Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="span10 offset1">
                <div class="row">
                    <h3>Update an Event</h3>
                </div>
                
                <form class="form-horizontal" action="events-update.php?id=<?php echo $id?>" method="post">
                    <div class="control-group <?php echo !empty($dateError) ? 'error' : ''; ?>">
                        <label class="control-label">Event Date</label>
                        <div class="controls">
                            <input name="date" type="date" value="<?php echo !empty($date) ? $date : ''; ?>">
                            <?php if (!empty($dateError)) : ?>
                                <span class="help-inline"><?php echo $dateError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($timeError) ? 'error' : ''; ?>">
                        <label class="control-label">Event Time</label>
                        <div class="controls">
                            <input name="time" type="time" value="<?php echo !empty($time) ? $time : ''; ?>">
                            <?php if (!empty($timeError)) : ?>
                                <span class="help-inline"><?php echo $timeError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($locationError) ? 'error' : ''; ?>">
                        <label class="control-label">Event Location</label>
                        <div class="controls">
                            <input name="location" type="text" placeholder="Location" value="<?php echo !empty($location) ? $location : ''; ?>">
                            <?php if (!empty($locationError)) : ?>
                                <span class="help-inline"><?php echo $locationError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group <?php echo !empty($descriptionError) ? 'error' : ''; ?>">
                        <label class="control-label">Event Description</label>
                        <div class="controls">
                            <input name="description" type="text" placeholder="Description" value="<?php echo !empty($description) ? $description : ''; ?>">
                            <?php if (!empty($descriptionError)) : ?>
                                <span class="help-inline"><?php echo $descriptionError; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a class="btn" href="events.php">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>