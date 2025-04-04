<?php
session_start();  // Start de sessie


// Verwijder alle sessievariabelen
session_unset();

// Vernietig de sessie
session_destroy();

// Redirect de gebruiker naar de loginpagina of een andere pagina
header("Location: register.php");
exit();
?>
