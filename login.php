<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <?php 
        session_start();
        $servername = "mysql.dcc.ufmg.br";
        $username = "felipealco";
        $password = "Queiph0a";
        $dbname = "felipealco";

        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $email = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["email"]))));

        $sql = "SELECT `id`, `name`, `email` FROM User WHERE `email` = '$email'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $participant_id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];

            $_SESSION["isSigned"] = true;
            $_SESSION["participant_id"] = $participant_id;
            $_SESSION["email"] = $email;
            header("Location: annotation.php");
            die();
        } else {
            $_SESSION["isSigned"] = false;
            header("Location: signed.php");
            die();
        }

        $conn->close();
    ?>
</body>
</html>
