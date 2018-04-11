<?php
    // Arquivo controlador, responsável por todas as funções relacionadas aos contatos.
    require_once("contato.php");
    require_once("contato_dao.php");
    class ContatoController {
        // Gera uma nova linha para a tabela de contatos na tela do usuário.
        public function gerarLinhaTabela($contato) {
            ?>
            <tr data-id="<?= $contato->getId() ?>">
                <td><?= $contato->getNome() ?></td>
                <td><?= $contato->getEmail() ?></td>
                <td><?= $contato->getCelular() ?></td>
                <td class="text-center acoes">
                    <a href="router.php?modo=editar&id=<?= $contato->getId() ?>" class="editar">
                        <img src="imagens/editar.png" alt="Editar" title="Editar">
                    </a>
                    <a href="router.php?modo=excluir&id=<?= $contato->getId() ?>" class="excluir">
                        <img src="imagens/excluir.png" alt="Excluir" title="Excluir">
                    </a>
                </td>
            </tr>
            <?php
        }
        
        // Gera o modal de adicionar um novo contato.
        public function gerarModalAdicionar() {
            ?>
            <div class="modal fade" id="modal_adicionar" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adicionar Contato</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="router.php?modo=gravar" id="form_adicionar">
                                <div class="form-row">
                                    <div class="form-group col-md-7">
                                        <label for="txt_nome">Nome</label>
                                        <input type="text" class="form-control" id="txt_nome" name="txt_nome" maxlength="100" required>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="txt_celular">Celular</label>
                                        <input type="text" class="form-control" id="txt_celular" name="txt_celular" maxlength="15" required placeholder="(XX) XXXXX-XXXX" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" title="(XX) XXXXX-XXXX">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txt_email">Email</label>
                                    <input type="email" class="form-control" id="txt_email" name="txt_email" maxlength="100" required>
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary salvar" data-form="#form_adicionar">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        
        // Gera o modal de editar um contato.
        public function gerarModalEditar() {
            $id = $_GET["id"];
            $contatoDao = new ContatoDAO();
            $contato = $contatoDao->selecionar($id);
            ?>
            <div class="modal fade" id="modal_atualizar" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Contato</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="router.php?modo=atualizar" id="form_atualizar">
                                <input type="hidden" name="id" value="<?= $contato->getId() ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-7">
                                        <label for="txt_nome">Nome</label>
                                        <input type="text" class="form-control" id="txt_nome" name="txt_nome" maxlength="100" required value="<?= $contato->getNome() ?>">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="txt_celular">Celular</label>
                                        <input type="text" class="form-control" id="txt_celular" name="txt_celular" maxlength="15" required placeholder="(XX) XXXXX-XXXX" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" title="(XX) XXXXX-XXXX" value="<?= $contato->getCelular() ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txt_email">Email</label>
                                    <input type="email" class="form-control" id="txt_email" name="txt_email" maxlength="100" required value="<?= $contato->getEmail() ?>">
                                </div>
                                <input type="submit">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary salvar" data-form="#form_atualizar">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        
        // Gera o modal para confirmar a exclusão de um contato.
        public function getModalExcluir() {
            $id = $_GET["id"];
            $nome = $_GET["nome"];
            ?>
            <div class="modal fade" id="modal_adicionar" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Excluir Contato</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Deseja realmente excluir <strong><?= $nome ?></strong> ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <a href="router.php?modo=confirmar_exclusao&id=<?= $id ?>" class="btn btn-danger confirmar" data-dismiss="modal">Excluir</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        
        // Função para adicionar um novo contato.
        public function gravar() {
            $contato = new Contato();
            $contato->setNome($_POST["txt_nome"]);
            $contato->setCelular($_POST["txt_celular"]);
            $contato->setEmail($_POST["txt_email"]);
            $contatoDao = new ContatoDAO();
            $id = $contatoDao->inserir($contato);
            $contato->setId($id);
            $this->gerarLinhaTabela($contato);
        }
        
        // Função para atualizar um contato já existente.
        public function atualizar() {
            $contato = new Contato();
            $contato->setId($_POST["id"]);
            $contato->setNome($_POST["txt_nome"]);
            $contato->setCelular($_POST["txt_celular"]);
            $contato->setEmail($_POST["txt_email"]);
            $contatoDao = new ContatoDAO();
            $contatoDao->atualizar($contato);
            $this->gerarLinhaTabela($contato);
        }
        
        // Função para excluir um contato.
        public function excluir() {
            $id = $_GET["id"];
            $contatoDao = new ContatoDAO();
            $contatoDao->excluir($id);
            echo $id;
        }
    }
?>