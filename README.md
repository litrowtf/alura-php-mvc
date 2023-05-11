# PHP na Web: conhecendo o padrão MVC
> Usando o PHP na web  
Gerar HTML usando PHP  
Filtragem e validação de dados de formulários  
Usando a orientação a objetos para organizar um projeto  
Entenda o padrão Model-View-Controller (MVC)  

## 1. PHP na WEB
-- Configuração do projto 

Nessa aula, nós:
* Entendemos qual o papel do PHP na web;  
* Aprendemos que o PHP é uma linguagem back-end, ou seja, ela roda no servidor;  
* Conhecemos o servidor embutido do PHP, que nos permite receber conexões HTTP em ambiente 
de desenvolvimento.


## 2. PHP com HTML

### Criando banco
Neste projeto será usado o banco SQLite.  
Executar o comando **"$ php --ini"** para saber o diretório do arquivo de configuração do php.  
Editar o arquivo e descomentar a extenção **"extension=pdo_sqlite"**.  
Ver o arquivo **"criar-banco.php"** o comando SQL para criar a tabela.

### Inserindo um vídeo
Em **enviar-video.html** inserir no formulário *action="/novo-video.php"* para chamar a instrução PHP que adicionará o vídeo.
Esta action será realizada usando o método post.  
Ao clicar no botão, o arquivo **novo-video.php** será chamado.
O arquivo **novo-video.php** faz o insert das infomações passadas na tabela.

### Realizando a busca
Padrão Post/Redirect/Get: redirecionando o usuário através do cabeçalho http após executar uma 
ação com requisição POST. 
o redirecionamento é feito através do código:
```header('Location: /index.php');```
Obs: atentar para não enviar uma resposta antes do header como, por exemplo, a execução do var_dump, que prepara um
cabeçado e envia como resposta.
No index.php foi inserido código php dentro do html para gerar as informações dos vídeos inseridos.

### Realizando exclusões
Implementada exclusão do vídeo em **remover-video.php**.  
Foi utilizada a função "filter_input" para validar o valor recuperado de $_POST, que é representado pela constante
INPUT_POST.  
Documentação para [filter_input](https://www.php.net/filter_input).
Ver também [filter_var](https://www.php.net/filter_var) que tem comportamento similar, porém para variáveis.

### Editando o vídeo
Implementada edição dos registros de vídeo em **editar-video.php**.

**Arquivo formulario.php:**  
É verificado se a requisição veio com id do vídeo, neste caso, é chamada a instrução para editar o registro,
caso contrário é chamada a instrução para criar um registro.  

**Arquivo editar-video.php:**  
Implementada a lógica do update das informações do vídeo. Os valores são capturados com as variáveis 
Superglobais e passadas no parâmetro da query através da função **bindValue().**
A query é executada (**$statement->execute()**). 

```
action="<?= $id !== false ? '/editar-video.php?id=' . $id : '/novo-video.php'; ?>"
```


Foi utilizada a função "filter_input" para validar o valor recuperado de $_POST, que é representado pela constante
INPUT_POST.  
Documentação para [filter_input](https://www.php.net/filter_input).
Ver também [filter_var](https://www.php.net/filter_var) que tem comportamento similar, porém para variáveis.


### Para saber mais
#### Variáveis superglobais

* $_FILES que contém um array dos arquivos enviados via upload em um formulário utilizando o verbo/método POST;
* $_COOKIE que contém um array associativo com todos os cookies enviados na requisição;
* $_SESSION que nos permite acessar e definir informações na sessão;
* $_REQUEST que possui todos os valores de $_GET, $_POST e $_COOKIE;
* $_ENV que contém todas as variáveis de ambiente passadas para o processo do PHP;
* $_SERVER que possui informações do servidor Web, como os cabeçalhos da requisição, o caminho acessado, etc. Todas as chaves desse array são criadas pelo servidor web, então elas podem variar de servidor para servidor.

### Nessa aula, nós:
* Criamos nosso primeiro CRUD com PHP;
* Aprendemos a ler dados da requisição com as variáveis superglobais;
* Vimos como podemos filtrar os dados vindos da requisição com a função filter_input;
* Aprendemos a enviar cabeçalhos HTTP em nossas respostas utilizando a função header.

## 3. Ponto único de entrada (Front Controller)

### Por que centralizar?
Em aplicações PHP é comum ter um arquivo em que deixamos a inicialização da aplicação.  
A inicialização realizará processos como carregar arquivos de configurações, configurar as 
dependências do nosso sistema, verificar qual URL foi acessada e chamar o arquivo correspondente.
A função do front controller é chamar outros arquivos para serem executados.  
**Definição:** é um controlador que fica à frente controlando tudo que entra no sistema. 
Ele receberá todas as requisições e redirecioná-lo-ás para os arquivos de cada etapa do processo.
**Vantagens:** com um ponto único de entrada em nossa aplicação, podemos realizar um filtro em todas
as requisições, realizar logs, carregar nosso código de autoload uma só vez, dentre várias outras 
vantagens que veremos à frente.  
Obs: o servidor embutido do PHP está configurado para redirecionar para "index.php" todas as urls que 
não existem, ou seja, se acessar a url "/url_que_nao_existe", o servidor irá redirecionar para index.php.  
Cana a url tenha uma extensão (ex: /nao_existe.php), aí ocorrerá a mensagem de erro.
Acessar cabçalhos da requisição: **_SERVER**  
Arquivo centralizador: **index.php**

### Vantagens
* O autoloader pode ser colocado apenas no index.php
* URLs mais amigáveis, pois utiliza o endereço (ex: /novo-video) ao invés do arquivo (ex: novo-video.php)

### Limpando o Código
Criado os arquivos "inicio-html.php" e "fim-html.php". Nestes arquivos, foram inseridos o cabeçado e rodapé 
das páginas para evitar repetição de código e facilitar a manutenção  

### Pasta "public"

Pasta que armazenará todo conteúdo acessível do servidor web

### Nessa aula, nós:
* Conhecemos o padrão front controller, que nos permite ter um ponto único de entrada na aplicação;
* Definimos a lógica em nosso front controller para incluir os arquivos corretos dependendo da rota;
* Falamos sobre segurança e por isso movemos os arquivos públicos para uma nova pasta, chamada public;
* Corrigimos alguns pequenos erros que haviam sido deixados na aplicação, como a verificação do ID ao editar um vídeo.

## 4. Orientação a objetos
Realizado refatoramento do código para organizar o projeto e utiizar OO.

### Criado pasta src
Nesta pasta, serão colocados todos códigos fontes da aplicação

### Configurado autoload com composer
Adicionado autoload psr-4 no composer.json.  
Executar ```composer dumpautoload``` no terminal para gerar o autoload.  
Dessa aforma, o autoload deverá ser chamado apenas no index.php.  
```
require_once __DIR__ . '/../vendor/autoload.php';
```

### Criando a classe "Video"
Por se tratar de uma entidade, a classe será criada no diretório src/Entity.  
Nessa classe, serão realizadas as verificações dos parâmetros

### Criando o repositório "VideoRepository"
No repositório, será implementado a manipulação do banco. Os arquivos serão organizados dentro de src/Repository.  
Como o acesso ao banco será realizado pelos repositórios, é essencial que o construtor receba uma 
instância de PDO, dessa forma, possíveis alterações de conexão com o banco serão realizadas em apenas um local.  
Serão adicionados aqui os métodos para realizar o CRUD.  
Os métodos criados foram implementados para retornar um booleano indicando se a operação foi bem sucedida.
> Foi utilizada a função **array_map** (na consulta dos vídeos - método all()) para transformar o array associativo 
> (retorno do fetchAll (FETCH_ASSOC)) para um array de objetos "Video".

### Controladores de requisição 
>**Função:** criar as dependências necessárias, receber os dados da requisição e montar a resposta.

Foram criados os seguintes controladores:
VideoCreateController.php
VideoEditController.php
VideoListController.php
VideoRemoveController.php

Agora, as requisições feitas ao index.php são passadas para os controladores. 
Através do método **processaRequisicao()** as requisições são redirecionadas.  

### Assinando um contrado
Criação da interface "Controller" para implementá-la nos controladores garantindo que todos os controladores 
implementem uma interface em comum
Foi realizado também o ajuste dos controladores e criado o redirecionamento de erro para Error404Controller.php

### Nessa aula, nós:
Praticamos orientação a objetos para extrair todo o código “solto” em nossa aplicação, organizando melhor a arquitetura;
Relembramos padrões de projeto como Repository, Entity;
Colocamos em prática detalhes da nova sintaxe do PHP em sua versão 8.1 como readonly e promoção de propriedades a partir do construtor;
Fizemos com que nosso front controller chamasse nossos controllers.

## 5. Conhecendo o MVC
No projeto, foram criados os arquivos de visualização na pasta "views".  
**Sobre o padrão MVC:**  
Modelo ou dommínio (Entity): terá  regras de negócio, acesso à persistência, detalhe de infraestrutura, etc.  
Visualização (Views): terá os códigos html para visualização da aplicação
Controladores (Controllers): pega o modelo e exibe na view, ou seja, junta as duas camadas. Recebe a requisição,
processa e utiliza a view necessária para exibir para o cliente.

### Isolando o HTML
Criado a pasta "views" para organizar os arquivos de visualização.  

### Configurando rotas
Criação da pasta "config" para organiar as configurações (de dependência, de arquivos com parâmetros ou de **rotas**)
Definição de rotas. Mapeamento de um verbo HTTP e uma URL para uma classe Controller.

### Nessa aula, nós:
Isolamos nossos arquivos de visualização (HTML) em uma pasta específica, garantindo uma maior manutenibilidade;  
Conhecemos sobre o padrão MVC (Model View Controller) que nos ajuda na separação das responsabilidades de nosso código em um sistema Web;  
Conversamos sobre arquitetura e o motivo pelo qual devemos nos preocupar com a organização dos componentes de nossa aplicação web;  
A partir da organização usando MVC, melhoramos nosso front controller com uma configuração de rotas mais enxuta e extensível.  


# PHP na Web: lidando com segurança e API
> Autenticação  
> Autorização usando sessões HTTP   
> Upload de arquivos  
> Conhecimento de segurança  
> criação de APIs  

## 1. Segurança com autenticação
Será criada a autenticação do usuário. 

### Criando a tabela "users"
Tabela criada com "pdo->exec" (tabela-usuario.php)

### Armazenando senhas
Função para fazer hash da senha: ```password_hash($pass, PASSWORD_ARGON2ID)```
O algorítimo de hash PASSWORD_ARGON2ID é um dos mais seguros da atualidade e é ideal 
para armazenamento seguro de senhas.

> Criptografia: pode-se usar as funções da biblioteca nativa "sodium".  
> ex: sodium_crypto_secretbox_keygen (para gerar chaves aleatórias) ou sodium_crypto_secretbox (para
> encriptar a mensage).

[Explicação no YouTube](https://www.youtube.com/watch?v=4MCO-FgukcA)

### Validando login
Exibir formulário de login  
Criadas Rotas e formulários de login  
Criado LoginFormController.php para mostrar o formulário de login quando a requisição for **GET|/login**  
Criado LoginController.php para buscar o usuário no banco e verificar a senha com **password_verify**


### Nessa aula, nós:
* Praticamos nosso conhecimento de banco de dados ao criar uma nova tabela (de usuário) e realizar inserções e consultas 
nela;  
* Conhecemos conceitos importantes de criptografia como funções de hash. Através desse tipo de função nós podemos 
armazenar as senhas de nossos usuário de forma segura;  
* Aprendemos a validar a autenticação de um usuário, inclusive de forma que não deixamos o sistema exposto à 
possibilidade de enumeração de usuários;  
* Conhecemos a diferença entre os termos autenticação e autorização, onde o primeiro identifica alguém e o segundo diz
quais permissões esse alguém possui.


## 2. Autorização com session
Uilização de sessão através de cookies

### Função de sessão session_start()
Para ter o controle total da aplicação, a função foi colocada no FrontController (index.php)  
Obs: geralmente a função é a primeira linha, pois no caso de haver erro na chamada de alguma função,
é assegurado que a sessão foi iniciada.

### Implementando logout
Aqui será executado a ação para remover o cookie com a função session_destroy(). A função será 
chamada no método processaRequisicao() da classe LogoutController.
> Pode ser utilizado opções mais seguras para o encerramento da sessão:
```
$_SESSION['logado'] = false;
ou
unset($_SESSION['logado']);
```
[Ver documentação do *session_destroy()*](https://www.php.net/manual/pt_BR/function.session-destroy.php)

### Resumo do que foi implementado nesta aula

1. Inicialize uma sessão com a função session_start;
2. Caso o usuário tenha sido autenticado com sucesso, armazene uma informação indicando isso em sessão (ex.: $_SESSION['logado'] = true;);
3. Ao tentar acessar alguma URL protegida (qualquer uma diferente de /login), se a informação não existir em sessão, redirecione o usuário para /login;
4. Ao tentar acessar o formulário de login, se o usuário já estiver autenticado, redirecione-o para a listagem de vídeos;
5. Crie uma nova rota e controller para que a sessão seja destruída, ou seja, uma rota de logout.

### Nessa aula nós:
* Conhecemos o conceito de sessões HTTP e como sessões podem nos prover a funcionalidade necessária para implementarmos a autorização em nosso sistema;
* Aprendemos a inicializar sessões com PHP e conferiu alguns problemas que podem acontecer nesse processo;
* Entendemos como passar a armazenar um dado de sessão, ao validar a identidade de um usuário, que indica que há alguém autenticado no sistema;
* Aprendemos também a realizar o logout, ou seja, destruir a sessão ou tornar os dados de autenticação inválidos;
* Compreendemos que limpar os dados de autenticação é melhor do que destruir a sessão.

## Upload de arquivos
Aprenderemos a manipular uploads de arquivos (como armazenar?).

> Obs: não é uma boa prática armazenar arquivos com o tipo "binário" no banco de dados, pois esse método exige mais processamento do PHP.

Será criada a coluna de texto "image_path" na tabela "videos" que armazenará o caminho da imagem.

```
--SQL de criação do campo 
ALTER TABLE videos ADD COLUMN image_path TEXT;
```

### Alteração no formulário (vieo-form.php).  
Adicionado novo campo de imagem.  
Adocionado parâmetro ```type="file"``` para informar que é um campode arquivo e ```accept="image/*"``` para pegar 
apenas imagens.  
Também foi incluído o ```enctype="multipart/form-data"``` para informar que o formulário enviará dados além de texto.   

### Processar upload no VideoCreateController.php
> Utilizar a imagem salva para ser mostrada como thumb do vídeo.

Criada a propriedade *$filePath* (com get e set) na entidade *Video* (?string -> string ou nulo).  

Criada classe *AtualizaImagem* para mover a imagem recebia no upload para um diretório acessível (public/img/uploads) e
salvar o caminho do arquivo no banco.  
Atualizado a função *update()* da classe *VideoRepository* para atualizar o campo "image_path" do banco.  
Atualizado a função *hydrateVideo()* para carregar o campo "image_path" do banco.  

**Adicionado botão "Remover capa".**  
Criada função *removeCapa()*.  
Atualizado *VideoEditController* para chamada da função *removerCapa*.
Atualizado *VideoEditController* para chamada da função *AtualizaImage::atualiza*.  

Criada nova rota 'GET|/remover-capa' em *routes.php*  

Realizado ajustes no *index.php* para apresentar a imagem enviada e para adicioanr a opção "Remover capa".

### Nessa aula:
* Discutimos sobre como arquivos normalmente são armazenados e os motivos para não salvarmos arquivos diretamente no 
* banco de dados;  
* Aprendemos a enviar arquivos através de formulários HTML, definindo corretamente o enctype;  
* Vimos como podemos receber envios de arquivos na variável $_FILES do PHP;  
* Aprendemos a usar a função move_uploaded_file para armazenar um arquivo enviado corretamente na pasta desejada.  