/*
 * Alterações tb_paciente
 */
update tb_paciente set obsDataNascimento = 'Desconhecido' WHERE obsDataNascimento = '' or obsDataNascimento is null;
update tb_paciente set obsNomeMae = 'Desconhecido' WHERE obsNomeMae = '' or obsNomeMae is null;
update tb_paciente set obsPassaporte = 'Desconhecido' WHERE obsPassaporte = '' or obsPassaporte is null;
update tb_paciente set obsCEP = 'Desconhecido' WHERE obsCEP = '' or obsCEP is null;
update tb_paciente set obsEndereco = 'Desconhecido' WHERE obsEndereco = '' or obsEndereco is null;
update tb_paciente set obsCPF = 'Desconhecido' WHERE obsCPF = '' or obsCPF is null;
update tb_paciente set 	obsCodGAL = 'Desconhecido' WHERE 	obsCodGAL = '' or 	obsCodGAL is null;
update tb_paciente set obsCartaoSUS = 'Desconhecido' WHERE obsCartaoSUS = '' or obsCartaoSUS is null;
update tb_paciente set CEP = NULL WHERE CEP = '';
update tb_paciente set RG = NULL WHERE RG = '';
update tb_paciente set CPF = NULL WHERE CPF = '';
update tb_paciente set passaporte = NULL WHERE passaporte = '';
update tb_paciente set nomeMae = NULL WHERE nomeMae = '';
update tb_paciente set endereco = NULL WHERE endereco = '';
/* update tb_paciente set dataNascimento = NULL WHERE dataNascimento = ''; */
update tb_paciente set cartaoSUS = NULL WHERE cartaoSUS = '';


/*
 * Alterações tb_amostra
 */
update tb_amostra set obsMotivo = 'Desconhecido' WHERE obsMotivo = '' or obsMotivo is null;
update tb_amostra set obsCEPAmostra = 'Desconhecido' WHERE 	obsCEPAmostra = '' or 	obsCEPAmostra is null;
update tb_amostra set obsLugarOrigem = 'Desconhecido' WHERE obsLugarOrigem = '' or obsLugarOrigem is null;
update tb_amostra set obsHoraColeta = 'Desconhecido' WHERE obsHoraColeta = '' or obsHoraColeta is null;
update tb_amostra set CEP = NULL WHERE CEP = '';
update tb_amostra set motivo = NULL WHERE motivo = '';
update tb_amostra set observacoes = NULL WHERE observacoes = '';

/*
    SELECT t1.*, t2.* FROM tb_tubo t1, tb_amostra t2 WHERE t1.idAmostra_fk = t2.idAmostra
 */

 /* Alterações tabela recurso */
insert into tb_recurso (nome,etapa,s_n_menu) values('montar_preparo_extracao','ETAPA 2 - MONTAGEM DO GRUPO DE PREPARO/EXTRAÇÃO','s');
INSERT INTO tb_rel_perfilusuario_recurso
        (idPerfilUsuario_fk, idRecurso_fk) VALUES (
              (SELECT idPerfilUsuario FROM tb_perfilusuario WHERE index_perfil = 'ADMINISTRADOR'),
              (SELECT idRecurso FROM tb_recurso WHERE nome = 'montar_preparo_extracao'));

