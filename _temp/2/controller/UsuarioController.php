<?php
//require_once '../dao/UsuarioDAO.php';
//require_once '../model/Usuario.php';

class UsuarioController {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function salvar($nome, $email, $senha, $telefone, $tipo_usuario) {
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuario->setTelefone($telefone);
        $usuario->setTipoUsuario($tipo_usuario);

        $this->usuarioDAO->salvar($usuario);
    }

    public function listar() {
        return $this->usuarioDAO->listar();
    }

    public function buscarPorId($id_usuario) {
        return $this->usuarioDAO->buscarPorId($id_usuario);
    }

    public function atualizar($id_usuario, $nome, $email, $senha, $telefone, $tipo_usuario) {
        $usuario = $this->usuarioDAO->buscarPorId($id_usuario);
        if ($usuario) {
            $usuario = new Usuario();
            $usuario->setIdUsuario($id_usuario);
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setSenha($senha);
            $usuario->setTelefone($telefone);
            $usuario->setTipoUsuario($tipo_usuario);

            $this->usuarioDAO->atualizar($usuario);
        }
    }

    public function deletar($id_usuario) {
        $this->usuarioDAO->deletar($id_usuario);
    }
}
?>
