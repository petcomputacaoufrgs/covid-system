<?php
require_once __DIR__ . '/../Situacao/Situacao.php';

class Tipo
{
    public static $TIPO_MANUAL = 1;
    public static $TIPO_HIBRIDO = 2;
    public static $TIPO_AUTOMATICO = 3;

    public static function listarTipos(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TIPO_MANUAL);
            $objSituacao->setStrDescricao('MANUAL');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TIPO_HIBRIDO);
            $objSituacao->setStrDescricao('HÍBRIDO');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TIPO_AUTOMATICO);
            $objSituacao->setStrDescricao('AUTOMÁTICO');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de TIPOS',$e);
        }
    }

    public static function mostrar_descricao_tipo($numero){
        $arr = self::listarTipos();
        foreach ($arr as $a){
            if($a->getStrTipo() == $numero ){
                return $a->getStrDescricao();
            }
        }
    }
}