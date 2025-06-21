# CI/CD Workflow Behavior

## Overview

Este documento explica como o workflow CI/CD se comporta em diferentes cenários de desenvolvimento.

## Triggers

O workflow é executado nos seguintes eventos:

1. **Push direto para `main`**: Executa todos os jobs incluindo build e deploy
2. **Pull Request para `main`**: Executa apenas os jobs de validação (sem build/deploy)

## Jobs e Quando Executam

### 1. code-quality
- **Quando**: PR e Push para main
- **Propósito**: Validação de qualidade de código (PHP CS Fixer, PHPStan, testes)

### 2. sonarqube
- **Quando**: Apenas Push direto para main
- **Propósito**: Análise final e relatório de cobertura
- **Nota**: **NÃO executa** em pull requests nem em outras branches como `develop`, `hotfix`, `release`, `feature`

### 3. snyk-security
- **Quando**: PR e Push para main
- **Propósito**: 
  - PR: Detecção de vulnerabilidades antes do merge
  - Push: Validação final de segurança

### 4. zap-security
- **Quando**: PR e Push para main
- **Propósito**: 
  - PR: Teste de segurança dinâmico antes do merge
  - Push: Validação final DAST

### 5. build-and-deploy
- **Quando**: Apenas Push para main
- **Propósito**: Build da imagem Docker e deploy em produção

## Cenários de Uso

### Cenário 1: Desenvolvimento em Branch Feature/Hotfix

1. **Criar branch**: `git checkout -b hotfix/critical-fix`
2. **Fazer commits**: Desenvolver a correção
3. **Criar PR**: Pull request para `main`
4. **Workflow executa**: Jobs de validação (1, 3, 4) - **SonarQube NÃO executa**
5. **Merge**: Quando PR é aprovado e mergeado
6. **Workflow executa novamente**: Todos os jobs (1-5) incluindo build/deploy - **SonarQube executa**

### Cenário 2: Desenvolvimento em Branch Develop

1. **Criar branch**: `git checkout -b develop`
2. **Fazer commits**: Desenvolver funcionalidades
3. **Push para develop**: `git push origin develop`
4. **Workflow executa**: Apenas jobs básicos (1, 3, 4) - **SonarQube NÃO executa**
5. **Criar PR**: Pull request de develop para main
6. **Workflow executa**: Jobs de validação (1, 3, 4) - **SonarQube NÃO executa**

### Cenário 3: Push Direto para Main (Não Recomendado)

1. **Push direto**: `git push origin main`
2. **Workflow executa**: Todos os jobs (1-5)

## Otimizações Implementadas

1. **Execução Condicional**: `build-and-deploy` só executa em push para main
2. **SonarQube Restritivo**: Só executa em push direto para main (não em PRs)
3. **Tipos de PR**: Workflow só executa em PRs `opened`, `synchronize`, `reopened`
4. **Dependências**: Jobs são executados em paralelo quando possível
5. **Cache**: Composer e outras dependências são cacheadas

## Benefícios

- **Eficiência**: Evita execuções duplicadas desnecessárias
- **Custo**: Reduz uso de recursos do GitHub Actions e SonarCloud
- **Velocidade**: Jobs de validação executam em PRs, build/deploy apenas no merge final
- **Foco**: SonarQube focado apenas em branches importantes
- **Clareza**: Comportamento bem documentado e previsível

## Troubleshooting

### Workflow Executando Duas Vezes

Se o workflow está executando duas vezes para uma PR:

1. Verifique se não há push direto para `main` acontecendo
2. Confirme que a PR está configurada corretamente
3. Verifique se não há outros workflows conflitantes

### Job Não Executando

Se um job específico não está executando:

1. Verifique as condições `if` no job
2. Confirme que as dependências (`needs`) estão sendo atendidas
3. Verifique se o trigger está correto para o cenário

### SonarQube Não Executando

Se o SonarQube não está executando:

1. **Verifique a branch**: SonarQube só executa em push direto para `main`
2. **Verifique o evento**: Deve ser `push` para main (não `pull_request`)
3. **Verifique os secrets**: `SONAR_TOKEN` e `SONAR_ORGANIZATION` devem estar configurados
4. **Nota**: SonarQube **NÃO executa** em pull requests nem em outras branches 