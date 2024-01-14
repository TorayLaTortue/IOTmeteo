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

<div class="container-fluid d-flex">
  <nav class="navbar flex-column navbar-expand-md navbar-light" style="background-color: #e3f2fd; width: 20%; min-height: 100vh; padding-top: 20px;">
  <button class="mb-3 btn btn-primary btn-lg bg-info" type="button" style= "background-size: cover;" value= "">Sonde :</button>

    <div class="d-grid gap-2 mx-auto">
  <button class="btn btn-primary" type="button">Sonde 1</button>
  <button class="btn btn-primary" type="button">Sonde 2</button>
</div>
  </nav>
  <div class="container-fluid d-flex mt-3">
    <div class="dashboard text-center">
      <h2 class="mt-3">Tableau de bord</h2>
      <button id="toggleButton" class="btn btn-primary">Semaine/24h</button>
      <div class="custom-padding-garph graph mt-3 justify-content-center d-flex flex-wrap">
        <canvas class="mt-5" id="lineCanvasTemp" aria-label="chart" role="img" width="500" height="500"></canvas>
        <canvas class="mt-5" id="lineCanvasHumidité" aria-label="chart" role="img" width="500" height="500"></canvas>
        <canvas class="mt-5" id="lineCanvasPression" aria-label="chart" role="img" width="500" height="500"></canvas>
      </div>
    </div>
  </div>
</div>

          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
          <script src="scriptdashboard.js"></script>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
