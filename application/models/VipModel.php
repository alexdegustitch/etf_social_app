<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * VipModel - klasa za rad sa podacima iz tabele 'vip_korisnik'
 * 
 * @version 1.0
 * 
 * @author Ksenija Mitrovic 2016/421
 */
class VipModel extends CI_Model{
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
     * Funkcija za postavljanje korisnika da je vip, tj. za dodavanje korisnika u tabelu 'vip_korisnik'
     *
     * @param string $username Username
     * @param int $cena Cena
     * 
     * 
     *
     * @return void
     *
     */
    
    public function dodajKorisnika($username, $cena){
        $datum = getdate();
        //var_dump($datum);
        $date = date('Y-m-d H:i:s');
        //var_dump($date);
        $data = array(
            'datumpocetak' => $date,
            'username' => $username,
            'idcena' => $cena,
            'kontaktiranjevip' => 0
        );
        
        $this->db->insert('vip_korisnik', $data);
    }
    
    /**
     * Funkcija za proveru da li je zadati korisnik vip korisnik
     *
     * @param string $username Username
     * 
     *
     * @return null ako nije, ili korisnika ako jeste
     *
     */
    
    public function proveriVIP($username){
        $query = $this->db->get_where('vip_korisnik', array('username' => $username));
        return $query->row();
    }
    
    /**
     * Funkcija za brisanje korisnika iz tabele 'vip', tj. oznacavanje da vise nije vip korisnik
     *
     * @param string $username Username
     * 
     *
     * @return void
     *
     */
    
    public function obrisiKorisnika($username){
        $this->db->where('username', $username);
        $this->db->delete('vip_korisnik');
    }
    
    /**
     * Funkcija za promenu username vip korisnika
     *
     * @param string $usernameStari
     * @param string $usernameNovi
     * 
     *
     * @return void
     *
     */
    
    public function promeniUsername($usernameStari, $usernameNovi){
        $this->db->set('username', $usernameNovi);
        $this->db->where('username', $usernameStari);
        $this->db->update('vip_korisnik');
    }
}
