<?php

require "require_login.php";

?>


<!DOCTYPE html>
<?php
    require("html_head.php");
    echoHTMLHead("As05 - Homepage", "");
?>
<body>
    <div class="container mt-2">
        <h1>As05</h1>
        <div><b>Current User: </b><?php echo $username; ?><br><b>Role: </b><?php echo $permission >= 1 ? 'Administrator' : 'User' ?></div>
        <a href="speaker/list.php"><button>Speakers</button></a>
        <a href="location/list.php"><button>Locations</button></a>
        <a href="event/list.php"><button>Events</button></a>
    </div>
</body>
</html>