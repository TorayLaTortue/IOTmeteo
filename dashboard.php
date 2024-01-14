<!-- http://localhost/Station%20m%c3%a9t%c3%a9o/IOTmeteo/dashboard.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Page Web</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="dashboard.css">
    <?php include ("getData.php")?>
    <?php include 'navbar.php'; ?>

</head>


<body class="main-body">


<nav class="navbar flex-column navbar-expand-md navbar-light" style= "background-color: #e3f2fd; width: 9%; height: 100vh;">
  <!-- Brand -->
  <a class="navbar-brand" href="#">Sonde</a>

  <!-- Bouton de basculement pour les petits écrans -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Contenu de la barre de navigation -->
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav flex-column">
      <!-- Boutons -->
      <li class="nav-item mb-3">
        <a class="nav-link btn btn-primary bg-warning" href="#">Bouton 1</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-secondary bg-warning" href="#">Bouton 2</a>
      </li>
    </ul>
  </div>
</nav>


<div class="container mt-3">
    <div class="row ">

        <div class="col-lg-9">
            <div class="dashboard">
                <h2 class="mt-3">Tableau de bord</h2>
                <button id="toggleButton" class="btn btn-primary">Semaine/24h</button>
                <div class="graph mt-3">
                    <canvas id="lineCanvasTemp" aria-label="chart" role="img" width="500" height="500"></canvas>
                    <canvas id="lineCanvasHumidité" aria-label="chart" role="img" width="500" height="500"></canvas>
                    <canvas id="lineCanvasPression" aria-label="chart" role="img" width="500" height="500"></canvas>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
                <script src="scriptdashboard.js"></script>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
