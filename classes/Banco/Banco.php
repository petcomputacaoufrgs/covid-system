<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

//require_once '../Excecao/Excecao.php';
require_once __DIR__ . '/../Configuracao.php';

class Banco {

    private static $conn;
    private static $flagGlobal_conexao=false;
    private $flagLocal_conexao;
    private static $flagGlobal_transacao=false;
    private $flagLocal_transacao;
    
    function __construct() {
        $this->flagLocal_conexao = false;
        $this->flagLocal_transacao = false;
    }

    public function abrirConexao() {
        try {
            if (!self::$flagGlobal_conexao) {
                $array_config = Configuracao::getInstance()->getValor('banco');

                if (Configuracao::getInstance()->getValor('producao')) {

                    self::$conn = mysqli_init();
                    if (!self::$conn) {
                        throw new Exception("Erro inicializando conexão com o banco de dados: " . mysqli_connect_error());
                    }

                    //	mysqli_ssl_set ( self::$conn , null,null,null,null,null);
                    //self::$conn = mysqli_real_connect("db2.inf.ufrgs.br","covid19_rtpcr", "tu4ei%PeaEe?p2Oew3Gei", "covid19_rtpcr");

                    mysqli_real_connect(self::$conn, $array_config['servidor'], $array_config['usuario'], $array_config['senha'], $array_config['nome'], $array_config['porta'], null, MYSQLI_CLIENT_SSL);
                } else {

                    self::$conn = mysqli_connect($array_config['servidor'], $array_config['usuario'], $array_config['senha'], $array_config['nome']);
                    if (!mysqli_set_charset(self::$conn, "utf8")) {
                        printf("Error loading character set utf8: %s\n", mysqli_error(self::$conn));
                        exit();
                    }
                }

                if (mysqli_connect_error()) {
                    throw new Exception('Erro abrindo conexão com o banco de dados:' . mysqli_connect_error()); // die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_errno());
                }
                
                self::$flagGlobal_conexao= true;
                $this->flagLocal_conexao = true;
            }
        } catch (Exception $e) {
            $msg = "Erro abrindo conexão com o banco de dados.";
            $prod = Configuracao::getInstance()->getValor('producao');
            if ($prod) {
                $exc = new Exception($msg);
            } else {
                $exc = new Exception($msg, $e->getCode(), $e);
            }
            throw $exc;
        }
    }

    public function fecharConexao() {
        if($this->flagLocal_conexao){
            mysqli_close(self::$conn);
            self::$flagGlobal_conexao = false;
            $this->flagLocal_conexao = false;
        }
        
    }

    public function abrirTransacao() {
        if(!self::$flagGlobal_transacao){
            mysqli_autocommit(self::$conn, false);
            self::$flagGlobal_transacao = true;
            $this->flagLocal_transacao = true;
            
        }
        
    }

    public function confirmarTransacao() {
        if($this->flagLocal_transacao){
            mysqli_commit(self::$conn);
            mysqli_autocommit(self::$conn, true);
            self::$flagGlobal_transacao = false;
            $this->flagLocal_transacao = false;
            
        }
    }

    public function cancelarTransacao() {
        try{
            if(self::$flagGlobal_transacao){
                mysqli_rollback(self::$conn);
                mysqli_autocommit(self::$conn, true);
                self::$flagGlobal_transacao = false;
                $this->flagLocal_transacao = false;
            }
        }catch (Throwable $e) {
            
        }
    }

    /* public function executarSQL($strSQL) {
      return mysqli_query(self::$conn, $strSQL);
      } */

    public function executarSql($sql, $arrCamposBind = null) {
        $arrResultado = array();
        //print_r($arrCamposBind);
                      
        if (($stmt = mysqli_prepare(self::$conn, $sql)) === FALSE) {
            throw new Exception(mysqli_error(self::$conn));
        }

        if ($arrCamposBind != null && count($arrCamposBind)) {
            //echo "aqui";	
            $arrParams = array();
            $arrParams[] = & $stmt;

            $strTiposBind = '';
            foreach ($arrCamposBind as $arrBind) {
                $strTiposBind .= $arrBind[0];
            }

            $arrParams[] = & $strTiposBind;

            $numBind = count($arrCamposBind);
            for ($i = 0; $i < $numBind; $i++) {
                $arrParams[] = & $arrCamposBind[$i][1];
            }
            //print_r($arrParams);

            if (call_user_func_array('mysqli_stmt_bind_param', $arrParams) === FALSE) {
                throw new Exception(mysqli_error(self::$conn));
            }
        }

        //print_r($arrParams);
        if (mysqli_stmt_execute($stmt) === FALSE) {
            throw new Exception(mysqli_error(self::$conn));
        }
        //die($sql);      

        $affectedRows = mysqli_affected_rows(self::$conn);
        //echo "##".$affectedRows;
        mysqli_stmt_close($stmt);

        return $affectedRows;
    }

    //CONSULTAR SQL
    public function consultarSql($sql, $arrCamposBind = null) {
        $arrResultado = array();
        //print_r($arrCamposBind);

        if (($stmt = mysqli_prepare(self::$conn, $sql)) === FALSE) {
            throw new Exception(mysqli_error(self::$conn));
        }


        if ($arrCamposBind != null && count($arrCamposBind)) {


            $arrParams = array();
            $arrParams[] = & $stmt;

            $strTiposBind = '';
            foreach ($arrCamposBind as $arrBind) {
                $strTiposBind .= $arrBind[0];
            }


            $arrParams[] = & $strTiposBind;

            $numBind = count($arrCamposBind);
            for ($i = 0; $i < $numBind; $i++) {
                $arrParams[] = & $arrCamposBind[$i][1];
            }

            if (call_user_func_array('mysqli_stmt_bind_param', $arrParams) === FALSE) {
                throw new Exception(mysqli_error(self::$conn));
            }
        }

        if (mysqli_stmt_execute($stmt) === FALSE) {
            throw new Exception(mysqli_error(self::$conn));
        }

        $resultado = mysqli_stmt_get_result($stmt);
        //var_dump($resultado);

        if ($resultado === FALSE) {
            throw new Exception(mysqli_error(self::$conn));
        }
        //die($sql);

        while ($registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            $arrResultado[] = $registro;
        }

//	print_r($arrResultado);

        mysqli_stmt_close($stmt);
        RETURN $arrResultado;
    }

    public function obterUltimoID() {
        return mysqli_insert_id(self::$conn);
    }

}
