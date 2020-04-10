<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Rel_perfilUsuario_recurso{
    private $id_rel_perfilUsuario_recurso;
    private $idPerfilUsuario_fk;
    private $idRecurso_fk;
    
    function __construct() {
        
    }
    
    function getId_rel_perfilUsuario_recurso() {
        return $this->id_rel_perfilUsuario_recurso;
    }

    function getIdPerfilUsuario_fk() {
        return $this->idPerfilUsuario_fk;
    }

    function getIdRecurso_fk() {
        return $this->idRecurso_fk;
    }

    function setId_rel_perfilUsuario_recurso($id_rel_perfilUsuario_recurso) {
        $this->id_rel_perfilUsuario_recurso = $id_rel_perfilUsuario_recurso;
    }

    function setIdPerfilUsuario_fk($idPerfilUsuario_fk) {
        $this->idPerfilUsuario_fk = $idPerfilUsuario_fk;
    }

    function setIdRecurso_fk($idRecurso_fk) {
        $this->idRecurso_fk = $idRecurso_fk;
    }



}