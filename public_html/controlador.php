<?php

/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
error_reporting(E_ALL & ~E_NOTICE);
require_once __DIR__ . '/../classes/Sessao/Sessao.php';



switch ($_GET['action']):
    case 'principal':
        require_once 'principal.php';
        break;

    case 'montar_caixas':
        require_once '../telas_prototipos_antigas/tabela_caixas.php';
        break;

    case 'usuario_naoEncontrado':
        require_once '../acoes/PaginaUserNotFound.php';
        break;

    case 'login':
        require_once 'index.php';
        break;
    
     case 'erro':
        require_once '../acoes/PaginaErro.php';
        break;
    
    case 'sair':
        Sessao::getInstance()->logoff();
        header('Location: controlador.php?action=login');
        break;


    
    /* ESTATÍSTICAS */
    case 'gerar_estatisticas':
        require_once '../acoes/Estatisticas/gerar_estatisticas.php';
        break;
    case 'mostrar_estatisticas':
        require_once '../acoes/Estatisticas/gerarPDF.php';
        break;

     /* ETAPA 2 */
    case 'montar_preparo_extracao':
        require_once '../acoes/PreparoLote/cadastrar_preparoLote.php';
        break;
    case 'realizar_preparo_inativacao':
        require_once '../acoes/PreparoLote/preparoInativacao.php';
        break;


    case 'rastrear_amostras':
        require_once '../acoes/RastreamentoAmostras/rastreamentoAmostras.php';
        break;


    case 'cadastrar_localArmazenamento':
        require_once '../acoes/LocalArmazenamento/cadastro_localArmazenamento.php';
        break;


    case 'extrair_amostra':
        require_once 'telas_prototipos_antigas/etapa_extracao.php';
        break;
    case 'exibir_laudo':
        require_once 'telas_prototipos_antigas/etapa_laudo.php';
        break;
    case 'imprimir_laudo':
        require_once 'telas_prototipos_antigas/impressao_laudo.php';
        break;
    case 'recepcionar_amostra':
        require_once 'telas_prototipos_antigas/etapa_recepcaoAmostra.php';
        break;
    
    case 'cadastrar_tipoAmostra':
    case 'editar_tipoAmostra':
        require_once '../acoes/TipoAmostra/cadastro_tipoAmostra.php';
        break;
    
    case 'listar_tipoAmostra':
        require_once '../acoes/TipoAmostra/listar_tipoAmostra.php';
        break;
    
    case 'remover_tipoAmostra':
        require_once '../acoes/TipoAmostra/remover_tipoAmostra.php';
        break;
    
    /* SEXO DO PACIENTE */
    case 'cadastrar_sexoPaciente':
    case 'editar_sexoPaciente':
        require_once '../acoes/SexoPacientes/cadastro_sexoPaciente.php';
        break;
    
    case 'listar_sexoPaciente':
        require_once '../acoes/SexoPacientes/listar_sexoPaciente.php';
        break;
    
    case 'remover_sexoPaciente':
        require_once '../acoes/SexoPacientes/remover_sexoPaciente.php';
        break;
    
    /* PERFIL DO PACIENTE */
    case 'cadastrar_perfilPaciente':
    case 'editar_perfilPaciente':
        require_once '../acoes/PerfilPaciente/cadastro_perfilPaciente.php';
        break;
    
    case 'listar_perfilPaciente':
        require_once '../acoes/PerfilPaciente/listar_perfilPaciente.php';
        break;
    
    case 'remover_perfilPaciente':
        require_once '../acoes/PerfilPaciente/remover_perfilPaciente.php';
        break;
    
    
    /* TIPO LOCAL DE ARMAZENAMENTO */
    case 'cadastrar_tipoLocalArmazenamento':
    case 'editar_tipoLocalArmazenamento':
        require_once '../acoes/TipoLocalArmazenamento/cadastro_tipoLocalArmazenamento.php';
        break;
    
    case 'listar_tipoLocalArmazenamento':
        require_once '../acoes/TipoLocalArmazenamento/listar_tipoLocalArmazenamento.php';
        break;
    
    case 'remover_tipoLocalArmazenamento':
        require_once '../acoes/TipoLocalArmazenamento/remover_tipoLocalArmazenamento.php';
        break;
    
    /* PERFIL DO USUÁRIO */
    case 'cadastrar_perfilUsuario':
    case 'editar_perfilUsuario':
        require_once '../acoes/PerfilUsuario/cadastro_perfilUsuario.php';
        break;
    
    case 'listar_perfilUsuario':
        require_once '../acoes/PerfilUsuario/listar_perfilUsuario.php';
        break;
    
    case 'remover_perfilUsuario':
        require_once '../acoes/PerfilUsuario/remover_perfilUsuario.php';
        break;
    
    
     /* DOENÇA */
    case 'cadastrar_doenca':
    case 'editar_doenca':
        require_once '../acoes/Doenca/cadastro_doenca.php';
        break;
    
    case 'listar_doenca':
        require_once '../acoes/Doenca/listar_doenca.php';
        break;
    
    case 'remover_doenca':
        require_once '../acoes/Doenca/remover_doenca.php';
        break;
    
     /* NÍVEL DE PRIORIDADE */
    case 'cadastrar_nivelPrioridade':
    case 'editar_nivelPrioridade':
        require_once '../acoes/NivelPrioridade/cadastro_nivelPrioridade.php';
        break;
    
    case 'listar_nivelPrioridade':
        require_once '../acoes/NivelPrioridade/listar_nivelPrioridade.php';
        break;
    
    case 'remover_nivelPrioridade':
        require_once '../acoes/NivelPrioridade/remover_nivelPrioridade.php';
        break;
    
    /* USUÁRIO */
    case 'cadastrar_usuario':
    case 'editar_usuario':
        require_once '../acoes/Usuario/cadastro_usuario.php';
        break;
    
    case 'listar_usuario':
        require_once '../acoes/Usuario/listar_usuario.php';
        break;
    
    case 'remover_usuario':
        require_once '../acoes/Usuario/remover_usuario.php';
        break;
    
    /* RECURSO */
    case 'cadastrar_recurso':
    case 'editar_recurso':
        require_once '../acoes/Recurso/cadastro_recurso.php';
        break;
    
    case 'listar_recurso':
        require_once '../acoes/Recurso/listar_recurso.php';
        break;
    
    case 'remover_recurso':
        require_once '../acoes/Recurso/remover_recurso.php';
        break;
    
    /* EQUIPAMENTO */
    case 'cadastrar_equipamento':
    case 'editar_equipamento':
        require_once '../acoes/Equipamento/cadastro_equipamento.php';
        break;
    
    case 'listar_equipamento':
        require_once '../acoes/Equipamento/listar_equipamento.php';
        break;
    
    case 'remover_equipamento':
        require_once '../acoes/Equipamento/remover_equipamento.php';
        break;
    
    /* DETENTOR */
    case 'cadastrar_detentor':
    case 'editar_detentor':
        require_once '../acoes/Detentor/cadastro_detentor.php';
        break;
    
    case 'listar_detentor':
        require_once '../acoes/Detentor/listar_detentor.php';
        break;
    
    case 'remover_detentor':
        require_once '../acoes/Detentor/remover_detentor.php';
        break;
    
    /* MARCA */
    case 'cadastrar_marca':
    case 'editar_marca':
        require_once '../acoes/Marca/cadastro_marca.php';
        break;
    
    case 'listar_marca':
        require_once '../acoes/Marca/listar_marca.php';
        break;
    
    case 'remover_marca':
        require_once '../acoes/Marca/remover_marca.php';
        break;
    
    /* MODELO */
    case 'cadastrar_modelo':
    case 'editar_modelo':
        require_once '../acoes/Modelo/cadastro_modelo.php';
        break;
    
    case 'listar_modelo':
        require_once '../acoes/Modelo/listar_modelo.php';
        break;
    
    case 'remover_modelo':
        require_once '../acoes/Modelo/remover_modelo.php';
        break;
    
    /* PERMANÊNCIA */
    case 'cadastrar_tempoPermanencia':
    case 'editar_tempoPermanencia':
        require_once '../acoes/TempoPermanencia/cadastro_tempoPermanencia.php';
        break;
    
    case 'listar_tempoPermanencia':
        require_once '../acoes/TempoPermanencia/listar_tempoPermanencia.php';
        break;
    
    case 'remover_tempoPermanencia':
        require_once '../acoes/TempoPermanencia/remover_tempoPermanencia.php';
        break;
    
    
    /* LOCAL DE ARMAZENAMENTO */
    case 'cadastrar_localArmazenamento':
    case 'editar_localArmazenamento':
        require_once '../acoes/LocalArmazenamento/cadastro_localArmazenamentov0.php';
        break;
    
    case 'listar_localArmazenamento':
        require_once '../acoes/LocalArmazenamento/listar_localArmazenamento.php';
        break;

    case 'mostrar_localArmazenamento':
        require_once '../acoes/LocalArmazenamento/mostrar_localArmazenamento.php';
        break;
    
    case 'remover_localArmazenamento':
        require_once '../acoes/LocalArmazenamento/remover_localArmazenamento.php';
        break;

    /* CAIXA */
    case 'editar_caixa':
        require_once '../acoes/Caixa/editar_caixa.php';
        break;
    
    /* PACIENTE */
    case 'cadastrar_paciente':
    case 'editar_paciente':
        require_once '../acoes/Paciente/cadastro_paciente.php';
        break;
    
    case 'listar_paciente':
        require_once '../acoes/Paciente/listar_paciente.php';
        break;
    
    case 'remover_paciente':
        require_once '../acoes/Paciente/remover_paciente.php';
        break;
    
    
    /* AMOSTRA */
    case 'cadastrar_amostra':
    case 'editar_amostra':
        require_once '../acoes/CadastroAmostra/CadastroAmostra.php';
        //require_once '../acoes/Amostra/cadastro_amostra.php';
        break;
    
    case 'listar_amostra':
       // require_once '../acoes/CadastroAmostra/listar_cadastroAmostra.php';
        require_once '../acoes/CadastroAmostra/listar_cadastroIntermediario.php';
        break;

    
    case 'remover_amostra':
        require_once '../acoes/CadastroAmostra/remover_cadastroAmostra.php';
        break;
    
    
    
    
    /* AMOSTRA + TIPO + LOCAL */
    /*case 'cadastrar_amostra_localArmazenamento':
    case 'editar_amostra_localArmazenamento':
        require_once '../acoes/AmostraTipoLocal/cadastro_amostra_localArmazenamento.php';
        break;
    
    case 'listar_amostra_localArmazenamento':
        require_once '../acoes/AmostraTipoLocal/listar_amostra_localArmazenamento.php';
        break;
    
    case 'remover_amostra_localArmazenamento':
        require_once '../acoes/AmostraTipoLocal/remover_amostra_localArmazenamento.php';
        break;*/
    
    /* CAPELA */
    case 'cadastrar_capela':
    case 'editar_capela':
        require_once '../acoes/Capela/cadastro_capela.php';
        break;
    
    case 'listar_capela':
        require_once '../acoes/Capela/listar_capela.php';
        break;
    
    case 'remover_capela':
        require_once '../acoes/Capela/remover_capela.php';
        break;
     case 'bloquear_capela':
        require_once '../acoes/Capela/LOCK_capela.php';
        break;
    
    /* USUÁRIO + PERFIL + RECURSO */
    case 'cadastrar_rel_usuario_perfil_recurso':
    case 'editar_rel_usuario_perfil_recurso':
        require_once '../acoes/UsuarioPerfilRecurso/cadastro_upr.php';
        break;
    
    case 'listar_rel_usuario_perfil_recurso':
        require_once '../acoes/UsuarioPerfilRecurso/listar_upr.php';
        break;
    
    case 'remover_rel_usuario_perfil_recurso':
        require_once '../acoes/UsuarioPerfilRecurso/remover_upr.php';
        break;
    
    /* PERFIL USUÁRIO + RECURSO */
    case 'cadastrar_rel_perfilUsuario_recurso':
    case 'editar_rel_perfilUsuario_recurso':
        require_once '../acoes/PerfilRecurso/cadastro_perfilRecurso.php';
        break;
    
    case 'listar_rel_perfilUsuario_recurso':
        require_once '../acoes/PerfilRecurso/listar_perfilRecurso.php';
        break;
    
    case 'remover_rel_perfilUsuario_recurso':
        require_once '../acoes/PerfilRecurso/remover_perfilRecurso.php';
        break;
    
    /* USUÁRIO + PERFIL USUÁRIO  */
    case 'cadastrar_usuario_perfilUsuario':
    case 'editar_usuario_perfilUsuario':
        require_once '../acoes/UsuarioPerfil/cadastro_usuarioPerfil.php';
        break;
    
    case 'listar_usuario_perfilUsuario':
        require_once '../acoes/UsuarioPerfil/listar_usuarioPerfil.php';
        break;
    
    case 'remover_usuario_perfilUsuario':
        require_once '../acoes/UsuarioPerfil/remover_usuarioPerfil.php';
        break;
    
     /* ETNIA  */
    case 'cadastrar_etnia':
    case 'editar_etnia':
        require_once '../acoes/Etnia/cadastro_etnia.php';
        break;
    
    case 'listar_etnia':
        require_once '../acoes/Etnia/listar_etnia.php';
        break;
    
    case 'remover_etnia':
        require_once '../acoes/Etnia/remover_etnia.php';
        break;
    
    default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador geral.');
endswitch;
