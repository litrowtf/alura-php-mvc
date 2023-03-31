# PHP na Web: conhecendo o padrão MVC

## Criando banco
Neste projeto será usado o banco SQLite.  
Executar o comando **"$ php --ini"** para saber o diretório do arquivo de configuração do php.  
Editar o arquivo e descomentar a extenção **"extension=pdo_sqlite"**.  
Ver o arquivo **"criar-banco.php"** o comando SQL para criar a tabela.

## Inserindo um vídeo
Em **enviar-video.html** inserir no formulário *action="/novo-video.php"* para chamar a instrução PHP que adicionará o vídeo.
Esta action será realizada usando o método post.  
Ao clicar no botão, o arquivo **novo-video.php** será chamado.
O arquivo **novo-video.php** faz o insert das infomações passadas na tabela.

## Realizando a busca
Padrão Post/Redirect/Get: redirecionando o usuário através do cabeçalho http após executar uma 
ação com requisição POST. 
o redirecionamento é feito através do código:
```header('Location: /index.php');```
Obs: atentar para não enviar uma resposta antes do header como, por exemplo, a execução do var_dump, que prepara um
cabeçado e envia como resposta.
No index.php foi inserido código php dentro do htmal para gerar as informações dos vídeos inseridos.

## Realizando exclusões
Implementada exclusão do vídeo em **remover-video.php**.  
Foi utilizada a função "filter_input" para validar o valor recuperado de $_POST, que é representado pela constante
INPUT_POST.  
Documentação para [filter_input](https://www.php.net/filter_input).
Ver também [filter_var](https://www.php.net/filter_var) que tem comportamento similar, porém para variáveis.

## Editando o vídeo
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


## Para saber mais
### Variáveis superglobais

* $_FILES que contém um array dos arquivos enviados via upload em um formulário utilizando o verbo/método POST;
* $_COOKIE que contém um array associativo com todos os cookies enviados na requisição;
* $_SESSION que nos permite acessar e definir informações na sessão;
* $_REQUEST que possui todos os valores de $_GET, $_POST e $_COOKIE;
* $_ENV que contém todas as variáveis de ambiente passadas para o processo do PHP;
* $_SERVER que possui informações do servidor Web, como os cabeçalhos da requisição, o caminho acessado, etc. Todas as chaves desse array são criadas pelo servidor web, então elas podem variar de servidor para servidor.