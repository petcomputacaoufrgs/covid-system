 CREATE TABLE tb_kits_extracao (
          idKitExtracao INTEGER(11)  NOT NULL AUTO_INCREMENT,
          nome varchar(300)  NOT NULL,
          index_nome varchar(300)  NOT NULL,
          PRIMARY KEY(idKitExtracao)
        );



        insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_kitExtracao','s','CADASTRO DO KIT DE EXTRAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_kitExtracao'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_kitExtracao','s','EDITAR O KIT DE EXTRAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_kitExtracao'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_kitExtracao','s','LISTAR OS KITS DE EXTRAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_kitExtracao'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_kitExtracao','s','REMOVER O KIT DE EXTRAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_kitExtracao'));


      CREATE TABLE tb_extracao (
          idExtracao INTEGER(11)  NOT NULL AUTO_INCREMENT,
          idUsuario_fk INTEGER(11)  NOT NULL,
          idLote_fk INTEGER(11)  NOT NULL,
          idCapela_fk INTEGER(11)  NOT NULL,
          dataHoraInicio datetime  NOT NULL,
          dataHoraFim datetime  NOT NULL,
          PRIMARY KEY(idExtracao)
        );