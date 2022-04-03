<?php
require_once('config.php');
session_start();
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}
if (isset($_SESSION["MAIL"]) && isset($_SESSION["MOT_DE_PASSE"])){
    $sql = "SELECT aliment.ID_ALIMENT, aliment.NOM, type_aliment.TYPE_ALIMENT FROM aliment INNER JOIN type_aliment ON type_aliment.ID_TYPE_ALIMENT = aliment.ID_TYPE_ALIMENT";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $array_values[] = $row;
        }
        echo json_encode($array_values);
    } else {
        echo json_encode([]);
    }
} else {
    header('Location: ../frontend/index.php');
}

$conn->close();