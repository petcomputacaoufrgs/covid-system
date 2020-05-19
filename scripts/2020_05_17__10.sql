insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_tubos','n','LISTAR TUBOS ADMIN');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_tubos'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_localArmazenamentoTxt','n','LISTAR LOCAIS DE ARMAZENAMENTO (TEXTO)');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_localArmazenamentoTxt'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_localArmazenamentoTxt','n','EDITAR LOCAL DE ARMAZENAMENTO (TEXTO)');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_localArmazenamentoTxt'));
