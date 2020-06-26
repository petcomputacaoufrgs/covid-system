     insert into tb_recurso (nome,s_n_menu,etapa) values ('realizar_extracao','n','REALIZAR EXTRAÇÃO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'realizar_extracao'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('imprimir_montagem_placa_RTqPCR','n','IMPRIMIR A SOLICITAÇÃO DE MONTAGEM DA PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'imprimir_montagem_placa_RTqPCR'));


        insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_montagem_placa_RTqPCR','n','REMOVER A SOLICITAÇÃO DE MONTAGEM DA PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_montagem_placa_RTqPCR'));



          insert into tb_recurso (nome,s_n_menu,etapa) values ('imprimir_solicitacao_montagem_placa_RTqPCR','n','IMPRIMIR A SOLICITAÇÃO DE MONTAGEM DA PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'imprimir_solicitacao_montagem_placa_RTqPCR'));


        insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_solicitacao_montagem_placa_RTqPCR','n','REMOVER A SOLICITAÇÃO DE MONTAGEM DA PLACA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_solicitacao_montagem_placa_RTqPCR'));



     alter table tb_protocolo add numDivisoes integer(4) not null;
      CREATE TABLE tb_divisao_protocolo (
              idDivisaoProtocolo INTEGER(11)  NOT NULL AUTO_INCREMENT,
              idProtocolo_fk  INTEGER(11) NOT NULL ,
              nomeDivisao  VARCHAR(50) NOT NULL,
              PRIMARY KEY(idDivisaoProtocolo)
        );
        ALTER TABLE tb_divisao_protocolo ADD FOREIGN KEY fk_idProtocolo_divisao (idProtocolo_fk) REFERENCES tb_protocolo (idProtocolo);


        CREATE TABLE tb_poco (
              idPoco INTEGER(11)  NOT NULL AUTO_INCREMENT,
              linha  varchar(6) NOT NULL ,
              coluna  varchar(6) NOT NULL,
              situacao  char(1) NOT NULL,
              idTubo_fk INTEGER(10)  NULL ,
              PRIMARY KEY(idPoco)
        );

        CREATE TABLE tb_pocos_placa (
              idPocosPlaca INTEGER(11)  NOT NULL AUTO_INCREMENT,
              idPlaca_fk INTEGER(10) unsigned  NOT NULL,
              idPoco_fk INTEGER(11)  NOT NULL,
              PRIMARY KEY(idPocosPlaca)
        );
        ALTER TABLE tb_pocos_placa ADD FOREIGN KEY fk_idPlaca_Poco (idPlaca_fk) REFERENCES tb_placa (idPlaca);
        ALTER TABLE tb_pocos_placa ADD FOREIGN KEY fk_idPoco_Placa (idPoco_fk) REFERENCES tb_poco (idPoco);



        insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_divisao_protocolo','n','CADASTRAR DIVISÃO DO PROTOCOLO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_divisao_protocolo'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_divisao_protocolo','n','EDITAR DIVISÃO DO PROTOCOLO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_divisao_protocolo'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_divisao_protocolo','n','LISTAR AS DIVISÕES DOS PROTOCOLOS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_divisao_protocolo'));

     insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_divisao_protocolo','n','REMOVER DIVISÃO DO PROTOCOLO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_divisao_protocolo'));

      insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_poco','n','CADASTRAR POÇO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_poco'));