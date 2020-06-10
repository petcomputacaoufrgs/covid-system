

CREATE TABLE tab_estado (
  cod_estado INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  sigla VARCHAR(2) NULL,
  nome VARCHAR(100) NULL,
  PRIMARY KEY(cod_estado)
);

CREATE TABLE tab_municipio (
  cod_municipio BIGINT(20) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NULL,
  PRIMARY KEY(cod_municipio)
);

CREATE TABLE tb_amostra (
  idAmostra INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPerfilPaciente_fk INTEGER UNSIGNED NOT NULL,
  idCodGAL_fk INTEGER UNSIGNED NULL,
  idNivelPrioridade_fk INTEGER UNSIGNED NULL,
  cod_municipio_fk BIGINT(20) NULL,
  cod_estado_fk INTEGER UNSIGNED NULL,
  idPaciente_fk INTEGER UNSIGNED NOT NULL,
  observacoes VARCHAR(300) NULL,
  dataColeta DATE NOT NULL,
  a_r_g CHAR(1) NOT NULL,
  CodigoAmostra VARCHAR(6) NOT NULL,
  motivo VARCHAR(200) NULL,
  horaColeta TIME NULL,
  CEP VARCHAR(8) NULL,
  PRIMARY KEY(idAmostra),
  INDEX tb_amostra_FKIndex3(idPaciente_fk),
  INDEX tb_amostra_FKIndex2(cod_municipio_fk),
  INDEX tb_amostra_FKIndex3(cod_estado_fk),
  INDEX tb_amostra_FKIndex4(idNivelPrioridade_fk),
  INDEX tb_amostra_FKIndex5(idCodGAL_fk),
  INDEX tb_amostra_FKIndex6(idPerfilPaciente_fk)
);

CREATE TABLE tb_armazenamento (
  idArmazenamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idLote_fk INTEGER UNSIGNED NOT NULL,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  dataHoraInicio DATETIME NOT NULL,
  dataHoraFim DATETIME NOT NULL,
  PRIMARY KEY(idArmazenamento),
  INDEX tb_armazenamento_FKIndex1(idLote_fk),
  INDEX tb_armazenamento_FKIndex2(idUsuario_fk)
);

CREATE TABLE tb_cadastroAmostra (
  idTubo_fk INTEGER UNSIGNED NOT NULL,
  idLocalArmazenamento INTEGER UNSIGNED NOT NULL,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  dataCadastroInicio DATETIME NOT NULL,
  dataCadastroFim DATETIME NOT NULL,
  INDEX tb_cadastroAmostra_FKIndex3(idUsuario_fk),
  INDEX tb_cadastroAmostra_FKIndex3(idLocalArmazenamento),
  INDEX tb_cadastroAmostra_FKIndex3(idTubo_fk)
);

CREATE TABLE tb_cadastroLocalArmazenamento (
  idCadastroLocalArm INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  idLocalArmazenamento_fk INTEGER UNSIGNED NOT NULL,
  dataHoraInicio DATETIME NOT NULL,
  dataHoraFim DATETIME NOT NULL,
  PRIMARY KEY(idCadastroLocalArm),
  INDEX tb_cadastroLocalArm_FKIndex1(idLocalArmazenamento_fk),
  INDEX tb_cadastroLocalArm_FKIndex2(idUsuario_fk)
);

CREATE TABLE tb_caixa (
  idCaixa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  numSlotsTotal INTEGER UNSIGNED NOT NULL,
  numSlotsVazios INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idCaixa)
);

CREATE TABLE tb_capela (
  idCapela INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  numero INTEGER UNSIGNED NOT NULL,
  statusCapela VARCHAR(100) NOT NULL,
  PRIMARY KEY(idCapela)
);

CREATE TABLE tb_codGAL (
  idCodGAL INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPaciente_fk INTEGER UNSIGNED NOT NULL,
  codigo BIGINT(20) NOT NULL,
  PRIMARY KEY(idCodGAL),
  INDEX tb_codGAL_FKIndex1(idPaciente_fk)
);

CREATE TABLE tb_detentor (
  idDetentor INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  detentor VARCHAR(100) NOT NULL,
  index_detentor VARCHAR(100) NOT NULL,
  PRIMARY KEY(idDetentor)
);

CREATE TABLE tb_doenca (
  idDoenca INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  doenca VARCHAR(100) NOT NULL,
  index_doenca VARCHAR(100) NOT NULL,
  PRIMARY KEY(idDoenca)
);

CREATE TABLE tb_equipamentos (
  idEquipamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idModelo_fk INTEGER UNSIGNED NOT NULL,
  idMarca_fk INTEGER UNSIGNED NOT NULL,
  idDetentor_fk INTEGER UNSIGNED NOT NULL,
  marca VARCHAR(100) NULL,
  modelo VARCHAR(100) NULL,
  dataUltimaCalibragem DATE NULL,
  dataChegada DATE NULL,
  statusEquipamento VARCHAR(100) NULL,
  PRIMARY KEY(idEquipamento),
  INDEX tb_equipamento_FKIndex1(idDetentor_fk),
  INDEX tb_equipamento_FKIndex2(idMarca_fk),
  INDEX tb_equipamento_FKIndex3(idModelo_fk)
);

CREATE TABLE tb_etnia (
  idEtnia INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  etnia VARCHAR(50) NOT NULL,
  index_etnia VARCHAR(50) NOT NULL,
  PRIMARY KEY(idEtnia)
);

CREATE TABLE tb_extracao (
  idExtracao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idRecursoExtracao_fk INTEGER UNSIGNED NOT NULL,
  idLote_fk INTEGER UNSIGNED NOT NULL,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  concentracao DOUBLE NOT NULL,
  pureza DOUBLE NOT NULL,
  260_280 DOUBLE NOT NULL,
  200_230 DOUBLE NOT NULL,
  dataHoraInicio DATE NOT NULL,
  dataHoraFim DATE NOT NULL,
  observacoes VARCHAR(300) NULL,
  PRIMARY KEY(idExtracao),
  INDEX tb_extracao_FKIndex1(idUsuario_fk),
  INDEX tb_extracao_FKIndex2(idLote_fk),
  INDEX tb_extracao_FKIndex3(idRecursoExtracao_fk)
);

CREATE TABLE tb_freezer (
  idFreezer INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  patrimonio BIGINT(6) NOT NULL,
  localizacao VARCHAR(100) NOT NULL,
  PRIMARY KEY(idFreezer)
);

CREATE TABLE tb_impressao (
  idImpressao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  dataHoraImpressao DATETIME NULL,
  PRIMARY KEY(idImpressao),
  INDEX tb_impressao_FKIndex2(idUsuario_fk)
);

CREATE TABLE tb_informacoes_tubo (
  idInfosTubo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idLote_fk INTEGER UNSIGNED NULL,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  idPosicao_fk INTEGER UNSIGNED NULL,
  idTubo_fk INTEGER UNSIGNED NULL,
  situacaoTubo CHAR(1) NULL,
  etapa CHAR(1) NULL,
  etapaAnterior CHAR(1) NULL,
  situacaoEtapa CHAR(1) NULL,
  dataHora DATETIME NOT NULL,
  reteste BOOL NULL,
  volume DOUBLE NULL,
  PRIMARY KEY(idInfosTubo)
  );
  ,
  INDEX tb_infosTubo_FKIndex1(idTubo_fk),
  INDEX tb_infosTubo_FKIndex2(idPosicao_fk),
  INDEX tb_infosTubo_FKIndex3(idUsuario_fk),
  INDEX tb_infosTubo_FKIndex4(idLote_fk)
);

CREATE TABLE tb_laudo (
  idLaudo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idAmostra_fk INTEGER UNSIGNED NOT NULL,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  dataHoraLiberacao DATETIME NOT NULL,
  observacoes VARCHAR(300) NULL,
  statusLaudo VARCHAR(50) NOT NULL,
  p_n_i CHAR(1) NOT NULL,
  PRIMARY KEY(idLaudo),
  INDEX tb_laudo_FKIndex1(idUsuario_fk),
  INDEX tb_laudo_FKIndex2(idAmostra_fk)
);

CREATE TABLE tb_localArmazenamento (
  idLocalArmazenamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idFreezer_fk INTEGER UNSIGNED NULL,
  idTemporario_fk INTEGER UNSIGNED NULL,
  PRIMARY KEY(idLocalArmazenamento),
  INDEX tb_localArmazenamento_FKIndex3(idTemporario_fk),
  INDEX tb_localArmazenamento_FKIndex4(idFreezer_fk)
);

CREATE TABLE tb_local_armazenamento (
  idLocalArmazenamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NULL,
  PRIMARY KEY(idLocalArmazenamento)
);

CREATE TABLE tb_log (
  idLog INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idUsuario INTEGER UNSIGNED NOT NULL,
  texto LONGTEXT NOT NULL,
  dataHora DATETIME NOT NULL,
  PRIMARY KEY(idLog),
  INDEX tb_log_FKIndex1(idUsuario)
);

CREATE TABLE tb_lote (
  idLote INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  qntAmostrasDesejada INTEGER UNSIGNED NOT NULL,
  qntAmostrasAdquiridas INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idLote)
);

CREATE TABLE tb_marca (
  idMarca INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  marca VARCHAR(100) NOT NULL,
  index_marca VARCHAR(100) NOT NULL,
  PRIMARY KEY(idMarca)
);

CREATE TABLE tb_modelo (
  idModelo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  modelo VARCHAR(100) NOT NULL,
  modelo_2 VARCHAR(100) NOT NULL,
  PRIMARY KEY(idModelo)
);

CREATE TABLE tb_niveis_prioridade (
  idNivelPrioridade INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nivel INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idNivelPrioridade)
);

CREATE TABLE tb_paciente (
  idPaciente INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idEtnia_fk INTEGER UNSIGNED NOT NULL,
  idSexo_fk INTEGER UNSIGNED NOT NULL,
  nome VARCHAR(130) NOT NULL,
  nomeMae VARCHAR(130) NULL,
  CPF VARCHAR(11) NOT NULL,
  RG VARCHAR(10) NULL,
  obsRG VARCHAR(150) NULL,
  obsSexo VARCHAR(150) NULL,
  dataNascimento DATE NOT NULL,
  obsNomeMae VARCHAR(150) NULL,
  CEP VARCHAR(8) NULL,
  endereco VARCHAR(150) NULL,
  passaporte VARCHAR(30) NULL,
  obsPassaporte VARCHAR(300) NULL,
  obsCEP VARCHAR(300) NULL,
  obsEndereco VARCHAR(300) NULL,
  obsCPF VARCHAR(300) NULL,
  PRIMARY KEY(idPaciente),
  INDEX tb_paciente_FKIndex3(idSexo_fk),
  INDEX tb_paciente_FKIndex2(idEtnia_fk)
);

CREATE TABLE tb_perfilPaciente (
  idPerfilPaciente INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  perfil VARCHAR(50) NOT NULL,
  index_perfil VARCHAR(50) NOT NULL,
  codigo_perfil CHAR(1) NOT NULL,
  PRIMARY KEY(idPerfilPaciente)
);

CREATE TABLE tb_perfilUsuario (
  idPerfilUsuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  index_nome VARCHAR(100) NOT NULL,
  PRIMARY KEY(idPerfilUsuario)
);

CREATE TABLE tb_placa (
  idPlaca INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  statusPlaca VARCHAR(100) NOT NULL,
  PRIMARY KEY(idPlaca)
);

CREATE TABLE tb_preparo_lote (
  idPreparo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  idCapela_fk INTEGER UNSIGNED NOT NULL,
  idLote_fk INTEGER UNSIGNED NOT NULL,
  dataHoraInicio DATETIME NOT NULL,
  dataHoraFim DATETIME NOT NULL,
  PRIMARY KEY(idPreparo),
  INDEX tb_preparo_FKIndex1(idLote_fk),
  INDEX tb_preparo_FKIndex2(idCapela_fk),
  INDEX tb_preparo_FKIndex3(idUsuario_fk)
);

CREATE TABLE tb_preparo_temporario (
  idPreparoTemporario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idCapela_fk INTEGER UNSIGNED NOT NULL,
  idLote_fk INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idPreparoTemporario),
  INDEX tb_preparo_temporario_FKIndex1(idLote_fk),
  INDEX tb_preparo_temporario_FKIndex2(idCapela_fk)
);

CREATE TABLE tb_recurso (
  idRecurso INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  s_n_menu CHAR(1) NOT NULL,
  etapa VARCHAR(100) NOT NULL,
  PRIMARY KEY(idRecurso)
);

CREATE TABLE tb_recursoExtracao (
  idRecursoExtracao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  statusRecursoExtracao VARCHAR(100) NOT NULL,
  PRIMARY KEY(idRecursoExtracao)
);

CREATE TABLE tb_rel_freezer_gaveta (
  idCaixa_fk INTEGER UNSIGNED NOT NULL,
  idFreezer_fk INTEGER UNSIGNED NOT NULL,
  INDEX tb_rel_freezer_gaveta_FKIndex1(idFreezer_fk),
  INDEX tb_rel_freezer_gaveta_FKIndex2(idCaixa_fk)
);

CREATE TABLE tb_rel_perfilUsuario_recurso (
  id_rel_perfilUsuario_recurso INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPerfilUsuario_fk INTEGER UNSIGNED NOT NULL,
  idRecurso_fk INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(id_rel_perfilUsuario_recurso, idPerfilUsuario_fk, idRecurso_fk),
  INDEX tb_rel_perfilUsuario_recurso_FKIndex1(idPerfilUsuario_fk),
  INDEX tb_rel_perfilUsuario_recurso_FKIndex2(idRecurso_fk)
);

CREATE TABLE tb_rel_perfil_preparolote (
  idRelPerfilPreparoLote INTEGER UNSIGNED NOT NULL,
  idPreparo_fk INTEGER UNSIGNED NOT NULL,
  idPerfilPaciente_fk INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idRelPerfilPreparoLote),
  INDEX tb_perfilPaciente_has_tb_preparo_extracao_FKIndex1(idPerfilPaciente_fk),
  INDEX tb_perfilPaciente_has_tb_preparo_extracao_FKIndex2(idPreparo_fk)
);

CREATE TABLE Tb_rel_tubo_lote (
  idRelTuboLote INTEGER UNSIGNED NOT NULL,
  idTubo_fk INTEGER UNSIGNED NOT NULL,
  idLote_fk INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idRelTuboLote),
  INDEX Table_rel_amostra_lote_FKIndex2(idLote_fk),
  INDEX Table_rel_amostra_lote_FKIndex2(idTubo_fk)
);

CREATE TABLE tb_rel_usuario_perfilUsuario (
  id_rel_usuario_perfilUsuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idPerfilUsuario_fk INTEGER UNSIGNED NOT NULL,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(id_rel_usuario_perfilUsuario, idPerfilUsuario_fk, idUsuario_fk),
  INDEX tb_rel_usuario_perfilUsuario_FKIndex1(idUsuario_fk),
  INDEX tb_rel_usuario_perfilUsuario_FKIndex2(idPerfilUsuario_fk)
);

CREATE TABLE tb_resultado_rtpcr (
  idResultado INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  idArquivo integer(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  well VARCHAR(3) NULL,
  sampleName VARCHAR(100) NULL,
  targetName VARCHAR(30) NULL,
  task VARCHAR(30) NULL,
  reporter VARCHAR(10) NULL,
  ct DOUBLE(13) NULL,
  PRIMARY KEY(idResultado)
);

CREATE TABLE tb_reteste (
  idReteste INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idExtracao_fk INTEGER UNSIGNED NULL,
  idTubo_fk INTEGER UNSIGNED NOT NULL,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  dataHoraInicio DATETIME NOT NULL,
  dataHoraFim DATETIME NOT NULL,
  PRIMARY KEY(idReteste),
  INDEX tb_reteste_FKIndex1(idUsuario_fk),
  INDEX tb_reteste_FKIndex3(idTubo_fk),
  INDEX tb_reteste_FKIndex3(idExtracao_fk)
);

CREATE TABLE tb_RTPCR (
  idRTPCR INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idUsuario_fk INTEGER UNSIGNED NOT NULL,
  idAmostra_fk INTEGER UNSIGNED NOT NULL,
  idEquipamento_fk INTEGER UNSIGNED NOT NULL,
  cqGeneRdRP INTEGER UNSIGNED NOT NULL,
  cqGeneE INTEGER UNSIGNED NOT NULL,
  p_n_i CHAR(1) NOT NULL,
  observacoes VARCHAR(300) NULL,
  dataHoraInicio DATETIME NOT NULL,
  dataHoraFim DATETIME NOT NULL,
  resteste BOOL NOT NULL,
  qnts_retestes INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idRTPCR),
  INDEX tb_RTPCR_FKIndex1(idEquipamento_fk),
  INDEX tb_RTPCR_FKIndex2(idAmostra_fk),
  INDEX tb_RTPCR_FKIndex3(idUsuario_fk)
);

CREATE TABLE tb_sexo (
  idSexo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  sexo VARCHAR(50) NOT NULL,
  index_sexo VARCHAR(50) NOT NULL,
  PRIMARY KEY(idSexo)
);

CREATE TABLE tb_temporario (
  idTemporario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  numSlotsTotal INTEGER UNSIGNED NOT NULL,
  numSlotsVazios INTEGER UNSIGNED NOT NULL,
  localizacao VARCHAR(100) NOT NULL,
  PRIMARY KEY(idTemporario)
);

CREATE TABLE tb_tubos (
  idTubo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idTubo_fk INTEGER UNSIGNED NULL,
  idAmostra_fk INTEGER UNSIGNED NOT NULL,
  tuboOriginal BOOL NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  PRIMARY KEY(idTubo),
  INDEX tb_tubos_FKIndex2(idAmostra_fk),
  INDEX tb_tubos_FKIndex2(idTubo_fk)
);

CREATE TABLE tb_Usuario (
  idUsuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  matricula VARCHAR(8) NULL,
  PRIMARY KEY(idUsuario)
);


