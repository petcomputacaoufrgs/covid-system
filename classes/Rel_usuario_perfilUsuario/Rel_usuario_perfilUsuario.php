<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
class Rel_usuario_perfilUsuario{
    private $id_rel_usuario_perfilUsuario;
    private $idUsuario_fk;
    private $idPerfilUsuario_fk;
    
    function __construct() {
        
    }
    
    function getId_rel_usuario_perfilUsuario() {
        return $this->id_rel_usuario_perfilUsuario;
    }

    function getIdUsuario_fk() {
        return $this->idUsuario_fk;
    }

    function getIdPerfilUsuario_fk() {
        return $this->idPerfilUsuario_fk;
    }

    function setId_rel_usuario_perfilUsuario($id_rel_usuario_perfilUsuario) {
        $this->id_rel_usuario_perfilUsuario = $id_rel_usuario_perfilUsuario;
    }

    function setIdUsuario_fk($idUsuario_fk) {
        $this->idUsuario_fk = $idUsuario_fk;
    }

    function setIdPerfilUsuario_fk($idPerfilUsuario_fk) {
        $this->idPerfilUsuario_fk = $idPerfilUsuario_fk;
    }


}