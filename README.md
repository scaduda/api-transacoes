## API de Transações Financeiras em Laravel

Exemplo de api RESTFul de transferência financeira tolerante a falhas, que consulta serviços externos de forma síncrona e assíncrona utilizando fila.

### Requisitos:

- Docker
- Docker-compose
- Make

### Instruções:

- Execute o comando ```make deploy_dev``` para iniciar a aplicação
- Execute o comando ```make test``` para iniciar os testes
- Execute o comando ```make down``` para descer a aplicação

O projeto estará rodando em http://localhost:8080

### Documentação:

- POST: Criação de Usuário Comum e Lojista
- POST: Criação de Transação

- Execute o comando ```make generate-scribe``` para gerar a documentação Scribe


