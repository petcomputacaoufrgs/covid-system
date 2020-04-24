Por conveniência, uma imagem de máquina virtual (VirtualBox) contendo um sistema GNU/Linux com o covid-system funcional (na versão de 24 de abril de 2020) pode ser encontrada no link

http://www.inf.ufrgs.br/~rma/Covid-24-abr-2020.ova

A instalação da máquina virtual foi preparada conforme descrito abaixo, podendo ser atualizada para a versão atual do sistema.

Detalhamos abaixo instruções para instalação local do covid-system em um sistema novo.

# 1. Preparando o sistema operacional

O Covid-System é desenvolvido utilizando tecnologias LAMP:
* Linux
* Apache
* MySQL/MariaDB
* PHP

É necessário inicialmente preparar um sistema GNU/Linux para hospedar o Covid-system. As instruções abaixo foram testadas no sistema Linux Mint 19.3 (Tricia), porém podem funcionar (com as devidas adaptações) em outras distribuições similares (como Ubuntu ou Debian).

No terminal, execute 

    sudo apt install git geany apache2 libapache2-mod-php mariadb-server php-xml php-mysql composer phpunit

O comando acima instala: servidor web (com módulo para rodar PHP), banco de dados MariaDB, ferramenta GIT e demais bibliotecas para teste e desenvolvimento, incluindo a IDE Geany.

Nota:
* Na sequência, serão configurados o servidor Apache (web) e o SGBD MariaDB (banco de dados) na mesma máquina GNU/Linux. 
* Na máquina virtual (previamente configurada seguindo essas instruções) definimos o seguinte usuário com status de administrador:

    User:     covid
    Password: covid


# 2. Baixando e instalando a versão estável do covid-system

Na máquina virtual instalamos o sistema em '/var/'. Como nesta temos somente um usuário administrador, vamos dar permissão total para acesso a essa pasta (note que isso não é recomendado em instalações compartilhadas). 

    sudo chmod 777 /var

Após dar as permissões, entre na pasta

    cd /var

e rode o seguinte comando para obter a versão estável (master branch) do covid-system:

    git clone https://github.com/petcomputacaoufrgs/covid-system

O comando acima cria a pasta '/var/covid-system' contendo o código-fonte do covid-system. Após isso, criamos links simbólicos para o sistema ser acessível a partir da raiz do apache (apagando o subdiretório www e a página default do apache, e substituindo as mesmas pelo covid-system). 

    cd /var
    sudo rm -rf www
    ln -s covid-system www
    cd covid-system
    ln -s public_html html



# 3. Preparando e povoando o SGBD (sistema gerenciador de banco de dados)

Após a etapa 1 temos o SGBD MariaDB instalado e rodando. Podemos interagir com ele através do aplicativo 'mysql'.

É necessário agora criar no SGBD um banco de dados para o covid-system. Na instalação da máquina virtual usamos:

    Database:     amostras_covid19
    User(DB):     covid
    Password(DB): covid


Execute o seguinte comando para criar a base de dados:

    echo "CREATE DATABASE amostras_covid19; CREATE USER 'covid'@'localhost' IDENTIFIED BY 'covid'; GRANT ALL PRIVILEGES ON *.* TO 'covid'@'localhost'; FLUSH PRIVILEGES;" | sudo mysql 


Dentro da pasta /var/covid-system/database/ há diversos diversos arquivos com nome no formato 'aaaa_mm_dd__hh.sql'. Esses arquivos são snapshots do conteúdo da base de dados de desenvolvimento. Todos esses arquivos devem ser incorporados à base de dados, em ordem, para reconstruir a última versão do esquema da mesma, através do seguinte comando:

    sudo mysql --database=amostras_covid19 --user='covid' --password='covid' < /var/covid-system/database/XXXX_XX_XX__XX.sql


IMPORTANTE: As instruções acima referem-se à instalação de uma base de dados local para desenvolvimento e teste. Em ambiente de produção, questões de segurança de acesso à base de dados devem ser levadas em consideração, sendo recomendado criar um usuário com senha significativa para a base de dados, políticas de acesso e realização de backups frequentes (em particular antes de qualquer alteração na mesma).

Após criar e povoar o banco de dados, deve-se informar ao sistema como o mesmo acessa o SGBD, atualizando a função 'getArray' do arquivo 

    '/var/covid-system/classes/Configuração.php'. 

Edite o arquivo para conter as informações corretas de endereço de servidor, nome da base de dados, usuário e senha, conforme abaixo.

    private function getArray(){
        return array(
            'versao' => '1.0.0',
            'producao' => false,

            'banco' => array(
                'servidor' => 'localhost',
                'nome'     => 'amostras_covid19',
                'usuario'  => 'covid',
                'senha'    => 'covid'),
        );
    }
    

Por garantia, reinicie o SGBD e o servidor apache antes de testar a instalação:

    sudo systemctl restart apache2
    sudo systemctl restart mariadb


# 4. Testando o sistema:


Se não houve nenhum erro em alguma etapa anterior, o sistema deve estar instalado e funcionando.

Abra o navegador e o direcione para 

    http://localhost/

A tela de login deve aparecer. Utilize o seguinte usuário de teste:

    User:     U10 
    Password: U10

Após o login, deve aparecer a tela de cadastro de amostra e consultas. Se algum erro ocorrer nessa etapa, como "Error loading character set utf8:", a aplicação PHP não está conseguindo conectar ao SGBD.


Para rodar os testes unitários automatizados do sistema, você pode executar:

    phpunit /var/covid-system/tests



# 5. Atualizando o sistema para a versão atual


*Aplicação:* rode os seguintes comandos para atualizar o sistema para a versão atual (i.e. o código presente no branch 'master').

    cd /var/covid-system
    git pull

Note que o comando acima atualiza somente o código-fonte da aplicação, sem afetar o estado do banco de dados.

Verifique também se a atualização não alterou as informações de acesso ao SGBD no arquivo /var/covid-system/classes/Configuracao.php


*Banco de Dados:* se houver arquivos aaaa_mm_dd__hh.sql em /var/covid-system/database/ posteriores à data da última atualização, os mesmo precisam ser incorporados ao banco de dados através do comando abaixo, para deixar o esquema de dados consistente com a última versão da aplicação. 

    sudo mysql --database=amostras_covid19 --user='covid' --password='covid' < /var/covid-system/database/XXXX_XX_XX__XX.sql

 

