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
          <form>

            <!-- Email -->
            <div class="form-outline mb-4" data-mdb-input-init>
              <input type="username" id="form1Example13" class="form-control form-control-lg" />
              <label class="form-label" for="form1Example13">Username</label>
            </div>

            <!-- Password -->
            <div class="form-outline mb-4" data-mdb-input-init>
              <input type="password" id="form1Example23" class="form-control form-control-lg" />
              <label class="form-label" for="form1Example23">Password</label>
            </div>

            <!-- Opzioni -->
            <div class="d-flex justify-content-around align-items-center mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                <label class="form-check-label" for="form1Example3">Ricorda al prossimo login</label>
              </div>
              <!-- <a href="#!">Password dimenticata?</a> -->
            </div>

            <!-- Pulsante -->
            <button type="submit" class="btn btn-primary btn-lg btn-block" data-mdb-button-init data-mdb-ripple-init>
              Login
            </button>

            <br>
            <p>Non hai un account? <a href="#!" class="link-info">Registrati</a></p>

          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- MDBootstrap JavaScript -->
<script type="text/javascript" src="mdb/mdb.min.js"></script>

<!-- Script personalizzato -->
<script>
  // Esempio script placeholder
  console.log("Pagina di login caricata correttamente");
</script>

</body>
</html>
