#!/usr/bin/env python3
"""
Script de health check para o Docker
"""
import requests
import sys

def check_health():
    """Verifica se a aplicação está saudável"""
    try:
        response = requests.get('http://localhost:3000/health', timeout=5)
        print(f"Health check status: {response.status_code}")
        
        if response.status_code == 200:
            return True
        else:
            return False
            
    except requests.exceptions.RequestException as e:
        print(f"Health check failed: {e}")
        return False

if __name__ == '__main__':
    if check_health():
        sys.exit(0)
    else:
        sys.exit(1) 