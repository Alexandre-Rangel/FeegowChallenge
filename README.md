
# Sistema de Agendamento (Feegow)




## Deploy

Para fazer o deploy desse projeto rode

```bash
  composer install
```
Depois adicione as informações no .env do projeto

```bash
FEEGOW_API_TOKEN='(Coloque o Token Aqui)'
FEEGOW_API_URL='https://api.feegow.com/v1/api/'
FEEGOW_API_ENDPOINT_SPECIALTIES='specialties/list'
FEEGOW_API_ENDPOINT_PROFESSIONAL='professional/list'
FEEGOW_API_ENDPOINT_PATIENT='patient/list-sources'
```

Defina as informações do banco de dados no arquivo .env

rode o comando 
```bash
  php artisan key:generate
```

a seguir inicie o servidor para testes

```bash
  php artisan serve
```