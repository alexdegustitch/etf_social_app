<html>
    <head>
        <meta charset="utf-8">
        <title> ETF Social </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/index.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
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
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/index') ?>"  title='Info'> Info </a></li>
                        <li class='nav-item active'><a class="nav-link loadContent" href="#" title='Isprobaj'> Isprobaj </a></li>
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/prijaviSe') ?>" title='Prijava'> Prijava </a></li>
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/registrujSe') ?>" title='Registracija'>Registracija </a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/50.jpg');">

            <div class="row">
                <div class="col-sm-12" style="padding-top: 80px;">
                    <div class="par">
                        <form name="forma" action="<?php echo site_url('GostController/isprobajPitanje') ?>" method="get" >

                            <?php
                            if (isset($poruka)) {
                                echo "<font color='red'>" . $poruka . "</font>";
                                echo "<br/>";
                            }
                            ?>
                            Pitanje: 
                            <br/>
                            <select name = "Pitanja" >
                                <option value="0"> Izaberite pitanje </option>
                                <?php
                                foreach ($pitanja as $pitanje) {

                                    echo "<option value = '$pitanje->Sadrzaj'>" . $pitanje->Sadrzaj . "</option>";
                                }
                                ?>
                            </select>
                            <br> <br>

                            <select name = "Odgovori"> 
                                <option value="0" >Izaberite opciju</option>
                                <option value="Da">Da</option>
                                <option value="Ne">Ne</option>
                            </select>

                            <br> <br>
<?php
if (isSet($porukaPitanje) || isSet($porukaOdgovor)) {
    echo "<font color='red'>" . $porukaPitanje . " " . $porukaOdgovor . "</font>";
}
if (isSet($ukupno)) {
    if ($ukupno != 0) {
        $procenat = $brOdgovora / $ukupno * 100;
        $precision = 2;
        $procenatSkraceno = substr(number_format($procenat, $precision + 1, '.', ''), 0, -1);

        echo "Procenat korisnika koji su identicno odgovorili na dato pitanje je: " . $procenatSkraceno . " %";
    } else {
        echo "Niko jos nije odgovorio na ovo pitanje";
    }
}
?>
                            <input type="submit" name="Isprobaj" value="Isprobaj" onclick="" class="btn btn-dark btn-lg">
                        </form>

                    </div>
                </div>
            </div>


        </div>

        <div id="footer">
            <footer> Copyright 2019, Paripović Aleksandar, Milošević Milica, Panić Tijana, Mitrović Ksenija, Odsek za softversko inženjerstvo Elektrotehničkog fakulteta Univerziteta u Beogradu </footer>
        </div>
    </body>
</html>
