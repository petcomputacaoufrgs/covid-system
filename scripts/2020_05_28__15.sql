
      insert into tb_recurso (nome,s_n_menu,etapa) values ('imprimir_mix_placa_RTqPCR','n','IMPRIMIR MIX DA PLACA DE RTQPCR');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'imprimir_mix_placa_RTqPCR'));

     alter table tb_preparo_lote add nomeResponsavel varchar(200) null;
     alter table tb_preparo_lote add idResponsavel int(10) unsigned null;
     ALTER TABLE tb_preparo_lote ADD FOREIGN KEY fk_idUsuarioRespon (idResponsavel) REFERENCES tb_usuario (idUsuario);
