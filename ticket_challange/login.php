<?php
session_start();


if (isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Je bent al ingelogd!');
        window.location.href ='ticket.php';
    </script>";
    exit();
}

// Databasegegevens
$servername = "localhost";
$username = "root";
$password = "Lijamar2312@";
$dbname = "db_ticket";

// Verbind met database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}

// Als formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Vul alle velden in.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, password FROM tb_ticket WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                header("Location: ticket.php");
                exit();
            } else {
                $error = "Ongeldig wachtwoord of gebruiker niet gevonden.";
            }
        } catch (PDOException $e) {
            die("Fout bij inloggen: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h1>Inloggen</h1>
        <form action="login.php" method="POST">
            <input type="text" name="email" class="input-field" placeholder="E-mailadres" required>
            <input type="password" name="password" class="input-field" placeholder="Wachtwoord" required>
            <button type="submit" name="login" class="login-button">Inloggen</button>
            <p>Nog geen account? <a href="register.php">Registreer hier</a></p>
        </form>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    </div>
</body>
</html>
