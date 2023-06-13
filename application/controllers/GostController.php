<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * GostController - klasa za rad sa metodama za Gosta
 *
 * @version 1.0
 * 
 * @author Tijana Panic 2016/0141
 */
class GostController extends CI_Controller {



    /**
     * Kreiranje nove instance
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $tip = $this->session->userdata('tip');
        if ($tip != NULL) {
            switch($tip){
               case "vip": redirect("VipController"); break;
               case "korisnik": redirect("KorisnikController"); break;
               case "admin": redirect("AdminController"); break;
           }

        }
    }

    /**
     * Funkcija za ucitavanje pocetne stranice gosta
     *
     *
     * @return Response
     *
     */
    
    public function index() {
        $this->load->view('index');
    }

    /**
     * Funkcija za ucitavanje stranice za isprobavanje pitanja
     *
     * @param float $procenat Procenat
     * @param string $poruka Poruka
     *
     * @return Response
     *
     */
    public function isprobaj($procenat = NULL, $poruka = NULL) {
        $pitanja = $this->PitanjeModel->dohvatiPitanja();
        $pitanja = $this->PitanjeModel->dohvatiPitanjaSaDaNeOdgovorima();
        //var_dump($pi);
        //var_dump($pitana);
        $data['pitanja'] = $pitanja;
        if ($procenat != null) {
            $data['ukupno'] = $procenat['ukupno'];
            $data['brOdgovora'] = $procenat['brOdgovora'];
        }

        if ($poruka != null) {
            $data['poruka'] = $poruka;
        }
        $this->load->view('isprobaj', $data);
    }

    /**
     * Funkcija za dohvatanje procenta identicnog odgovora na dato pitanje
     *
     *
     * @return Response
     *
     */
    public function isprobajPitanje() {
        //$this->OdgovaranjeModel->sviOdgovori('necke');
        $poruka = '';
        $pitanje = $this->input->get('Pitanja');
        if ($pitanje == '0') {
            $poruka .= 'Morati izabrati pitanje. ';
        }

        $odgovor = $this->input->get('Odgovori');
        if ($odgovor == '0') {
            $poruka .= 'Morati izabrati odgovor. ';
        }
        if ($poruka != '') {
            $this->isprobaj(null, $poruka);
        } else {
            $procenat = $this->OdgovaranjeModel->procenatOdgovora($pitanje, $odgovor);
            $this->isprobaj($procenat, null);
        }
    }
    /**
     * Funkcija za prijavu korisnika
     *
     * @param string $poruka Poruka
     *
     * @return Response
     *
     */

    public function prijava($poruka = null) {
        $data['poruka'] = $poruka;
        $this->load->view('prijava', $data);
    }

    /**
     * Funkcija za proveru da li su su sva polja za prijavu popunjena
     *
     * 
     *
     * @return Response
     *
     */
    
    public function prijaviSe() {
        $this->form_validation->set_rules('korime', 'Korisnicko ime', 'required');
        $this->form_validation->set_rules('lozinka', 'Lozinka', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->prijava();
        } else {
            $korime = $this->input->post('korime');
            $lozinka = $this->input->post('lozinka');
            if (strlen($lozinka) <= 3) {
                //$this->prijaviSeAdmin($korime, $lozinka);
            } else {
                $this->prijaviSeKorisnik($korime, $lozinka);
            }
        }
    }
    /**
     * Funkcija za proveru da li korisnik postoji u bazi
     *
     * @param string $korime Korime
     * @param string $lozinka Lozinka
     *
     * @return Response
     *
     */

    public function prijaviSeKorisnik($korime, $lozinka) {


        if (!$this->KorisnikModel->dohvatiKorisnika($korime)) {
            $this->prijava("Neispravno korisnicko ime!");
        } else if (!$this->KorisnikModel->proveriLozinku($lozinka)) {
            $this->prijava("Neispravna lozinka!");
        } else {
            $korisnik = $this->KorisnikModel->korisnik;
            $this->session->set_userdata('korisnik', $korisnik);
            //var_dump($korisnik);
            if ($korisnik->admin == '1') {
                $this->session->set_userdata('tip','admin');
                redirect('AdminController');
            } else {
                $user = $this->VipModel->proveriVIP($korime);
                //var_dump($user);
                

                if ($user != null) {
                    $datum = new DateTime($user->DatumPocetak);
                    //var_dump($datum);
                    //$datumSada = date('Y-m-d H:i:s');
                    //$time = strtotime($datum->date);
                    // var_dump($time);
                    //$newformat = date('Y-m-d H:i:s', $time);
                    // var_dump($newformat);
                    //var_dump($datumSada);
                    //$date = new DateTime($newformat);
                    $now = new DateTime();
                    //var_dump($now);
                    //var_dump($datum);
                    $difference = date_diff($datum, $now);
                    $tip = $user->IdCena;
                    //var_dump($tip);
                    //var_dump($difference);
                    $zahtev = null;
                    //var_dump($difference);
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

                    if ($zahtev == null) {
                        $this->session->set_userdata('tip','vip');
                        redirect('VipController');
                    } else {
                        $this->session->set_userdata('tip','korisnik');
                        redirect('KorisnikController/index/' . $zahtev);
                    }

                    //redirect('VipController', $zahtev);
                } else {
                    $this->session->set_userdata('tip','korisnik');
                    redirect("KorisnikController");
                }
            }
        }
    }

    /**
     * Funkcija za ucitavanje stranice za registraciju
     *
     * 
     *
     * @return Response
     *
     */
    public function registracija() {
        $this->load->view('registracija');
    }

    /**
     * Funkcija za dohvatanje svih polja forme za registraciju
     *
     *
     *
     * @return Response
     *
     */
    
    public function registrujSe() {
        if (!$this->provera()) {
            $this->registracija();
        } else {

            $ime = $this->input->post('ime');
            $prezime = $this->input->post('prezime');
            $korime = $this->input->post('korime');
            $email = $this->input->post('email');
            $lozinka = $this->input->post('lozinka');
            //$lozinkaPotvrda = $this->input->post('lozinkaPotvrda');
            $pol = $this->input->post('pol');
            $smer = $this->input->post('smer');
            $godinaStudija = $this->input->post('godinaStudija');
            $dan = $this->input->post('dan');
            $mesec = $this->input->post('mesec');
            $godina = $this->input->post('godina');
            $datum = date_create("$godina-$mesec-$dan");
            $slika = $this->input->post('filename');
            $this->KorisnikModel->postaviKorisnika($ime, $prezime, $korime, $email, $lozinka, $pol, $smer, $godinaStudija, $datum, $slika);
            // var_dump(KorisnikModel::$korisnik);
            $pitanja = $this->PitanjeModel->dohvatiPitanja();
            $odgovori = $this->OdgovorModel->dohvatiOdgovore($pitanja);
            $data['pitanja'] = $pitanja;
            $data['odgovori'] = $odgovori;
            $this->load->view('pitanjaReg', $data);
        }
    }

    /**
     * Funkcija za dohvatanje svih odgovora na pitanje  
     *
     * 
     *
     * @return Response
     *
     */
    
    public function registrujSePitanja() {

        $pitanja = $this->PitanjeModel->dohvatiPitanja();
        
        foreach ($pitanja as $pitanje) {
            $value = str_replace(' ', '', $pitanje->Sadrzaj);
            $value = substr($value, 0, -1);
             $value = str_replace("'", "", $value);
            //var_dump($value);
            $this->form_validation->set_rules($value, $value, 'required');
            //var_dump('proslo je');
        }

        if ($this->form_validation->run()) {
           
            foreach ($pitanja as $pitanje) {
                $value = str_replace(' ', '', $pitanje->Sadrzaj);
                $value = substr($value, 0, -1);
                $value = str_replace("'", "", $value);
                $idOdgovor = $this->input->post($value);
                //var_dump(KorisnikModel::$korisnik);
                //var_dump($korisnik);
                //$data['promenljiva'] = $korisnik;
                //$this->load->view("TestView", $data);
                $korisnik = $this->session->korisnik;
                $username = $korisnik->Username;

                //$username = $this->KorisnikModel->korisnik['username'];
                $this->OdgovaranjeModel->dodajOdgovorKorisnika($idOdgovor, $username, $pitanje->IdPitanje);
            }
            if ($this->KorisnikModel->dodajKorisnika()) {
                $this->session->set_userdata('tip','korisnik');
                redirect('KorisnikController');
            }
        } else {
            //var_dump('nije proslo');
            $pitanja = $this->PitanjeModel->dohvatiPitanja();
            $odgovori = $this->OdgovorModel->dohvatiOdgovore($pitanja);
            $data['pitanja'] = $pitanja;
            $data['odgovori'] = $odgovori;
            $data['poruka'] = 'Da biste se registrovali morate da odgovorite na sva pitanja';
            $this->load->view('pitanjaReg', $data);
        }
    }

    /**
     * Funkcija za proveru da li su sva polja forme u skladu sa navedenim pravilima
     *
     * 
     *
     * @return Response
     *
     */
    
    public function provera() {
        $this->form_validation->set_rules('ime', 'Ime', 'required');
        $this->form_validation->set_rules('prezime', 'Prezime', 'required');
        $this->form_validation->set_rules('korime', 'Korisnicko ime', 'required|is_unique[korisnik.username]');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('lozinka', 'Lozinka', 'required|min_length[4]');
        $this->form_validation->set_rules('lozinkaPotvrda', 'Potvrda lozinke', 'required|matches[lozinka]');
        $this->form_validation->set_rules('pol', 'Pol', 'required');
        $this->form_validation->set_rules('smer', 'Smer', 'required');
        $this->form_validation->set_rules('godinaStudija', 'Godina studija', 'required');
        $this->form_validation->set_rules('dan', 'Dan', 'required');
        $this->form_validation->set_rules('mesec', 'Mesec', 'required');
        $this->form_validation->set_rules('godina', 'Godina rodjenja', 'required');
        $uspeh = $this->form_validation->run();
        return $uspeh;
    }

}
