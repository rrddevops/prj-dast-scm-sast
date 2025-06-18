import pytest
import json
from src.app import app

@pytest.fixture
def client():
    """Fixture para criar cliente de teste"""
    app.config['TESTING'] = True
    app.config['WTF_CSRF_ENABLED'] = False
    with app.test_client() as client:
        yield client

class TestAPIEndpoints:
    """Testes para os endpoints da API"""
    
    def test_index_endpoint(self, client):
        """Testa o endpoint principal"""
        response = client.get('/')
        data = json.loads(response.data)
        
        assert response.status_code == 200
        assert 'message' in data
        assert 'version' in data
        assert 'status' in data
        assert 'timestamp' in data
        assert data['status'] == 'online'
    
    def test_health_endpoint(self, client):
        """Testa o endpoint de health check"""
        response = client.get('/health')
        data = json.loads(response.data)
        
        assert response.status_code == 200
        assert 'status' in data
        assert 'uptime' in data
        assert 'timestamp' in data
        assert data['status'] == 'healthy'
    
    def test_get_users(self, client):
        """Testa a listagem de usuários"""
        response = client.get('/api/users')
        data = json.loads(response.data)
        
        assert response.status_code == 200
        assert isinstance(data, list)
        assert len(data) > 0
        assert 'id' in data[0]
        assert 'name' in data[0]
        assert 'email' in data[0]
    
    def test_create_user_valid(self, client):
        """Testa criação de usuário com dados válidos"""
        user_data = {
            'name': 'Test User',
            'email': 'test@example.com'
        }
        
        response = client.post('/api/users',
                             data=json.dumps(user_data),
                             content_type='application/json')
        data = json.loads(response.data)
        
        assert response.status_code == 201
        assert 'id' in data
        assert data['name'] == user_data['name']
        assert data['email'] == user_data['email']
    
    def test_create_user_missing_name(self, client):
        """Testa criação de usuário sem nome"""
        user_data = {
            'email': 'test@example.com'
        }
        
        response = client.post('/api/users',
                             data=json.dumps(user_data),
                             content_type='application/json')
        data = json.loads(response.data)
        
        assert response.status_code == 400
        assert 'error' in data
    
    def test_create_user_missing_email(self, client):
        """Testa criação de usuário sem email"""
        user_data = {
            'name': 'Test User'
        }
        
        response = client.post('/api/users',
                             data=json.dumps(user_data),
                             content_type='application/json')
        data = json.loads(response.data)
        
        assert response.status_code == 400
        assert 'error' in data
    
    def test_get_user_valid(self, client):
        """Testa busca de usuário válido"""
        response = client.get('/api/users/1')
        data = json.loads(response.data)
        
        assert response.status_code == 200
        assert data['id'] == 1
        assert 'name' in data
        assert 'email' in data
    
    def test_get_user_invalid(self, client):
        """Testa busca de usuário inexistente"""
        response = client.get('/api/users/999')
        data = json.loads(response.data)
        
        assert response.status_code == 404
        assert 'error' in data
    
    def test_404_handler(self, client):
        """Testa handler de 404"""
        response = client.get('/non-existent')
        data = json.loads(response.data)
        
        assert response.status_code == 404
        assert 'error' in data 