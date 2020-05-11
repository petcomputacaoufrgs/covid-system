alter table tb_preparo_lote drop idCapela_fk;

insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_preparo_lote','s','LISTAR PREPAROS DE LOTES');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_preparo_lote'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_montagemGrupo','s','REMOVER MONTAGEM GRUPO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_montagemGrupo'));



ALTER TABLE tb_tubo DROP tipo;
alter table tb_tubo add tipo char(1) null;
update  tb_tubo set tipo = 'C' where tipo is null;

alter table tb_lote add tipo char(1) not null;


insert into tb_recurso (nome,s_n_menu,etapa) values ('montar_preparo_extracao','s','MONTAR OS GRUPOS PARA PREPARAÇÃO/INATIVAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'montar_preparo_extracao'));

insert into tb_recurso (nome,s_n_menu,etapa) values ('imprimir_preparo_lote','s','IMPRIMIR GRUPO DA PREPARAÇÃO/INATIVAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'imprimir_preparo_lote'));



    CREATE TABLE tb_local_armazenamento_texto (
          idLocal INTEGER(11)  NOT NULL AUTO_INCREMENT,
          idTipoLocal INTEGER(10) UNSIGNED NOT NULL,
          porta varchar(150) NULL,
          prateleira VARCHAR(150) NULL,
          coluna VARCHAR(150) NULL,
          caixa varchar(150) NULL,
          posicao varchar(6) NULL,
          PRIMARY KEY(idLocal)
        );



     alter table tb_infostubo add idLocal_fk int(11)  null;
     ALTER TABLE tb_infostubo ADD FOREIGN KEY fk_idLocal (idLocal_fk) REFERENCES tb_local_armazenamento_texto (idLocal);
      ALTER TABLE tb_local_armazenamento_texto ADD FOREIGN KEY fk_idTipoLocal (idTipoLocal) REFERENCES tb_tipo_localarmazenamento (idTipoLocalArmazenamento);
      alter table tb_local_armazenamento_texto add posicao varchar(6) null;

