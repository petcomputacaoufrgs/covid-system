 insert into tb_recurso (nome,s_n_menu,etapa) values ('exibir_graficos','n','EXIBIR GRAFICOS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'exibir_graficos'));