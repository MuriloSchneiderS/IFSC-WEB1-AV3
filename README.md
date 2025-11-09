# IFSC-WEB1-AV3
Aplicação web de página única que funcione como um "Mural de Recados" público. Onde se pode adicionar um recado, ver todos os recados existentes, editar um recado, marcar um recado como "favorito" e excluí-lo.
# Nome do banco: trabalho_web
## Tabela:
CREATE TABLE recados (
id INT PRIMARY KEY AUTO_INCREMENT,
mensagem TEXT NOT NULL,
status TINYINT(1) NOT NULL DEFAULT 0,
data_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

## Especificações técnicas
# HTML:
1. A estrutura deve conter um cabeçalho com o título da aplicação, o conteúdo principal
contendo os posts e uma área para criação/edição de posts, e um rodapé de direitos
reservados

# CSS:
1. Para questões visuais é necessário ter no mínimo os seguintes requisitos CSS.
Avaliação Final
a. Todos os posts devem vir se adaptando a tela, por exemplo 2 posts devem
vir com espaçamento apropriado entre eles e caso um novo seja adicionado,
adaptar para encaixar este na tela.
b. Cores de fundo e fontes diferentes
c. Quando estiver ocorrendo uma requisição, bloquear os botões e mudá-los de
aparência para mostrar que estão bloqueados, e a tela de posts deve mostrar
uma mensagem de atualizando ou algum ícone de carregamento para
atualizar os posts
d. Faça sua aplicação ser responsiva a diferentes tipos de tela.
2. O uso de bootstrap é OPCIONAL.
   
# CRUD de posts:
1. Deve ser uma área antes de todos os posts para criação e edição dos posts, caso
eu selecione para editar um post, o formulário deve se auto preencher com os
conteúdos para edição.
2. Quando eu criar ou editar um novo post não deve acontecer nenhum carregamento
na tela, a lista de posts deve ser atualizada de forma fluida.

# Lista de posts:
1. Abaixo do CRUD de posts deve haver uma lista dos posts já cadastrados, cada um
com seu título, conteúdo, botão de editar e de excluir, a data de postagem, e algum
sinal que possa ser categorizado como lido ou favorito(uma estrela, ou sinal para
favoritar), e deve atualizar o banco de dados.
2. A lista deve carregar junto com a página de forma fluida.
3. O design de cada post deve ser no mínimo com bordas arredondadas e uma cor
diferente entre o título e corpo do texto.
4. Caso aperte no botão de excluir, deve solicitar uma confirmação se você quer
apagar este post.
5. Qualquer alteração nos posts(inserção, edição, exclusão) devem atualizar a tabela.
6. Deve estar listado como as favoritas em primeiro lugar seguido de outros posts

# Tabela a ser utilizada
● Para facilitar o desenvolvimento da aplicação deve ser utilizado o seguinte banco de
dados fornecido neste arquivo, tenha em mente que possivelmente sua aplicação
não será a primeira que será aberta então terá que comportar os registros já
existentes por aplicações anteriores, por exemplo caso eu tenha 3 aplicações, as 3
devem estar preparadas para um banco de dados já populado, e caso eu adicione
um post em uma, as outras devem apresentar este post. Caso uma aplicação não
obtenha os posts já registrados será descontada. E não se preocupem, a primeira
aplicação que eu testar também será testada por último, para ver como se comporta
após a população do banco de dados, assim ninguém fica com a vantagem de ser o
primeiro.