<?php

require("../../database.php");

$usernameError = false;
$passwordError = false;
$passwordConfirmError = false;
$valid = true;

if (!empty($_POST)) {


    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    if (strlen($username) == 0) {
        $usernameError = "Must have username";
        $valid = false;
    }
    if (strlen($password) == 0) {
        $passwordError = "Must have password";
        $valid = false;
    }
    else if (strcmp($password, $passwordConfirm) != 0) {
        $passwordConfirmError = "Passwords do not match";
        $valid = false;
    }

    if ($valid) {
        // Tests for existing user in the database.
        $conn = DatabaseUtil::openConnection("as05");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT Username FROM Users WHERE Username=? LIMIT 1";
        $preparedQuery = $conn->prepare($query);
        $preparedQuery->execute(array($username));
        DatabaseUtil::closeConnection();

        if ($preparedQuery->fetch(PDO::FETCH_ASSOC))
        {
            $usernameError = "Username already taken";
            $valid = false;
        }
        else
        {
            $passwordHash = MD5($password . $username);

            // Inserts new user into the database.
            $conn = DatabaseUtil::openConnection("as05");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = 'INSERT INTO Users (Username, PasswordHash, PermissionLevel) VALUES (?, ?, 0)';
            $preparedQuery = $conn->prepare($query);
            $preparedQuery->execute(array($username, $passwordHash));
            DatabaseUtil::closeConnection();

            session_start();

            $_SESSION['Username'] = $username;
            $_SESSION['PermissionLevel'] = 0;

            header("Location: ../event/list.php");
        }
    }
}

?>

<!DOCTYPE html>
<?php
    require("../html_head.php");
    echoHTMLHead("As05 - Create Account", "../");
?>
<body>
    <div class="container mt-2">
        <h1>Create Account</h1>
        <?php
            // Error stuff might go here
        ?>
        <form method="post">
            <div class="form-group">
                <label for="usernameInput">Username</label>
                <input type="text" name="username" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>"
                    id="usernameInput" value="<?php echo !empty($username) ? $username : ''; ?>">
                <?php if (!empty($usernameError)) { ?>
                    <span class="invalid-feedback"><?php echo $usernameError; ?></span>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="passwordInput">Password</label>
                <input type="password" name="password" class="form-control <?php echo !empty($passwordError) ? 'is-invalid' : ''; ?>" id="passwordInput">
                <?php if (!empty($passwordError)) { ?>
                    <span class="invalid-feedback"><?php echo $passwordError; ?></span>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="passwordConfirmInput">Confirm Password</label>
                <input type="password" name="passwordConfirm" class="form-control <?php echo !empty($passwordConfirmError) ? 'is-invalid' : ''; ?>" id="passwordConfirmInput">
                <?php if (!empty($passwordConfirmError)) { ?>
                    <span class="invalid-feedback"><?php echo $passwordConfirmError; ?></span>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary float-left">Submit</button>
        </form>
        <a href="../login.php"><button class="btn btn-secondary ml-1">Go to Sign-in Page</button></a>
    </div>
</body>
</html>
