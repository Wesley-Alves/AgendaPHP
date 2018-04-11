<?php
    // Arquivo roteador, responsável por mandar as diferentes requisições para diferentes métodos.
    require_once("contato_controller.php");

    if (isset($_GET["modo"])) {
        $modo = $_GET["modo"];
        $contatoController = new ContatoController();
        if ($modo == "adicionar") {
            $contatoController->gerarModalAdicionar();
        } else if ($modo == "gravar") {
            $contatoController->gravar();
        } else if ($modo == "editar") {
            $contatoController->gerarModalEditar();
        } else if ($modo == "atualizar") {
            $contatoController->atualizar();
        } else if ($modo == "excluir") {
            $contatoController->getModalExcluir();
        } else if ($modo == "confirmar_exclusao") {
            $contatoController->excluir();
        }
    }
?>