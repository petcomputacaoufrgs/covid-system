alter table tb_resultado_rtqpcr add idRTqPCR_fk INT(10)  not null ;
    ALTER TABLE tb_resultado_rtqpcr ADD FOREIGN KEY fk_idRTqPCRResultado (idRTqPCR_fk) REFERENCES tb_rtqpcr (idRTqPCR);


insert into tb_recurso (nome,s_n_menu,etapa) values ('gerar_planilha_correta','n','GERAR PLANILHA CORRETA');

insert into tb_rel_perfilusuario_recurso (idPerfilUsuario_fk,idRecurso_fk) VALUES
   ((SELECT idPerfilUsuario from tb_perfilusuario where index_perfil = 'ADMINISTRADOR'),
     (select idRecurso from tb_recurso where nome = 'gerar_planilha_correta'));