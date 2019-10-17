<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <?php 
        session_start();
        function get_ip(){
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
              $ip=$_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
              $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
              $ip=$_SERVER['REMOTE_ADDR'];
            }     
            return $ip;
        }

        $servername = "mysql.dcc.ufmg.br";
        $username = "felipealco";
        $password = "Queiph0a";
        $dbname = "felipealco";

        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $name = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["name"]))));
        $email = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["email"]))));
        $age = mysqli_real_escape_string($conn, $_POST["age"]);
        $sex = mysqli_real_escape_string($conn, $_POST["sex"]);
        $english_proficiency_level = mysqli_real_escape_string($conn, $_POST["english_proficiency_level"]);
        $educational_level = mysqli_real_escape_string($conn, $_POST["educational_level"]);

        $sql = "SELECT `email` FROM User WHERE `email` = '$email'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row

            $_SESSION["isSigned"] = true;
            header("Location: signed.php");
            die();
        }

        $ip = get_ip();
        $sql = "INSERT INTO User (name, email, age, sex, english_proficiency_level, educational_level, ip_address) VALUES ('$name', '$email', '$age', '$sex', '$english_proficiency_level', '$educational_level', '$ip')";
        // echo "\nSigning up: $sql";
        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT id FROM User WHERE name = '$name' AND age = '$age' AND sex = '$sex'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                $participant_id = $row["id"];

                $_SESSION["isSigned"] = true;
                $_SESSION["participant_id"] = $participant_id;
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $email;
                header("Location: annotation.php");
                die();
            }
        }

        $conn->close();
    ?>
</body>
</html>
