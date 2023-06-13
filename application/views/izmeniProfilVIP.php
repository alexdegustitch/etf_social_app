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
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('VipController/index') ?>"  title='Info'> Moj profil </a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/50.jpg');">
            <form name="izmenaProf" action="<?php echo site_url('VipController/izmeni') ?>" method="post" >
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-6 col-6">
                        <p class="pomPar"> Ime: </p>
                    </div>
                    <div class="col-sm-6 col-6" >
                        <input type='text' name='ime' placeholder="<?php echo $ime ?>" size='20'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6" >
                        <p class="pomPar"> Prezime: </p>
                    </div>
                    <div class="col-sm-6 col-6" >
                        <input type='text' name='prezime' placeholder="<?php echo $prezime ?>" size='20'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6" >
                        <p class="pomPar"> Korisničko ime: </p>
                    </div>
                    <div class="col-sm-6 col-6" >
                        <input type='text' name='korime' placeholder="<?php echo $username ?>" size='20'>
                        <?php
                        if(isset($poruka)){
                            echo "<font color='red'>".$poruka."</font>";
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6" >
                        <p class="pomPar"> Pol: </p>
                    </div>
                    <div class="col-sm-6 col-6" >
                       
                        
                        <input type='radio' name='pol' value='M' <?php if ($pol == 'M') {echo "checked"; }?>> muški
                        <br/>
                        <input type='radio' name='pol' value='Z' <?php if ($pol == 'Z') {echo "checked"; }?>> ženski
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6" >
                        <p class="pomPar"> Smer: </p>
                    </div>
                    <div class="col-sm-6 col-6" >
                        <select name='smer'>
                            <option value="SI"<?php if ($smer == 'SI') {echo "checked"; }?>>SI</option>
                            <option value="ER"<?php if ($smer == 'ER') {echo "checked"; }?>>ER</option>
                            <option value="RTI"<?php if ($smer == 'RTI') {echo "checked"; }?>>RTI</option>
                            <option value="OF"<?php if ($smer == 'OF') {echo "checked"; }?>>OF</option>
                            <option value="OE"<?php if ($smer == 'OE') {echo "checked"; }?>>OE</option>
                            <option value="OG"<?php if ($smer == 'OG') {echo "checked"; }?>>OG</option>
                            <option value="OS"<?php if ($smer == 'OS') {echo "checked"; }?>>OS</option>
                            <option value="OT"<?php if ($smer == 'OT') {echo "checked"; }?>>OT</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6" >
                        <p class="pomPar"> Godina: </p>
                    </div>
                    <div class="col-sm-6 col-6" >
                        <input type='radio' name='godina' value='1' <?php if ($godina == 1) {echo "checked"; }?>>I</option>
                        <input type='radio' name='godina' value='2' <?php if ($godina == 2) {echo "checked"; }?>>II
                        <input type='radio' name='godina' value='3' <?php if ($godina == 3) {echo "checked"; }?>>III
                        <input type='radio' name='godina' value='4' <?php if ($godina == 4) {echo "checked"; }?>>IV
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6" >
                        <p class="pomPar"> Datum: </p>
                    </div>
                    <div class="col-sm-6 col-6" >
                        <select name = "dan" >
                            <option value="0"></option>
                            <option value="01"<?php if ($dan == '1') {echo "selected"; }?> >1</option>
                            <option value="02"<?php if ($dan == '2') {echo "selected"; }?>>2</option>
                            <option value="03"<?php if ($dan == '3') {echo "selected"; }?>>3</option>
                            <option value="04"<?php if ($dan == '4') {echo "selected"; }?>>4</option>
                            <option value="05"<?php if ($dan == '5') {echo "selected"; }?>>5</option>
                            <option value="06"<?php if ($dan == '6') {echo "selected"; }?>>6</option>
                            <option value="07"<?php if ($dan == '7') {echo "selected"; }?>>7</option>
                            <option value="08"<?php if ($dan == '8') {echo "selected"; }?>>8</option>
                            <option value="09"<?php if ($dan == '9') {echo "selected"; }?>>9</option>
                            <option value="10"<?php if ($dan == '10') {echo "selected"; }?>>10</option>
                            <option value="11"<?php if ($dan == '11') {echo "selected"; }?>>11</option>
                            <option value="12"<?php if ($dan == '12') {echo "selected"; }?>>12</option>
                            <option value="13"<?php if ($dan == '13') {echo "selected"; }?>>13</option>
                            <option value="14"<?php if ($dan == '14') {echo "selected"; }?>>14</option>
                            <option value="15"<?php if ($dan == '15') {echo "selected"; }?>>15</option>
                            <option value="16"<?php if ($dan == '16') {echo "selected"; }?>>16</option>
                            <option value="17"<?php if ($dan == '17') {echo "selected"; }?>>17</option>
                            <option value="18"<?php if ($dan == '18') {echo "selected"; }?>>18</option>
                            <option value="19"<?php if ($dan == '19') {echo "selected"; }?>>19</option>
                            <option value="20"<?php if ($dan == '20') {echo "selected"; }?>>20</option>
                            <option value="21"<?php if ($dan == '21') {echo "selected"; }?>>21</option>
                            <option value="22"<?php if ($dan == '22') {echo "selected"; }?>>22</option>
                            <option value="23"<?php if ($dan == '23') {echo "selected"; }?>>23</option>
                            <option value="24"<?php if ($dan == '24') {echo "selected"; }?>>24</option>
                            <option value="25"<?php if ($dan == '25') {echo "selected"; }?>>25</option>
                            <option value="26"<?php if ($dan == '26') {echo "selected"; }?>>26</option>
                            <option value="27"<?php if ($dan == '27') {echo "selected"; }?>>27</option>
                            <option value="28"<?php if ($dan == '28') {echo "selected"; }?>>28</option>
                            <option value="29"<?php if ($dan == '29') {echo "selected"; }?>>29</option>
                            <option value="30"<?php if ($dan == '30') {echo "selected"; }?>>30</option>
                            <option value="31"<?php if ($dan == '31') {echo "selected"; }?>>31</option>
                        </select>
                        <select name = "mesec">
                            <option value="0"></option>
                            <option value="01"<?php if ($mesec == '1') {echo "selected"; }?>>1</option>
                            <option value="02"<?php if ($mesec == '2') {echo "selected"; }?>>2</option>
                            <option value="03"<?php if ($mesec == '3') {echo "selected"; }?>>3</option>
                            <option value="04"<?php if ($mesec == '4') {echo "selected"; }?>>4</option>
                            <option value="05"<?php if ($mesec == '5') {echo "selected"; }?>>5</option>
                            <option value="06"<?php if ($mesec == '6') {echo "selected"; }?>>6</option>
                            <option value="07"<?php if ($mesec == '7') {echo "selected"; }?>>7</option>
                            <option value="08"<?php if ($mesec == '8') {echo "selected"; }?>>8</option>
                            <option value="09"<?php if ($mesec == '9') {echo "selected"; }?>>9</option>
                            <option value="10"<?php if ($mesec == '10') {echo "selected"; }?>>10</option>
                            <option value="11"<?php if ($mesec == '11') {echo "selected"; }?>>11</option>
                            <option value="12"<?php if ($mesec == '12') {echo "selected"; }?>>12</option>
                        </select>
                        <input type='text' name='godinadatum' placeholder="<?php echo $godinadatum ?>" size='5'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-6" >

                    </div>
                    <div class="col-sm-6 col-6" >
                        <a href="profil.html">
                            <input type='submit' name='sacuvaj' value='Sačuvaj promene' class="btn btn-dark btn-lg">
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div id="footer">
            <footer> Copyright 2019, Paripović Aleksandar, Milošević Milica, Panić Tijana, Mitrović Ksenija, Odsek za softversko inženjerstvo Elektrotehničkog fakulteta Univerziteta u Beogradu </footer>
        </div>
    </body>
</html>
