-- Tabela usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(15),
    tipo_usuario ENUM('cuidador', 'enfermeiro') NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela pacientes
CREATE TABLE pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    sexo ENUM('M', 'F', 'O') NOT NULL, -- Masculino -- Feminino -- Outro
    telefone VARCHAR(15),
    endereco VARCHAR(255),
    id_usuario INT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabela medicamentos
CREATE TABLE medicamentos (
    id_medicamento INT AUTO_INCREMENT PRIMARY KEY,
    nome_medicamento VARCHAR(100) NOT NULL,
    dosagem VARCHAR(50) NOT NULL,
    frequencia VARCHAR(50) NOT NULL,
    descricao TEXT,
    id_paciente INT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente)
);

-- Tabela alertas
CREATE TABLE alertas (
    id_alerta INT AUTO_INCREMENT PRIMARY KEY,
    data_hora_alerta DATETIME NOT NULL,
    status_alerta ENUM('pendente', 'confirmado', 'ignorado') NOT NULL,
    metodo_alerta ENUM('email', 'sms', 'app') NOT NULL,
    data_confirmacao DATETIME,
    id_medicamento INT,
    FOREIGN KEY (id_medicamento) REFERENCES medicamentos(id_medicamento)
);

-- Talvez seja necessario
-- -- Tabela historico_medicacao
-- CREATE TABLE historico_medicacao (
--     id_historico INT AUTO_INCREMENT PRIMARY KEY,
--     id_prescricao INT NOT NULL,
--     data_hora_tomado DATETIME NOT NULL,
--     confirmado_por INT,
--     observacoes TEXT,
--     FOREIGN KEY (id_prescricao) REFERENCES prescricoes(id_prescricao),
--     FOREIGN KEY (confirmado_por) REFERENCES usuarios(id_usuario)
-- );