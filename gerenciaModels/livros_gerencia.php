<?
if (file_exists('DAO/livrosDAO.php')) {
    require_once 'DAO/livrosDAO.php';
} else if (file_exists('../DAO/livrosDAO.php')) {
    require_once '../DAO/livrosDAO.php';
} else if (file_exists('../../DAO/livrosDAO.php')) {
    require_once '../../DAO/livrosDAO.php';
}
$dao = new livrosDAO;
$livros = $dao->getLivros();
$controller ='livros_gerencia';
?>

<!-- Modais -->
<!-- Adicionar Autor -->
<div class="modal fade" id="modalCadastrarAutor" tabindex="-1" role="dialog" aria-labelledby="modalAutor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAutor">Cadastrar Autor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ui styled sixteen fluid wide">
                    <div class="ui form form-gerencia-autores form-save-gerencia-autor">
                        <div class="field">
                            <input type="hidden"  class="id_item_gerencia">
                            <label class="ui label ontobooks_color indice-1" data-indice = "1" tabindex="4">Nome do Autor</label>
                            <input class="autores_gerencia-nome" placeholder="Nome" data-required='required' name="nome" type="text" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ui red direita button" data-dismiss="modal">Cancelar</button>
                <button type="button" class="ui green direita save_gerencia button" data-controller='autores_gerencia' form-name='form-save-gerencia-autor'>Cadastrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Adicionar Editora -->
<div class="modal fade" id="modalCadastrarEditora" tabindex="-1" role="dialog" aria-labelledby="modalEditora" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEdiora">Cadastrar Editora</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ui styled sixteen fluid wide">
                    <div class="ui form form-gerencia-editora form-save-gerencia-editora">
                        <div class="field">
                            <input type="hidden"  class="id_item_gerencia">
                            <label class="ui label ontobooks_color indice-1" data-indice = "1" tabindex="4">Nome do Editora</label>
                            <input class="editora_gerencia-nome" placeholder="Nome" data-required='required' name="nome" type="text" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ui red direita button" data-dismiss="modal">Cancelar</button>
                <button type="button" class="ui green direita save_gerencia button" data-controller='editora_gerencia' form-name='form-save-gerencia-editora'>Cadastrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Adicionar Área -->
<div class="modal fade" id="modalCadastrarArea" tabindex="-1" role="dialog" aria-labelledby="modalArea" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalArea">Cadastrar Área</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ui styled sixteen fluid wide">
                    <div class="ui form form-gerencia-area form-save-gerencia-area">
                        <div class="field">
                            <input type="hidden"  class="id_item_gerencia">
                            <label class="ui label ontobooks_color indice-1" data-indice = "1" tabindex="4">Nome da Área</label>
                            <input class="area_gerencia-nome" placeholder="Área" data-required='required' name="nome" type="text" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ui red button" data-dismiss="modal">Cancelar</button>
                <button type="button" class="ui green save_gerencia button" data-controller='area_gerencia' form-name='form-save-gerencia-area'>Cadastrar</button>
            </div>
        </div>
    </div>
</div>

<h1 class="titulo_gerencia">Livros</h1>

<div class="ui styled sixteen fluid wide accordion novo_gerencia">
    <div class=" title">
        <button type="button" class="mb-3 btn btn-primary">
            Adicionar Livro
        </button>
    </div>
    <div class="content">
        <div class="ui equal width form form-gerencia-<? echo $controller ?> form-save-gerencia">
            <div class="fields" >
                <div class="field">
                    <input type="hidden"  class="id_item_gerencia">
                    <label class="ui label ontobooks_color">Título</label>
                    <input class="<? echo $controller ?>-titulo" type="text" placeholder="Título" data-required="required" name="titulo" value="">
                </div>
                <div class="field">
                    <label class="ui label ontobooks_color">Autor <a data-toggle="modal" data-target="#modalCadastrarAutor"><span class="ml-4 small">(Adicionar)</span></a></label>
                    <div class="ui search selection dropdown <? echo $controller ?>-autor indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                        <input type="hidden" data-required="required" tabindex="1" name="id_autor">    
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecione o Autor</div>
                        <div class="menu form-autor-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="fields">
                <div class="field">
                    <label class="ui label ontobooks_color">Edição</label>
                    <input class="<? echo $controller ?>-edicao" data-required='required' placeholder="Edição"  name="edicao" type="number" value="">
                </div>
                <div class="field">
                    <label class="ui label ontobooks_color">Editora <a data-toggle="modal" data-target="#modalCadastrarEditora"><span class="ml-4 small">(Adicionar)</span></a></label>
                    <div class="ui fluid search selection dropdown <? echo $controller ?>-editora indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                        <input type="hidden" data-required="required" tabindex="1" name="id_editora">
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecione a Editora</div>
                        <div class="menu form-editora-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="ui label ontobooks_color">Área <a data-toggle="modal" data-target="#modalCadastrarArea"><span class="ml-4 small">(Adicionar)</span></a></label>
                    <div class="ui search selection dropdown <? echo $controller ?>-area indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                        <input type="hidden" data-required="required" tabindex="1" name="id_area">
                        <i class="dropdown icon"></i>
                        <div class="default text">Selecione a Área</div>
                        <div  class="menu form-area-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="ui red direita cancela_save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Cancelar</button>
        <button class="ui green direita save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Salvar</button>
    </div>
</div>

<!-- Tabela criada com Boostrap e Datatable -->
<table class="table table-hover table-responsive-sm bg-light" id="lista_gerencia">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Título</th>
            <th scope="col">Autor</th>
            <th scope="col">Editora</th>
            <th scope="col">Edição</th>
            <th scope="col">Área</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($livros as $livro) { ?>
        <tr class="livro_edicao_gerencia edit_item_gerencia"
            data-item='<? echo $livro['id_livro']?>' <?if(file_exists('../img/livros/'.$livro['id_livro'].'.jpg')){?>
            imagem='ok'
            data-html="<div class='header ontobooks_titles' >CAPA:</div> <img width='250px' height='300px' src='img/livros/<? echo $livro['id_livro']?>.jpg'>" <?}?>
            data-controller="<?echo $controller?>">
            <td><? echo $livro['id_livro']?></td>
            <td title="<? echo utf8_encode($livro['titulo'])?>"><? echo utf8_encode($livro['titulo_short'])?></td>
            <td><? echo utf8_encode($livro['autor']) ?></td>
            <td><? echo utf8_encode($livro['editora']) ?></td>
            <td><? echo utf8_encode($livro['edicao']) ?></td>
            <td><? echo utf8_encode($livro['area']) ?></td>
            <td>
                <i class="fas fa-pencil-alt huge" id="editar"></i>
                <i class="ml-2 fas fa-trash-alt huge" id="excluir"></i>
            </td>
        </tr>
        <? } ?>
    </tbody>
</table>