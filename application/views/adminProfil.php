<html>
    <head>
        <meta charset="utf-8">
        <title> ETF Social </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/index.css">
        <script src="<?php echo base_url(); ?> javascript/javascript.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    </head>

    <body onload=' <?php
    //var_dump($zahtev);
    if (isset($pitanja)) {
        if ($pitanja == false) {
            echo 'myFunction()';
        }
    }
    ?>'>
        <div id="header">
            <h1 class="display-3" style="padding-top: 30px;">
                ETF Social
                <img id="logo" src="http://localhost/social/images/logo2.png" class="img-fluid">
            </h1>

        </div>

        <div id="menu" >
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#myMenu" aria-controls="myMenu"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="myMenu">
                    <ul class='nav navbar-nav'>
                        <li class='nav-item dropdown'>
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" title='Profil'>
                                Profil
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('AdminController/izmeniProfil/') ?>"> Izmeni profil </a>
                                <a class="dropdown-item" href="<?php echo site_url('AdminController/izmeniOdgovore/') ?>"> Izmeni odgovore </a>
                                <a class="dropdown-item" href="<?php echo site_url('AdminController/dodajPitanje/') ?>"> Dodaj pitanje </a>
                                <a class="dropdown-item" href="<?php echo site_url('AdminController/obrisiPitanje/') ?>"> Obrisi pitanje </a>
                                <a class="dropdown-item" href="<?php echo site_url('AdminController/brisanje/') ?>"> Zahtevi za brisanje </a>
                                <a class="dropdown-item" href="<?php echo site_url('AdminController/izlogujSe/') ?>"> Izloguj se </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/50.jpg');">

            <div class = "row">
                <div class = "col-sm-12 col-md-4 col-lg-4">
                    <h4 style = "padding: 20px; padding-top: 80px; text-align: justify;"> <i> ZAPRACENI KORISNICI: </i> </h4>
                    <p class = "par" style = "border: 1px dotted; ">
                        <!--<a href = "http://www.google.com"> @neca </a> <br>
                        <a href = "http://www.google.com" > @neca </a> <br>
                        <a href = "http://www.google.com"> @xenia97</a> <br>
                        <a href = "http://www.google.com"> @mmilica</a> <br> -->
                        <?php
                        foreach ($zapraceni as $zapracen) {
                            echo "<a href='" . site_url('AdminController/posetiProfil/') . $zapracen . "'> @" . $zapracen . " </a> <br/>";
                        }
                        ?>
                    </p>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <img id="profilnaSlika" src="<?php
                    if ($slika != null) {
                        echo "http://localhost/social/images/" . $slika;
                    } else {
                        echo "http://localhost/social/images/user_image.png";
                    }
                    ?>" alt="nema slike" width="160px" height="160px" style="border-radius: 50%;" class="img-fluid mx-auto d-block ">
                    <p style="text-align: center; font-family:'Helvetica';" class="fontovi">
                        <br>
                        <?php echo "@" . $username; ?>
                        <br>
                        <?php echo $ime . " " . $prezime; ?>

                    </p>
                    <form name="formaSlika" action="<?php echo site_url('AdminController/promeniSliku') ?>" method="get">
                        <center>
                            <input type="file" id="myFile" name="filename">

                            <br/>

                            <input type="submit" name="promeniSliku" value="Promeni sliku" class="btn btn-lg btn-dark">
                        </center>
                    </form>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4" style="padding: 20px; padding-top: 100px; ">
                    <form name="podaci" action="<?php echo site_url('AdminController/upari') ?>" method="post">
                        <table class="table table-dark table-striped" >
                            <tr id="prvired">
                                <td> E-MAIL: </td>
                                <td id="prvakol">
                                    <input type="label" value="<?php echo $email; ?>" size="25" disabled="disabled">
                                </td>
                            </tr>
                            <tr id="drugiired">
                                <td> POL: </td>
                                <td id="drugakol">
                                    <input type="label" value="<?php
                                    if ($pol == "Z") {
                                        echo 'Zenski';
                                    } else {
                                        echo 'Muski';
                                    };
                                    ?>" size="25" disabled="disabled">
                                </td>
                            </tr>
                            <tr id="trecired">
                                <td> SMER: </td>
                                <td id="trecakol">
                                    <input type="label" value="<?php echo $smer; ?>" size="25" disabled="disabled">
                                </td>
                            </tr>
                            <tr id="cetvrtired">
                                <td> GODINA: </td>
                                <td id="cetvrtakol">
                                    <input type="label" value="<?php
                                    switch ($godina) {
                                        case 1: echo "I";
                                            break;
                                        case 2: echo "II";
                                            break;
                                        case 3: echo "III";
                                            break;
                                        case 4: echo "IV";
                                            break;
                                    }
                                    ?>" size="25" disabled="disabled">

                                </td>
                            </tr>
                            <tr id="petired">
                                <td> DATUM: </td>
                                <td id="petakol">
                                    <input type="label" value="<?php
                                    $datum = strtotime($datum);
                                    $date = getdate($datum);
                                    echo $date['mday'] . ". " . $date['month'] . " " . $date['year'];
                                    ?>" size="25" disabled="disabled">
                                </td>
                            </tr>
                            <tr id="sestired">
                                <td> &nbsp; </td>
                                <td id="sestakol">
                                    <input type="submit" name="upariMe" value="Upari me" class="btn btn-lg btn-dark">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

        </div>

        <div id="footer">
            <footer> Copyright 2019, Paripović Aleksandar, Milošević Milica, Panić Tijana, Mitrović Ksenija, Odsek za softversko inženjerstvo Elektrotehničkog fakulteta Univerziteta u Beogradu </footer>
        </div>

        <script>
function myFunction() {
    alert("Dodata su neka nova pitanja. Kliknite na 'OK' kako biste odgovorili na njih.");
    window.location.replace("<?php echo site_url('AdminController/odgovoriNaPitanja') ?>");


}
        </script>
    </body>
</html>
