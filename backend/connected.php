<?php
session_start();

require_once('config.php');

$crit_login="MAIL";
$crit_pwd="MOT_DE_PASSE";

$conn = new mysqli($servername, $username, $password, $dbname);

$login = "anonymous";
$successfullyLogged = false;
if (isset($_SESSION["MAIL"])  && isset($_SESSION["MOT_DE_PASSE"])){
    $tryLogin=$_SESSION["MAIL"];
    $tryPwd=$_SESSION["MOT_DE_PASSE"];
    $sql = "SELECT NOM FROM utilisateur WHERE MAIL='$tryLogin' AND MOT_DE_PASSE='$tryPwd'";
    $result = $conn->query($sql);

    if($result->num_rows >0){
        $successfullyLogged = true;
        $login = $tryLogin;
    }

} else if (isset($_POST['MAIL']) && isset($_POST['MOT_DE_PASSE'])){
    $tryLogin=$_POST['MAIL'];
    $tryPwd=$_POST['MOT_DE_PASSE'];
    $sql = "SELECT NOM FROM utilisateur WHERE MAIL='$tryLogin' AND MOT_DE_PASSE='$tryPwd'";
    $result = $conn->query($sql);

    if($result->num_rows >0){
        $successfullyLogged = true;
        $login = $tryLogin;
    }
    } else
        header('Location: ../frontend/login.php');
if(!$successfullyLogged) {
    echo '<script type="text/javascript">'; 
    echo 'alert("Erreur d\'identifiant/mot de passe !");'; 
    echo 'window.location.href = "../frontend/login.php";';
    echo '</script>';
} else {
$sql = "SELECT * FROM utilisateur WHERE MAIL='$tryLogin' AND MOT_DE_PASSE='$tryPwd'";
$result = $conn->query($sql)->fetch_assoc();
$_SESSION["MAIL"]=$tryLogin;
$_SESSION["MOT_DE_PASSE"]=$tryPwd;
$_SESSION["NOM"]=$result["NOM"];
$_SESSION["PRENOM"]=$result["PRENOM"];
$_SESSION["AGE"]=$result["AGE"];
$_SESSION["ID_SEXE"]=$result["ID_SEXE"];
$_SESSION["ID_NIVEAU_DE_PRATIQUE_SPORTIVE"]=$result["ID_NIVEAU_DE_PRATIQUE_SPORTIVE"];
header('Location: ../frontend/index.php');
}

$conn->close();
?>