<?php
    session_start();

    define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST') . ':' . getenv('OPENSHIFT_MYSQL_DB_PORT'));
    define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
    define('DB_PASSWORD',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
    define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

    $db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $myusername = mysqli_real_escape_string($db,$_POST['usernameinput']);

        $mypassword = mysqli_real_escape_string($db,$_POST['passwordinput']);
        $mypassword = md5($mypassword);

        $sql = "SELECT * FROM admin WHERE admin_email = '$myusername'";
        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        if($count == 1) {
            $sql = "SELECT * FROM admin WHERE admin_email = '$myusername' and admin_password = '$mypassword'";
            $result = mysqli_query($db,$sql);
            $count = mysqli_num_rows($result);
            if($count == 1) {
                $_SESSION['login_user'] = $myusername;
                header("location: ../index.php");
            }else {
                echo "Password error.";
            }
        }else{
            echo "Username error.";
        }


    }

?>
