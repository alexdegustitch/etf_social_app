<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * AdminController - klasa za rad sa metodama za Admina
 * 
 * @version 1.0
 * 
 * @author Milica Milosevic 2016/0352
 */
class AdminController extends CI_Controller {

    /**
     * Kreiranje nove instance
     *
     * @return void
     */
    function __construct() {
        parent::__construct();
        if (($this->session->userdata('tip')) == NULL) {
            redirect("GostController");
        } else{
           $tip = $this->session->tip;
           switch($tip){
               case "vip": redirect("VipController"); break;
               case "korisnik": redirect("KorisnikController"); break;
           }
        }
    }

    /**
     * Funkcija za ucitavanje pocetne stranice administratora
     *
     * @param string $zahtev Zahtev
     *
     * @return Response
     *
     */
    public function index($zahtev = null) {
        $korisnik = $this->session->korisnik;
        $data['pitanja'] = $this->OdgovaranjeModel->sveOdgovorio($korisnik->Username);
        $data['username'] = $korisnik->Username;
        $data['ime'] = $korisnik->Ime;
        $data['prezime'] = $korisnik->Prezime;
        $data['pol'] = $korisnik->Pol;
        $data['smer'] = $korisnik->Smer;
        $data['godina'] = $korisnik->Godina_studija;
        $data['email'] = $korisnik->E_mail;
        $data['datum'] = $korisnik->DatumRodjenja;
        $data['slika'] = $korisnik->Slika;
        $data['zapraceni'] = $this->PratiModel->dohvatiKorisnikeKojePrati($korisnik->Username);
        //var_dump($data['zapraceni']);
        if ($zahtev != null) {
            $data['zahtev'] = $zahtev;
        }
        $this->load->view('adminProfil', $data);
    }

    /**
     * Funkcija za izmenu ucitavanje stranica za izmenu odgovora administratora
     *
     * 
     *
     * @return Response
     *
     */
    public function izmeniOdgovore() {
        $pitanja = $this->PitanjeModel->dohvatiPitanja();
        $odgovori = $this->OdgovorModel->dohvatiOdgovore($pitanja);
        $data['pitanja'] = $pitanja;
        $data['odgovori'] = $odgovori;
        $data['admin'] = $this->session->korisnik->admin;
        $this->load->view('izmeniOdg', $data);
    }

    /**
     * Funkcija za potvrdu izmene odgovora administratora
     *
     * 
     *
     * @return Response
     *
     */
    public function potvrdiIzmenuOdgovora() {
        $pitanja = $this->PitanjeModel->dohvatiPitanja();

        foreach ($pitanja as $pitanje) {
            //var_dump($pitanje->IdPitanje);
            $odg = $this->input->post($pitanje->IdPitanje);
            //var_dump($odg);
            $this->OdgovaranjeModel->promeniOdgovor($pitanje->IdPitanje, $odg);
        }

        $this->index();
    }

    /**
     * Funkcija za ucitavanje profila nekog drugog korisnika
     *
     * @param string $username Username
     *
     * @return Response
     *
     */
    public function posetiProfil($username) {

        $pratilac = $this->session->korisnik;
        $this->KorisnikModel->dohvatiKorisnika($username);
        $korisnik = $this->KorisnikModel->korisnik;
        date_default_timezone_set("Europe/Belgrade");
        $nowDate = date('Y-m-d');
        $resetDate = $pratilac->DatumResetovanja;
        if ($nowDate > $resetDate) {
            $this->KorisnikModel->resetujKontaktiranje($nowDate, $pratilac->Username);
            $pratilac->BrojKontaktiranja = 0;
            $pratilac->DatumResetovanja = $nowDate;
        }

        //var_dump($korisnik);
        $data['username'] = $username;
        $data['ime'] = $korisnik->Ime;
        $data['prezime'] = $korisnik->Prezime;
        $data['smer'] = $korisnik->Smer;
        $data['godina'] = $korisnik->Godina_studija;
        $data['email'] = $korisnik->E_mail;
        $data['slika'] = $korisnik->Slika;
        $data['zapracen'] = $this->PratiModel->proveriDaLiPrati($pratilac->Username, $username);
        $data['brojKontaktiranja'] = $pratilac->BrojKontaktiranja;
        //var_dump($data['brojKontaktiranja']);
        $data['admin'] = 1;

        $this->load->view('korisnik', $data);
    }

    /**
     * Funkcija za povecanje broja poslatih poruka korisnika
     *
     * @param string $username Username
     *
     * @return Response
     *
     */
    public function potvrdiSlanje($username) {
        $korisnik = $this->session->korisnik;
        $myUsername = $korisnik->Username;
        $broj = $this->input->post('brojKontakt');
        $korisnik->BrojKontaktiranja++;
        //var_dump($korisnik);
        //var_dump($broj);
        $this->KorisnikModel->postaviBrojKontaktiranja($myUsername, $broj);
        $this->posetiProfil($username);
    }

    /**
     * Funkcija za zapracivanje nezabracenog korisnika
     *
     * @param string $zapracen Zapracen
     *
     * @return Response
     *
     */
    public function zaprati($zapracen) {
        $pratilac = $this->session->korisnik;
        $this->PratiModel->zaprati($pratilac->Username, $zapracen);
        $this->posetiProfil($zapracen);
        //var_dump($pratilac);
        //var_dump($zapracen);
    }

    /**
     * Funkcija za otpracivanje zapracenog korisnika
     *
     * @param string $zapracen Zapracen
     *
     * @return Response
     *
     */
    public function otprati($zapracen) {
        $pratilac = $this->session->korisnik;
        $this->PratiModel->otprati($pratilac->Username, $zapracen);
        $this->posetiProfil($zapracen);
    }

    /**
     * Funkcija za slanje poruke korisniku
     *
     * 
     *
     * @return Response
     *
     */
    public function posaljiPoruku() {
        $korisnik = $this->session->korisnik;
        $username = $this->session->username;
        $email = $this->session->email;
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_user'] = $korisnik->E_mail;
        $config['smtp_pass'] = 'akiaki84908590';
        $config['smtp_port'] = 465;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from($korisnik->E_mail, $korisnik->Username);
        $this->email->to($email);
        $this->email->subject('ETFSocial message');
        $this->email->message('Zdravo' + $username + ', ja sam ' + $korisnik->Ime);
        if ($this->email->send()) {
            $this->session->set_flashdata("email_sent", "Congragulation Email Send Successfully.");
        } else {
            $this->session->set_flashdata("email_sent", "You have encountered an error");
        }
        $this->posetiProfil($username);
    }

    /**
     * Funkcija za logout
     *
     * 
     *
     * @return Response
     *
     */
    public function izlogujSe() {
        $this->session->unset_userdata("tip");
        $this->session->sess_destroy();
        redirect('GostController');
    }

    /**
     * Funkcija za ucitavanje stranice za izmenu informacija administratora
     *
     * 
     *
     * @return Response
     *
     */
    public function izmeniProfil($poruka = null) {
        $korisnik = $this->session->korisnik;
        $data['ime'] = $korisnik->Ime;
        $data['prezime'] = $korisnik->Prezime;
        $data['username'] = $korisnik->Username;
        $data['pol'] = $korisnik->Pol;
        $data['smer'] = $korisnik->Smer;
        $data['godina'] = $korisnik->Godina_studija;
        $datum = $korisnik->DatumRodjenja;
        $time = strtotime($datum);
        $month = date("m", $time);
        $year = date("Y", $time);
        $day = date("j", $time);

        $data['dan'] = $day;
        $data['mesec'] = $month;
        $data['godinadatum'] = $year;
        $data['admin'] = 1;
        if ($poruka != null) {
            $data['poruka'] = $poruka;
        }

        $this->load->view('izmeniProfil', $data);
    }

    /**
     * Funkcija za potvrdu izmena informacija o administratoru
     *      
     * @param string $zahtev Zahtev
     *
     * @return Response
     *
     */
    public function izmeni() {
        $korisnik = $this->session->korisnik;
        $ime = $this->input->post('ime');
        $prezime = $this->input->post('prezime');
        $korime = $this->input->post('korime');
        if ($korime != $korisnik->Username && $this->KorisnikModel->dohvatiKorisnika($korime)) {
            $poruka = "Korisnicko ime vec postoji.";
            $this->izmeniProfil($poruka);
        } else {
            $pol = $this->input->post('pol');
            $smer = $this->input->post('smer');
            $godinaStudija = $this->input->post('godina');
            $dan = $this->input->post('dan');
            $mesec = $this->input->post('mesec');
            $godina = $this->input->post('godinadatum');
            if ($godina == "") {
                $korisnik = $this->session->korisnik;
                $datum = $korisnik->DatumRodjenja;
                $time = strtotime($datum);
                $godina = date("Y", $time);
            }
            $datum = date_create("$godina-$mesec-$dan");
            /* var_dump($ime);
              var_dump($prezime);
              var_dump($korime);
              var_dump($pol);
              var_dump($smer);
              var_dump($godinaStudija);
              var_dump($dan);
              var_dump($mesec);
              var_dump($godina);
              var_dump($datum); */
            $this->KorisnikModel->promeniProfil($ime, $prezime, $korime, $pol, $smer, $godinaStudija, $datum);
            $this->index();
        }
    }

    /**
     * Funkcija za ucitavanje stranice za uparivanje
     *
     *
     *
     * @return Response
     *
     */
    public function upari() {
        $data['admin'] = 1;
        $this->load->view('uparivanje', $data);
    }

    /**
     * Funkcija za izlistavanje uparenih korisnika
     *
     * 
     *
     * @return Response
     *
     */
    public function upariMe() {
        $tipVeze = $this->input->post('veza');
        $username = $this->session->korisnik->Username;
        $data['korisnici'] = $this->KorisnikModel->upari($tipVeze, $username);
        $data['admin'] = 1;
        $this->load->view('uparivanje', $data);
    }

    /**
     * Funkcija za promenu slike administratora
     *
     * 
     *
     * @return Response
     *
     */
    public function promeniSliku() {
        $slika = $this->input->get('filename');
        $username = $this->session->korisnik->Username;
        $this->KorisnikModel->promeniSliku($username, $slika);
        $this->index();
    }

    /**
     * Funkcija za ucitavanje stranice sa zahtevima za brisanje 
     *
     * 
     *
     * @return Response
     *
     */
    public function brisanje() {
        $data['korisnici'] = $this->KorisnikModel->dohvatiKorisnikeZaBrisanje();
        $this->load->view('brisanje', $data);
    }

    /**
     * Funkcija za brisanje korisnika 
     *
     * 
     *
     * @return Response
     *
     */
    public function obrisiKorisnike() {
        $korisnici = $this->KorisnikModel->dohvatiKorisnikeZaBrisanje();
        $odobreni = array();
        foreach ($korisnici as $korisnik) {
            $user = $this->input->get($korisnik->Username);
            array_push($odobreni, $user);
        }
        //var_dump($odobreni);
        $this->KorisnikModel->obrisiKorisnike($odobreni);

        $this->index();
    }

    /**
     * Funkcija za ucitavanje stranice za brisanje pitanja
     *
     * 
     *
     * @return Response
     *
     */
    public function obrisiPitanje() {
        $data['pitanja'] = $this->PitanjeModel->dohvatiPitanja();
        $this->load->view('brisanjeOdg', $data);
    }

    /**
     * Funkcija za brisanje pitanja
     *
     * 
     *
     * @return Response
     *
     */
    public function potvrdiBrisanjePitanja() {
        $idPitanje = $this->input->get('pitanje');
        $this->PitanjeModel->obrisiPitanje($idPitanje);
        $this->obrisiPitanje();
    }

    /**
     * Funkcija za dodavanje pitanja
     *
     * @param string $poruka Poruka
     *
     * @return Response
     *
     */
    public function dodajPitanje($poruka = NULL) {
        if ($poruka != null) {
            $data['poruka'] = $poruka;
            $this->load->view('dodavanjeOdg', $data);
        } else {
            $this->load->view('dodavanjeOdg');
        }
    }

    /**
     * Funkcija za potvrdu dodavanja pitanja
     *
     * 
     *
     * @return Response
     *
     */
    public function potvrdiDodavanjePitanja() {
        $brojOdg = $this->input->get('brojOdg');
        //var_dump($brojOdg);
        //$this->form_validation->set_rules('pitanje', 'Pitanje', 'required');
        /* for($i = 0;$i<$brojOdg;$i++){
          $naziv = 'odg'.$i;
          $this->form_validation->get($naziv, 'Odgovor '.$i, 'required');
          } */
        $poeniLJP = $this->input->get('ljp');
        $poeniPP = $this->input->get('pp');
        $poeniP = $this->input->get('p');
        $poruka = '';

        $poeniLJP = (int) $poeniLJP;
        $poeniPP = (int) $poeniPP;
        $poeniP = (int) $poeniP;
        $proslo = true;
        // var_dump($poeniLJP);
        // var_dump($poeniPP);
        //var_dump($poeniP);
        if ($poeniLJP == 0 && $poeniPP = 0 && $poeniP == 0) {
            $poruka .= 'Ne moze pitanje za svaki tip veze nositi 0 poena! ';
        }
        //var_dump($poruka);
        $pitanje = $this->input->get('pitanje');
        if ($pitanje == null) {
            $poruka .= 'Morate uneti tekst pitanja! ';
        }
        //var_dump($poruka);
        $odgovori = array();
        $brojOdg = (int) $brojOdg;
        //var_dump($brojOdg);
        for ($i = 1; $i <= $brojOdg; $i++) {
            // var_dump($i);
            $naziv = 'odg' . $i;
            $odg = $this->input->get($naziv);
            //var_dump($odg);
            if ($odg == '') {
                $poruka .= 'Morati uneti tekst odgovora! ';
                $proslo = false;
                break;
            }
            array_push($odgovori, $odg);
        }
        //var_dump($poruka);
        if ($poruka != '') {
            $this->dodajPitanje($poruka);
        } else {
            $brPitanja = $this->PitanjeModel->dodajPitanje($pitanje, $poeniLJP, $poeniPP, $poeniP);
            $this->OdgovorModel->dodajOdgovor($odgovori, $brPitanja);
            $this->index();
        }
    }

    /**
     * Funkcija za ucitavanje stranice sa neodgovorenim pitanjima
     *
     * 
     *
     * @return Response
     *
     */
    public function odgovoriNaPitanja() {
        //var_dump($this->session->korisnik);
        $pitanja = $this->OdgovaranjeModel->neodgovorenaPitanja($this->session->korisnik->Username);
        $odgovori = $this->OdgovorModel->dohvatiOdgovoreBezOdgovora($pitanja);

        $data['pitanja'] = $pitanja;
        $data['odgovori'] = $odgovori;
        $data['tip'] = 'a';

        $this->load->view('neodgovorenaPitanja', $data);
    }

    /**
     * Funkcija za potvrdu odgovora na neodgovorena pitanja
     *
     * 
     *
     * @return Response
     *
     */
    public function potvrdiOdgNaNeodgovorena() {


        $pitanja = $this->OdgovaranjeModel->neodgovorenaPitanja($this->session->korisnik->Username);


        foreach ($pitanja as $pitanje) {
            //var_dump($pitanje->IdPitanje);
            $odg = $this->input->post($pitanje->IdPitanje);
            //var_dump($odg);
            $this->OdgovaranjeModel->dodajOdgovorKorisnika($odg, $this->session->korisnik->Username, $pitanje->IdPitanje);
        }

        $this->index();
    }

}
