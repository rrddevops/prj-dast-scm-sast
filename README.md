# DAST/SCM/SAST Application

Aplicação web com esteira completa de validação de código incluindo análise SAST (SonarQube), análise de vulnerabilidades (Snyk) e testes DAST (OWASP ZAP).

## 🚀 Funcionalidades

- **API REST** com Express.js
- **Containerização** com Docker
- **Esteira CI/CD** com GitHub Actions
- **Análise SAST** com SonarQube Cloud
- **Análise de vulnerabilidades** com Snyk
- **Testes DAST** com OWASP ZAP
- **Testes automatizados** com Jest
- **Linting e formatação** com ESLint e Prettier

## 📋 Pré-requisitos

- Node.js 18+
- Docker
- Git

## 🛠️ Instalação

### Desenvolvimento Local

```bash
# Clone o repositório
git clone <repository-url>
cd prj-dast-scm-sast

# Instale as dependências
npm install

# Execute em modo desenvolvimento
npm run dev
```

### Com Docker

```bash
# Build da imagem
docker build -t dast-scm-sast-app .

# Executar container
docker run -p 3000:3000 dast-scm-sast-app
```

### Com Docker Compose

```bash
# Desenvolvimento
docker-compose up app-dev

# Produção
docker-compose up app
```

## 🧪 Testes

```bash
# Executar testes
npm test

# Executar testes com coverage
npm test -- --coverage

# Executar linting
npm run lint

# Executar auditoria de segurança
npm run security-check
```

## 🔧 Scripts Disponíveis

- `npm start` - Inicia a aplicação em produção
- `npm run dev` - Inicia a aplicação em desenvolvimento com hot reload
- `npm test` - Executa os testes
- `npm run lint` - Executa o ESLint
- `npm run lint:fix` - Corrige automaticamente problemas do ESLint
- `npm run format` - Formata o código com Prettier
- `npm run security-check` - Executa auditoria de segurança

## 🌐 Endpoints da API

- `GET /` - Informações da aplicação
- `GET /health` - Status de saúde da aplicação
- `GET /api/users` - Lista de usuários
- `POST /api/users` - Criar novo usuário

## 🔒 Esteira de Segurança

### SonarQube Cloud (SAST)
- Análise estática de código
- Métricas de qualidade
- Cobertura de testes
- Duplicação de código

### Snyk (Análise de Vulnerabilidades)
- Vulnerabilidades em dependências
- Verificação de licenças
- Monitoramento contínuo

### OWASP ZAP (DAST)
- Testes de segurança dinâmicos
- Análise de vulnerabilidades em runtime
- Relatórios detalhados

## ⚙️ Configuração do GitHub Actions

### Secrets Necessários

Configure os seguintes secrets no seu repositório GitHub:

- `SONAR_TOKEN` - Token do SonarQube Cloud
- `SNYK_TOKEN` - Token do Snyk
- `DOCKER_USERNAME` - Usuário do Docker Hub
- `DOCKER_PASSWORD` - Senha do Docker Hub

### Workflow

O workflow executa automaticamente:

1. **Code Quality** - Linting, testes e auditoria
2. **SonarQube Analysis** - Análise SAST
3. **Snyk Security Scan** - Análise de vulnerabilidades
4. **OWASP ZAP Security Test** - Testes DAST
5. **Docker Build** - Build e push da imagem
6. **Deploy** - Deploy para ambiente de staging

## 📁 Estrutura do Projeto

```
prj-dast-scm-sast/
├── src/
│   ├── app.js              # Aplicação principal
│   └── app.test.js         # Testes da aplicação
├── .github/workflows/
│   └── ci-cd.yml           # Workflow do GitHub Actions
├── Dockerfile              # Configuração do Docker
├── docker-compose.yml      # Configuração do Docker Compose
├── package.json            # Dependências e scripts
├── jest.config.js          # Configuração do Jest
├── .eslintrc.js            # Configuração do ESLint
├── .prettierrc             # Configuração do Prettier
├── sonar-project.properties # Configuração do SonarQube
├── snyk.json               # Configuração do Snyk
└── README.md               # Documentação
```

## 🔧 Configuração de Desenvolvimento

### VS Code Extensions Recomendadas

- ESLint
- Prettier
- Docker
- Jest Runner

### Configurações do VS Code

```json
{
  "editor.formatOnSave": true,
  "editor.codeActionsOnSave": {
    "source.fixAll.eslint": true
  },
  "eslint.validate": ["javascript"]
}
```

## 📊 Monitoramento

A aplicação inclui endpoints de monitoramento:

- `/health` - Health check para Docker e load balancers
- Logs estruturados com Morgan
- Métricas de performance

## 🚀 Deploy

### Produção

```bash
# Build da imagem de produção
docker build -t dast-scm-sast-app:latest .

# Push para registry
docker push your-registry/dast-scm-sast-app:latest

# Deploy
docker run -d -p 3000:3000 --name dast-app dast-scm-sast-app:latest
```

## 📝 Licença

MIT License - veja o arquivo LICENSE para detalhes.

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📞 Suporte

Para suporte, abra uma issue no GitHub ou entre em contato através do email. 