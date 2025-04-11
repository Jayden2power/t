<?php
ob_start();

$servername = "localhost";

$username = "root";

$password = "password";

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
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="registration-container">
        <h1>Registreren</h1>
        <form method="POST" action="">
            <input type="email" id="email" name="email" class="input-field" placeholder="E-mailadres" required><br>
            <input type="password" id="password" name="password" class="input-field" placeholder="Wachtwoord" required><br>
            <button type="submit" class="submit-button">Registreren</button>
            <p>Al een account <a href="login.php">Hier inloggen</a></p>
        </form>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    </div>
</body>
</html>