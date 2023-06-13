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
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/isprobaj') ?>" title='Isprobaj'> Isprobaj </a></li>
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('GostController/prijaviSe') ?>" title='Prijava'> Prijava </a></li>
                        <li class='nav-item'><a class="nav-link loadContent" href="#" title='Registracija'>Registracija </a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/19.jpg');">
            <form name="registracija" action="<?php echo site_url('GostController/registrujSe') ?>" method="post">
                <div class="row">
                    <div class="col-sm-6 col-6">
                        <caption class="cap"><b>Licni podaci : </b></caption>
                    </div>
                    <div class="col-sm-6 col-6">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Ime:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="text" name="ime" size="20">
                        <?php echo form_error("ime", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Prezime:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="text" name="prezime" size="20">
                        <?php echo form_error("prezime", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Korisnicko ime:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="text" name="korime" size="20">
                        <?php echo form_error("korime", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        E-mail:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="email" name="email" size="40" placeholder="example@ex.com">
                        <?php echo form_error("email", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Lozinka:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="password" name="lozinka" size="20">
                        <?php echo form_error("lozinka", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Potvrdi lozinku:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="password" name="lozinkaPotvrda" size="20">
                        <?php echo form_error("lozinkaPotvrda", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Pol:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="radio" name="pol" value="M">Muski
                        <input type="radio" name="pol" value="Z">Zenski
                        <?php echo form_error("pol", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Smer:
                    </div>
                    <div class="col-sm-6 col-6">
                        <select name = "smer">
                            <option value="">Izaberite opciju</option>
                            <option value="SI">SI</option>
                            <option value="ER">ER</option>
                            <option value="RTI">RTI</option>
                            <option value="OF">OF</option>
                            <option value="OE">OE</option>
                            <option value="OG">OG</option>
                            <option value="OS">OS</option>
                            <option value="OT">OT</option>
                        </select>
                        <?php echo form_error("smer", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Godina studija:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="radio" name="godinaStudija" value="1">I
                        <input type="radio" name="godinaStudija" value="2">II
                        <input type="radio" name="godinaStudija" value="3">III
                        <input type="radio" name="godinaStudija" value="4">IV
                        <?php echo form_error("godinaStudija", "<font color='red'>", "</font>"); ?>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Datum rodjenja:
                    </div>
                    <div class="col-sm-6 col-6">
                        <select name = "dan" >
                            <option value="0"></option>
                            <option value="01">1</option>
                            <option value="02">2</option>
                            <option value="03">3</option>
                            <option value="04">4</option>
                            <option value="05">5</option>
                            <option value="06">6</option>
                            <option value="07">7</option>
                            <option value="08">8</option>
                            <option value="09">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                        </select>
                        <select name = "mesec">
                            <option value="0"></option>
                            <option value="01">1</option>
                            <option value="02">2</option>
                            <option value="03">3</option>
                            <option value="04">4</option>
                            <option value="05">5</option>
                            <option value="06">6</option>
                            <option value="07">7</option>
                            <option value="08">8</option>
                            <option value="09">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <input text="number" name="godina" maxlength="4" size="5">
                        <?php echo form_error("dan", "<font color='red'>", "</font>"); ?>
                        <?php echo form_error("mesec", "<font color='red'>", "</font>"); ?>
                        <?php echo form_error("godina", "<font color='red'>", "</font>"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">
                        Slika:
                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="file" id="myFile" name="filename">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6">

                    </div>
                    <div class="col-sm-6 col-6">
                        <input type="submit" value="Dalje" class="btn btn-lg btn-dark">
                    </div>
                </div>
            </form>

        </div>

        <div id="footer">
            <footer> Copyright 2019, Paripović Aleksandar, Milošević Milica, Panić Tijana, Mitrović Ksenija, Odsek za softversko inženjerstvo Elektrotehničkog fakulteta Univerziteta u Beogradu </footer>
        </div>
    </body>
</html>
