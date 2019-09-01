<?php
$direccionInclude = "views/include/scope.".$_SESSION['INCLUDE']['ASIDE'].".php";
?>
<!DOCTYPE html>
<html lang="ES" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Biomatic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">


  <link rel="shortcut icon" href="views/assets/image/logo.png">


  <link rel="stylesheet" href="views/assets/lib/jquery-ui/jquery-ui.css">
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

  <link rel="stylesheet" href="views/assets/lib/datatables/jquery.dataTables.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->

  <link href="views/assets/lib/fontawesome/css/all.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"> -->

  <link rel="stylesheet" href="views/assets/lib/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="views/assets/lib/xtreme/dist/css/style.min.css" rel="stylesheet">
  <!-- libreria exportar javascript a pdf -->
  <script src="views/assets/lib/JsPdf/jspdf.min.js"></script>


  <script type="text/javascript" src="views/assets/lib/canvas/html2canvas.js"></script>
  <script type="text/javascript" src="views/assets/lib/canvas/html2canvas.min.js"></script>

  <!-- <script src="views/assets/lib/JsPdf/jspdf.plugin.autotable.min.js"></script> -->
  <!-- libreria graficas google -->
  <script type="text/javascript" src="views/assets/lib/charts/loader.js"></script>


  <link rel="stylesheet" href="views/assets/css/main.css">

</head>

<body>
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

    <header>
      <?php require_once "views/include/scope.menutop.php"; ?>
    </header>
    <?php require_once $direccionInclude; ?>
    <div class="page-wrapper">
      <div class="container-fluid content">
        <div class="row">
          <div class="col-12">
            <div class="card">