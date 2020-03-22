<?php

require("../database.php");

session_start();

$signinFailed = false;

if (!empty($_POST)) {

    $username = $_POST['username'];
    $passwordHash = MD5($_POST['password'] . $_POST['username']);

    // Tests for existing user in the database.
    $conn = DatabaseUtil::openConnection("as05");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT Username, PermissionLevel FROM Users WHERE Username=? AND PasswordHash=? LIMIT 1";
    $preparedQuery = $conn->prepare($query);
    $preparedQuery->execute(array($username, $passwordHash));
    DatabaseUtil::closeConnection();

    // Tries to get record from query result.
    $record = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    if ($record)
    {
        $_SESSION['Username'] = $record['Username'];
        $_SESSION['PermissionLevel'] = $record['PermissionLevel'];

        header("Location: event/list.php");
    }
    else
    {
        $signinFailed = true;
    }
}

?>

<!DOCTYPE html>
<?php
    require("html_head.php");
    echoHTMLHead("As05 - Sign in", "");
?>
<body>
    <div class="container mt-2">
        <h1>Sign In</h1>
        <?php 
            if ($signinFailed) {
                echo '<div class="card text-white bg-danger mb-3"><div class="card-body"><b>Sign-in Failed: </b>Username or password is incorrect.</div></div>';
            }
        ?>
        <form method="post">
            <div class="form-group">
                <label for="usernameInput">Username</label>
                <input type="text" name="username" class="form-control" id="usernameInput" value="<?php echo !empty($username) ? $username : ''; ?>">
            </div>
            <div class="form-group">
                <label for="passwordInput">Password</label>
                <input type="password" name="password" class="form-control" id="passwordInput">
            </div>
            <button type="submit" class="btn btn-primary float-left">Sign in</button>
        </form>
        <a href="user/create.php"><button class="btn btn-secondary ml-1">Create Account</button></a>
    </div>
</body>
</html>