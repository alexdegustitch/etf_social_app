<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * OdgovorModel - klasa za rad sa podacima iz tabele 'odgovor'
 * 
 * @version 1.0
 * 
 * @author Milica Milosevic 2016/352
 */

class OdgovorModel extends CI_Model {

    //put your code here

    /**
     * Kreiranje nove instance
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

     /**
     * Funkcija za dohvatanje odgovora na pitanja iz niza $pitanja
     *
     * @param Pitanje[] $pitanja Pitanja
     * 
     *
     * @return niz odgovora, tj. redova iz tabele 'odgovor'
     *
     */
    
    public function dohvatiOdgovore($pitanja) {
        $odgovori = array();
        $username = $this->session->korisnik->Username;
        //var_dump($this->session->korisnik);
        //var_dump($username);
        foreach ($pitanja as $pitanje) {
            $query = $this->db->get_where('Sadrzi', array('idpitanje' => $pitanje->IdPitanje));
            $odgovor = $query->result();

            $odgniz = array();
            foreach ($odgovor as $odg) {
                $query = $this->db->get_where('Odgovor', array('idodgovor' => $odg->IdOdgovor));
                $res = $query->row();
                array_push($odgniz, $res);
            }
            $res = $this->OdgovaranjeModel->odgovorNaPitanje($username, $pitanje->IdPitanje);
            array_push($odgniz, $res);
            array_push($odgovori, $odgniz);
        }

        return $odgovori;
    }
    
     /**
     * Funkcija za brisanje zadatog odgovora
     *
     * @param int $idOdgovor IdOdgovor
     * 
     *
     * @return void
     *
     */

    public function obrisiOdgovor($idOdgovor) {
        $this->db->where('idodgovor', $idOdgovor);
        $this->db->delete('odgovor');
        //var_dump($idOdgovor);
    }

     /**
     * Funkcija za dohvatanje svih odgovora na pitanja iz niza $pitanja
     *
     * @param Pitanje[] $pitanja Pitanja
     * 
     *
     * @return odgovore
     *
     */
    
    public function dohvatiOdgovoreBezOdgovora($pitanja) {
        $odgovori = array();
        $username = $this->session->korisnik->Username;
        //var_dump($this->session->korisnik);
        //var_dump($username);
        foreach ($pitanja as $pitanje) {
            $query = $this->db->get_where('Sadrzi', array('idpitanje' => $pitanje->IdPitanje));
            $odgovor = $query->result();

            $odgniz = array();
            foreach ($odgovor as $odg) {
                $query = $this->db->get_where('Odgovor', array('idodgovor' => $odg->IdOdgovor));
                $res = $query->row();
                array_push($odgniz, $res);
            }
            array_push($odgovori, $odgniz);
        }
        return $odgovori;
    }

     /**
     * Funkcija za dodavanje odgovora na pitanje
     *
     * @param Odgovor[] $odgovori Odgovori
     * 
     *
     * @return void
     *
     */
    
    public function dodajOdgovor($odgovori, $brPitanja) {
        foreach ($odgovori as $odg) {
            $this->db->select_max('idodgovor');
            $query = $this->db->get('odgovor');
            $br = $query->row();
            $br = $br->idodgovor;
            $br++;
            //var_dump($br);
            $data = array(
                'idodgovor' => $br,
                'tekstodgovora' => $odg
            );
            $this->db->insert('odgovor', $data);
            
            $this->SadrziModel->dodaj($br, $brPitanja);
        }
    }
    
     /**
     * Funkcija za dohvatanje odgovora
     *
     * @param int $idOdg IdOdg
     * 
     *
     * @return odgovor, tj. red iz tabele 'odgovor'
     *
     */
    
    public function dohvatiOdgovor($idOdg){
        $query = $this->db->get_where('odgovor', array('idodgovor' => $idOdg));
        return $query->row();
    }

}
