select tb_local_armazenamento.idLocalArmazenamento,tb_local_armazenamento.idTipoLocalArmazenamento_fk, tb_tipo_localarmazenamento.caractereTipo from
tb_posicao_caixa, tb_caixa, tb_coluna, tb_prateleira, tb_porta, tb_local_armazenamento, tb_tipo_localarmazenamento
where tb_posicao_caixa.idCaixa_fk=tb_caixa.idCaixa
and tb_caixa.idColuna_fk=tb_coluna.idColuna and tb_coluna.idPrateleira_fk=tb_prateleira.idPrateleira and tb_prateleira.idPorta_fk=tb_porta.idPorta
and tb_porta.idLocalArmazenamento_fk=tb_local_armazenamento.idLocalArmazenamento
and tb_posicao_caixa.idPosicaoCaixa  in  (66 ... 85)
and tb_posicao_caixa.situacaoPosicao= 'S'
and tb_tipo_localarmazenamento.caractereTipo = 'G' or
and tb_tipo_localarmazenamento.caractereTipo = 'B' or
and tb_tipo_localarmazenamento.idTipoLocalArmazenamento = tb_local_armazenamento.idTipoLocalArmazenamento_fk



select tb_local_armazenamento.idLocalArmazenamento,tb_local_armazenamento.idTipoLocalArmazenamento_fk, tb_tipo_localarmazenamento.caractereTipo
from tb_posicao_caixa, tb_caixa, tb_coluna, tb_prateleira, tb_porta, tb_local_armazenamento, tb_tipo_localarmazenamento
where tb_posicao_caixa.idCaixa_fk=tb_caixa.idCaixa
and tb_caixa.idColuna_fk=tb_coluna.idColuna
and tb_coluna.idPrateleira_fk=tb_prateleira.idPrateleira
and tb_prateleira.idPorta_fk=tb_porta.idPorta
and tb_porta.idLocalArmazenamento_fk=tb_local_armazenamento.idLocalArmazenamento
and tb_posicao_caixa.idPosicaoCaixa  = 27
and tb_posicao_caixa.situacaoPosicao= 'S'
and tb_tipo_localarmazenamento.caractereTipo = 'G'
or tb_tipo_localarmazenamento.caractereTipo = 'B'
and tb_tipo_localarmazenamento.idTipoLocalArmazenamento = tb_local_armazenamento.idTipoLocalArmazenamento_fk


select tb_local_armazenamento.idLocalArmazenamento,tb_local_armazenamento.idTipoLocalArmazenamento_fk, tb_tipo_localarmazenamento.caractereTipo
from tb_amostra,tb_posicao_caixa, tb_caixa, tb_coluna, tb_prateleira, tb_porta, tb_local_armazenamento, tb_tipo_localarmazenamento,tb_tubo,tb_infostubo
where tb_posicao_caixa.idCaixa_fk=tb_caixa.idCaixa
and tb_caixa.idColuna_fk=tb_coluna.idColuna
and tb_coluna.idPrateleira_fk=tb_prateleira.idPrateleira
and tb_prateleira.idPorta_fk=tb_porta.idPorta
and tb_porta.idLocalArmazenamento_fk=tb_local_armazenamento.idLocalArmazenamento
and tb_posicao_caixa.idPosicaoCaixa  = tb_infostubo.idPosicao_fk
and tb_infostubo.idTubo_fk = tb_tubo.idTubo
and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
and tb_posicao_caixa.situacaoPosicao= 'S'
and tb_tipo_localarmazenamento.caractereTipo = 'G'
or tb_tipo_localarmazenamento.caractereTipo = 'B'
and tb_tipo_localarmazenamento.idTipoLocalArmazenamento = tb_local_armazenamento.idTipoLocalArmazenamento_fk


select tb_amostra.idAmostra,tb_amostra.a_r_g, tb_tubo.idTubo, tb_infostubo.idInfosTubo,tb_infostubo.situacaoTubo,tb_infostubo.situacaoEtapa,tb_infostubo.etapa,tb_infostubo.idPosicao_fk
from tb_amostra,tb_tubo,tb_infostubo,tb_posicao_caixa
where tb_infostubo.idTubo_fk  = tb_tubo.idTubo
and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
and tb_infostubo.etapa = 'G'
and tb_infostubo.situacaoEtapa = 'U'
and tb_infostubo.situacaoTubo = 'S'
and tb_infostubo.idPosicao_fk = tb_posicao_caixa.idPosicaoCaixa


select tb_amostra.idAmostra,
    tb_amostra.a_r_g,
    tb_amostra.codigoAmostra,
    tb_perfilpaciente.caractere,
    tb_tubo.idTubo,
    tb_infostubo.idInfosTubo,
    tb_infostubo.situacaoTubo,
    tb_infostubo.situacaoEtapa,
    tb_infostubo.etapa,
    tb_infostubo.idPosicao_fk,
    tb_posicao_caixa.linha,
    tb_posicao_caixa.coluna,
    tb_caixa.idCaixa,
    tb_coluna.idColuna,
    tb_coluna.nome,
    tb_prateleira.idPrateleira,
    tb_prateleira.nome,
    tb_porta.idPorta,
    tb_porta.nome,
    tb_local_armazenamento.idLocalArmazenamento,
    tb_local_armazenamento.nome,
    tb_tipo_localarmazenamento.idTipoLocalArmazenamento,
    tb_tipo_localarmazenamento.caractereTipo
from tb_amostra,tb_tubo,tb_infostubo,tb_posicao_caixa,tb_caixa,tb_coluna,tb_prateleira,tb_porta,tb_local_armazenamento,tb_tipo_localarmazenamento,tb_perfilpaciente
where tb_infostubo.idTubo_fk  = tb_tubo.idTubo
and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
and tb_infostubo.etapa = 'G'
and tb_infostubo.situacaoEtapa = 'U'
and tb_infostubo.situacaoTubo = 'S'
and tb_infostubo.idPosicao_fk = tb_posicao_caixa.idPosicaoCaixa
and tb_posicao_caixa.idCaixa_fk = tb_caixa.idCaixa
and tb_caixa.idColuna_fk = tb_coluna.idColuna
and tb_coluna.idPrateleira_fk = tb_prateleira.idPrateleira
and tb_prateleira.idPorta_fk = tb_porta.idPorta
and tb_porta.idLocalArmazenamento_fk = tb_local_armazenamento.idLocalArmazenamento
and tb_tipo_localarmazenamento.idTipoLocalArmazenamento = tb_local_armazenamento.idTipoLocalArmazenamento_fk
and tb_tipo_localarmazenamento.caractereTipo = 'B'
and tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk



select tb_paciente.idPaciente,
                              tb_paciente.nome,
                              tb_paciente.idSexo_fk,
                              tb_paciente.idEtnia_fk,
                              tb_paciente.nomeMae,
                              tb_paciente.CPF,
                              tb_paciente.obsCPF,
                              tb_paciente.RG,
                              tb_paciente.obsRG,
                              tb_paciente.dataNascimento,
                              tb_paciente.obsNomeMae,
                              tb_paciente.endereco,
                              tb_paciente.CEP,
                              tb_paciente.passaporte,
                              tb_paciente.obsPassaporte,
                              tb_paciente.obsCEP,
                              tb_paciente.obsEndereco,
                              tb_paciente.cadastroPendente,
                              tb_paciente.cartaoSUS,
                              tb_paciente.obsCartaoSUS,
                              tb_paciente.obsDataNascimento,
                              tb_codgal.idCodGAL,
                              tb_codgal.obsCodGAL,
                              tb_codgal.codigo
                        from tb_paciente, tb_amostra, tb_codgal
                        where tb_paciente.idPaciente = tb_codgal.idPaciente_fk
                        and tb_amostra.idCodGAL_fk = tb_codgal.idCodGAL
                        and (tb_paciente.nome LIKE '%nome%'
                        and tb_codgal.codigo = 123456789012323)



                        select
                            tb_amostra.idAmostra,
                              tb_amostra.idCodGAL_fk,
                              tb_amostra.cod_municipio_fk,
                              tb_amostra.idPaciente_fk,
                              tb_amostra.observacoes,
                              tb_amostra.dataColeta,
                              tb_amostra.idPerfilPaciente_fk,
                              tb_amostra.horaColeta,
                              tb_amostra.motivo,
                              tb_amostra.CEP,
                              tb_amostra.codigoAmostra,
                              tb_amostra.obsMotivo,
                              tb_amostra.obsCEPAmostra,
                              tb_amostra.obsLugarOrigem,
                              tb_amostra.obsHoraColeta
                              tb_tubo.idTubo,
                              tb_tubo.tipo
                              from tb_tubo, tb_amostra
                              where tb_tubo.idAmostra_fk = tb_amostra.idAmostra
                              and tb_amostra.idAmostra in (119,120)



                              select count(*) from tb_codGAL

                              select count(*), tb_paciente.nome
                              from tb_paciente,tb_amostra
                              where tb_paciente.idPaciente = tb_amostra.idPaciente_fk
                              and tb_paciente.nome LIKE '%bruna%'
                              group by tb_paciente.nome
                              having count(*) >=1


                              SELECT * FROM tb_amostra WHERE tb_amostra.idAmostra NOT IN (SELECT idAmostra_fk FROM tb_tubo)

                              SELECT * FROM tb_tubo WHERE  idAmostra_fk NOT IN (SELECT idAmostra FROM tb_amostra)

                              SELECT tb_tubo.idTubo,tb_amostra.idAmostra,tb_amostra.a_r_g FROM tb_tubo,tb_amostra WHERE idTubo NOT IN (SELECT idTubo_fk FROM tb_infostubo)
                              and tb_amostra.idAmostra = tb_tubo.idAmostra_fk

                              SELECT * FROM tb_tubo WHERE idTubo NOT IN (SELECT idTubo_fk FROM tb_infostubo)
                              select idAmostra,a_r_g from tb_amostra where idAmostra in (SELECT idAmostra_fk FROM tb_tubo WHERE  idTubo NOT IN (SELECT idTubo_fk FROM tb_infostubo))

                              select tb_amostra.idAmostra,tb_amostra.a_r_g,tb_tubo.idTubo
                              from tb_amostra,tb_tubo
                              where idAmostra in (SELECT idAmostra_fk FROM tb_tubo WHERE idTubo NOT IN (SELECT idTubo_fk FROM tb_infostubo))
                                and tb_amostra.idAmostra = tb_tubo.idAmostra_fk



                                select DISTINCT
                        tb_amostra.idAmostra,
                        tb_amostra.codigoAmostra,
                        tb_amostra.dataColeta,
                        tb_perfilpaciente.idPerfilPaciente,
                        tb_perfilpaciente.caractere,
                        tb_tubo.idTubo,
                        tb_tubo.tuboOriginal,
                        tb_tubo.tipo as tipoTubo,
                        tb_infostubo.idInfosTubo,
                        tb_infostubo.situacaoTubo,
                        tb_infostubo.situacaoEtapa,
                        tb_infostubo.etapa,
                        tb_infostubo.idPosicao_fk
                    from tb_amostra,tb_tubo,tb_infostubo,tb_perfilpaciente
                    where tb_infostubo.idTubo_fk  = tb_tubo.idTubo
                    and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
                    and tb_infostubo.etapa = 'G'
                    and tb_infostubo.situacaoEtapa = 'U'
                    and tb_infostubo.situacaoTubo = 'S'
                    and tb_perfilpaciente.idPerfilPaciente in (2,4)
                    and tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk

                    order by tb_amostra.dataColeta
                    LIMIT 8



                    select DISTINCT tb_tubo.idTubo
                    from tb_amostra,tb_tubo,tb_infostubo,tb_perfilpaciente
                    where tb_infostubo.idTubo_fk = tb_tubo.idTubo
                    and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
                    and tb_infostubo.etapa = 'G'
                    and tb_infostubo.situacaoEtapa = 'U'
                    and tb_infostubo.situacaoTubo = 'S'
                    and tb_perfilpaciente.idPerfilPaciente in (2,4)
                    and tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk
                    order by tb_amostra.dataColeta LIMIT 8



select DISTINCT tb_local_armazenamento.nome,
tb_caixa.idCaixa
from tb_local_armazenamento, tb_tipo_localarmazenamento,tb_porta,tb_prateleira,tb_coluna,tb_caixa,tb_posicao_caixa
where tb_local_armazenamento.idTipoLocalArmazenamento_fk = tb_tipo_localarmazenamento.idTipoLocalArmazenamento
and tb_tipo_localarmazenamento.caractereTipo = 'B'
and tb_local_armazenamento.idLocalArmazenamento = tb_porta.idLocalArmazenamento_fk
and tb_porta.idPorta = tb_prateleira.idPorta_fk
and tb_prateleira.idPrateleira = tb_coluna.idPrateleira_fk
and tb_coluna.idColuna = tb_caixa.idColuna_fk
and tb_posicao_caixa.idCaixa_fk = tb_caixa.idCaixa


select DISTINCT tb_local_armazenamento.nome, tb_caixa.idCaixa, tb_posicao_caixa.idPosicaoCaixa
from tb_local_armazenamento, tb_tipo_localarmazenamento,tb_porta,tb_prateleira,tb_coluna,tb_caixa,tb_posicao_caixa
where tb_local_armazenamento.idTipoLocalArmazenamento_fk = tb_tipo_localarmazenamento.idTipoLocalArmazenamento
and tb_tipo_localarmazenamento.caractereTipo = 'B'
and tb_local_armazenamento.idLocalArmazenamento = tb_porta.idLocalArmazenamento_fk
and tb_porta.idPorta = tb_prateleira.idPorta_fk
and tb_prateleira.idPrateleira = tb_coluna.idPrateleira_fk
and tb_coluna.idColuna = tb_caixa.idColuna_fk
and tb_posicao_caixa.idCaixa_fk = tb_caixa.idCaixa
and tb_posicao_caixa.situacaoPosicao = 'C' limit 1


select DISTINCT tb_local_armazenamento.idLocalArmazenamento,
                tb_local_armazenamento.nome,
                tb_caixa.idCaixa,
                tb_posicao_caixa.idPosicaoCaixa,
                tb_posicao_caixa.linha,
                tb_posicao_caixa.coluna
from tb_local_armazenamento, tb_tipo_localarmazenamento,tb_porta,tb_prateleira,tb_coluna,tb_caixa,tb_posicao_caixa
where tb_local_armazenamento.idTipoLocalArmazenamento_fk = tb_tipo_localarmazenamento.idTipoLocalArmazenamento
and tb_tipo_localarmazenamento.caractereTipo = 'B'
and tb_local_armazenamento.idLocalArmazenamento = tb_porta.idLocalArmazenamento_fk
and tb_porta.idPorta = tb_prateleira.idPorta_fk
and tb_prateleira.idPrateleira = tb_coluna.idPrateleira_fk
and tb_coluna.idColuna = tb_caixa.idColuna_fk
and tb_posicao_caixa.idCaixa_fk = tb_caixa.idCaixa
and tb_posicao_caixa.situacaoPosicao = 'C' limit 2


1º - SELECT * FROM tb_tubo where tb_tubo.idTubo_fk = 70 and tb_tubo.tipo = 'A'; -- selecionou os tubos que foram originados do tubo de id 70
vai retornar 2 ids de tubos

2º para cada um eu pego o infos tubo maximo
SELECT max(idInfosTubo), idTubo_fk, volume from tb_infostubo where idTubo_fk = 602
SELECT max(idInfosTubo), idTubo_fk, volume from tb_infostubo where idTubo_fk = 603

depois só somo os volumes

SELECT * from tb_infostubo where idTubo_fk in (SELECT idTubo FROM tb_tubo where tb_tubo.idTubo_fk = 70 and tb_tubo.tipo = 'A') -- selecionou os infos tubos gerados


1º CONSEGUE TODOS OS TUBOS DA AMOSTRA
SELECT DISTINCT * FROM tb_tubo, tb_amostra
where tb_amostra.idAmostra = tb_tubo.idAmostra_fk
and tb_amostra.codigoAmostra = 'V84'

/---
SELECT DISTINCT idTubo FROM tb_tubo, tb_amostra
where tb_amostra.idAmostra = tb_tubo.idAmostra_fk
and tb_amostra.codigoAmostra = 'V84'

pra cada um ver
SELECT max(idInfosTubo), idTubo_fk, volume from tb_infostubo where idTubo_fk = 602
SELECT max(idInfosTubo), idTubo_fk, volume from tb_infostubo where idTubo_fk = 603
...

----/

SELECT DISTINCT sum(tb_infostubo.volume) FROM tb_tubo, tb_amostra,tb_infostubo
where tb_amostra.idAmostra = tb_tubo.idAmostra_fk
and tb_amostra.codigoAmostra = 'V84'
AND tb_tubo.idTubo = tb_infostubo.idTubo_fk



SELECT tb_amostra.idAmostra, tb_paciente.nome,tb_amostra.dataColeta, tb_perfilpaciente.perfil
FROM tb_laudo, tb_amostra, tb_paciente, tb_perfilpaciente, tb_codgal
where tb_laudo.idLaudo = 2
and tb_amostra.idPaciente_fk = tb_paciente.idPaciente
and tb_laudo.idAmostra_fk = tb_amostra.idAmostra
and tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk


select tb_codgal.codigo from tb_codgal, tb_paciente,tb_amostra where
tb_paciente.nome = 'paciente 2' and
tb_paciente.idPaciente = tb_codgal.idPaciente_fk
and tb_amostra.idCodGAL_fk = tb_codgal.idCodGAL




delete from tb_tubo;
delete from tb_infostubo;
delete from tb_lote;
delete from tb_preparo_lote;
delete from tb_local_armazenamento_texto;
delete from tb_rel_tubo_lote;


select * from tb_perfilpaciente,tb_tubo, tb_amostra, tb_infostubo
where tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk
and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
and tb_tubo.idTubo = tb_infostubo.idTubo_fk
and tb_infostubo.situacaoTubo = 'Q'


select distinct * from tb_amostra, tb_perfilpaciente, tb_tubo
where tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk
and tb_perfilpaciente.idPerfilPaciente = 2
and tb_tubo.idAmostra_fk = tb_amostra.idAmostra

select distinct tb_amostra.idAmostra,tb_amostra.nickname, tb_tubo.idTubo,tb_tubo.tuboOriginal,tb_tubo.tipo from tb_amostra, tb_perfilpaciente, tb_tubo
where tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk
and tb_perfilpaciente.idPerfilPaciente = 2
and tb_tubo.idAmostra_fk = tb_amostra.idAmostra

/* todas as amostras que não tem laudo, que são do perfil certo e que o tubo é do tipo RNA */
select * from tb_amostra, tb_tubo, tb_perfilpaciente
where tb_amostra.idAmostra not in (select idAmostra_fk from tb_laudo)
and tb_amostra.idAmostra = tb_tubo.idAmostra_fk
and tb_amostra.idPerfilPaciente_fk = tb_perfilpaciente.idPerfilPaciente
and tb_perfilpaciente.idPerfilPaciente = 2
and tb_tubo.tipo = 'N'

/* para cada um gerar o ultimo info tubo dos tubos gerados acima e que tenha como situação do tubo o 'aguardando RTqPCR' */
select max(tb_infostubo.idInfosTubo), tb_infostubo.situacaoTubo
from tb_infostubo
where tb_infostubo.idTubo_fk = 267
and tb_infostubo.situacaoTubo = 'Q'




