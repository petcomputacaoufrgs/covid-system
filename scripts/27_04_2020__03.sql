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



/*ALTER TABLE tb_lote DROP statusLote;