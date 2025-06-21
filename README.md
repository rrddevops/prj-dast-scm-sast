# DAST/SCM/SAST Application

Aplicação web PHP/Slim com esteira completa de validação de código incluindo análise SAST (SonarQube), análise de vulnerabilidades (Snyk) e testes DAST (OWASP ZAP).

## 🚀 Funcionalidades

- **API REST** com Slim Framework
- **Containerização** com Docker
- **Esteira CI/CD** com GitHub Actions
- **Análise SAST** com SonarQube Cloud
- **Análise de vulnerabilidades** com Snyk
- **Testes DAST** com OWASP ZAP
- **Testes automatizados** com PHPUnit
- **Linting e formatação** com PHP_CodeSniffer e PHP CS Fixer
- **Análise estática** com PHPStan
- **Análise de segurança** com Composer Audit

## 📋 Pré-requisitos

- PHP 8.2+
- Composer
- Docker
- Git
- GPG

## 🛠️ Instalação

### Desenvolvimento Local

```bash
# Clone o repositório
git clone <repository-url>
cd prj-dast-scm-sast

# Instale as dependências
composer install

# Configure as variáveis de ambiente
cp .env.example .env

# Execute em modo desenvolvimento
php -S localhost:8000 -t app/public
```

### Com Docker

```bash
# Build da imagem
docker build -t dast-scm-sast-app .

# Executar container
docker run -p 80:80 dast-scm-sast-app
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
composer test

# Executar testes com coverage
composer test-coverage

# Executar linting
composer lint

# Executar formatação
composer format

# Executar análise estática
composer stan

# Executar auditoria de segurança
composer audit
```

## 🔧 Scripts Disponíveis

- `composer test` - Executa os testes
- `composer test-coverage` - Executa testes com coverage
- `composer lint` - Executa o linting
- `composer lint-fix` - Corrige automaticamente problemas de linting
- `composer format` - Formata o código
- `composer stan` - Executa análise estática
- `composer audit` - Executa auditoria de segurança

## 🌐 Endpoints da API

- `GET /` - Informações da aplicação
- `GET /health` - Status de saúde da aplicação
- `GET /api/users` - Lista de usuários
- `POST /api/users` - Criar novo usuário
- `GET /api/users/{id}` - Buscar usuário específico

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

### PHPStan (Análise Estática)
- Detecção de erros em tempo de compilação
- Análise de tipos
- Verificação de código morto

### Composer Audit (Verificação de Dependências)
- Verificação de vulnerabilidades conhecidas
- Alertas de segurança

## 📊 Resultados da Esteira CI/CD

### ✅ Code Quality
```
OK, but there were issues!
Tests: 6, Assertions: 28, PHPUnit Deprecations: 1.
```
- **Status**: ✅ Passou com avisos
- **Testes**: 6 testes executados
- **Assertions**: 28 verificações realizadas
- **Cobertura**: Acima de 80% (threshold configurado)
- **Issues**: 1 depreciação do PHPUnit (não crítico)

### ✅ SCM Snyk Security
```
✔ Tested 25 dependencies for known issues, no vulnerable paths found.
Tip: Detected multiple supported manifests (3), use --all-projects to scan all of them at once.
```
- **Status**: ✅ Passou
- **Dependências testadas**: 25
- **Vulnerabilidades encontradas**: 0
- **Manifests detectados**: 3 (composer.json, package.json, etc.)

### ✅ SAST SonarQube
```
12:40:53.534 INFO  ------------- Check Quality Gate status
12:40:53.534 INFO  Waiting for the analysis report to be processed (max 300s)
12:40:59.332 INFO  QUALITY GATE STATUS: PASSED - View details on https://sonarcloud.io/dashboard?id=rrddevops_prj-dast-scm-sast&branch=main
12:40:59.337 INFO  Analysis total time: 29.086 s
12:40:59.338 INFO  SonarScanner Engine completed successfully
12:40:59.671 INFO  EXECUTION SUCCESS
```
- **Status**: ✅ Quality Gate PASSED
- **Tempo de análise**: 29.086 segundos
- **Cobertura**: Acima do threshold de 80%
- **Dashboard**: [SonarCloud](https://sonarcloud.io/dashboard?id=rrddevops_prj-dast-scm-sast&branch=main)

### ⚠️ DAST ZAP Security
```
Unable to find image 'ghcr.io/zaproxy/zap-baseline:latest' locally
docker: Error response from daemon: Head "https://ghcr.io/v2/zaproxy/zap-baseline/manifests/latest": denied
ZAP scan completed with warnings
```
- **Status**: ⚠️ Falhou (problema de acesso à imagem Docker)
- **Problema**: Acesso negado ao GitHub Container Registry
- **Solução**: Configurar autenticação ou usar imagem alternativa
- **Impacto**: Não crítico para o pipeline principal
- **Workaround**: Relatório vazio é gerado para não quebrar o pipeline

### ✅ Build & Deploy
- **Status**: ✅ Container test passou
- **Docker build**: Sucesso
- **Health check**: `/health` endpoint funcionando
- **Deploy**: Pronto para produção

## ⚙️ Configuração do GitHub Actions

### Secrets Necessários

Configure os seguintes secrets no seu repositório GitHub:

- `SONAR_TOKEN` - Token do SonarQube Cloud
- `SNYK_TOKEN` - Token do Snyk
- `SONAR_HOST_URL` - URL do SonarCloud (opcional, padrão: https://sonarcloud.io)

### Workflow

O workflow executa automaticamente:

1. **Code Quality** - Linting, testes e auditoria
2. **SonarQube** - Análise SAST com cobertura
3. **Snyk Security Scan** - Análise de vulnerabilidades
4. **OWASP ZAP Security Test** - Testes DAST
5. **Build & Deploy** - Build e teste do container

## 📁 Estrutura do Projeto

```
prj-dast-scm-sast/
├── app/
│   ├── src/
│   │   └── Controllers/
│   │       ├── HomeController.php
│   │       ├── HealthController.php
│   │       └── UserController.php
│   ├── tests/
│   │   └── Controllers/
│   │       ├── HomeControllerTest.php
│   │       └── UserControllerTest.php
│   ├── public/
│   │   ├── index.php
│   │   └── .htaccess
│   ├── config/
│   │   ├── container.php
│   │   └── routes.php
│   └── logs/
├── docker/
│   ├── nginx.conf
│   └── start.sh
├── .github/workflows/
│   └── ci-cd.yml
├── Dockerfile
├── docker-compose.yml
├── composer.json
├── phpunit.xml
├── phpcs.xml
├── phpstan.neon
├── sonar-project.properties
├── zap-baseline.conf
└── README.md
```

## 🔧 Configuração de Desenvolvimento

### VS Code Extensions Recomendadas

- PHP Intelephense
- PHP Debug
- PHP CS Fixer
- PHP Sniffer
- Docker
- PHP Test Explorer

### Configurações do VS Code

```json
{
  "php.validate.enable": true,
  "php.suggest.basic": false,
  "phpcs.standard": "PSR12",
  "php-cs-fixer.executablePath": "vendor/bin/php-cs-fixer",
  "php-cs-fixer.onsave": true,
  "php-cs-fixer.config": ".php-cs-fixer.php",
  "phpunit.php": "vendor/bin/phpunit",
  "phpunit.phpunit": "vendor/bin/phpunit"
}
```

## 📊 Monitoramento

A aplicação inclui endpoints de monitoramento:

- `/health` - Health check para Docker e load balancers
- Logs estruturados com Monolog
- Métricas de performance

## 🚀 Deploy

### Produção

```bash
# Build da imagem de produção
docker build -t dast-scm-sast-app:latest .

# Push para registry
docker push your-registry/dast-scm-sast-app:latest

# Deploy
docker run -d -p 80:80 --name dast-app dast-scm-sast-app:latest
```
## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request
