alter table tb_equipamento add nomeEquipamento varchar(150) null;
alter table tb_equipamento add situacaoEquipamento char(1) not null;
alter table tb_equipamento add idUsuario_fk integer(10) not null;
alter table tb_equipamento add dataCadastro datetime not null;
alter table tb_equipamento add horas int(2) not null;
alter table tb_equipamento add minutos int(2) not null;


insert into tb_recurso (nome,s_n_menu,etapa) values ('analisar_RTqPCR','n','ANÁLISE RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'analisar_RTqPCR'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('finalizar_RTqPCR','n','FINALIZAÇÃO RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'finalizar_RTqPCR'));


      CREATE TABLE tb_rtqpcr (
              idRTqPCR INTEGER(10)  NOT NULL AUTO_INCREMENT,
              idPlaca_fk int(10) UNSIGNED NOT NULL,
              idUsuario_fk  int(10) UNSIGNED NOT NULL,
              idEquipamento_fk  int(10) UNSIGNED NOT NULL,
              dataHoraInicio  datetime NOT NULL,
              dataHoraFim datetime not NULL ,
              situacaoRTqPCR char(1) not NULL ,
              PRIMARY KEY(idRTqPCR)
        );
ALTER TABLE tb_rtqpcr ADD FOREIGN KEY fk_idPlacaRTqPCR (idPlaca_fk) REFERENCES tb_placa (idPlaca);
ALTER TABLE tb_rtqpcr ADD FOREIGN KEY fk_idUsuarioRTqPCR (idUsuario_fk) REFERENCES tb_usuario
 (idUsuario);
 ALTER TABLE tb_rtqpcr ADD FOREIGN KEY fk_idEquipamentoRTqPCR (idEquipamento_fk) REFERENCES tb_equipamento
 (idEquipamento);


 insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_analise_RTqPCR','n','LISTAR ANÁLISE RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_analise_RTqPCR'));