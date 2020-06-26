INSERT INTO tb_perfilpaciente  (perfil,index_perfil,caractere) VALUES ("Prefeitura de Porto Alegre","PREFEITURA DE PORTO ALEGRE","P");


CREATE TABLE tb_diagnostico (
              idDiagnostico INTEGER(10)  NOT NULL AUTO_INCREMENT,
              situacao char(1) not null,
              idAmostra_fk  int(10) unsigned NOT NULL ,
              diagnostico  char(1) NOT NULL,
              idUsuario_fk  int(10) UNSIGNED NOT NULL,
              dataHoraInicio  datetime NOT NULL,
              dataHoraFim datetime not NULL ,
              observacoes varchar(300) NULL ,
              reteste boolean not NULL ,
              volumeRestante varchar(6) not NULL ,
              PRIMARY KEY(idDiagnostico)
        );

ALTER TABLE tb_diagnostico ADD FOREIGN KEY fk_idAmostraDiag (idAmostra_fk) REFERENCES tb_amostra (idAmostra);
ALTER TABLE tb_diagnostico ADD FOREIGN KEY fk_idUsuarioDiag (idUsuario_fk) REFERENCES tb_usuario (idUsuario);


     insert into tb_recurso (nome,s_n_menu,etapa) values ('gerar_estatisticas_paciente','n','GERAR ESTATÍSTICAS DOS PACIENTES');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'gerar_estatisticas_paciente'));
