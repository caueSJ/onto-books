<!-- Modal Adicionar Livro -->
<div class="modal fade" id="modalAdicionarLivro" tabindex="-1" role="dialog" aria-labelledby="AdicionarLivro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AdicionarLivro">Adicionar Livro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <form class="form-save-gerencia">
                                <div class="form-group">
                                    <label for="tituloLivro">Título</label>
                                    <input type="text" class="form-control" id="tituloLivro">
                                </div>
                                <div class="form-group">
                                    <label for="autorLivro">Autor</label>
                                    <input type="text" class="form-control" id="autorLivro">
                                </div>
                                <div class="form-group">
                                    <label for="autorLivro">Editora</label>
                                    <input type="text" class="form-control" id="autorLivro">
                                </div>
                                <div class="form-group">
                                    <label for="autorLivro">Edição</label>
                                    <input type="text" class="form-control" id="autorLivro">
                                </div>
                                <div class="form-group">
                                    <label for="autorLivro">Área</label>
                                    <input type="text" class="form-control" id="autorLivro">
                                </div>
                                <div class="form-group">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save_gerencia" data-controller="<?echo $controller ?>" form-name="">Adicionar</button>
            </div>
        </div>
    </div>
</div>

<!-- Botão para adicionar livro -->
<button type="button" class="mb-3 btn btn-primary adicionar-button" data-toggle="modal" data-target="#modalAdicionarLivro">
  Adicionar Livro
</button>