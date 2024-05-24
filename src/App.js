import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './App.css'; 

function App() {
  const [students, setStudents] = useState([]);
  const [form, setForm] = useState({ Materia: '', N1: '', AP: '', AI: '' });
  const [isEditing, setIsEditing] = useState(false);
  const [currentId, setCurrentId] = useState(null);

  useEffect(() => {
    fetchStudents();
  }, []);

  const fetchStudents = async () => {
    const res = await axios.get('http://localhost:4000/api/students');
    setStudents(res.data);
  };

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (isEditing) {
      await axios.put(`http://localhost:4000/api/students/${currentId}`, form);
      setIsEditing(false);
      setCurrentId(null);
    } else {
      await axios.post('http://localhost:4000/api/students', form);
    }
    setForm({ Materia: '', N1: '', AP: '', AI: '' });
    fetchStudents();
  };

  const handleEdit = (student) => {
    setForm({ Materia: student.Materia, N1: student.N1, AP: student.AP, AI: student.AI });
    setIsEditing(true);
    setCurrentId(student.id);
  };

  const handleDelete = async (id) => {
    await axios.delete(`http://localhost:4000/api/students/${id}`);
    fetchStudents();
  };

  return (
    <div className="App">
      <h1>Cadastro de Aluno</h1>
      <form onSubmit={handleSubmit}>
        <input type="text" name="Materia" value={form.Materia} onChange={handleChange} placeholder="Nome da Matéria" required />
        <input type="number" name="N1" value={form.N1} onChange={handleChange} placeholder="N1" required />
        <input type="number" name="AP" value={form.AP} onChange={handleChange} placeholder="AP" required />
        <input type="number" name="AI" value={form.AI} onChange={handleChange} placeholder="AI" required />
        <button type="submit">{isEditing ? 'Atualizar' : 'Adicionar'}</button>
      </form>
      <ul>
        {students.map((student) => (
          <li key={student.id}>
            {student.Materia} - N1: {student.N1}, AP: {student.AP}, AI: {student.AI}
            <button onClick={() => handleEdit(student)}>Editar</button>
            <button onClick={() => handleDelete(student.id)}>Deletar</button>
          </li>
        ))}
      </ul>
    </div>
  );
}

export default App;
