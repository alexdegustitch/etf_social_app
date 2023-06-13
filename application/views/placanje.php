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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
                font-family: Arial;
                font-size: 17px;

            }

            * {
                box-sizing: border-box;
            }

            .row {
                display: -ms-flexbox; /* IE10 */
                display: flex;
                -ms-flex-wrap: wrap; /* IE10 */
                flex-wrap: wrap;
                margin: 0 -16px;
            }

            .col-25 {
                -ms-flex: 25%; /* IE10 */
                flex: 25%;
            }

            .col-50 {
                -ms-flex: 50%; /* IE10 */
                flex: 50%;
            }

            .col-75 {
                -ms-flex: 75%; /* IE10 */
                flex: 75%;
            }

            .col-25,
            .col-50,
            .col-75 {
                padding: 0 16px;
            }

            .container {
                background-color: #f2f2f2;
                padding: 5px 20px 15px 20px;
                border: 1px solid lightgrey;
                border-radius: 3px;
            }

            input[type=text] {
                width: 100%;
                margin-bottom: 20px;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }

            label {
                margin-bottom: 10px;
                display: block;
            }

            .icon-container {
                margin-bottom: 20px;
                padding: 7px 0;
                font-size: 24px;
            }

            .btn {
                background-color: #4CAF50;
                color: white;
                padding: 12px;
                margin: 10px 0;
                border: none;
                width: 100%;
                border-radius: 3px;
                cursor: pointer;
                font-size: 17px;
            }

            .btn:hover {
                background-color: #45a049;
            }

            a {
                color: #2196F3;
            }

            hr {
                border: 1px solid lightgrey;
            }

            span.price {
                float: right;
                color: grey;
            }

            /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
            @media (max-width: 800px) {
                .row {
                    flex-direction: column-reverse;
                }
                .col-25 {
                    margin-bottom: 20px;
                }
            }
        </style>
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
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('KorisnikController/index') ?>"  title='Info'> Moj profil </a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/50.jpg'), url('http://localhost/social/images/50.jpg');" id='slikaPlacanje'>
            <div class="pom">

                <div class="row">
                    <div class="col-75">
                        <div class="container">
                            <form action="<?php echo site_url('KorisnikController/uplati') ?>" method='post'>

                                <div class="col-100" s>
                                    <label for="fname">Odobrene kartice</label>
                                    <div class="icon-container">
                                        <i class="fa fa-cc-visa" style="color:navy;"></i>
                                        <i class="fa fa-cc-amex" style="color:blue;"></i>
                                        <i class="fa fa-cc-mastercard" style="color:red;"></i>
                                        <i class="fa fa-cc-discover" style="color:orange;"></i>
                                    </div>
                                    <label for="cname">Ime na kartici</label>
                                    <input type="text"  name="ime" placeholder="<?php echo $ime ?>"><br/>
                                    <?php echo form_error("ime", "<font color='red'>", "</font>"); ?>
                                    <div class='row'>
                                        <div class="col-50">
                                            <label for="ccnum">Broj bankovne kartice</label>
                                            <input type="text"  name="brojKartice" placeholder="1111-2222-3333-4444">
                                        </div>
                                        <div class="col-25">
                                            <label for="cvv">CVV</label>
                                            <input type="text"  name="cvv" placeholder="352">
                                        </div>
                                        <div class='col-25'>
                                            <label for="expmonth">Mesec isteka</label>
                                            <input type="text" name="mesecIsteka" placeholder="06">
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="col-50">
                                            <?php echo form_error("brojKartice", "<font color='red'>", "</font>"); ?>
                                        </div>
                                        <div class="col-25">
                                            <?php echo form_error("cvv", "<font color='red'>", "</font>"); ?>
                                        </div>
                                        <div class='col-25'>
                                            <?php echo form_error("mesecIsteka", "<font color='red'>", "</font>"); ?>
                                        </div>
                                    </div>

                                </div>
                                <label>
                                    Na koliko dugo zelite da se pretplatite? (sve vrednosti su izrazene u dinarima) <br/>
                                    <input type="radio" checked="checked" name="cena" value ='1'> 1 dan, Cena: <?php echo "<font color='orange'>" . $cenaDan . "</font>"; ?> <br/>
                                    <input type="radio"  name="cena" value="2"> 1 nedelja, Cena: <?php echo "<font color='orange'>" . $cenaNedeljuDana . "</font>"; ?> <br/>
                                    <input type="radio"  name="cena" value='3'> 1 mesec, Cena: <?php echo "<font color='orange'>" . $cenaMesecDana . "</font>"; ?> <br/>
                                    <input type="radio"  name="cena" value='4'> 1 godina, Cena: <?php echo "<font color='orange'>" . $cenaGodinuDana . "</font>"; ?> <br/>
                                </label>
                                <input type="submit" value="Pretplati se" class="btn btn-lg btn-dark">
                                </div>


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
