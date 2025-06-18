from flask import Flask, jsonify, request
from flask_cors import CORS
from flask_helmet import Helmet
import os
import time
from datetime import datetime
from dotenv import load_dotenv

# Carregar variáveis de ambiente
load_dotenv()

app = Flask(__name__)

# Configurações de segurança
app.config['SECRET_KEY'] = os.getenv('SECRET_KEY', 'dev-secret-key-change-in-production')
app.config['JSON_SORT_KEYS'] = False

# Middleware de segurança
CORS(app)
Helmet(app)

# Dados simulados de usuários
users = [
    {'id': 1, 'name': 'João Silva', 'email': 'joao@example.com'},
    {'id': 2, 'name': 'Maria Santos', 'email': 'maria@example.com'},
    {'id': 3, 'name': 'Pedro Costa', 'email': 'pedro@example.com'}
]

@app.route('/')
def index():
    """Endpoint principal da aplicação"""
    return jsonify({
        'message': 'Bem-vindo à aplicação DAST/SCM/SAST',
        'version': '1.0.0',
        'status': 'online',
        'timestamp': datetime.now().isoformat()
    })

@app.route('/health')
def health():
    """Endpoint de health check"""
    return jsonify({
        'status': 'healthy',
        'uptime': time.time(),
        'timestamp': datetime.now().isoformat()
    })

@app.route('/api/users', methods=['GET'])
def get_users():
    """Retorna lista de usuários"""
    return jsonify(users)

@app.route('/api/users', methods=['POST'])
def create_user():
    """Cria um novo usuário"""
    data = request.get_json()
    
    if not data or 'name' not in data or 'email' not in data:
        return jsonify({'error': 'Nome e email são obrigatórios'}), 400
    
    # Simulação de criação de usuário
    new_user = {
        'id': len(users) + 1,
        'name': data['name'],
        'email': data['email']
    }
    
    users.append(new_user)
    return jsonify(new_user), 201

@app.route('/api/users/<int:user_id>', methods=['GET'])
def get_user(user_id):
    """Retorna um usuário específico"""
    user = next((u for u in users if u['id'] == user_id), None)
    if user is None:
        return jsonify({'error': 'Usuário não encontrado'}), 404
    return jsonify(user)

@app.errorhandler(404)
def not_found(error):
    """Handler para rotas não encontradas"""
    return jsonify({'error': 'Rota não encontrada'}), 404

@app.errorhandler(500)
def internal_error(error):
    """Handler para erros internos"""
    return jsonify({'error': 'Algo deu errado!'}), 500

if __name__ == '__main__':
    port = int(os.getenv('PORT', 3000))
    debug = os.getenv('FLASK_ENV') == 'development'
    app.run(host='0.0.0.0', port=port, debug=debug) 