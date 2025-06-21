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
- **Quando**: PR e Push para main
- **Propósito**: 
  - PR: Validação do quality gate
  - Push: Análise final e relatório de cobertura

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
4. **Workflow executa**: Apenas jobs de validação (1-4)
5. **Merge**: Quando PR é aprovado e mergeado
6. **Workflow executa novamente**: Todos os jobs (1-5) incluindo build/deploy

### Cenário 2: Push Direto para Main (Não Recomendado)

1. **Push direto**: `git push origin main`
2. **Workflow executa**: Todos os jobs (1-5)

## Otimizações Implementadas

1. **Execução Condicional**: `build-and-deploy` só executa em push para main
2. **Tipos de PR**: Workflow só executa em PRs `opened`, `synchronize`, `reopened`
3. **Dependências**: Jobs são executados em paralelo quando possível
4. **Cache**: Composer e outras dependências são cacheadas

## Benefícios

- **Eficiência**: Evita execuções duplicadas desnecessárias
- **Segurança**: Validação completa antes do merge
- **Velocidade**: Jobs de validação executam em PRs, build/deploy apenas no merge final
- **Custo**: Reduz uso de recursos do GitHub Actions

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