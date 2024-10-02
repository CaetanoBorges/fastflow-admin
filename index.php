<!-- inicialize the db -->
<?php

session_start();
if (isset($_SESSION['REST-admin'])) {

    error_reporting(0);
    include("backEnd/FERRAMENTAS/AX.php");
    include("backEnd/FERRAMENTAS/dbWrapper.php");
    include("backEnd/FERRAMENTAS/Funcoes.php");

    $funcoes = new Funcoes;
    $db = new dbWrapper($funcoes::conexao());

    $metadata = $_SESSION['metadata'];

    // Converte os dados para JSON
    $dados_json = json_encode($metadata);
    $usuario = AX::attr($_SESSION["metadata"]["usuario"]);
    // Imprime o valor diretamente no script JavaScript
    echo "<script>var dadosUsuario = $dados_json;</script>";
    $mesas = $db->select()->from("mesa")->where(["usuario=$usuario"])->pegaResultados();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Inicio</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="assets/modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- nav include here-->
      <?php include("nav.php"); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
                    <div class="section-header">
                        <h1></h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div>
                                <div >
                                    <?php
                                    foreach ($mesas as $k => $v) {
                                        $hoje = date("d-m-Y");
                                        $mesa = $v["numeromesa"];
                                        $totalHoje = $db->select(["SUM(total)"])->from("conta")->where(["usuario=$usuario","quando LIKE '%$hoje%'","fechado='1'","mesa='$mesa'"])->pegaResultado()["SUM(total)"];
                                        $cor = "#6777ef";
                                        $codigo = " &nbsp;";
                                        if($v["ocupada"]){
                                            $cor="#990000";
                                            $codigo = $v["codigo"];
                                        }
                                        $params=md5(time()).'='.md5(time()*time())."&opt=".$v["numeromesa"];
                                    ?>
                                    <a href="mesa.php?<?php echo $params; ?>" style="text-decoration:none;">
                                        <div style="position:relative;width: 200px;height:200px;margin:10px;padding:10px;display:inline-block;border:1px solid <?php echo $cor; ?>;border-radius:5px;">
                                            <p style="font-size: 40px;font-weight:bold;color: <?php echo $cor; ?>"><?php echo $v["numeromesa"] ?></p>
                                            <p style="font-size: 15px;font-weight:bold;color: <?php echo $cor; ?>"><?php echo $codigo ?></p>
                                            <p style="font-size: 15px;font-weight:bold;position:absolute; bottom:-13px;left:10px;font-weight:bolder;color:#00000050"><?php echo $totalHoje ?></p>
                                            
                                        </div> 

                                    </a>
                                        
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </section>
      </div>
      <!-- footer include here -->
      <?php 
        include("footer.php");
      ?>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="assets/modules/cleave-js/dist/cleave.min.js"></script>
  <script src="assets/modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
  <script src="assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="assets/modules/select2/dist/js/select2.full.min.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } else { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>REST - THE BEST</title>
    </head>

    <body>
        <form action="BackEnd/Administrador/entrar.php" method="post">
            <section class="vh-100" style="background-color: #ffffff;">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card shadow-2-strong" style="border-radius: 1rem;">
                                <div class="card-body p-5 text-center">

                                    <h3 class="mb-5">Login</h3>

                                    <div class="form-outline mb-4">
                                        <input type="email" id="typeEmailX-2" name="email" class="form-control form-control-lg" placeholder="Email" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="typePasswordX-2" name="passe" class="form-control form-control-lg" placeholder="Palavra passe" required />

                                    </div>
                                    <div class="form-outline mb-4">
                                        <a href="receber_codigo.php" style="color:red;text-decoration:none;">
                                            <p>Esqueci a passe</p>
                                        </a>
                                    </div>


                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Entrar</button>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    </html>

<?php }
