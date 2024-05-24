import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './App.css';

function App() {
  const [users, setUsers] = useState([]);
  const [form, setForm] = useState({ nome_completo: '', telefone: '', email: '', senha: '' });
  const [isEditing, setIsEditing] = useState(false);
  const [currentId, setCurrentId] = useState(null);

  useEffect(() => {
    fetchUsers();
  }, []);

  const fetchUsers = async () => {
    try {
      const res = await axios.get('http://localhost:4001/api/users');
      setUsers(res.data);
    } catch (error) {
      console.error('Error fetching users:', error);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (name === 'telefone') {
      const onlyNums = value.replace(/[^0-9]/g, '');
      setForm({ ...form, [name]: onlyNums });
    } else {
      setForm({ ...form, [name]: value });
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      if (isEditing) {
        await axios.put(`http://localhost:4001/api/users/${currentId}`, form);
        setIsEditing(false);
        setCurrentId(null);
      } else {
        await axios.post('http://localhost:4001/api/users', form);
      }
      setForm({ nome_completo: '', telefone: '', email: '', senha: '' });
      fetchUsers();
    } catch (error) {
      console.error('Error submitting form:', error);
    }
  };

  const handleEdit = (user) => {
    setForm({ nome_completo: user.nome_completo, telefone: user.telefone, email: user.email, senha: user.senha });
    setIsEditing(true);
    setCurrentId(user.id);
  };

  const handleDelete = async (id) => {
    try {
      await axios.delete(`http://localhost:4001/api/users/${id}`);
      fetchUsers();
    } catch (error) {
      console.error('Error deleting user:', error);
    }
  };

  return (
    <div className="App">
      <h1>Cadastro de Usuário</h1>
      <form onSubmit={handleSubmit}>
        <input type="text" name="nome_completo" value={form.nome_completo} onChange={handleChange} placeholder="Nome Completo" required />
        <input type="tel" name="telefone" value={form.telefone} onChange={handleChange} placeholder="Telefone" required />
        <input type="email" name="email" value={form.email} onChange={handleChange} placeholder="E-mail" required />
        <input type="password" name="senha" value={form.senha} onChange={handleChange} placeholder="Senha" required />
        <button type="submit">{isEditing ? 'Atualizar' : 'Adicionar'}</button>
      </form>
      <ul>
        {users.map((user) => (
          <li key={user.id}>
            {user.nome_completo} - Telefone: {user.telefone}, E-mail: {user.email}
            <div>
              <button className="edit" onClick={() => handleEdit(user)}>Editar</button>
              <button className="delete" onClick={() => handleDelete(user.id)}>Deletar</button>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
}

export default App;
