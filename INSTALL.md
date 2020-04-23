Detalhamos abaixo instruções para instalação local do covid-system.

Por conveniência, uma imagem de máquina virtual (VirtualBox) contendo uma instalação funcional do sistema (na versão de 22 de abril de 2020) pode ser encontrada no link

    http://www.inf.ufrgs.br/~rma/Covid-22-abr-2020.ova

a mesma pode ser atualizada para a versão atual via GIT, conforme descrito abaixo.


# 1. Preparando o sistema operacional

O Covid-System é desenvolvido utilizando tecnologias LAMP:
* Linux
* Apache
* MySQL/MariaDB
* PHP

É necessário inicialmente preparar um sistema GNU/Linux para hospedar o Covid-system. As instruções abaixo foram testadas no sistema Linux Mint 19.3 (Tricia), porém podem funcionar (com as devidas adaptações) em outras distribuições similares (como Ubuntu ou Debian).

No terminal, execute 

    sudo apt install git geany apache2 libapache2-mod-php mariadb-server php-xml php-mysql composer phpunit

O comando acima instala: servidor web (com módulo para rodar PHP), banco de dados MariaDB, ferramenta GIT e demais bibliotecas para teste e desenvolvimento (incluindo a IDE Geany).

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

É necessário agora criar no SGBD um banco de dados para o covid-system, assim como um usuário com permissões adequadas para acessá-lo. Na instalação da máquina virtual usamos:

    Database:     amostras_covid19
    User(DB):     covid
    Password(DB): covid


Para criar database e usuário, acesse o prompt do SGBD com 

    sudo mysql

e, dentro do prompt, digite

    CREATE DATABASE amostras_covid19;
    CREATE USER 'covid'@'localhost' IDENTIFIED BY 'covid';
    GRANT ALL PRIVILEGES ON *.* TO 'covid'@'localhost';
    FLUSH PRIVILEGES;
    QUIT;

Após criar o usuário e database, o banco de dados pode ser povoado com o seguinte comando.

    sudo mysql --database=amostras_covid19 --user 'covid' --password 'covid'  < /var/covid-system/db_XXXX.sql

Nota: no comando acima, o arquivo db_XXXX.sql corresponde ao 'dump' do banco de dados associado à data em questão. Esse arquivo se encontra dentro do diretório /var/covid-system.

Após criar e povoar o banco de dados, deve-se informar ao sistema como o mesmo acessa o SGBD (através do arquivo config.php)

    cd /var/covid-system
    cp config.php.default config.php

Edite o arquivo config.php para conter as informações do SGBD, como abaixo:

    <?php
    $config = array(
      'versao' => '1.0.0',
      'producao' => false,
      'banco' => array(
        'servidor' => 'localhost', 
        'nome'     => 'amostras_covid19',
        'usuario'  => 'covid',
        'senha'    => 'covid'
        ),
    );

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


Para rodar os testes unitários automatizados do sistema, você pode executar:

    phpunit /var/covid-system/tests



# 5. Atualizando o sistema para a versão atual

Rode os seguintes comandos para atualizar o sistema para a versão atual (i.e. o código presente no branch 'master').

    cd /var/covid-system
    git pull

Note: o comando acima atualiza somente o código-fonte da aplicação: nenhuma alteração no estado do banco de dados é realizada.
