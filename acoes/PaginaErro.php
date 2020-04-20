<?php 
session_start();
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Sessao/Sessao.php';

    Pagina::abrir_head("ERRO");
    Pagina::getInstance()->adicionar_css("style");
    //Pagina::getInstance()->adicionar_javascript();
    ?>
<p style="color: red; align-content: center;margin-right: 42%; margin-left: 42%;">Página de erro</p>
    <img src="img/errorPage.png"  style="margin-right: 15%; margin-left: 15%; width: 70%; height: 95%;">
   

<?php
    
    Pagina::getInstance()->fechar_corpo();
