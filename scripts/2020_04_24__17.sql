alter table tb_tubo add tipo varchar(15);

/*update tb_tubo set tipo = 'COLETA' where idTubo =
(select idTubo_fk from tb_infostubo where
        statusTubo = 'Aguardando preparação' OR  statusTubo = 'Descartado' and
        tb_tubo.idTubo = tb_infostubo.idTubo_fk);*/


CREATE TABLE tb_lote (
  idLote INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  qntAmostrasDesejadas INTEGER UNSIGNED NOT NULL,
  qntAmostrasAdquiridas INTEGER UNSIGNED NOT NULL,
  statusLote VARCHAR(100) NOT NULL,
  PRIMARY KEY(idLote)
);

CREATE TABLE tb_rel_tubo_lote (
    idRelTuboLote int NOT NULL AUTO_INCREMENT ,
    idTubo_fk INTEGER UNSIGNED NOT NULL,
    idLote_fk INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(idRelTuboLote),
    INDEX Table_rel_amostra_lote_FKIndex1(idLote_fk),
    INDEX Table_rel_amostra_lote_FKIndex2(idTubo_fk) );


CREATE TABLE tb_preparo_lote (
  idPreparoLote INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  idCapela_fk INTEGER UNSIGNED NOT NULL,
  idLote_fk INTEGER UNSIGNED NOT NULL,
  dataHoraInicio DATETIME NOT NULL,
  dataHoraFim DATETIME NOT NULL,
  PRIMARY KEY(idPreparoLote),
  INDEX tb_preparo_FKIndex1(idLote_fk),
  INDEX tb_preparo_FKIndex2(idCapela_fk),
  INDEX tb_preparo_FKIndex3(idUsuario_fk)
);


CREATE TABLE tb_rel_perfil_preparolote (
  idRelPerfilPreparoLote INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPreparoLote_fk INTEGER UNSIGNED NOT NULL,
  idPerfilPaciente_fk INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idRelPerfilPreparoLote),
  INDEX tb_perfilPaciente_has_tb_preparo_extracao_FKIndex1(idPerfilPaciente_fk),
  INDEX tb_perfilPaciente_has_tb_preparo_extracao_FKIndex2(idPreparoLote_fk)
);


ALTER TABLE tb_infostubo ADD idLote_fk int(10) unsigned NULL default null;
ALTER TABLE tb_infostubo ADD FOREIGN KEY fk_idLote (idLote_fk) REFERENCES tb_lote (idLote);
CREATE INDEX statusTuboLote ON tb_lote ( statusLote)


Alter table tb_codgal add obsCodGAL varchar(300) default null;

update tb_codgal inner join tb_paciente on tb_codgal.idPaciente_fk = tb_paciente.idPaciente set
tb_codgal.obsCodGAL = tb_paciente.obsCodGAL where tb_paciente.idPaciente = tb_codgal.idPaciente_fk;


update tb_tubo set tipo = 'COLETA' where tuboOriginal = 's';


insert into tb_recurso (nome,s_n_menu,etapa) values ('realizar_preparo_inativacao','s','REALIZAR PREPARO/INATIVAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'realizar_preparo_inativacao'));

/* SELECT * from tb_infostubo where idTubo_fk = 29 order by idInfosTubo DESC LIMIT 1;*/

alter table tb_capela add nivelSeguranca varchar(10) not null;

alter table tb_infostubo add descarteNaEtapa char(1) default null;
alter table tb_infostubo add observacoes varchar(150) default null;

update tb_infostubo set  descarteNaEtapa = 's' where statusTubo = 'Descartado';
