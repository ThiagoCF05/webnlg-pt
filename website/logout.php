<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <?php 
        session_start();
        // remove all session variables
        session_unset(); 
        session_destroy();
        header("Location: index.php");
        die();
    ?>
</body>
</html>
