<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * VipController - klasa za rad sa metodama za Admina
 *
 * @version 1.0
 * 
 * @author Aleksandar Paripovic 2016/0417 
 */
class VipController extends CI_Controller {

    /**
     * Kreiranje nove instance 
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        if (($this->session->userdata('tip')) == NULL) {
            redirect("GostController");
        } else{
           $tip = $this->session->tip;
           switch($tip){
               case "admin": redirect("AdminController"); break;
               case "korisnik": redirect("KorisnikController"); break;
           }
        }
    }

    /**
     * Funkcija za ucitavanje pocetne stranice vip korisnika
     *
     * @param string $zahtev Zahtev
     *
     * @return Response
     *
     */
    public function index($zahtev = NULL) {
        $korisnik = $this->session->korisnik;
        $data['pitanja'] = $this->OdgovaranjeModel->sveOdgovorio($korisnik->Username);
        //var_dump($data['pitanja']);
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
        //var_dump($data['zahtev']);
        $this->load->view('vip', $data);
    }

    /**
     * Funkcija za izmenu ucitavanje stranica za izmenu odgovora vip korisnika
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
        $this->load->view('izmeniOdgVIP', $data);
    }

    /**
     * Funkcija za potvrdu izmene odgovora vip korisnika
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
     * Funkcija za ucitavanje stranice za izmenu informacija vip korisnika
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
        if($poruka != null){
            $data['poruka'] = $poruka;
        }
        $this->load->view('izmeniProfilVIP', $data);
    }

    /**
     * Funkcija za potvrdu izmena informacija o vip korisniku
     *      
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

            $this->KorisnikModel->promeniProfil($ime, $prezime, $korime, $pol, $smer, $godinaStudija, $datum);
            $username = $this->session->korisnik->Username;
            if ($korime != null) {
                $this->VipModel->promeniUsername($username, $korime);
            }
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
        $this->load->view('uparivanjeVIP');
    }

    /**
     * Funkcija za promenu slike vip korisnika
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
        $this->load->view('korisnikVIP', $data);
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
     * Funkcija za izlistavanje korisnika koji su odgovorili identicno na trazeno pitanje
     *
     * 
     *
     * @return Response
     *
     */
    public function upariPoPitanju($izabranoPitanje = null, $korisnici = null) {
        if ($izabranoPitanje != null) {
            $data['izabranoPitanje'] = $izabranoPitanje;
        }
        if ($korisnici != null) {
            $data['korisnici'] = $korisnici;
        }
        $data['pitanja'] = $this->PitanjeModel->dohvatiPitanja();
        $this->load->view('pitanjaVIP', $data);
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
        $this->load->view('uparivanjeVIP', $data);
    }

    /**
     * Funkcija za ucitavanje
     *
     *
     * @return Response
     *
     */
    public function upariZaPitanje() {
        $idPitanje = $this->input->get('pitanje');
        //var_dump($idPitanje);
        $korisnici = $this->OdgovaranjeModel->istiOdgovor($idPitanje);
        $this->upariPoPitanju($idPitanje, $korisnici);
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
        $data['tip'] = 'v';

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
