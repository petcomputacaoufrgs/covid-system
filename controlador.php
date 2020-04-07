<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


switch ($_GET['action']):
    case 'tela_inicial':
        require_once 'index.php';
        break;
    
    case 'cadastrar_tipoAmostra':
    case 'editar_tipoAmostra':
        require_once 'acoes/TipoAmostra/cadastro_tipoAmostra.php';
        break;
    
    case 'listar_tipoAmostra':
        require_once 'acoes/TipoAmostra/listar_tipoAmostra.php';
        break;
    
    case 'remover_tipoAmostra':
        require_once 'acoes/TipoAmostra/remover_tipoAmostra.php';
        break;
    
    /* SEXO DO PACIENTE */
    case 'cadastrar_sexoPaciente':
    case 'editar_sexoPaciente':
        require_once 'acoes/SexoPacientes/cadastro_sexoPaciente.php';
        break;
    
    case 'listar_sexoPaciente':
        require_once 'acoes/SexoPacientes/listar_sexoPaciente.php';
        break;
    
    case 'remover_sexoPaciente':
        require_once 'acoes/SexoPacientes/remover_sexoPaciente.php';
        break;
    
    /* PERFIL DO PACIENTE */
    case 'cadastrar_perfilPaciente':
    case 'editar_perfilPaciente':
        require_once 'acoes/PerfilPaciente/cadastro_perfilPaciente.php';
        break;
    
    case 'listar_perfilPaciente':
        require_once 'acoes/PerfilPaciente/listar_perfilPaciente.php';
        break;
    
    case 'remover_perfilPaciente':
        require_once 'acoes/PerfilPaciente/remover_perfilPaciente.php';
        break;
    
    
    /* TIPO LOCAL DE ARMAZENAMENTO */
    case 'cadastrar_tipoLocalArmazenamento':
    case 'editar_tipoLocalArmazenamento':
        require_once 'acoes/TipoLocalArmazenamento/cadastro_tipoLocalArmazenamento.php';
        break;
    
    case 'listar_tipoLocalArmazenamento':
        require_once 'acoes/TipoLocalArmazenamento/listar_tipoLocalArmazenamento.php';
        break;
    
    case 'remover_tipoLocalArmazenamento':
        require_once 'acoes/TipoLocalArmazenamento/remover_tipoLocalArmazenamento.php';
        break;
    
    /* PERFIL DO USUÁRIO */
    case 'cadastrar_perfilUsuario':
    case 'editar_perfilUsuario':
        require_once 'acoes/PerfilUsuario/cadastro_perfilUsuario.php';
        break;
    
    case 'listar_perfilUsuario':
        require_once 'acoes/PerfilUsuario/listar_perfilUsuario.php';
        break;
    
    case 'remover_perfilUsuario':
        require_once 'acoes/PerfilUsuario/remover_perfilUsuario.php';
        break;
    
    
     /* DOENÇA */
    case 'cadastrar_doenca':
    case 'editar_doenca':
        require_once 'acoes/Doenca/cadastro_doenca.php';
        break;
    
    case 'listar_doenca':
        require_once 'acoes/Doenca/listar_doenca.php';
        break;
    
    case 'remover_doenca':
        require_once 'acoes/Doenca/remover_doenca.php';
        break;
    
     
    /* USUÁRIO */
    case 'cadastrar_usuario':
    case 'editar_usuario':
        require_once 'acoes/Usuario/cadastro_usuario.php';
        break;
    
    case 'listar_usuario':
        require_once 'acoes/Usuario/listar_usuario.php';
        break;
    
    case 'remover_usuario':
        require_once 'acoes/Usuario/remover_usuario.php';
        break;
    
    /* RECURSO */
    case 'cadastrar_recurso':
    case 'editar_recurso':
        require_once 'acoes/Recurso/cadastro_recurso.php';
        break;
    
    case 'listar_recurso':
        require_once 'acoes/Recurso/listar_recurso.php';
        break;
    
    case 'remover_recurso':
        require_once 'acoes/Recurso/remover_recurso.php';
        break;
    
    /* EQUIPAMENTO */
    case 'cadastrar_equipamento':
    case 'editar_equipamento':
        require_once 'acoes/Equipamento/cadastro_equipamento.php';
        break;
    
    case 'listar_equipamento':
        require_once 'acoes/Equipamento/listar_equipamento.php';
        break;
    
    case 'remover_equipamento':
        require_once 'acoes/Equipamento/remover_equipamento.php';
        break;
    
    /* DETENTOR */
    case 'cadastrar_detentor':
    case 'editar_detentor':
        require_once 'acoes/Detentor/cadastro_detentor.php';
        break;
    
    case 'listar_detentor':
        require_once 'acoes/Detentor/listar_detentor.php';
        break;
    
    case 'remover_detentor':
        require_once 'acoes/Detentor/remover_detentor.php';
        break;
    
    /* MARCA */
    case 'cadastrar_marca':
    case 'editar_marca':
        require_once 'acoes/Marca/cadastro_marca.php';
        break;
    
    case 'listar_marca':
        require_once 'acoes/Marca/listar_marca.php';
        break;
    
    case 'remover_marca':
        require_once 'acoes/Marca/remover_marca.php';
        break;
    
    /* MODELO */
    case 'cadastrar_modelo':
    case 'editar_modelo':
        require_once 'acoes/Modelo/cadastro_modelo.php';
        break;
    
    case 'listar_modelo':
        require_once 'acoes/Modelo/listar_modelo.php';
        break;
    
    case 'remover_modelo':
        require_once 'acoes/Modelo/remover_modelo.php';
        break;
    
    /* PERMANÊNCIA */
    case 'cadastrar_tempoPermanencia':
    case 'editar_tempoPermanencia':
        require_once 'acoes/TempoPermanencia/cadastro_tempoPermanencia.php';
        break;
    
    case 'listar_tempoPermanencia':
        require_once 'acoes/TempoPermanencia/listar_tempoPermanencia.php';
        break;
    
    case 'remover_tempoPermanencia':
        require_once 'acoes/TempoPermanencia/remover_tempoPermanencia.php';
        break;
    
    
    /* LOCAL DE ARMAZENAMENTO */
    case 'cadastrar_localArmazenamento':
    case 'editar_localArmazenamento':
        require_once 'acoes/LocalArmazenamento/cadastro_localArmazenamento.php';
        break;
    
    case 'listar_localArmazenamento':
        require_once 'acoes/LocalArmazenamento/listar_localArmazenamento.php';
        break;
    
    case 'remover_localArmazenamento':
        require_once 'acoes/LocalArmazenamento/remover_localArmazenamento.php';
        break;
    
    /* PACIENTE */
    case 'cadastrar_paciente':
    case 'editar_paciente':
        require_once 'acoes/Paciente/cadastro_paciente.php';
        break;
    
    case 'listar_paciente':
        require_once 'acoes/Paciente/listar_paciente.php';
        break;
    
    case 'remover_paciente':
        require_once 'acoes/Paciente/remover_paciente.php';
        break;
    
    default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador geral.');
endswitch;