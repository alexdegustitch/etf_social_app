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
                        <li class='nav-item '><a class="nav-link loadContent" href="<?php echo site_url('GostController/index') ?>"  title='Info'> Info </a></li>
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/isprobaj') ?>" title='Isprobaj'> Isprobaj </a></li>
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/prijaviSe') ?>" title='Prijava'> Prijava </a></li>
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/registrujSe') ?>" title='Registracija'>Registracija </a></li>
                        <!-- <li class='nav-item dropdown'>
                             <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" title='Profil'>
                                 Profil
                             </a>
                             <div class="dropdown-menu">
                                 <a class="dropdown-item" href="#"> Obrisi </a>
                                 <a class="dropdown-item" href="index.html"> Izloguj se </a>
                                 <a class="dropdown-item" href="izmeniProfil.html"> Izmeni </a>
                                 <a class="dropdown-item" href="vip.html"> Postani VIP </a>
                                 <a class="dropdown-item" href="izmeniOdg.html"> Izmeni odgovore </a>
                             </div>
                         </li>-->
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/50.jpg');" id="backSlika1">
            <form name="izmenaOdg" action="<?php echo site_url('GostController/registrujSePitanja/')?>" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <ol>
                            <br/>
                            <?php
                            if(isset($poruka)){
                                echo "<font color='red'>".$poruka."</font> <br/>";
                            }
                            for ($i = 0; $i < count($pitanja); $i++) {
                                $m = $i + 1;

                                echo $m . ". " . $pitanja[$i]->Sadrzaj . "<br/>";
                                //var_dump($odgovori[$i]);
                                for ($j = 0; $j < count($odgovori[$i]) - 1; $j++) {
                                    $odgovor = $odgovori[$i][$j];
                                    $value = str_replace(' ', '', $pitanja[$i]->Sadrzaj);
                                    $value = substr($value, 0, -1);
                                    $value = str_replace("'", "", $value);

                                    echo "<input type = 'radio' name = '" . $value . "' value = '" . $odgovor->IdOdgovor . "'>" . $odgovor->TekstOdgovora . "<br/>";
                                }
                                echo form_error("pol", "<font color='red'>", "</font>");
                                echo "</li>";
                            }
                            ?>
                        </ol>

                        <input type='submit' name='registracija' value='Registruj se' class="btn btn-lg btn-dark">
                    </div>
                </div>
            </form>
        </div>

        <div id="footer">
            <footer> Copyright 2019, Paripović Aleksandar, Milošević Milica, Panić Tijana, Mitrović Ksenija, Odsek za softversko inženjerstvo Elektrotehničkog fakulteta Univerziteta u Beogradu </footer>
        </div>
    </body>
</html>
