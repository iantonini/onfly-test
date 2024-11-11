### Onfly | Teste técnico   

___
[Home](../README.md) |
[Requisitos](./Onfly-Teste-Tecnico.md) |
[Endpoints](./Endpoints.md) |
___

#### Para começar:   
- Crie um repositório no seu GitHub
- Faça seus commits no seu repositório
- Tecnologia para desenvolvimento da aplicação: PHP usando Laravel ou Hyper-f   

#### Objetivo:   
- Crie um sistema que simula de forma básica o cadastro de despesas de um usuário a partir de um cartão.   
- Para esse sistema é desejado que tenha dois tipos de usuários, um que seja do tipo administrador e outro que seja do tipo comum;   
- Cada usuário pode ter quantos cartões quiser, e cada cartão pode ter um número ilimitado de despesas;   
- O usuário administrador pode ter acesso a visualização de todos os cartões e todos os usuários e todas as suas despesas;   
- O usuário comum pode apenas acessar seu cartão e suas despesas;   
- Ao receber um evento de cadastro de despesa deve ser disparado um email para todos os administradores e também para o usuário do cartão no momento que a despesa foi gerada;   
- Para uma despesa ser criada , é necessário que exista saldo no cartão do usuário, e este saldo precisa ser atualizado toda vez que for criada uma despesa.   
- Não permitir usuários duplicados.   
- Cartão deve possuir no mínimo os atributos de número do cartão, saldo.   
- Uma transação de geração de despesa só pode acontecer quando houver saldo disponível
- Saldos de cartão não podem ser negativos   
- Despesas não podem ser negativas.   
- A operação de geração de despesa  deve ser uma transação (em caso de inconsistência deve ser revertida) e o dinheiro deve voltar para o saldo do cartão do usuário que envia.   
- Construir apenas a API com todas as rotas necessárias   
    - Criar   
    - Listar   
    - Deletar   
    - Atualizar   

#### O que será avaliado:   
- Testes automatizados   
- Domínio de arquitetura   
- Código limpo e organizado (nomenclatura, etc)   
- Conhecimento de padrões (PSRs, design patterns, SOLID)   
- Modelagem de Dados   
- Manutenibilidade do Código   
- Tratamento de erros   
- Cuidado com itens de segurança   
- Arquitetura (estruturar o pensamento antes de escrever)   
- Carinho em desacoplar componentes (outras camadas, service, repository)   

#### O que será um diferencial   
- Uso de Docker   
- Testes de integração automatizados   
- Uso de Design Patterns   
- Documentação   
- Prazo esperado para o teste   

Lembrando que todos os pontos acima demonstram domínio!.   

Prazo: 04 dias corridos   
