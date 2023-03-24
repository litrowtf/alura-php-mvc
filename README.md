# PHP na Web: conhecendo o padrão MVC

## Criando banco
Neste projeto será usado o banco SQLite.  
Executar o comando **"$ php --ini"** para saber o diretório do arquivo de configuração do php.  
Editar o arquivo e descomentar a extenção **"extension=pdo_sqlite"**.  
Ver o arquivo **"criar-banco.php"** o comando SQL para criar a tabela.

## Inserindo um vídeo
Em  **enviar-video.html** inserir no formulário *action="/novo-video.php"* para chamar a instrução PHP que adicionará o vídeo.
Esta action será realizada usando o método post.  
Ao clicar no botão, o arquivo **novo-video.php** será chamado.
O arquivo **novo-video.php** faz o insert das infomações passadas na tabela.







## Para saber mais

### Variáveis superglobais

* $_FILES que contém um array dos arquivos enviados via upload em um formulário utilizando o verbo/método POST;
* $_COOKIE que contém um array associativo com todos os cookies enviados na requisição;
* $_SESSION que nos permite acessar e definir informações na sessão;
* $_REQUEST que possui todos os valores de $_GET, $_POST e $_COOKIE;
* $_ENV que contém todas as variáveis de ambiente passadas para o processo do PHP;
* $_SERVER que possui informações do servidor Web, como os cabeçalhos da requisição, o caminho acessado, etc. Todas as chaves desse array são criadas pelo servidor web, então elas podem variar de servidor para servidor.