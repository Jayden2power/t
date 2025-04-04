
<?php
ob_start();

$servername = "localhost";

$username = "root";

$password = "Lijamar2312@";

$dbname = "db_ticket";

try {
    
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinding: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

  
    if (empty($email) || empty($password)) {
        echo "Alle velden zijn verplicht.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ongeldig e-mailadres.";
    } else {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Voorbereide SQL-query
            $sql = "INSERT INTO tb_ticket (email, password) VALUES (:email, :password)";
            $stmt = $pdo->prepare($sql);

            // Waarden binden
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            // Query uitvoeren
            $stmt->execute();

            echo "Registratie succesvol!";
        } catch (PDOException $e) {
            echo "Fout bij opslaan: " . $e->getMessage();
        }
    }
    $stmt->execute();
    header("Location: ticket.php");
    exit();
    ob_end_flush();

}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratiepagina</title>
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

        .registration-container {
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
            border-color:rgb(255, 0, 0);
            outline: none;
        }

        .submit-button {
            width: 100%;
            padding: 10px;
            background-color:rgb(255, 136, 0);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color:rgb(179, 131, 0);
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h1>Registreren</h1>
        <form method="POST" action="">
            <input type="email" id="email" name="email" class="input-field" placeholder="E-mailadres" required><br>
            <input type="password" id="password" name="password" class="input-field" placeholder="Wachtwoord" required><br>
            <button type="submit" class="submit-button">Registreren</button>
        </form>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    </div>
</body>
</html>
