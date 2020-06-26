alter table tb_usuario add CPF varchar(11) null;

 insert into tb_recurso (nome,s_n_menu,etapa) values ('gerar_estatisticas_relatorios','n','GERAR ESTATÍSTICAS E RELATÓRIOS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'gerar_estatisticas_relatorios'));


 insert into tb_recurso (nome,s_n_menu,etapa) values ('gerar_estatisticas_prefeitura','n','GERAR ESTATÍSTICAS PREFEITURA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'gerar_estatisticas_prefeitura'));
