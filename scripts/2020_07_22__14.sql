 CREATE TABLE tb_laudo_protocolo (
              idRelLaudoProtocolo INTEGER(10)  NOT NULL AUTO_INCREMENT,
              idLaudo_fk  int(10) unsigned NOT NULL ,
              idProtocolo_fk  int(10) NOT NULL ,
              PRIMARY KEY(idRelLaudoProtocolo)
        );

ALTER TABLE tb_laudo_protocolo ADD FOREIGN KEY fk_idRelProtocoloLaudo (idProtocolo_fk) REFERENCES tb_protocolo (idProtocolo);
ALTER TABLE tb_laudo_protocolo ADD FOREIGN KEY fk_idRelLaudoProtocolo (idLaudo_fk) REFERENCES tb_laudo (idLaudo);

 CREATE TABLE tb_laudo_kitextracao (
              idRelLaudoKitExtracao INTEGER(10)  NOT NULL AUTO_INCREMENT,
              idLaudo_fk  int(10) unsigned NOT NULL ,
              idKitExtracao_fk  int(11) NOT NULL ,
              PRIMARY KEY(idRelLaudoKitExtracao)
        );

ALTER TABLE tb_laudo_kitextracao ADD FOREIGN KEY fk_idRelKitExtracaoLaudo (idKitExtracao_fk) REFERENCES tb_kits_extracao (idKitExtracao);
ALTER TABLE tb_laudo_kitextracao ADD FOREIGN KEY fk_idRelLaudoKitExtracao (idLaudo_fk) REFERENCES tb_laudo (idLaudo);


alter table tb_paciente add numero int(10) null;
alter table tb_paciente add complemento varchar(50) null;
alter table tb_paciente add bairro varchar(50) null;
