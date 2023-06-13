<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * KorisnikController - klasa za rad sa metodama za Korisnika
 *
 * @version 1.0
 * 
 * @author Ksenija Mitrovic 2016/0421
 */
class KorisnikController extends CI_Controller {

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
               case "admin": redirect("AdminController"); break;
           }
        }
    }

    /**
     * Funkcija za ucitavanje pocetne stranice obicnog korisnika
     *
     * @param string $zahtev Zahtev
     *
     * @return Response
     *
     */
    public function index($zahtev = null) {
        $korisnik = $this->session->korisnik;
        $data['pitanja'] = $this->OdgovaranjeModel->sveOdgovorio($korisnik->Username);
        if ($data['pitanja'] == true) {
            $this->VipModel->obrisiKorisnika($korisnik->Username);
        }
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
        $this->load->view('profil', $data);
    }

    /**
     * Funkcija za izmenu ucitavanje stranica za izmenu odgovora obicnog korisnika
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
     * Funkcija za potvrdu izmene odgovora korisnika
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

        $data['username'] = $username;
        $data['ime'] = $korisnik->Ime;
        $data['prezime'] = $korisnik->Prezime;
        $data['smer'] = $korisnik->Smer;
        $data['godina'] = $korisnik->Godina_studija;
        $data['email'] = $korisnik->E_mail;
        $data['slika'] = $korisnik->Slika;
        $data['zapracen'] = $this->PratiModel->proveriDaLiPrati($pratilac->Username, $username);
        $data['brojKontaktiranja'] = $pratilac->BrojKontaktiranja;
        $data['admin'] = 0;

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
    public function posaljiPoruku() {/*
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
      $this->posetiProfil($username); */
        $to_email = 'paripovic.aleks@gmail.com';
        $subject = 'Testing PHP Mail';
        $message = 'This mail is sent using the PHP mail function';
        $headers = 'From:paripovic.aleks@gmail.com';
        mail($to_email, $subject, $message, $headers);
    }

    /**
     * Funkcija za slanje zahteva za brisanje administratoru
     *
     * 
     *
     * @return Response
     *
     */
    public function obrisi() {
        $korisnik = $this->session->korisnik;
        //var_dump($korisnik);
        if ($this->KorisnikModel->postaviZahtev($korisnik->Username)) {
            $this->index(2);
        } else {
            $this->index(1);
        }
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
     * Funkcija za ucitavanje stranice za izmenu informacija obicnog korisnika
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
        $data['admin'] = 0;
        if($poruka != null){
            $data['poruka'] = $poruka;
        }
        $this->load->view('izmeniProfil', $data);
    }

    /**
     * Funkcija za potvrdu izmena informacija o obicnom korisniku
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
        $data['admin'] = 0;
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
        $data['admin'] = 0;
        $this->load->view('uparivanje', $data);
    }

    /**
     * Funkcija za promenu slike obicnog korisnika
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
     * Funkcija za ucitavanje stranice gde se vrsi uplata za pretplatu za VIP korisnika
     *
     * 
     *
     * @return Response
     *
     */
    public function postaniVIP() {
        $cene = $this->CenaModel->dohvatiCene();
        $korisnik = $this->session->korisnik;
        $data['cenaDan'] = $cene[0]->Cena;
        $data['cenaNedeljuDana'] = $cene[1]->Cena;
        $data['cenaMesecDana'] = $cene[2]->Cena;
        $data['cenaGodinuDana'] = $cene[3]->Cena;
        $data['ime'] = $korisnik->Ime . " " . $korisnik->Prezime;
        $this->load->view('placanje', $data);
    }

    /**
     * Funkcija za potvrdu pretplate za postajanje VIP korisnika
     *
     * 
     *
     * @return Response
     *
     */
    public function uplati() {
        $this->form_validation->set_rules('ime', "Ime", 'required');
        $this->form_validation->set_rules('brojKartice', "Broj kartice", 'required|min_length[19]|max_length[19]');
        $this->form_validation->set_rules('cvv', "CVV", 'required|min_length[3]|max_length[3]');
        $this->form_validation->set_rules('mesecIsteka', "Mesec isteka kartice", 'required|max_length[2]|max_length[2]');

        if ($this->form_validation->run()) {
            //$mesecIsteka = $this->input->post('mesecIsteka');
            $tip = $this->input->post('cena');
            $username = $this->session->korisnik->Username;
            $this->VipModel->dodajKorisnika($username, $tip);
            $this->session->set_userdata('tip','vip');
            redirect('VipController');
        } else {
            $this->postaniVIP();
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
        $data['tip'] = 'k';

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

        $user = $this->VipModel->proveriVIP($this->session->korisnik->Username);

        if ($user != null) {
            $datum = new DateTime($user->DatumPocetak);

            $now = new DateTime();

            $difference = date_diff($datum, $now);
            $tip = $user->IdCena;

            $zahtev = null;

            switch ($tip) {
                case 1: if ($difference->d >= 1 || $difference->y >= 1 || $difference->m >= 1) {
                        $zahtev = 3;
                    } break;
                case 2: if ($difference->d >= 7 || $difference->y >= 1 || $difference->m >= 1) {
                        $zahtev = 3;
                    };
                    break;
                case 3: if ($difference->m >= 1 || $difference->y >= 1) {
                        $zahtev = 3;
                    };
                    break;
                case 4: if ($difference->y >= 1) {
                        $zahtev = 3;
                    };
                    break;
            }

            //
            //var_dump($zahtev);
            if ($zahtev == null) {
                redirect('VipController');
            } else {
                $this->VipModel->obrisiKorisnika($user->Username);
                $this->index($zahtev);
            }
        } else {
            $this->index();
        }
    }

}
