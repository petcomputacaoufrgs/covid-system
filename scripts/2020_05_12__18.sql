insert into tb_recurso (nome,s_n_menu,etapa) values ('solicitar_montagem_placa_RTqPCR','s','SOLICITAR MONTAGEM DA PLACA DE RTqPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'solicitar_montagem_placa_RTqPCR'));


     CREATE TABLE tb_protocolo (
          idProtocolo  INTEGER(10)  NOT NULL AUTO_INCREMENT,
          protocolo VARCHAR(150)  NOT NULL,
          numMax_amostras integer(3) not null,
          index_protocolo VARCHAR(150)  NOT NULL,
          PRIMARY KEY(idProtocolo)
        );


        CREATE TABLE tb_placa (
          idPlaca   INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          idProtocolo_fk   INTEGER(10)  NOT NULL,
          placa VARCHAR(150)  NULL,
          index_placa VARCHAR(150)  NULL,
          situacaoPlaca CHAR(1)  NOT NULL,
          PRIMARY KEY(idPlaca)
        );
        ALTER TABLE tb_placa ADD FOREIGN KEY fk_idProtocolo (idProtocolo_fk) REFERENCES tb_protocolo (idProtocolo);

        CREATE TABLE tb_rel_perfil_placa (
          idRelPerfilPlaca INTEGER(11)  NOT NULL AUTO_INCREMENT,
          idPerfil_fk   integer(10) UNSIGNED not NULL,
          idPlaca_fk  integer(10) UNSIGNED not  NULL,
          PRIMARY KEY(idRelPerfilPlaca)
        );
        ALTER TABLE tb_rel_perfil_placa ADD FOREIGN KEY fk_idPerfil (idPerfil_fk) REFERENCES tb_perfilpaciente (idPerfilPaciente);
        ALTER TABLE tb_rel_perfil_placa ADD FOREIGN KEY fk_idPlaca2 (idPlaca_fk) REFERENCES tb_placa (idPlaca);


         CREATE TABLE tb_rel_tubo_placa (
          idRelTuboPlaca INTEGER(11)  NOT NULL AUTO_INCREMENT,
          idTubo_fk   integer(10) UNSIGNED not NULL,
          idPlaca_fk  integer(10) UNSIGNED not  NULL,
          PRIMARY KEY(idRelTuboPlaca)
        );
        ALTER TABLE tb_rel_tubo_placa ADD FOREIGN KEY fk_idTubo (idTubo_fk) REFERENCES tb_tubo (idTubo);
        ALTER TABLE tb_rel_tubo_placa ADD FOREIGN KEY fk_idPlaca (idPlaca_fk) REFERENCES tb_placa (idPlaca);


      CREATE TABLE tb_solicitacao_montagem_placa_rtqpcr (
              idSolicitacaoPlacaRTQPCR INTEGER(11)  NOT NULL AUTO_INCREMENT,
              idUsuario_fk  INTEGER(10) UNSIGNED NOT NULL ,
              idPlaca_fk  INTEGER(10) UNSIGNED NOT NULL ,
              situacaoSolicitacao char(1) NULL,
              dataHoraInicio datetime  NOT NULL,
              dataHoraFim datetime  NOT NULL,
              PRIMARY KEY(idSolicitacaoPlacaRTQPCR)
        );

        ALTER TABLE tb_solicitacao_montagem_placa_rtqpcr ADD FOREIGN KEY fk_idPlaca_solicitacao (idPlaca_fk) REFERENCES tb_placa (idPlaca);
        ALTER TABLE tb_solicitacao_montagem_placa_rtqpcr ADD FOREIGN KEY fk_idUsuario_solicitacao (idUsuario_fk) REFERENCES tb_usuario (idUsuario);


insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_protocolo','s','CADASTRAR PROTOCOLO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_protocolo'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_protocolo','s','EDITAR PROTOCOLO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_protocolo'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_protocolo','s','LISTAR PROTOCOLO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_protocolo'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_protocolo','s','REMOVER PROTOCOLO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_protocolo'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_placa','s','CADASTRAR PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_placa'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_placa','s','EDITAR PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_placa'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_placa','s','LISTAR PLACAS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_placa'));


insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_placa','s','REMOVER PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_placa'));


