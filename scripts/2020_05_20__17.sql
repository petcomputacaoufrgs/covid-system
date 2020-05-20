alter table tb_preparo_lote add obsKitExtracao varchar(300) null;
alter table tb_preparo_lote add loteFabricacaoKitExtracao varchar(130) null;


    insert into tb_recurso (nome,s_n_menu,etapa) values ('mostrar_poco','n','MOSTRAR POÇO');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'mostrar_poco'));