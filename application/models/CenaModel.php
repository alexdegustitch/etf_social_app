<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CenaModel - klasa za rad sa podacima iz tabele 'cena'
 * 
 * @version 1.0
 * 
 * @author Tijana Panic 2016/141
 */

class CenaModel extends CI_Model {
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
     * Funkcija za dohvatanje svih podataka iz tabele 'cena'
     *
     * 
     *
     * @return sve redove tabele 'cena'
     *
     */
    public function dohvatiCene(){
        $query = $this->db->get('cena');
        return $query->result();
    }
}
