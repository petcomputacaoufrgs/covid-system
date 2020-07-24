 insert into tb_recurso (nome,s_n_menu,etapa) values ('realizar_reteste','n','REALIZAR RETESTE');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'realizar_reteste'));



     CREATE TABLE tb_analise_qualidade (
              idAnaliseQualidade INTEGER(10)  NOT NULL AUTO_INCREMENT,
              idAmostra_fk  int(10) unsigned NOT NULL ,
              idTubo_fk  int(10) unsigned NOT NULL ,
              observacoes  varchar(300) NULL,
              idUsuario_fk  int(10) UNSIGNED NOT NULL,
              dataHoraInicio  datetime NOT NULL,
              dataHoraFim datetime not NULL ,
              resultado char(1) NULL ,
              PRIMARY KEY(idAnaliseQualidade)
        );

ALTER TABLE tb_analise_qualidade ADD FOREIGN KEY fk_idAmostraQuali (idAmostra_fk) REFERENCES tb_amostra (idAmostra);
ALTER TABLE tb_analise_qualidade ADD FOREIGN KEY fk_idTuboQuali (idTubo_fk) REFERENCES tb_tubo (idTubo);
ALTER TABLE tb_analise_qualidade ADD FOREIGN KEY fk_idUsuarioQuali (idUsuario_fk) REFERENCES tb_usuario (idUsuario);

