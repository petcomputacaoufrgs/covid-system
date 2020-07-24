 insert into tb_recurso (nome,s_n_menu,etapa) values ('mix_placa_RTqPCR','n','MIX PLACA RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'mix_placa_RTqPCR'));


      insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_amostras_da_placa','n','REMOVER AMOSTRA(S) DA PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_amostras_da_placa'));



        insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_mix_placa_RTqPCR','n','LISTAR MIX PLACA RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_mix_placa_RTqPCR'));



     CREATE TABLE tb_mix_placa (
              idMixPlaca INTEGER(10)  NOT NULL AUTO_INCREMENT,
              situacaoMix char(1) not null,
              idSolicitacao_fk  int(11) NOT NULL ,
              idPlaca_fk  int(10) UNSIGNED NOT NULL,
              idUsuario_fk  int(10) UNSIGNED NOT NULL,
              dataHoraInicio  datetime NOT NULL,
              dataHoraFim datetime not NULL ,
              PRIMARY KEY(idMixPlaca)
        );
ALTER TABLE tb_mix_placa ADD FOREIGN KEY fk_idSolicitacao_mix (idSolicitacao_fk) REFERENCES tb_solicitacao_montagem_placa_rtqpcr (idSolicitacaoPlacaRTQPCR)
ALTER TABLE tb_mix_placa ADD FOREIGN KEY fk_idPlaca_mix (idPlaca_fk) REFERENCES tb_placa (idPlaca);
ALTER TABLE tb_mix_placa ADD FOREIGN KEY fk_idUsuario_mix (idUsuario_fk) REFERENCES tb_usuario (idUsuario);