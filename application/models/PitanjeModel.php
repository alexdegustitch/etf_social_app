<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * PitanjeModel - klasa za rad sa podacima iz tabele 'pitanje'
 * 
 * @version 1.0
 * 
 * @author Aleksandar Paripovic 2016/417
 */

class PitanjeModel extends CI_Model {

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
     * Funkcija za dohvatanje svih pitanja
     *
     * 
     * 
     *
     * @return niz pitanja
     *
     */
    
    public function dohvatiPitanja() {
        $this->db->order_by('idpitanje', 'ASC');
        $query = $this->db->get('pitanje');

        $res = $query->result();
        return $res;
    }

     /**
     * Funkcija za dohvatanje ukupnog broja poena za konrektan tip
     *
     * @param string $tip Tip
     * 
     *
     * @return int
     *
     */
    
    public function ukupanBrojPoenaZaTip($tip) {
        $brojPoena = "brojpoena" . $tip;
        $this->db->select_sum($brojPoena);
        $this->db->from('pitanje');
        $query = $this->db->get();
        $result = $query->row();
        return (int) $result->$brojPoena;
    }

     /**
     * Funkcija za dohvatanje broja poenta za pitanje za konkretan tip veze
     *
     * @param int $idPitanje IdPitanje
     * @param string $tip Tip
     * 
     *
     * @return odgovor, tj. red iz tabele odgovor
     *
     */
    
    public function brPoenaPitanjeZaTip($idPitanje, $tip) {
        $this->db->select($tip);
        $query = $this->db->get_where('pitanje', array('idpitanje' => $idPitanje));
        return $query->row();
    }

     /**
     * Funkcija za brisanje konkretnog pitanja
     *
     * @param int $idPitanje IdPitanje
     * 
     *
     * @return void
     *
     */
    
    public function obrisiPitanje($idPitanje) {
        

        $odgovori = $this->SadrziModel->odgovoriNaPitanje($idPitanje);
        //var_dump($odgovori);
        foreach ($odgovori as $odgovor) {
            $this->OdgovorModel->obrisiOdgovor($odgovor->IdOdgovor);
        }
        $this->db->where('idpitanje', $idPitanje);
        $this->db->delete('pitanje');
    }

     /**
     * Funkcija za dohvatanje konkretnog pitanja
     *
     * @param int $idPitanje IdPitanje
     * 
     *
     * @return pitanje
     *
     */
    
    public function dohvatiPitanje($idPitanje) {
        $query = $this->db->get_where('pitanje', array('idpitanje' => $idPitanje));
        return $query->row();
    }

     /**
     * Funkcija za dodavanje novog pitanja
     *
     * @param int $idPitanje IdPitanje
     * @param int $poeniLJP PoeniLJP
     * @param int $poeniPP PoeniPP
     * @param int $poeniP PoeniP
     * 
     *
     * @return int, id pitanja
     *
     */
    
    
    public function dodajPitanje($pitanje, $poeniLJP, $poeniPP, $poeniP) {
        $this->db->select_max('idpitanje');
        $query = $this->db->get('pitanje');
        $br = $query->row();
        $br = $br->idpitanje;
        $br++;
        $data = array(
            'idpitanje' => $br,
            'sadrzaj' => $pitanje,
            'brojpoenaljp' => $poeniLJP,
            'brojpoenapp' => $poeniPP,
            'brojpoenap' => $poeniP
        );

        $this->db->insert('pitanje', $data);
        return $br;
    }
    
     /**
     * Funkcija za dohvatanje pitanja koji imaju samo odgovore 'da' i 'ne'
     *
     * 
     * 
     *
     * @return niz pitanja, tj. redova iz tabele 'pitanje'
     *
     */
    
    public function dohvatiPitanjaSaDaNeOdgovorima(){
        $pitanja = $this->dohvatiPitanja();
        
        $pitanjaNiz = array();
       // var_dump($pitanja);
        foreach($pitanja as $pitanje){
           // var_dump($pitanje);
            if($this->SadrziModel->tipOdgovora($pitanje->IdPitanje)){
                array_push($pitanjaNiz, $pitanje);
            }
        }
        
        return $pitanjaNiz;
    }
    
    

}
