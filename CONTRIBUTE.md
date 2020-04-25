# Instruções para colaborar com o projeto Covid-system:

## Pré-requisitos

Para colaborar com o desenvolvimento de código, é desejável algum conhecimento em desenvolvimento web com PHP, sistemas de banco de dados e ferramenta GIT para versionamento. Contudo, há espaço para quem não conhece as tecnologias acima para ajudar em diversas tarefas: testando o sistema, reportando bugs, documentando, criando telas, etc. O principal pré-requisito é responsabilidade e dedicação.



**Quero ajudar com o desenvolvimento! Como faço?**


### 1. Acesse o repositório em:

    https://github.com/petcomputacaoufrgs/covid-system


### 2. Obtenha a última versão do sistema. 

Há duas opções:
     
 a) Seguir as instruções do arquivo INSTALL.md, e instalar uma versão local em um sistema GNU/Linux, ou 

 b) Baixar uma máquina virtual Linux com o covid-system já instalado e rodar a mesma sob o sistema de virtualização VirtualBox. O link para a mesma está descrito em INSTALL.md. Após baixar e instalar a imagem da máquina virtual, atualize o covid-system para a última versão conforme descrito nas instruções.


### 3. Visão geral da arquitetura do sistema: 


Todos os dados são armazenados no SGBD relacional. Em linhas gerais, a estrutura de diretórios é a seguinte:

    public_html/                       contém as páginas principais, incluindo
    public_html/controlador.php        o principal módulo que invoca as ações do sistema
    public_html/index.php              a página principal de login

    classes/               contém o código associado a cada classe do sistema, cada uma em três arquivos:
    classes/Nome           descriçao da classes, construtores, getters & setters
    classes/NomeBD         funções de interação com o banco de dados (wrappers) 
    classes/NomeRN         regras de negócio de cada classe (validação de campos, funções de inclusão e alteração de cadastro, etc.)



## 4. Propondo alterações / bugfixes e desenvolvendo novos módulos

  Qualquer alteração no sistema deve ser realizado da seguinte forma:

  1. Garanta que você tem a última versão do repositório, no branch master
   
         cd /var/covid-system
         git pull                # sincroniza com o servidor
         git branch -a           # ver os branches
         git checkout master     # muda para o master

  1. Crie um branch local para trabalhar, e envie o mesmo para o servidor

         git branch   novafeature                     # cria o branch 
         git checkout novafeature                     # altera para o novo branch
         git push --set-upstream origin novafeature   # envia o branch local para o servidor 

  1. Desenvolva o sistema nesse branch, até ter uma versão estável do código. Adicione os arquivos alterados e crie um 'commit' com uma mensagem explicando as alterações. Ao final, faça um 'push' para enviar o seu branch para o servidor.

          git add arquivoModificado1.php
          git add arquivoModificado2.php
          ...
          git commit -m "implementei a novafeature"
          git push

  1. No GitHub, selecione o seu branch e crie um *pull request* via interface. Um *pull request* é uma solicitação para o time principal da incorporação de um dado código ao branch master do projeto. Os *pull requests* serão avaliados pelos integrantes do time principal, e se tudo estiver OK eles farão o merge das suas alterações com o master. Se houver algum problema, será dada uma justificativa para a não-incorporação das alterações. 

