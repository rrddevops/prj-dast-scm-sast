# DAST/SCM/SAST Application

Aplicação web Python/Flask com esteira completa de validação de código incluindo análise SAST (SonarQube), análise de vulnerabilidades (Snyk) e testes DAST (OWASP ZAP).

## 🚀 Funcionalidades

- **API REST** com Flask
- **Containerização** com Docker
- **Esteira CI/CD** com GitHub Actions
- **Análise SAST** com SonarQube Cloud
- **Análise de vulnerabilidades** com Snyk
- **Testes DAST** com OWASP ZAP
- **Testes automatizados** com pytest
- **Linting e formatação** com flake8 e black
- **Análise de segurança** com bandit e safety

## 📋 Pré-requisitos

- Python 3.11+
- Docker
- Git

## 🛠️ Instalação

### Desenvolvimento Local

```bash
# Clone o repositório
git clone <repository-url>
cd prj-dast-scm-sast

# Crie um ambiente virtual
python -m venv venv
source venv/bin/activate  # Linux/Mac
# ou
venv\Scripts\activate  # Windows

# Instale as dependências
pip install -r requirements.txt

# Execute em modo desenvolvimento
python src/app.py
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
pytest

# Executar testes com coverage
pytest --cov=src --cov-report=html

# Executar linting
flake8 src/

# Executar formatação
black --check src/

# Executar auditoria de segurança
bandit -r src/
safety check
```

## 🔧 Scripts Disponíveis

- `python src/app.py` - Inicia a aplicação em desenvolvimento
- `gunicorn --bind 0.0.0.0:3000 src.app:app` - Inicia a aplicação em produção
- `pytest` - Executa os testes
- `flake8 src/` - Executa o linting
- `black src/` - Formata o código
- `bandit -r src/` - Executa auditoria de segurança
- `safety check` - Verifica vulnerabilidades em dependências

## 🌐 Endpoints da API

- `GET /` - Informações da aplicação
- `GET /health` - Status de saúde da aplicação
- `GET /api/users` - Lista de usuários
- `POST /api/users` - Criar novo usuário
- `GET /api/users/<id>` - Buscar usuário específico

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

### Bandit (Análise de Segurança Python)
- Detecção de vulnerabilidades específicas do Python
- Análise de código estático

### Safety (Verificação de Dependências)
- Verificação de vulnerabilidades conhecidas
- Alertas de segurança

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
2. **Snyk Security Scan** - Análise de vulnerabilidades
3. **OWASP ZAP Security Test** - Testes DAST
4. **Docker Build** - Build e push da imagem
5. **Deploy** - Deploy para ambiente de staging

## 📁 Estrutura do Projeto

```
prj-dast-scm-sast/
├── src/
│   ├── app.py              # Aplicação principal Flask
│   └── test_app.py         # Testes da aplicação
├── .github/workflows/
│   └── ci-cd.yml           # Workflow do GitHub Actions
├── Dockerfile              # Configuração do Docker
├── docker-compose.yml      # Configuração do Docker Compose
├── requirements.txt        # Dependências Python
├── setup.py               # Configuração do pacote
├── pytest.ini             # Configuração do pytest
├── .flake8                # Configuração do flake8
├── pyproject.toml         # Configuração do black
├── sonar-project.properties # Configuração do SonarQube
├── snyk.json              # Configuração do Snyk
└── README.md              # Documentação
```

## 🔧 Configuração de Desenvolvimento

### VS Code Extensions Recomendadas

- Python
- Pylance
- Black Formatter
- Flake8
- Docker
- Python Test Explorer

### Configurações do VS Code

```json
{
  "python.defaultInterpreterPath": "./venv/bin/python",
  "python.formatting.provider": "black",
  "python.linting.enabled": true,
  "python.linting.flake8Enabled": true,
  "editor.formatOnSave": true,
  "python.testing.pytestEnabled": true,
  "python.testing.unittestEnabled": false
}
```

## 📊 Monitoramento

A aplicação inclui endpoints de monitoramento:

- `/health` - Health check para Docker e load balancers
- Logs estruturados
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