<<<<<<< HEAD
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spik & Span Tickets</title>
    <link rel="stylesheet" href="css/style.css">
      
</head>
<body>
    <div class="header">Spik & Span Tickets</div>
    <div class="banner">
        <p>De kampioenen van de nacht!</p>
        <h1>Bestel nu jouw tickets!</h1>
    </div>
    
    <div class="container">
        <div class="featured-ticket">
            <div class="featured-text">Geniet van Spik & Span!</div>
                <div class="buttons">
                    <a href="register.php">Registratie</a>
                    <a href="login.php">Inloggen</a>
                    <a href="">Bestel nu je tickets</a>
                </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
=======
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spik & Span Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000000;
            color: white;
            margin: 0;
            padding: 0;
        }
        .header {
            background: linear-gradient(90deg, #ffcc00, #00aaff, #ff0033);
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        .banner {
            height: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: bold;
            text-shadow: 3px 3px 15px rgba(0,0,0,0.8);
            color: white;
            background-color: #333;
            margin-bottom: 20px;
        }
        .container {
            max-width: 100%;
            margin: 20px auto;
            padding: 60px;
            color: white;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            background-color: #222;
            background-image: url('images/spikspan.jpg');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
        }
        .container h2 {
            color: #ff0033;
            font-size: 26px;
        }

        .featured-ticket {
            position: relative;
            max-width: 100%%;
            height: 400px;
            margin: 20px auto;
            overflow: hidden;
            border-radius: 10px;
            display: flex;
            
            
        }
        .featured-text {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
        }
        .featured-ticket button {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: #ffcc00;
            color: black;
            font-size: 18px;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .featured-ticket button:hover {
            background: #ffaa00;
            transform: scale(1.05);
        }
        .buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .buttons a {
    display: block;
    text-decoration: none;
    background-color: #ff8000;
    padding: 30px;
    text-align: center;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .buttons a:hover {
    background-color: #dbb020;
    transform: scale(1.1); 

  }
    </style>
</head>
<body>
    <div class="header">Spik & Span Tickets</div>
    <div class="banner">
        <p>De kampioenen van de nacht!</p>
        <h1>Bestel nu jouw tickets!</h1>
    </div>
    
    <div class="container">
        <div class="featured-ticket">
            <div class="featured-text">Geniet van Spik & Span!</div>
                <div class="buttons">
                    <a href="register.php">Registratie</a>
                    <a href="">Bestel nu je tickets</a>
                </div>
        </div>
    </div>
</body>
>>>>>>> 3a997ff59a51bc53a127aef5fb2c1159fa71ea92
</html>