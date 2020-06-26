alter table tb_preparo_lote add idKitExtracao_fk int(11)   null;
ALTER TABLE tb_preparo_lote ADD FOREIGN KEY fk_idKitExtracaoPrep (idKitExtracao_fk) REFERENCES tb_kits_extracao (idKitExtracao);