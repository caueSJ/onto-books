<?
if (file_exists('DAO/livrosDAO.php')) {
    require_once 'DAO/livrosDAO.php';
} else if (file_exists('../DAO/livrosDAO.php')) {
    require_once '../DAO/livrosDAO.php';
} else if (file_exists('../../DAO/livrosDAO.php')) {
    require_once '../../DAO/livrosDAO.php';
}
$dao = new livrosDAO;
$autores = $dao->getAutores();
$controller ='autores_gerencia';
?>

<h1 class="titulo_gerencia">Autores</h1>

<div class="ui styled sixteen wide accordion novo_gerencia">
    <div class=" title">
        <button type="button" class="mb-3 btn btn-primary" id="botaoAdicionarLivro">
            Adicionar Autor
        </button>
    </div>
    <div class="content">
        <div class="ui form form-gerencia-<? echo $controller ?> form-save-gerencia">
            <div class="field ui">
                <input type="hidden"  class="id_item_gerencia">
                <label class="ui label ontobooks_color" data-indice = "1">Nome</label>
                <input class="<? echo $controller ?>-nome" type="text" placeholder="Nome" data-required="required" name="nome" value="">
            </div>
        </div>
        <button class="mt-3 ui red direita cancela_save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Cancelar</button>
        <button class="ui green direita save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Salvar</button>
    </div>
</div>

<table class="table table-hover table-responsive-sm bg-light" id="lista_gerencia">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Opções</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($autores as $autor) { ?>
        <tr class="livro_edicao_gerencia edit_item_gerencia"
            data-item='<? echo $autor['id']?>'
            data-controller="<?echo $controller?>">
            <td><? echo $autor['id']?></td>
            <td title="<? echo utf8_encode($autor['text'])?>"><? echo utf8_encode($autor['text'])?></td>
            <td>
                <button class="ui button mini orange" data-controller="autores_gerencia" id="editar" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="ui button mini mt-1 orange" data-controller="autores_gerencia" id="excluir" title="Excluir"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        <? } ?>
    </tbody>
</table>