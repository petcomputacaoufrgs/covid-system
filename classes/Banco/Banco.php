<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

//require_once '../Excecao/Excecao.php';
class Banco {

    private $host; 
    private $dbUsername; 
    private $dbPassword;
    private $dbName;
    private $conn;
    private $isDebugMode;

    public function __construct() {
        require 'config/db.php';
        $this->host = $host;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->dbName = $dbName;
        $this->isDebugMode = isset($isDebugMode) && $isDebugMode;
    }

    public function abrirConexao() {
        try {
            $this->conn = mysqli_connect(
                $this->host,
                $this->dbUsername,
                $this->dbPassword,
                $this->dbName
            );
        } catch (Exception $e) {
            $msg = "Erro abrindo conexão com o banco de dados.";
            if ($this->isDebugMode) {
                $exc = new Exception($msg, $e->getCode(), $e);
            } else {
                $exc = new Exception($msg, $e->getCode());
            }
            throw $exc;
        }

        if (mysqli_connect_error()) {
            throw new Exception('Erro abrindo conexão com o banco de dados:' . mysqli_connect_error());
        }
    }

    public function fecharConexao() {
        mysqli_close($this->conn);
    }

    public function abrirTransacao() {
        mysqli_autocommit($this->conn, false);
    }

    public function confirmarTransacao() {
        mysqli_commit($this->conn);
        mysqli_autocommit($this->conn, true);
    }

    public function cancelarTransacao() {
        mysqli_rollback($this->conn);
        mysqli_autocommit($this->conn, true);
    }

    /* public function executarSQL($strSQL) {
      return mysqli_query($this->conn, $strSQL);
      } */

    public function executarSql($sql, $arrCamposBind = null) {
        $arrResultado = array();
        //print_r($arrCamposBind);

        if (($stmt = mysqli_prepare($this->conn, $sql)) === FALSE) {
            throw new Exception(mysqli_error($this->conn));
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
                throw new Exception(mysqli_error($this->conn));
            }
        }

        //print_r($arrParams);
        if (mysqli_stmt_execute($stmt) === FALSE) {
            throw new Exception(mysqli_error($this->conn));
        }
        //die($sql);      

        $affectedRows = mysqli_affected_rows($this->conn);
        mysqli_stmt_close($stmt);

        return $affectedRows;
    }

    //CONSULTAR SQL
    public function consultarSql($sql, $arrCamposBind = null) {
        $arrResultado = array();
        //print_r($arrCamposBind);

        if (($stmt = mysqli_prepare($this->conn, $sql)) === FALSE) {
            throw new Exception(mysqli_error($this->conn));
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
                throw new Exception(mysqli_error($this->conn));
            }
        }

        if (mysqli_stmt_execute($stmt) === FALSE) {
            throw new Exception(mysqli_error($this->conn));
        }

        $resultado = mysqli_stmt_get_result($stmt);
        //var_dump($resultado);

        if ($resultado === FALSE) {
            throw new Exception(mysqli_error($this->conn));
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
        return mysqli_insert_id($this->conn);
    }

}

?>
