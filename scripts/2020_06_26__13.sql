 insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_reteste','n','CADASTRAR RETESTE');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_reteste'));


 insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_reteste','n','LISTAR RETESTE');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_reteste'));
