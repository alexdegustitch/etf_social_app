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
    <body onload='init()'>
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
                        <li class='nav-item'><a class="nav-link loadContent" href="<?php echo site_url('AdminController/index') ?>"  title='Info'> Moj profil </a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container" style="background-image: url('http://localhost/social/images/50.jpg');">
            <div class="col-sm-12 col-md-6 col-lg-6">



                <form name="myForm" id='myForm' onsubmit="validateForm()" action='<?php echo site_url('AdminController/potvrdiDodavanjePitanja') ?>' method="get">

                    <div class ='row'>

                        Pitanje: 
                        <input type="text" size="50" name='pitanje'>
                        <?php echo form_error("pitanje", "<font color='red'>", "</font>"); ?>



                    </div>

                    <div class="row">

                        <div class="col-sm-6 col-6">
                            <?php 
                            if(isset($poruka)){
                                echo "<font color = 'red' >".$poruka."</font> <br/>";
                            }
                            ?>
                            Ljubavni partner: 
                            <select name = 'ljp'>
                                <option value='0'> 0 </option> 
                                <option value='1'> 1 </option>
                                <option value='2'> 2 </option> 
                                <option value='3'> 3 </option>
                                <option value='4'> 4 </option>
                                <option value='5'> 5 </option> 
                            </select>
                            poena
                            <br/>
                            Poslovni partner: 
                            <select name = 'pp'>
                                <option value='0'> 0 </option> 
                                <option value='1'> 1 </option>
                                <option value='2'> 2 </option> 
                                <option value='3'> 3 </option>
                                <option value='4'> 4 </option>
                                <option value='5'> 5 </option> 
                            </select>
                            poena
                            <br/>
                            Prijatelj: 
                            <select name = 'p'>
                                <option value='0'> 0 </option> 
                                <option value='1'> 1 </option>
                                <option value='2'> 2 </option> 
                                <option value='3'> 3 </option>
                                <option value='4'> 4 </option>
                                <option value='5'> 5 </option> 
                            </select>
                            poena

                            
                        </div>
                    </div>
                    <div class='row'>

                        <p>
                            <!--<a href="javascript:void(0);" onclick="addElement();">Add</a>
                            <a href="javascript:void(0);" onclick="removeElement();">Remove</a>-->
                            <input type='button' name='Dodaj odgovor' value='Dodaj odgovor' class="btn btn-lg btn-dark" onclick="addElement();">
                            <input type='button' name='Ukloni odgovor' value='Ukloni odgovor' class="btn btn-lg btn-dark" onclick="removeElement();">
                        </p>

                    </div>
                    <div>
                        <div id="content">
                            <div id='div_1'>
                                Odgovor 1:
                                <input type="text" id="odg1" name ="odg1">
                            </div>
                            <div id='div_2'>
                                Odgovor 2:
                                <input type="text" id="odg2" name ="odg2">
                            </div>
                        </div>
                    </div>
                    <div class="row" >

                        <input type='submit' name='prikazi' value='Dodaj pitanje' class="btn btn-lg btn-dark"> &nbsp;
                        <a href="<?php echo site_url('AdminController/index') ?>"> <input type='button' name='nazad' value='Vrati se nazad'  class="btn btn-lg btn-dark"> </a>
                        <input type="hidden" id="brojOdg" name="brojOdg" value="2">


                    </div>




            </div>

        </form>
    </div>

    <div id="footer">
        <footer> Copyright 2019, Paripović Aleksandar, Milošević Milica, Panić Tijana, Mitrović Ksenija, Odsek za softversko inženjerstvo Elektrotehničkog fakulteta Univerziteta u Beogradu </footer>
    </div>

    <script>
        document.getElementById("dodajOdgovor").onclick = function () {
            var form = document.getElementById("myForm");
            var input = document.createElement("input");
            input.type = "text";
            var br = document.createElement("br");
            form.appendChild(input);
            form.appendChild(br);
        }

        var intTextBox;
        function init() {
            intTextBox = 2;
            //alert("broj=" + intTxtBox.toString());
            document.cookie = 'broj = 5';
        }

        function getBr() {
            return intTextBox;
        }
        /**
         * Function to add textbox element dynamically
         * First we incrementing the counter and creating new div element with unique id
         * Then adding new textbox element to this div and finally appending this div to main content.
         */
        function addElement() {
            if (intTextBox === 12) {
                alert('Pitanje moze imati maksimalno 12 odgovora');
            } else {
                intTextBox++;
                document.getElementById("brojOdg").value = intTextBox;

                var objNewDiv = document.createElement('div');
                objNewDiv.setAttribute('id', 'odg' + intTextBox);
                objNewDiv.innerHTML = 'Odgovor ' + intTextBox + ': <input type="text" id="odg' + intTextBox + '" name="odg' + intTextBox + '"/>';
                document.getElementById('content').appendChild(objNewDiv);
            }
        }

        /**
         * Function to remove textbox element dynamically
         * check if counter is more than zero then remove the div element with the counter id and reduce the counter
         * if counter is zero then show alert as no existing textboxes are there
         */
        function removeElement() {
            if (2 < intTextBox) {
                document.getElementById('content').removeChild(document.getElementById('odg' + intTextBox));
                intTextBox--;
                document.getElementById("brojOdg").value = intTextBox;
            } else {
                alert("Pitanje mora imati najmanje dva odgovora");
            }
        }


    </script>
</body>

</html>

