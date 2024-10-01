<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir un compte</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: rgb(0, 0, 64);
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .account {
            width: 200px;
            padding: 20px;
            margin: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .account:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .account img {
            width: 100px;
            height: 100px;
            display: block;
            margin: 0 auto 15px;
        }

        .account p {
            margin: 0;
            font-size: 18px;
        }

        footer {
            background-color: rgb(0, 0, 64);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .logo img {
            width: 80px;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #555;
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo">
            <img src="images/logo/logo.png" alt="Logo">
        </div>
        <div class="title">
            <h1>Choisissez un type de compte</h1>
        </div>
        <div class="dropdowns">
            <div class="dropdown">
                <button class="dropbtn">Langue</button>
                <div class="dropdown-content">
                    <a href="#">Français</a>
                    <a href="#">Anglais</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Pays</button>
                <div class="dropdown-content">
                    <a href="#">France</a>
                    <a href="#">USA</a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="account" id="employee">
        <img src="images/employer.png" alt="Compte Employé">
        <p>Employé</p>
    </div>
    <div class="account" id="agence">
        <img src="images/agence.png" alt="Compte Client">
        <p>Entreprise</p>
    </div>
    <div class="account" id="immigration">
        <img src="images/imm.jpg" alt="Compte immigration">
        <p>Candidat à l'immigration</p>
    </div>
    <div class="account" id="partenaire">
        <img src="images/parte.jpg" alt="Compte Partenaire">
        <p>Compte Partenaire</p>
    </div>
</div>

<div class="container">
    <div class="account" id="tele">
        <img src="images/tele.png" alt="Compte Télévendeur">
        <p>Télévendeur</p>
    </div>
    <div class="account" id="admin">
        <img src="images/adminn.jpg" alt="Compte Administrateur">
        <p>Administrateur</p>
    </div>
    <div class="account" id="client">
        <img src="images/client.png" alt="Compte client">
        <p>Compte client</p>
    </div>
    <div class="account" id="marketing">
        <img src="images/market.jpg" alt="Compte Centre marketing">
        <p>Compte marketing</p>
    </div>
</div>

<footer>
    <p>&copy; 2024 Mon Site</p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accounts = [
        {id: 'employee', message: 'Vous avez choisi le compte Employé', url: 'login.php'},
        {id: 'agence', message: 'Vous avez choisi le compte Agence à l\'immigration', url: 'login.php'},
        {id: 'immigration', message: 'Vous avez choisi le compte Candidat à l\'immigration', url: 'login.php'},
        {id: 'partenaire', message: 'Vous avez choisi le compte Partenaire', url: 'login.php'},
        {id: 'tele', message: 'Vous avez choisi le compte Télévendeur', url: 'login.php'},
        {id: 'admin', message: 'Vous avez choisi le compte Administrateur', url: 'login.php'},
        {id: 'client', message: 'Vous avez choisi le compte Client', url: 'login.php'},
        {id: 'marketing', message: 'Vous avez choisi le compte Centre marketing', url: 'login.php'}
    ];

    accounts.forEach(account => {
        const element = document.getElementById(account.id);
        if (element) {
            element.addEventListener('click', function() {
                alert(account.message);
                window.location.href = account.url;
            });
        }
    });
});
</script>
</body>
</html>
