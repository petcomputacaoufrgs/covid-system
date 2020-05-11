alter table tb_amostra add nickname varchar(6)  null;
--- alter table tb_laudo add situacaoLaudo char(1) not null;


 -- LAUDO
alter table tb_laudo add resultado char(1) not null;
alter table tb_laudo drop p_n_i;
alter table tb_laudo drop registro_SUS;
alter table tb_laudo add situacao char(1) not null;

alter table tb_laudo drop dataHoraLiberacao;
alter table tb_laudo add dataHoraGeracao datetime not null;
alter table tb_laudo add dataHoraLiberacao datetime null;

insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_laudo','s','LISTAR LAUDOS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_laudo'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastro_laudo','s','MOSTRAR LAUDOS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastro_laudo'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_laudo','s','EDITAR LAUDO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_laudo'));

          insert into tb_recurso (nome,s_n_menu,etapa) values ('imprimir_laudo','s','IMPRIMIR LAUDO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'imprimir_laudo'));


          insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_preparo_inativacao','s','LISTAR PREPARO INATIVAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_preparo_inativacao'));