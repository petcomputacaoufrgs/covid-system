alter table tb_protocolo add caractere char(1) not  null;


alter table tb_paciente add idEstado_fk bigint(20)  null;
alter table tb_paciente add idMunicipio_fk bigint(20)  null;
alter table tb_paciente add obsMunicipio varchar(150)  null;


alter table tb_preparo_lote add idCapela_fk int(10) unsigned  null;
alter table tb_preparo_lote add idPreparoLote_fk int(10) unsigned   null;
ALTER TABLE tb_preparo_lote ADD FOREIGN KEY fk_idCapelalote (idCapela_fk) REFERENCES tb_capela (idCapela);
ALTER TABLE tb_preparo_lote ADD FOREIGN KEY fk_idPreparoLote (idPreparoLote_fk) REFERENCES tb_preparo_lote (idPreparoLote);

insert into tb_recurso (nome,s_n_menu,etapa) values ('imprimir_preparo_lote','s','IMPRIMIR GRUPO DA PREPARAÇÃO/INATIVAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'imprimir_preparo_lote'));



     insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_montagemGrupo_extracao','s','REMOVER MONTAGEM GRUPO DE EXTRAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_montagemGrupo_extracao'));