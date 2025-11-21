<?php 
include("config.php");
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Sito sviluppato nel primo semestre 2025-2026 - M306 - Made by Kilian Righetti">
  <meta name="keywords" content="HTML, CSS, JS, PHP">
  <meta name="author" content="Kilian Righetti">
  <title>Wallpaper Downloader</title>

  <!-- MDBootstrap CSS -->
  <link rel="stylesheet" href="mdb/mdb.min.css" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"/> -->

  <!-- CSS personalizzato -->
  <link rel="stylesheet" type="text/css" href="login_register_css.css">

  <style>
    /* Bordo visibile anche se MDB non viene inizializzato */
    .form-control {
      border: 1px solid #ccc !important;
      border-radius: 6px;
      padding: 10px;
      background-color: #fff;
      color: #000;
    }

    .form-control:focus {
      border-color: #007bff !important;
      box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
    }

    body {
      background-color: #f5f5f5;
    }
  </style>
</head>
<body>

<div id="main">
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <!-- Titolo Registrazione -->
          <h2 class="text-center mb-4">REGISTRATI</h2>

          <form action="/WallpaperDownloader/register_process.php" method="POST">
            <!-- Username -->
            <div class="form-outline mb-4" data-mdb-input-init>
              <input type="username" name="username" class="form-control form-control-lg" required />
              <label class="form-label" for="username">Username</label>
            </div>

            <!-- Password -->
            <div class="form-outline mb-4" data-mdb-input-init>
              <input type="password" name="password" class="form-control form-control-lg" required/>
              <label class="form-label" for="password">Password</label>
            </div>

            <!-- Password ripetuta -->
              <div class="form-outline mb-4" data-mdb-input-init>
              <input type="password" name="repeatedPassword" class="form-control form-control-lg" required/>
              <label class="form-label" for="password">Ripeti la password</label>
            </div>


            <!-- Pulsante -->
            <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn_subit">
              Registrati
            </button>

            <br>
            <p>Hai già un account? <a href="login.php" class="link-info">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="mdb/mdb.umd.min.js"></script>
</body>
</html>