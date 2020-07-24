 insert into tb_recurso (nome,s_n_menu,etapa) values ('exibir_dados_amostra_paciente','n','EXIBIR DADOS DAS AMOSTRAS E DOS PACIENTES');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'exibir_dados_amostra_paciente'));


