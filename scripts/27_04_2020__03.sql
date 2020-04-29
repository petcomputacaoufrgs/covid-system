alter table tb_infostubo add obsProblema varchar(150) default null;
ALTER TABLE tb_paciente  DROP COLUMN obsCodGAL;
insert into tb_recurso (nome,s_n_menu,etapa) values ('rastrear_amostras','s','RASTREAMENTO DAS AMOSTRAS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'rastrear_amostras'));


/* ADMIN PARA REMOVER AMOSTRA
INSERT INTO tb_usuario (matricula,senha) VALUES ('admCovid','admin');
INSERT INTO tb_rel_usuario_perfilusuario (idPerfilUsuario_fk,idUsuario_fk) VALUES (
    (select idPerfilUsuario from tb_perfilusuario where INDEX_PERFIL = 'ADMINISTRADOR'),
    (select idUsuario from tb_usuario where matricula = 'admCovid'));
*/

/*alter table tb_lote add statusPreparoLote varchar(50) not null;*/


alter table tb_capela add situacaoCapela char(1) not null;
ALTER TABLE tb_capela DROP statusCapela;

alter table tb_lote add situacaoLote char(1) not null;
ALTER TABLE tb_lote DROP statusLote;


alter table tb_infostubo add situacaoTubo char(1) not null;
alter table tb_infostubo add situacaoEtapa char(1) not null;

update tb_infostubo set situacaoTubo= 'D' where statusTubo = 'Descartado';
update tb_infostubo set situacaoTubo= 'S' where statusTubo = '(RECEPÇÃO) Aguardando preparação';
update tb_infostubo set situacaoEtapa= 'F' where etapa = 'emitir laudo - descarte na recepção' or etapa = 'recepção - finalizada';
update tb_infostubo set etapa= 'R' where etapa = 'emitir laudo - descarte na recepção' or etapa = 'recepção - finalizada';

alter table tb_infostubo drop descarteNaEtapa;
ALTER TABLE tb_infostubo DROP statusTubo;
alter table tb_infostubo add etapaAnterior char(1) null;
update tb_infostubo set etapaAnterior= null where etapa = 'R';
update tb_infostubo set etapaAnterior= 'R' where etapa = 'G';


insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_localArmazenamento','s','CADASTRAR LOCAL DE ARMAZENAMENTO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_localArmazenamento'));

insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_localArmazenamento','s','EDITAR LOCAL DE ARMAZENAMENTO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_localArmazenamento'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_tipoLocalArmazenamento','s','CADASTRAR TIPO DE LOCAL DE ARMAZENAMENTO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_tipoLocalArmazenamento'));

insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_tipoLocalArmazenamento','s','EDITAR TIPO DE LOCAL DE ARMAZENAMENTO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_tipoLocalArmazenamento'));

insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_tipoLocalArmazenamento','s','LISTAR TIPO DE LOCAL DE ARMAZENAMENTO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_tipoLocalArmazenamento'));

CREATE TABLE tb_caixa (
  idCaixa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idColuna_fk INTEGER UNSIGNED NOT NULL,
  posicao VARCHAR(4) NOT NULL,
  qntSlotsOcupados INTEGER UNSIGNED NULL,
  qntSlotsVazios INTEGER UNSIGNED NULL,
  qntLinhas INTEGER UNSIGNED NULL,
  qntColunas INTEGER UNSIGNED NULL,
  PRIMARY KEY(idCaixa),
  INDEX tb_caixa_FKIndex1(idColuna_fk)
);

CREATE TABLE tb_coluna (
  idColuna INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPrateleira_fk INTEGER UNSIGNED NOT NULL,
  nome VARCHAR(100) NOT NULL,
  situacaoColuna CHAR(1) NULL,
  PRIMARY KEY(idColuna),
  INDEX tb_coluna_FKIndex1(idPrateleira_fk)
);

CREATE TABLE tb_local_armazenamento (
  idLocalArmazenamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idTipoLocalArmazenamento_fk INTEGER UNSIGNED NOT NULL,
  nome VARCHAR(100) NOT NULL,
  PRIMARY KEY(idLocalArmazenamento),
  INDEX tb_freezer_FKIndex1(idTipoLocalArmazenamento_fk)
);

CREATE TABLE tb_porta (
  idPorta INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idLocalArmazenamento_fk INTEGER UNSIGNED NOT NULL,
  nome VARCHAR(100) NOT NULL,
  situacaoPorta CHAR(1) NULL,
  PRIMARY KEY(idPorta),
  INDEX tb_porta_FKIndex1(idLocalArmazenamento_fk)
);

CREATE TABLE tb_prateleira (
  idPrateleira INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPorta_fk INTEGER UNSIGNED NOT NULL,
  nome VARCHAR(100) NOT NULL,
  situacaoPrateleira CHAR(1) NULL,
  PRIMARY KEY(idPrateleira),
  INDEX tb_prateleira_FKIndex1(idPorta_fk)
);

CREATE TABLE tb_tipo_localarmazenamento (
  idTipoLocalArmazenamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tipo VARCHAR(100) NOT NULL,
  index_tipo VARCHAR(100) NOT NULL,
  PRIMARY KEY(idTipoLocalArmazenamento)
);


insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_tipoLocalArmazenamento','s','REMOVER TIPO DE LOCAL DE ARMAZENAMENTO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_tipoLocalArmazenamento'));


alter table tb_caixa add nome varchar(100) not null;
ALTER TABLE tb_caixa DROP posicao;

CREATE TABLE tb_posicao_caixa (
  idPosicaoCaixa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idCaixa_fk INTEGER UNSIGNED NOT NULL,
  linha VARCHAR(10) NULL,
  coluna VARCHAR(10) NULL,
  situacaoPosicao CHAR(1) NULL,
  PRIMARY KEY(idPosicaoCaixa),
  INDEX tb_posicaoCaixa_FKIndex1(idCaixa_fk)
);
ALTER TABLE tb_posicao_caixa ADD FOREIGN KEY fk_idcaixa (idCaixa_fk) REFERENCES tb_caixa (idCaixa);
alter table tb_posicao_caixa add idTubo_fk int(10) null;

insert into tb_recurso (nome,s_n_menu,etapa) values ('mostrar_localArmazenamento','s','MOSTRAR LOCAL DE ARMAZENAMENTO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'mostrar_localArmazenamento'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_caixa','s','EDITAR CAIXA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_caixa'));


alter table tb_infostubo add idPosicao_fk int(10) unsigned null;
ALTER TABLE tb_infostubo ADD FOREIGN KEY fk_idPosicao (idPosicao_fk) REFERENCES tb_posicao_caixa (idPosicaoCaixa);
ALTER TABLE tb_infostubo DROP idLocalArmazenamento_fk;
alter table tb_tipo_localarmazenamento add caractereTipo char(1) not null;

alter table tb_capela drop nivelSeguranca;
alter table tb_capela add nivelSeguranca char(1) not null;