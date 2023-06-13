<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * SadrziModel - klasa za rad sa podacima iz tabele 'sadrzi'
 * 
 * @version 1.0
 * 
 * @author Tijana Panic 2016/141
 */

class SadrziModel extends CI_Model{
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
     * Funkcija za dodavanje odgovora na zadato pitanje
     *
     * @param int $idPitanje IdPitanje
     * @param Odgovor[] $odgovori Odgovori
     * 
     *
     * @return int, id odgovora
     *
     */
    
    public function odgovorZaPitanje($idPitanje, $odgovori){
        foreach ($odgovori as $odgovor){
            $query = $this->db->get_where('sadrzi', array('idpitanje' => $idPitanje, 'idodgovor' => $odgovor->IdOdgovor));
            if($query->num_rows() >= 1){
                return $odgovor->IdOdgovor;
              
            }
        }
    }
    
    /**
     * Funkcija za dohvatanje odgovora na pitaje
     *
     * @param int $idPitanje IdPitanje
     * 
     *
     * @return niz odgovora
     *
     */
    
    public function odgovoriNaPitanje($idPitanje){
        $query = $this->db->get_where('sadrzi', array('idpitanje' => $idPitanje));
        //var_dump($idPitanje);
        //var_dump($query->result());
        return $query->result();
    }
    
    /**
     * Funkcija za dodavanje odgovora na pitanje u tabelu 'sadrzi'
     *
     * @param int $idOdg IdOdg
     * @param int $idPit IdPit
     * 
     *
     * @return void
     *
     */
    
    public function dodaj($idOdg, $idPit){
        $data = array(
            'idpitanje' =>$idPit,
            'idodgovor' => $idOdg
        );
        
        $this->db->insert('sadrzi', $data);
    }
    
    /**
     * Funkcija za proveru da li zadato pitanje ima samo odgovore 'da' i 'ne'
     *
     * @param int $idPitanje IdPitanje
     * 
     *
     * @return true ako ima samo te odgovore, false ako nema ili ima i neke druge
     *
     */
    
    public function tipOdgovora($idPitanje){
        $query = $this->db->get_where('sadrzi', array('idpitanje' => $idPitanje));
        $odgovori = $query->result();
        $ok = true;
        foreach ($odgovori as $odg){
            $idodg = $odg->IdOdgovor;
            $odgovor = $this->OdgovorModel->dohvatiOdgovor($idodg);
           // var_dump($odgovor);
            if(!($odgovor->TekstOdgovora == 'Da' || $odgovor->TekstOdgovora == 'Ne' || $odgovor->TekstOdgovora == 'DA' || $odgovor->TekstOdgovora == 'NE' || $odgovor->TekstOdgovora == 'da' || $odgovor->TekstOdgovora == 'ne' || $odgovor->TekstOdgovora == 'dA' || $odgovor->TekstOdgovora == 'nE')){
                $ok = false;
                break;
            }
        }
        return $ok;
    }
}
