
 insert into tb_recurso (nome,s_n_menu,etapa) values ('verificar_amostras','n','VERIFICAR SE NÃO ACABOU O TEMPO DO RTqPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'verificar_amostras'));

     CREATE TABLE tb_calculo (
      idCalculo INTEGER(10)  NOT NULL AUTO_INCREMENT,
      idProtocolo_fk integer(10) not null,
      nome VARCHAR(50) not NULL,
      PRIMARY KEY(idCalculo)
    );

    ALTER TABLE tb_calculo ADD FOREIGN KEY fk_idProtocoloCalculo (idProtocolo_fk) REFERENCES tb_protocolo (idProtocolo);

    CREATE TABLE tb_operador (
      idOperador INTEGER(10)  NOT NULL AUTO_INCREMENT,
      idCalculo_fk INTEGER(10)  NOT NULL,
      nome VARCHAR(50) not NULL,
      valor VARCHAR(6) not NULL,
      PRIMARY KEY(idOperador)
    );
    ALTER TABLE tb_operador ADD FOREIGN KEY fk_idCalculoOperador (idCalculo_fk) REFERENCES tb_calculo (idCalculo);

    CREATE TABLE tb_rel_mix_operador (
         idRelMixOperador INTEGER(10)  NOT NULL AUTO_INCREMENT,
      idOperador_fk INTEGER(10)  NOT NULL ,
      idMix_fk INTEGER(10)  NOT NULL,
      valor decimal not NULL,
      PRIMARY KEY(idRelMixOperador)
    );
    ALTER TABLE tb_rel_mix_operador ADD FOREIGN KEY fk_idOperadorMix (idOperador_fk) REFERENCES tb_operador (idOperador);
    ALTER TABLE tb_rel_mix_operador ADD FOREIGN KEY fk_idMixOperador (idMix_fk) REFERENCES tb_mix_placa (idMixPlaca);



 insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_operador','n','CADASTRAR OPERADOR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_operador'));

      insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_operador','n','EDITAR OPERADOR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_operador'));

           insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_operador','n','LISTAR OPERADOR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_operador'));

           insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_operador','n','REMOVER OPERADOR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_operador'));



      insert into tb_recurso (nome,s_n_menu,etapa) values ('cadastrar_calculo','n','CADASTRAR CALCULO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'cadastrar_calculo'));

      insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_calculo','n','EDITAR CALCULO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_calculo'));

           insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_calculo','n','LISTAR CALCULO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_calculo'));

           insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_calculo','n','REMOVER CALCULO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_calculo'));



           insert into tb_recurso (nome,s_n_menu,etapa) values ('editar_tabelas_protocolos','n','EDITAR TABELAS DOS PROTOCOLOS');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'editar_tabelas_protocolos'));


