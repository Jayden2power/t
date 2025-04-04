<?php
session_start();

// Als de gebruiker al is ingelogd, doorsturen naar ticket.php
if (isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Je bent al ingelogd!');
        window.location.href = 'ticket.php';
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('images/spikspan.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .input-field {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .input-field:focus {
            border-color: rgb(255, 0, 0);
            outline: none;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background-color: rgb(255, 145, 0);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: rgb(179, 131, 0);
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Inloggen</h1>
        <form action="login.php" method="POST">
            <input type="text" name="email" class="input-field" placeholder="E-mailadres" required>
            <input type="password" name="password" class="input-field" placeholder="Wachtwoord" required>
            <button type="submit" name="login" class="login-button">Inloggen</button>
        </form>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    </div>
</body>
</html>
