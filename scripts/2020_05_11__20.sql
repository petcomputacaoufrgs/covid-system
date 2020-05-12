insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_usuario_perfilUsuario','s','EDITAR USUÁRIO + PERFIL DO USUÁRIO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_usuario_perfilUsuario'));