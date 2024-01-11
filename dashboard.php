<!--http://127.0.0.1/Station%20m%c3%a9t%c3%a9o/IOTmeteo/dashboard.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Page Web</title>
    <link rel="stylesheet" href="dashboard.css">





</head>
<body class="main-body">

<header class="site-header">
    <div class="header-container">
        <nav>
            <img src="image/TooboLogo.png" alt="Logo Mascotte">
            <h1>Station Toobo</h1>
            <form action="getData.php" method="post">
                <input type="submit" value="Deconnexion" />
            </form>
        </nav>
    </div>
</header>



<div class="content-body">
    <!-- Ajout de la colonne à gauche -->
    <aside class="left-column">
        <button>Sonde 1</button>
        <button>Sonde 2</button>
        <button>Sonde 3</button>
    </aside>

    <div class="dashboard">
        <h2>Tableau de bord</h2>
        <button id="toggleButton">Semaine/24h</button>
        <div class= "graph">
        <canvas id="lineCanvasTemp" aria-label="chart" role="img" width="500" height="500"></canvas>
        <canvas id="lineCanvasHumidité" aria-label="chart" role="img" width="500" height="500"></canvas>
        <canvas id="lineCanvasPression" aria-label="chart" role="img" width="500" height="500"></canvas>
        </div>
        <!-- <script src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script> -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script src="scriptdashboard.js"></script>
    </div>
</div>

</body>
</html>