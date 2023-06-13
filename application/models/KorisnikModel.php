<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * KorisnikModel - klasa za rad sa podacima iz tabele 'korisnik'
 * 
 * @version 1.0
 * 
 * @author Aleksandar Paripovic 2016/417
 */

class KorisnikModel extends CI_Model {

    //put your code here

    public $korisnik;

    /**
     * Kreiranje nove instance
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Funkcija za dohvatanje korisnika sa zadatim usernamom
     *
     * @param string $korime Korime
     *
     * @return true or false
     *
     */
    public function dohvatiKorisnika($korime) {
        $query = $this->db->get_where('korisnik', array('username' => $korime));
        $korisnik = $query->row();
        if ($korisnik != null) {
            $this->korisnik = $korisnik;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Funkcija za proveru proveru lozinke korisnika
     *
     * @param string $lozinka Lozinka
     *
     * @return true ako je lozinka tacna, false ako nije
     *
     */
    
    public function proveriLozinku($lozinka) {
        return ($this->korisnik->Password === $lozinka);
    }

    /**
     * Funkcija za postavljanje podataka korisnika
     *
     * @param string $ime Ime
     * @param string $prezime Prezime
     * @param string $korime Korime
     * @param string $email Email
     * @param string $lozinka Lozinka
     * @param string $pol Pol
     * @param int $smer Smer
     * @param int $godinaStudija GodinaStudija
     * @param date $datum Datum
     * @param string $slika Slika
     * 
     * @return Response
     *
     */
    
    public function postaviKorisnika($ime, $prezime, $korime, $email, $lozinka, $pol, $smer, $godinaStudija, $datum, $slika) {
        $date = date_format($datum, "Y-m-d");
        $this->korisnik = array(
            'Ime' => $ime,
            'Prezime' => $prezime,
            'Username' => $korime,
            'Password' => $lozinka,
            'E_mail' => $email,
            //'admin' => $admin,
            'Pol' => $pol,
            'Smer' => $smer,
            'Godina_studija' => $godinaStudija,
            'brojkontaktiranja' => 0,
            'brisanje' => 0,
            'DatumRodjenja' => $date,
            'Slika' => $slika
        );

        $this->korisnik = (object) $this->korisnik;
        $korisnik = $this->korisnik;
        $this->session->set_userdata('korisnik', $korisnik);
    }

    /**
     * Funkcija za dodavanje korisnika u tabelu 'korisnik'
     *
     *
     *
     * @return true 
     *
     */
    
    public function dodajKorisnika() {
        //$date = DateTime::createFromFormat('Y-d-m',$datum)->format('Y-m-d');
        //$date = date_format($datum, "Y-m-d");
        $korisnik = $this->session->korisnik;
        date_default_timezone_set("Europe/Belgrade");
        //echo "The time is " . date("h:i:sa");
        //var_dump(date('Y-m-d'));
        $date = date('Y-m-d');
        //var_dump($korisnik);
        $data = array(
            'ime' => $korisnik->Ime,
            'prezime' => $korisnik->Prezime,
            'username' => $korisnik->Username,
            'password' => $korisnik->Password,
            'e_mail' => $korisnik->E_mail,
            'admin' => 0,
            'pol' => $korisnik->Pol,
            'smer' => $korisnik->Smer,
            'godina_studija' => $korisnik->Godina_studija,
            'brojkontaktiranja' => 0,
            'datumresetovanja' => $date,
            'brisanje' => 0,
            'datumrodjenja' => $korisnik->DatumRodjenja,
            'slika' => $korisnik->Slika,
        );

        $this->db->insert('korisnik', $data);

        $query = $this->db->get_where('korisnik', array('username' => $korisnik->Username));
        $korisnikUpit = $query->row();
        $this->session->set_userdata('korisnik', $korisnikUpit);
        return true;
    }

    /**
     * Funkcija za postavljanje zahteva za brisanje u tabeli 'korisnik'
     *
     * @param string $username Username
     *
     * @return true ako je uspesno postavljen, false ako nije(vec je bio postavljen)
     *
     */
    
    public function postaviZahtev($username) {
        $this->db->set('brisanje', 1, FALSE);
        $this->db->where('username', $username);
        $this->db->update('korisnik');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Funkcija za promenu informacija o korisniku
     *
     * @param string $ime Ime
     * @param string $prezime Prezime
     * @param string $korime Lozinka
     * @param string $pol Lozinka
     * @param int $smer Lozinka
     * @param int $lozinka Lozinka
     * @param date $lozinka Lozinka
     *
     * @return void
     *
     */
    public function promeniProfil($ime, $prezime, $korime, $pol, $smer, $godinaStudija, $datum) {

        $korisnik = $this->session->korisnik;
        $username = $korisnik->Username;
        if ($ime != '') {
            $this->db->set('ime', $ime);
        }
        if ($prezime != '') {
            $this->db->set('prezime', $prezime);
        }
        if ($korime != '') {
            $this->db->set('username', $korime);
        } else {
            $korime = $username;
        }
        $date = date_format($datum, "Y-m-d");


        $this->db->set('pol', $pol);
        $this->db->set('smer', $smer);
        $this->db->set('godina_studija', $godinaStudija, FALSE);
        $this->db->set('datumrodjenja', $date);
        $this->db->where('username', $username);
        $this->db->update('korisnik');

        $query = $this->db->get_where('korisnik', array('username' => $korime));
        $korisnikUpit = $query->row();
        $this->session->set_userdata('korisnik', $korisnikUpit);
    }

     /**
     * Funkcija za racunanje procenta poena na osnovu istih odgovora
     *
     * @param string $tip Tip
     * @param string $username Username
     *
     * @return niz korisnika
     *
     */
    public function upari($tip, $username) {
        $this->db->select('username');
        $query = $this->db->get_where('korisnik', array('username !=' => $username));
        $users = $query->result_array();

        $brojPoena = 'brojpoena' . $tip;

        $ukupnoPoena = $this->PitanjeModel->ukupanBrojPoenaZaTip($tip);
        //var_dump($ukupnoPoena);
        $odgovori = $this->OdgovaranjeModel->sviOdgovori($username);

        $poeniArray = array();
        for ($i = 0; $i < count($odgovori); $i++) {
            $poeni = $this->PitanjeModel->brPoenaPitanjeZaTip($odgovori[$i]->idpitanje, $brojPoena);

            array_push($poeniArray, (int) $poeni->$brojPoena);
        }
        //var_dump($poeniArray);
        $korisnici = array();
        $m = 0;
        foreach ($users as $user) {
            $brPoena = 0;
            // var_dump($user['username']);
            for ($i = 0; $i < count($odgovori); $i++) {
                $idPitanje = $odgovori[$i]->idpitanje;
                $idOdgovor = $odgovori[$i]->idodgovor;
                $odg = $this->OdgovaranjeModel->odgovorNaPitanje($user['username'], $idPitanje);
                // var_dump($odg->idodgovor);
                //var_dump($idOdgovor); 
                if ($odg != null) {
                    if ($idOdgovor == $odg->idodgovor) {

                        $brPoena += $poeniArray[$i];
                    }
                }
            }
            $procenat = ($brPoena / $ukupnoPoena) * 100;
            $precision = 2;
            $procenatSkraceno = substr(number_format($procenat, $precision + 1, '.', ''), 0, -1);
            $obj = (object) array('user' => $user['username'], 'procenat' => $procenatSkraceno);
            $korisnici[$m] = $obj;
            $m++;
        }


        for ($i = 0; $i < count($korisnici) - 1; $i++) {
            for ($j = $i + 1; $j < count($korisnici); $j++) {
                if ($korisnici[$i]->procenat < $korisnici[$j]->procenat) {
                    $temp = $korisnici[$i];
                    $korisnici[$i] = $korisnici[$j];
                    $korisnici[$j] = $temp;
                }
            }
        }
        return $korisnici;
    }

     /**
     * Funkcija za promenu slike korisnika
     *
     * @param string $username Username
     * @param string $slika Slika
   
     *
     * @return void
     *
     */
    
    public function promeniSliku($username, $slika = NULL) {
        if ($slika == null) {
            $slika = "user_image.png";
        }

        $this->db->set('slika', $slika);
        $this->db->where('username', $username);
        $this->db->update('korisnik');
        $this->session->korisnik->Slika = $slika;
    }
     /**
     * Funkcija za dohvatanje svih korisnika koji su poslali zahtev za brisanje
     *
     * 
     * 
     *
     * @return niz korisnika
     *
     */
    public function dohvatiKorisnikeZaBrisanje() {
        $query = $this->db->get_where('korisnik', array('brisanje' => 1));
        return $query->result();
    }

     /**
     * Funkcija za brisanje korisnika
     *
     * @param string[] $korisnici Korisnici
     * 
     * 
     * @return void
     *
     */
    
    public function obrisiKorisnike($korisnici) {

        foreach ($korisnici as $korisnik) {
            if ($korisnik != null) {
                $this->db->where('username', $korisnik);
                $this->db->delete('korisnik');
                $this->PratiModel->obrisiKorisnika($korisnik);
                $this->OdgovaranjeModel->obrisi($korisnik);
            }
        }
    }

     /**
     * Funkcija za postavljanje koliko je puta korisnik poslao poruku u toku dana
     *
     * @param string $username Username
     * @param int $broj Broj
     *
     *
     * @return void
     *
     */
    
    public function postaviBrojKontaktiranja($username, $broj) {
        $this->db->set('BrojKontaktiranja', $broj);
        $this->db->where('username', $username);
        $this->db->update('korisnik');
        //var_dump('promenio sam');
    }

     /**
     * Funkcija za postavljanje broja poslatih poruka na 0, i datum resetovanja broja poslatih poruka
     *
     * @param date $datum Datum
     * @param string $username Username
     *
     * @return void
     *
     */
    
    public function resetujKontaktiranje($datum, $username) {
        $data = array(
            'BrojKontaktiranja' => 0,
            'DatumResetovanja' => $datum,
        );
        
        $this->db->where('username', $username);
        $this->db->update('korisnik', $data);
        //var_dump('promenio sam');
    }

}
