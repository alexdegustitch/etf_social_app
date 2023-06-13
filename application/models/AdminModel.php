<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminModel
 *
 * @author uSER
 */
class AdminModel extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    /**
     * Funkcija za proveru da li je korisnik admin
     *
     * @param string $korime Korime
     * @param string $lozinka Lozinka
     *
     * @return 
     *
     */
    public function proveriPostoji($korime, $lozinka){
        $query = $this->db->get_where('administrator', array('username' => $korime, 'password' => $lozinka));
        return $query->row();
    }
}
