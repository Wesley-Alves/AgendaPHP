<?php
    // Arquivo DAO, responsável por fazer acesso ao banco de dados na tabela de contatos.
    include_once("database.php");
    class ContatoDAO {
        public function inserir($contato) {
            $conexao = getDatabaseConnection();
            $statement = $conexao->prepare("INSERT INTO tbl_contato (nome, email, celular) VALUES (?, ?, ?)");
            $statement->bind_param("sss", ...array($contato->getNome(), $contato->getEmail(), $contato->getCelular()));
            $statement->execute();
            $id = $statement->insert_id;
            $statement->close();
            $conexao->close();
            return $id;
        }
        
        public function selecionarTodos() {
            $contatos = array();
            $conexao = getDatabaseConnection();
            $result = $conexao->query("SELECT * FROM tbl_contato");
            while ($data = $result->fetch_array()) {
                $contato = new Contato();
                $contato->setId($data["id"]);
                $contato->setNome($data["nome"]);
                $contato->setEmail($data["email"]);
                $contato->setCelular($data["celular"]);
                $contatos[] = $contato;
            }
            
            $conexao->close();
            return $contatos;
        }
        
        public function selecionar($id) {
            $contato = null;
            $conexao = getDatabaseConnection();
            $statement = $conexao->prepare("SELECT * FROM tbl_contato WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();
            if ($data = $result->fetch_array()) {
                $contato = new Contato();
                $contato->setId($data["id"]);
                $contato->setNome($data["nome"]);
                $contato->setEmail($data["email"]);
                $contato->setCelular($data["celular"]);
            }
            
            $statement->close();
            $conexao->close();
            return $contato;
        }
        
        public function atualizar($contato) {
            $conexao = getDatabaseConnection();
            $statement = $conexao->prepare("UPDATE tbl_contato SET nome = ?, email = ?, celular = ? WHERE id = ?");
            $statement->bind_param("sssi", ...array($contato->getNome(), $contato->getEmail(), $contato->getCelular(), $contato->getId()));
            $statement->execute();
            $statement->close();
            $conexao->close();
        }
        
        public function excluir($id) {
            $conexao = getDatabaseConnection();
            $statement = $conexao->prepare("DELETE FROM tbl_contato WHERE id = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $statement->close();
            $conexao->close();
        }
    }
?>