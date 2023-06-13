<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * OdgovaranjeModel - klasa za rad sa podacima iz tabele 'odgovaranje'
 * 
 * @version 1.0
 * 
 * @author Milica Milosevic 2016/352
 */
class OdgovaranjeModel extends CI_Model {
    //put your code here

    /**
     * Kreiranje nove instance
     *
     * @return void
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Funkcija za dohvatanje koliko je procenat odgovora na to pitanje
     *
     * @param string $pitanje Pitanje
     * @param string $odgovor Odgovor
     *
     * @return int[]
     *
     */
    public function procenatOdgovora($pitanje, $odgovor) {
        $queryPit = $this->db->get_where('pitanje', array('sadrzaj' => $pitanje));
        $idPit = $queryPit->row();
        $queryOdg = $this->db->get_where('odgovor', array('tekstodgovora' => $odgovor));
        $idOdg = $queryOdg->result();
        $idOdgovor = $this->SadrziModel->odgovorZaPitanje($idPit->IdPitanje, $idOdg);
        $ukupno = $this->dohvatiUkupanBrojOdgovora($idPit->IdPitanje);

        $brOdgovora = $this->dohvatiUkupanBrojIstihOdgovora($idPit->IdPitanje, $idOdgovor);

        $data['ukupno'] = $ukupno;
        $data['brOdgovora'] = $brOdgovora;
        return $data;
    }

    /**
     * Funkcija za dohvatanje ukupnog broja ljudi koji su odgovorili na pitanje
     *
     * @param int $idPitanje IdPitanje
     * 
     *
     * @return int
     *
     */
    public function dohvatiUkupanBrojOdgovora($idPitanje) {
        $this->db->from('odgovaranje');
        $this->db->where(array('idpitanje' => $idPitanje));
        $query = $this->db->get();
        $ukupno = $query->num_rows();
        return $ukupno;
    }

    /**
     * Funkcija za dohvatanje ukupnog broja ljudi koji su odgovorili odgovorom ciji je Id $idOdgovor
     *
     * @param int $idPitanje IdPitanje
     * @param int $idOdgovor IdOdgovor
     * 
     *
     * @return int
     *
     */
    public function dohvatiUkupanBrojIstihOdgovora($idPitanje, $idOdgovor) {

        //var_dump($idOdgovor);
        //var_dump($idPitanje);
        $query = $this->db->get_where('odgovaranje', array('idpitanje' => $idPitanje, 'idodgovor' => $idOdgovor));

        $brOdgovora = $query->num_rows();
        //var_dump($brOdgovora);
        //var_dump($query);
        return $brOdgovora;
    }

    /**
     * Funkcija za dohvatanje svih korisnika koji su odgovorili isto na pitanje kao i trenutni korisnik
     *
     * @param int $idPitanje IdPitanje
     * 
     *
     * @return niz korisnika
     *
     */
    public function istiOdgovor($idPitanje) {
        $username = $this->session->korisnik->Username;

        $query = $this->db->get_where('odgovaranje', array('idpitanje' => $idPitanje, 'username' => $username));
        $odgovor = $query->row();

        $query = $this->db->get_where('odgovaranje', array('idpitanje' => $idPitanje, 'username !=' => $username, 'idodgovor' => $odgovor->IdOdgovor));
        $korisnici = $query->result();

        return $korisnici;
    }

    /**
     * Funkcija za dodavanje odgovora korisnika na neko pitanje
     *
     * @param int $idOdgovor IdOdgovor
     * @param string @username Username
     * @param int $idPitanje IdPitanje
     *
     * @return void
     *
     */
    public function dodajOdgovorKorisnika($idOdgovor, $username, $idPitanja) {


        $data = array(
            'idpitanje' => $idPitanja,
            'idodgovor' => $idOdgovor,
            'username' => $username
        );

        $this->db->insert('odgovaranje', $data);
    }

    /**
     * Funkcija za dohvatanje svih odgovora korisnika
     *
     * @param string $username Username
     * 
     *
     * @return niz redova tabele 'odgovaranje'
     *
     */
    public function sviOdgovori($username) {
        $this->db->select('idpitanje, idodgovor');
        $this->db->order_by('idpitanje', 'ASC');
        $query = $this->db->get_where('odgovaranje', array('username' => $username));
        $odg = $query->result();
        //var_dump($odg);
        return $query->result();
    }

    /**
     * Funkcija za dohvatanje odgovora korisnika na zadato pitanje
     *
     * @param string $username Username
     * @param int $idPitanje IdPitanje
     * 
     *
     * @return red iz tabele 'odgovaranje'
     *
     */
    public function odgovorNaPitanje($username, $idpitanje) {
        $this->db->select('idodgovor');
        $query = $this->db->get_where('odgovaranje', array('username' => $username, 'idpitanje' => $idpitanje));

        return $query->row();
    }

    /**
     * Funkcija za promenu odgovara korisnika za konkretno pitanje
     *
     * @param int $idPitanje IdPitanje
     * @param string $odgovor $Odgovor
     * 
     *
     * @return void
     *
     */
    public function promeniOdgovor($idPitanje, $odgovor) {
        //var_dump($odgovor);
        $query = $this->db->get_where('odgovor', array('idodgovor' => $odgovor));
        $odg = $query->row();
        $username = $this->session->korisnik->Username;
        //var_dump($odg);
        $this->db->set('idodgovor', $odg->IdOdgovor, FALSE);
        $this->db->where(array('idpitanje' => $idPitanje, 'username' => $username));
        $this->db->update('odgovaranje');
    }

    /**
     * Funkcija za proveru da li je koirsnik odgovorio na svako pitanje
     *
     * @param string $username Username
     * 
     *
     * @return true ako jeste, false ako nije
     *
     */
    public function sveOdgovorio($username) {
        $pitanja = $this->PitanjeModel->dohvatiPitanja();
        $brPitanja = count($pitanja);

        $query = $this->db->get_where('odgovaranje', array('username' => $username));
        $brOdgovora = $query->num_rows();
        // var_dump($brOdgovora);
        //var_dump($brPitanja);

        if ($brOdgovora < $brPitanja) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Funkcija za dohvatanje pitanja na koje korisnik nije odgovorio
     *
     * @param string $username Username
     * 
     *
     * @return niz pitanja, tj. niz redova iz tabele 'pitanje'
     *
     */
    public function neodgovorenaPitanja($username) {

        /* $myQuery = "SELECT DISTINCT idpitanje "
          . "FROM Odgovaranje"
          . " WHERE username = '".$username."'";
         */
        $svaPitanja = $this->PitanjeModel->dohvatiPitanja();
        $this->db->select('idpitanje');
        $query = $this->db->get_where('odgovaranje', array('username' => $username));
        $result = $query->result();
        //var_dump($result);
        $pitanjaId = array();
        foreach ($svaPitanja as $pitanje) {
            $ima = false;
            //var_dump('Pitanje');
            //var_dump($pitanje->IdPitanje);
            foreach ($result as $res) {
                if ($res->idpitanje == $pitanje->IdPitanje) {
                    $ima = true;
                    break;
                }
                //var_dump('IdPitanja je');
                //var_dump($res);
            }
            if ($ima == false) {
                array_push($pitanjaId, $pitanje->IdPitanje);
            }
        }

        /* $this->db->distinct();
          $this->db->select('idpitanje');
          $this->db->where("NOT EXISTS(SELECT * FROM odgovaranje)");
          $query = $this->db->get('odgovaranje'); */
        //$query = $this->db->query($myQuery);
        // $pitanjaId = $query->result();
        //var_dump($pitanjaId);
        $pitanja = array();
        foreach ($pitanjaId as $pitanjeId) {
            $pitanje = $this->PitanjeModel->dohvatiPitanje($pitanjeId);
            array_push($pitanja, $pitanje);
        }
        //var_dump($pitanja);
        return $pitanja;
    }

    /**
     * Funkcija za brisanje odgovora korisnika
     *
     * @param string $username Username
     * 
     *
     * @return void
     *
     */
    public function obrisi($username) {
        $this->db->delete('odgovaranje', array('username' => $username));
    }

}
