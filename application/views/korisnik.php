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
        <script type="text/javascript" src="https://cdn.emailjs.com/sdk/2.3.2/email.min.js"></script>
        <script type="text/javascript">
            (function () {
                emailjs.init("user_gMoSsIEkwj5RnQOKLgrp4");
            })();
        </script>
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
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php
                            if ($admin == 1) {
                                echo site_url('AdminController/index');
                            } else {
                                echo site_url('KorisnikController/index');
                            }
                            ?>"  title='Info'> Moj profil </a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/50.jpg');">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6" style="padding: 50px;">
                    <img id="profilnaSlika" src="<?php
                    if ($slika != null) {
                        echo "http://localhost/social/images/" . $slika;
                    } else {
                        echo "http://localhost/social/images/user_image.png";
                    }
                    ?>" alt="nema slike" width="160px" height="160px" style="border-radius: 50%;" class="img-fluid mx-auto d-block ">
                    <p style="text-align: center; font-family:'Helvetica';" class="fontovi">
                        <br>

                        <?php
                        echo "@" . $username . "<br/>" . $ime . " " . $prezime;
                        ?>
                    </p>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6" style="padding: 50px;">

                    <table class="table table-dark table-striped" >
                        <tr id="prvired">
                            <td> SMER: </td>
                            <td id="prvakol">
                                <input type="label" value="<?php echo $smer ?>" size="25" disabled="disabled">
                            </td>
                        </tr>
                        <tr id="drugired">
                            <td> GODINA: </td>
                            <td id="drugakol">
                                <input type="label" value="<?php echo $godina ?>" size="25" disabled="disabled">
                            </td>
                        </tr>
                        <tr id="trecired">
                            <td> &nbsp; </td>
                            <td id="trecakol">

                                <form name="forma" action ="<?php
                                if ($zapracen) {
                                    if ($admin == 1) {
                                        echo site_url('AdminController/otprati/') . $username;
                                    } else {
                                        echo site_url('KorisnikController/otprati/') . $username;
                                    }
                                } else {
                                    if ($admin == 1) {
                                        echo site_url('AdminController/zaprati/') . $username;
                                    } else {
                                        echo site_url('KorisnikController/zaprati/') . $username;
                                    }
                                }
                                ?>" method ="post">
                                    <input type="submit" name="zaprati" value="<?php
                                    if ($zapracen) {
                                        echo "Otprati";
                                    } else {
                                        echo "Zaprati";
                                    }
                                    ?>" class="btn btn-lg btn-dark">

                                </form>
                            </td>
                        </tr>
                        <tr id="cetvrtired">
                            <td> &nbsp; </td>
                            <td id="cetvrtakol">
                                <form name='forma' id='forma' action='<?php
                                if ($admin == 1) {
                                    echo site_url('AdminController/potvrdiSlanje/') . $username;
                                } else {
                                    echo site_url('KorisnikController/potvrdiSlanje/') . $username;
                                }
                                ?>' method="post">

                                    <input type="button" name="posalji" onclick="posaljiPoruku()" value="Posalji poruku" class="btn btn-lg btn-dark"> 
                                    <input type='hidden' id = 'skriven' name = 'brojKontakt' value='<?php echo $brojKontaktiranja; ?>'>
                                </form>   
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <div id="footer">
            <footer> Copyright 2019, Paripović Aleksandar, Milošević Milica, Panić Tijana, Mitrović Ksenija, Odsek za softversko inženjerstvo Elektrotehničkog fakulteta Univerziteta u Beogradu </footer>
        </div>

        <script>
            function posaljiPoruku() {
                var node = document.getElementById('skriven');
                if (node.value < 5) {
                    var poruka = confirm("Klikom na 'OK' potvrdjujete da zelite da posaljete poruku. Danas ste poslali poruku " + <?php echo $brojKontaktiranja; ?>  + " puta. Maksimalan broj poruka\n\
                koje mozete poslati u toku dana je 5.");
                    if (poruka == true) {
                        var text = '<?php echo $email; ?>';
                        var body = 'Zdravo ' + '<?php echo $ime; ?>';
                        node.value++;
                        var win = window.open('mailto:' + text + '?subject=SocialETF&body=' + body);
                        
                        document.getElementById("forma").submit();
                        setTimeout(function () {
                            win.close()
                        }, 1);
                        //alert('prosao!');
                    }
                } else {
                    alert('Poslali ste maksimalan broj dozvoljenih poruka!');
                }
            }

        </script>
    </body>
</html>


