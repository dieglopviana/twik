## twik - Site de leilão desenvolvido com CakePHP(1.2.3) em 2008

<!-- SOBRE O TWIK -->

[Screenshot da home](/src/app/webroot/img/Screenshot_home.png)


### Instalação

1. Clone o repositório
```
git clone https://github.com/dieglopviana/twik.git 
```
2. Inicie o container docker
```
docker-compose up -d --build
```
3. Abra o seu gerenciador de banco de dados e restaure o backup do arquivo "[./src/twik.sql](https://github.com/dieglopviana/twik/blob/main/src/twik.sql)"

4. Acesse a URL [http://localhost:8056/](http://localhost:8056/)

Se tudo deu certo, você já deve visualizar a home com alguns produtos onde os leilões iniciarão em 2050, ta pertinho pô! hehehe...

Login e senha dos usuários:

| login | senha | admin |
| --- | --- | --- |
| admin | teste123 | SIM |
| guest1 | teste123 | NÃO |
| guest2 | teste123 | NÃO |

Para acessar o painel administrador, logue com um usuário administrador e acesse o [painel administrador](http://localhost:8056/admin) e aí você já pode gerenciar os leilões, inserir lances para os usuários, alterar os produtos, etc...

Para testar o Leilão, abra o Chrome e logue com um usuário, depois em uma aba anônima logue com outro usuário e em outro navegador acesse com o outro usuário, altere o Leilão para iniciar em determinado horário e espere o mesmo se iniciar. Vai iniciar um cronômetro com o tempo determinado na configuração do leilão e então, comece a dar lances. Assim que o cronômetro zerar, o último a dar lance, será o vencedor.
