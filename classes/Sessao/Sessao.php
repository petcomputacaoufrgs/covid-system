<?php

require_once __DIR__ . '/../Excecao/Excecao.php';

require_once __DIR__ . '/../Usuario/Usuario.php';
require_once __DIR__ . '/../Usuario/UsuarioRN.php';

require_once __DIR__ . '/../Recurso/Recurso.php';
require_once __DIR__ . '/../Recurso/RecursoRN.php';

require_once __DIR__ . '/../Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
require_once __DIR__ . '/../Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';

require_once __DIR__ . '/../Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once __DIR__ . '/../Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

// $_SESSION['CHAVE'] = hash('sha256', 'abcd');
// $_SESSION['ID_USUARIO'] = 1;
// $_SESSION['RECURSOS'] = array('listar_doenca');
class Sessao {

    private static $instance;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Sessao();
        }
        return self::$instance;
    }

    public function logar($matricula, $senha) {
        //$this->logoff();
        //ver LDAP
        try {

            unset($_SESSION['COVID19']);
            if ( (!is_null($matricula) && $matricula != '') && $senha != '' && $senha != null ) {

                $objUsuario = new Usuario();
                $objUsuarioRN = new UsuarioRN();


                $objUsuario->setCPF($matricula);
                $objUsuario->setMatricula($matricula);
                $objUsuario->setSenha($senha);
                //$objUsuarioRN->validar_cadastro($objUsuario);

                $arr_valida = $objUsuarioRN->validar_cadastro($objUsuario);
                $objUsuario = $arr_valida[0];
                if (count($arr_valida) == 0 && empty($arr_valida)) {
                    $objExcecao = new Excecao();
                    $objExcecao->adicionar_validacao("Usuário não encontrado.");
                    die("Usuário não encontrado.");
                    //header('Location: controlador.php?action=usuario_naoEncontrado');
                    //die();
                }

                //die("aquiiii");

                $arr_usuario = $objUsuarioRN->listar($objUsuario);

                $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
                $objRel_usuario_perfilUsuario_RN = new Rel_usuario_perfilUsuario_RN();
                $objRel_usuario_perfilUsuario->setIdUsuario_fk($arr_usuario[0]->getIdUsuario());
                $perfis_usuario = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
                //print_r($perfis_usuario);
                

                if (empty($perfis_usuario) && $perfis_usuario == null) {
                    $objExcecao = new Excecao();
                    $objExcecao->adicionar_validacao("Usuário não tem permissões no sistema.");
                    die("Usuário não tem permissões no sistema.");
                }

                //print_r($perfis_usuario);

                $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
                $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();

                foreach ($perfis_usuario as $perfis) {
                    $objRel_perfilUsuario_recurso->setIdPerfilUsuario_fk($perfis->getIdPerfilUsuario_fk());
                    $recursos = $objRel_perfilUsuario_recurso_RN->listar_recursos($objRel_perfilUsuario_recurso);
                }

                if (empty($recursos) && $recursos == null) {
                    $objExcecao = new Excecao();
                    $objExcecao->adicionar_validacao("Usuário não tem nenhum recurso no sistema.");
                }

                $objRecurso = new Recurso();
                $objRecursoRN = new RecursoRN();
                foreach ($recursos as $r) {
                    $objRecurso->setIdRecurso($r->getIdRecurso_fk());
                    $objRecurso = $objRecursoRN->consultar($objRecurso);
                    $arr_recursos[] = $objRecurso->getNome();
                }

                //print_r($arr_recursos);
                $_SESSION['COVID19'] = array();
                $_SESSION['COVID19']['ID_USUARIO'] = $arr_usuario[0]->getIdUsuario();
                $_SESSION['COVID19']['CPF'] = $arr_usuario[0]->getCPF();
                $_SESSION['COVID19']['MATRICULA'] = $objUsuario->getMatricula();
                $_SESSION['COVID19']['RECURSOS'] = $arr_recursos;
                $_SESSION['COVID19']['CHAVE'] = hash('sha256', random_bytes(50));


                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=principal'));
                die();
            }
        } catch (Exception $ex) {
            if (!Configuracao::getInstance()->getValor("producao")) {
                echo "<pre>" . $ex . "</pre>";
            }
            //echo "<pre>" . $ex . "</pre>";
            die("erro na sessão");
        }
    }

    public function logoff() {
                
        session_destroy();
        
        
        
    }

    public function validar() {
        if (!isset($_SESSION['COVID19']['ID_USUARIO']) || $_SESSION['COVID19']['ID_USUARIO'] == null) {
            //LOGIN
            //header('Location: controlador.php?action=listar_perfilPaciente');
        }

        foreach ($_GET as $strChave => $strValor) {
            //if (($strChave != 'action' && substr($strChave, 0, 2) != 'id' && $strChave != 'hash') || ($strChave == 'action' && !preg_match('/^[a-zA-Z0-9_]+/', $strValor)) || (substr($strChave, 0, 2) == 'id' && !is_numeric($strValor)) || ($strChave == 'hash' && (strlen($strValor) != 64 || !ctype_alnum($strValor)))
            if (($strChave != 'action' && substr($strChave, 0, 2) != 'id' && $strChave != 'hash') || ($strChave == 'action' && !preg_match('/^[a-zA-Z0-9_]+/', $strValor)) || (substr($strChave, 0, 2) == 'id' && !is_numeric($strValor)) || ($strChave == 'hash' && (strlen($strValor) != 64 || !ctype_alnum($strValor)))
            ) {
                //die('url inválida:' . $strChave . "=" . $strValor);
                header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=acesso_negado'));
                //header('Location: controlador.php?action=login');
                die();
            }
        }

        if (!$this->verificar_link()) {
            $this->logoff();
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=nao_encontrado'));
            die();
            //$this->logoff();
            //header('Location: controlador.php?action=login');
            //die();
        }

        if (!$this->verificar_permissao($_GET['action'])) {
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=acesso_negado'));
            die();
            //throw new Exception("Acesso negado");
            //die();
        }
    }

    public function getIdUsuario() {
      
           return $_SESSION['COVID19']['ID_USUARIO'];
      
    }

    public function getCPF() {

        return $_SESSION['COVID19']['CPF'];

    }

    public function getMatricula() {
        return $_SESSION['COVID19']['MATRICULA'];
    }

    public function assinar_link($link) {
        //http://localhost/covid-system/public_html/controlador.php?action=editar_doenca&idDoenca=8

        $strPosParam = strpos($link, '?');
        if ($strPosParam !== FALSE) {
            $strParametros = substr($link, $strPosParam + 1);
            //throw new Exception("XXXX");
            $link = substr($link, 0, $strPosParam + 1) . $strParametros . '&hash=' . hash('sha256', $strParametros . $_SESSION['COVID19']['CHAVE']);
        }
        return $link;
    }

    public function verificar_link() {
        //http://localhost/covid-system/public_html/controlador.php?action=editar_doenca&idDoenca=8&hash=hhhhhh
        $link = $_SERVER['QUERY_STRING'];

        if (strlen($link)) {
            $strPosHash = strpos($link, '&hash=');
            if ($strPosHash !== FALSE) {
                $strParametros = substr($link, 0, $strPosHash);
                $chave = $_SESSION['COVID19']['CHAVE'];
                if (hash('sha256', $strParametros . $_SESSION['COVID19']['CHAVE']) == $_GET['hash']) {
                    return true;
                }
            }
        }
        return false;
    }

    public function verificar_permissao($strRecurso) {

        if (in_array($strRecurso, $_SESSION['COVID19']['RECURSOS'])) {
            return true;
        }
        return false;
    }

}
