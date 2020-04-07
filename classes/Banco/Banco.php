<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


class Banco {

    private $host = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "amostras_covid19";
    private $conn;

    public function abrirConexao() {
        $this->conn = mysqli_connect($this->host, $this->dbUsername, $this->dbPassword, $this->dbName);
        /* change character set to utf8 */
        if (!mysqli_set_charset($this->conn, "utf8")) {
            printf("Error loading character set utf8: %s\n", mysqli_error($this->conn));
            exit();
        }
        set_time_limit(3000);
        if (mysqli_connect_error()) {
            throw new Exception('Erro abrindo conexão com o banco de dados:' . mysqli_connect_error()); // die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_errno());
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
    /*public function executarSQL($strSQL) {
        return mysqli_query($this->conn, $strSQL);
    }*/
    
    public function executarSql($sql, $arrCamposBind = null) {
        $arrResultado = array();


        if (($stmt = mysqli_prepare($this->conn,$sql)) === FALSE) {
            throw new Exception(mysqli_error($this->conn));
        }
        
        if($arrCamposBind != null && count($arrCamposBind)){
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
        
        //print_r($arrParams);
        if (mysqli_stmt_execute($stmt) === FALSE) {
            throw new Exception(mysqli_error($this->conn));
           
        }
        
        
        $affectedRows = mysqli_affected_rows($this->conn);
       
        mysqli_stmt_close($stmt);
		
		return $affectedRows;
}
    

    //CONSULTAR SQL
    public function consultarSql($sql, $arrCamposBind = null) {
        $arrResultado = array();


        if (($stmt = mysqli_prepare($this->conn,$sql)) === FALSE) {
            throw new Exception(mysqli_error($this->conn));
        }
        
        if($arrCamposBind != null && count($arrCamposBind)){
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

        if ($resultado === FALSE) {
            throw new Exception(mysqli_error($this->conn));
        }

        while ($registro = mysqli_fetch_array($resultado,MYSQLI_ASSOC)) {
            $arrResultado[] = $registro;
        }

        mysqli_stmt_close($stmt);
        RETURN $arrResultado;
    }

  
    public function obterUltimoID() {
        return mysqli_insert_id($this->conn);
    }

}

?>