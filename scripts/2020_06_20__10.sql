insert into tb_recurso (nome,s_n_menu,etapa) values ('gerar_planilha_incorreta','n','GERAR PLANILHA INCORRETA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'gerar_planilha_incorreta'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_diagnostico','n','CADASTRAR DIAGNÓSTICO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_diagnostico'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_diagnostico','n','EDITAR DIAGNÓSTICO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_diagnostico'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_diagnostico','n','LISTAR DIAGNÓSTICO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_diagnostico'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_diagnostico','n','REMOVER DIAGNÓSTICO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_diagnostico'));


     CREATE INDEX etapa ON tb_infostubo(etapa);

     ////////////////////////////// mudar no rel_mix_operador para varchar, tirar o decimal