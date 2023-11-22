# Módulo para Magento 2 "Double Check Price"
## Descrição

O módulo "Double Check Price" para Magento adiciona uma camada de segurança adicional para alterações de preços de produtos no painel administrativo. Este módulo permite que alterações no preço de um produto sejam primeiramente salvas para aprovação, antes de serem efetivamente aplicadas. Isso garante que todas as mudanças sejam revisadas e aprovadas por um usuário autorizado, como um gerente ou administrador.

### Características
Bloqueio de Modificação Imediata do Preço: Alterações no preço de um produto são bloqueadas para revisão.
Grid de Aprovação: Uma grid no painel administrativo exibe todas as solicitações de alteração de preço pendentes.
Funcionalidade de Aprovação: Permite a aprovação ou reprovação de mudanças de preço.
Notificação por Email: Envia notificações por email quando uma alteração de preço é solicitada.
Exportação da Grid: Permite a exportação dos dados da grid de aprovação.
CLI: Comandos CLI para listar e gerenciar alterações de preço pendentes.
Endpoints GraphQL: Fornece endpoints para integração com sistemas de ERP.

### Instalação
Copie o módulo para o diretório <Magento_root>/app/code/MagentoModules/DoubleCheckPrice.
### Execute os comandos:
```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:clean
```
## Uso
### Painel Administrativo
Acesse a grid de "Double Check Price" no painel administrativo para gerenciar solicitações de alteração de preço.
### Comandos CLI
```
php bin/magento pending:prices:approvals: Lista todas as solicitações de alteração de preço pendentes.
php bin/magento approve:price:change --id=ID: Aprova uma solicitação de alteração de preço.
php bin/magento edit:price:change --id=ID --new_price=PRICE: Edita o preço pendente de uma solicitação.
```
### Endpoints GraphQL
Consultar solicitações pendentes: Endpoint para consultar todas as solicitações pendentes de alteração de preço.
Aprovar alteração de preço: Endpoint para aprovar uma solicitação de alteração de preço.
Editar solicitação de alteração de preço: Endpoint para editar o preço pendente em uma solicitação.
### Configuração
Configure as opções de email no painel administrativo em Stores > Configuration > Double Check Price > Mail Settings.
### Licença
Este módulo é de código aberto e está disponível sob a Licença MIT, que permite uso livre, distribuição, modificação e comercialização.
