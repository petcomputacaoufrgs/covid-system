insert into tb_recurso (nome,s_n_menu,etapa) values ('montar_placa_RTqPCR','n','MONTAGEM PLACA DE RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'montar_placa_RTqPCR'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('listar_montagem_placa_RTqPCR','n','LISTAR MONTAGEM PLACA DE RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'listar_montagem_placa_RTqPCR'));


     insert into tb_recurso (nome,s_n_menu,etapa) values ('imprimir_montagem_placa_RTqPCR','n','IMPRIMIR PLACA DE RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'imprimir_montagem_placa_RTqPCR'));



       CREATE TABLE tb_montagem_placa (
              idMontagemPlaca INTEGER(10)  NOT NULL AUTO_INCREMENT,
              idMix_fk int(10) not null,
              idUsuario_fk  int(10) UNSIGNED NOT NULL,
              dataHoraInicio  datetime NOT NULL,
              dataHoraFim datetime not NULL ,
              situacaoMontagemPlaca char(1) not NULL ,
              PRIMARY KEY(idMontagemPlaca)
        );
ALTER TABLE tb_montagem_placa ADD FOREIGN KEY fk_idMixMontagem (idMix_fk) REFERENCES tb_mix_placa (idMixPlaca);
ALTER TABLE tb_montagem_placa ADD FOREIGN KEY fk_idUsuarioMontagem (idUsuario_fk) REFERENCES tb_usuario
 (idUsuario);

    insert into tb_recurso (nome,s_n_menu,etapa) values ('remover_montagem_placa_RTqPCR','n','REMOVER MONTAGEM DA PLACA DE RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'remover_montagem_placa_RTqPCR'));
