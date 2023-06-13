<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * PratiModel - klasa za rad sa podacima iz tabele 'prati'
 * 
 * @version 1.0
 * 
 * @author Ksenija Mitrovic 2016/421
 */

class PratiModel extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

     /**
     * Funkcija za dohvatanje korisnika koje prati zadati korisnik
     *
     * @param string $usernameKorisnik UsernameKorisnik
     * 
     *
     * @return niz korisnika
     *
     */
    
    public function dohvatiKorisnikeKojePrati($usernameKorisnik) {
        $query = $this->db->get_where('prati', array('usernamepratilac' => $usernameKorisnik));
        $results = $query->result();
        //var_dump($results);
        $zapraceni = array();
        foreach ($results as $result) {
            //$this->db->select('username');
            //$query = $this->db->get_where('korisnik', array('idkorisnik' => $result->IdZapracen));
            //$username = $query->row();
            $username = $result->usernameZapracen;
            array_push($zapraceni, $username);
        }

        return $zapraceni;
    }

     /**
     * Funkcija za zapracivanje korisnika, tj. ubacivanje novog reda u tabelu 'prati'
     *
     * @param string $pratilac Pratilac
     * @param string $zapracen Zapracen
     * 
     *
     * @return void
     *
     */
    
    public function zaprati($pratilac, $zapracen){
        $data = array(
            'usernamepratilac' => $pratilac,
            'usernamezapracen' => $zapracen
        );
        
        $this->db->insert('prati', $data);
    }
    
    public function otprati($pratilac, $zapracen){
        $this->db->delete('prati', array('usernamepratilac' => $pratilac, 'usernamezapracen' => $zapracen));
    }


     /**
     * Funkcija za proveru da li zadati korisnik prati zadatog korisnika
     *
     * @param string $pratilac Pratilac
     * @param string $zapracen Zapracen
     * 
     *
     * @return true ako prati, false ako ne prati
     *
     */
    
    public function proveriDaLiPrati($pratilac, $zapracen){
      
        $query = $this->db->get_where('prati', array('usernamepratilac' => $pratilac, 'usernamezapracen' => $zapracen));
        
        if($query->num_rows() > 0){
            return true;
        }
        else {
            return false;
        }
        
    }
    
    
    /**
     * Funkcija za brisanje reda iz tabele 'prati'
     *
     * @param string $username Username
     * 
     *
     * @return void
     *
     */
    
    public function obrisiKorisnika($username){
        $this->db->delete('prati', array('usernamepratilac' => $username));
        $this->db->delete('prati', array('usernamezapracen' => $username)); 
    }
}
