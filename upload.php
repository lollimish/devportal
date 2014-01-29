<?php

include 'define.php';


if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];

    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "<p>An error occurred.</p>";
        exit;
    }

    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
    session_start();
    //if (!isset($_SESSION['file_name'])) {
        $_SESSION['file_name'] = $name;
        $_SESSION['UPLOAD_DIR'] = UPLOAD_DIR;
        
    //}
    if (startsWith($name, "Input") || startsWith($name, "Errors") || startsWith($name, "ATT") || startsWith($name, "Opera") || startsWith($name, "Output") || startsWith($name, "Object")) {
        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(UPLOAD_DIR . $name)) {
            $i++;
            $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
        }

        // preserve file from temporary directory
        $success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
        if (!$success) {
            echo "<p>Unable to save file.</p>";
            exit;
        }
//        echo $name . '</br>';
//        echo $_FILES["myFile"]['size'] . ' bytes</br>';

        if (startsWith($name, "Input") || startsWith($name, "Output") || startsWith($name, "Object")) {
        echo '<script>window.location.href = "preview.php";</script>';
            
//header('Location: param_temp.php');
        }
        // set proper permissions on the new file
        chmod(UPLOAD_DIR . $name, 0644);
    } else {
        echo '<script>alert("Please follow the naming from devcontent/template.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
    }
}else{
    echo 'something happen';
}

?>
