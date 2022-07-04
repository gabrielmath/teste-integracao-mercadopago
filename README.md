# Teste de Backend: Integração MercadoPago

Este foi um teste realizado a partir de um processo seletivo. O teste consiste em uma integração simples com o
Mercado Pago.

**OBJETIVO:**

## Enunciado

Basicamente, o sistema deve ter um formulario com inputs necessarios pra processar o pagamento e um botão
'finalizar pagamento'. Se o pagamento der certo, redirecionar para uma página de obrigado.

### Exigências

- Utilizar laravel para o desenvolvimento;
- Não é necessário o uso de banco de dados;
- Processamento de pagamentos com boleto e cartão de crédito;
- Se o pagamento for boleto, mostrar um botão com o link do boleto na pagina de obrigado;
- Não é necessario se importar com a qualidade do front, usar um bootstrap básico;
- Utilizar a bilioteca php desenvolvida pelo Mercado Pago, tanto o
  [Checkout Transparante](https://www.mercadopago.com.br/developers/pt/guides/payments/api/introduction/) quanto o
  [PHP SDK](https://www.mercadopago.com.br/developers/pt/guides/sdks/official/php/).

## Ambiente Local Utilizado

Utilizei o **NGINX** como servidor HTTP e o **PHP em sua versão 8.1**. Usei também o **Docker a partir do LaravelSail**,
que já trás um ambiente robusto e completamente configurado.
Rodei isso no **WSL2 com Ubuntu** e o docker instalado nele, nativamente.

## Instalação

Após clonar o projeto em seu aparelho, basta rodar o comando do composer para instalar as
dependências:

```bash
composer install
```

OBS: caso não tenha o composer em sua máquina, recomendo utilizar seu [container
docker](https://hub.docker.com/_/composer) para instalar as dependências do projeto.

Em seguida, faça uma cópia do arquivo `.env.example` para `.env` e configure seu ambiente de desenvolvimento como
banco de dados e etc.

Gere uma chave para aplicação:

```bash
sail artisan key:generate
```

E lembre-se de preencher os dados do mercado pago com seu `accessToken` e `publicKey`:

```dotenv
MERCADOPAGO_PUBLIC_KEY=YOUR_PUBLIC_KEY
MERCADOPAGO_ACCESS_TOKEN=YOUR_ACCESS_TOKEN
```

Finalmente, para rodar a aplicação:

```bash
sail up -d
```

## Resumo da construção da Integração

### Problemas no desenvolvimento relacionados a API do Mercaod Pago

Primeiramente, gostaria de destacar aqui que a documentação estava apresentando algumas irregularidades, como problema
no uso dos
[cartões de crédito](https://www.mercadopago.com.br/developers/pt/docs/checkout-api/integration-test/test-cards) de
testes e falta de informação na documentação de uso básico da API (desconfio que a mesma esteja desatualizada).

Então diferente de como está na
[documentação](https://www.mercadopago.com.br/developers/pt/docs/checkout-api/payment-methods/receiving-payment-by-card)
, além do `accessToken`, é necessário passar para o objeto a `publicKey`para conseguir criar novos pagamentos:

```php
MercadoPago\SDK::setAccessToken("YOUR_ACCESS_TOKEN");
MercadoPago\SDK::setPublicKey("YOUR_PUBLIC_KEY");
```

Outro detalhe é que, pelo menos nos testes que realizei enquanto fazia a integração, o Cartão de teste MasterCard
não funciona e o AmericanExpress apresenta certa instabilidade.

### Funcionamento

Como foi exigida uma integração mais simples, meu foco foi processar o pagamento e, caso tenha sucesso, redirecionar
para a página de "Obrigado". Para agilizar o processo, criei uma página diferente para o cartão e boleto.

Basta preencher os dados da compra em cada uma delas e o backend processa os dados de cada uma delas, cada uma com
sua peculiaridades.

### Estrutura

Optei por criar uma camada de serviço (Services) para separar as integrações. Nela, criei uma Interface chamada
`PaymentInterface` onde toda integração futura com outros meios de pagamento deverão implementá-la.
Após, criei uma classe para tratar os dados financeiros do pagamento (`MercadoPagoPaymentData`), uma outra para tratar
os dados pessoais do cliente (`MercadoPagoPayerData`) e uma outra que faz todo o processamento do pagamento
(`MercadoPagoService`). Essa última implementa a interface citada anteriormente.

Assim como solicitado, a integração foi realizada. Ao instalar o sistema, a tela inicial já te "pergunta" qual a forma
de pagamento.

Por conta da instabilidade e documentação que deixa a desejar, tive dificuldades em processar os erros. Deste modo,
visto o tempo que eu já havia perdido com problemas em encontrar respostas na documentação, apenas retornei o JSON
informando-os.

Enfim, espero ter conseguido passar um pouco da ideia que tive pra solucionar o problema e como me organizei, como
estruturei o código para deixá-lo melhor manutenível, com fácil compreensão e rápida leitura.

### Obrigado!
