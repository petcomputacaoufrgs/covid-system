
CREATE TABLE tb_resultado_rtpcr (
      idResultado INTEGER(10)  NOT NULL AUTO_INCREMENT,
      well VARCHAR(3) NULL,
      sampleName VARCHAR(100) NULL,
      targetName VARCHAR(30) NULL,
      task VARCHAR(30) NULL,
      reporter VARCHAR(10) NULL,
      ct DECIMAL (13) NULL,
      PRIMARY KEY(idResultado)
);

alter table tb_rtqpcr add horaFinal time not null ;