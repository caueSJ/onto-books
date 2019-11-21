<?
if (file_exists('DAO/livrosDAO.php')) {
    require_once 'DAO/livrosDAO.php';
} else if (file_exists('../DAO/livrosDAO.php')) {
    require_once '../DAO/livrosDAO.php';
} else if (file_exists('../../DAO/livrosDAO.php')) {
    require_once '../../DAO/livrosDAO.php';
}
$dao = new livrosDAO;
$usuarios = $dao->getUsuarios();
$controller ='usuarios_gerencia';
?>

<h1 class="titulo_gerencia">Usuários</h1>

<div class="ui styled sixteen fluid wide accordion novo_gerencia">
    <div class=" title">
        <button type="button" class="mb-3 btn btn-primary" id="botaoAdicionarLivro">
            Adicionar Usuário
        </button>
    </div>
    <div class="content">
        <div class="ui equal width form form-gerencia-<? echo $controller ?> form-save-gerencia">
            <div class="fields">
                <div class="field">
                    <input type="hidden" class="id_item_gerencia">
                    <label class="ui label ontobooks_color" data-indice = "1">Nome</label>
                    <input class="<? echo $controller ?>-nome" placeholder="Nome" data-required='required' name="nome" type="text" value="">
                </div>
                <div class="field">
                    <label class="ui label ontobooks_color" data-indice = "1">Usuário</label>
                    <input class="<? echo $controller ?>-usuario" data-required='required' placeholder="Usuário"  name="login" type="text" value="">
                </div>
                <div class="field">
                    <label class="ui label ontobooks_color" data-indice = "1">Senha</label>
                    <div class="ui action input">
                        <input class="<? echo $controller ?>-senha" data-required='required' placeholder="Senha"  name="senha" type="password" value="">
                        <button class="ui icon button visualizar_senha" data-controller="<?echo $controller?>">
                            <i class="lock icon" title="Visualizar Senha"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <button class="ui red direita cancela_save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Cancelar</button>
        <button class="ui green direita save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Salvar</button>
    </div>
</div>

<table class="table table-hover table-responsive-sm bg-light" id="lista_gerencia">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Usuário</th>
            <th scope="col">Status</th>
            <th scope="col">Opções</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($usuarios as $usuario) { ?>
            <tr class="livro_edicao_gerencia edit_item_gerencia"
                data-item='<? echo $usuario['id_usuario']?>'
                data-controller="<?echo $controller?>">
                <td><? echo $usuario['id_usuario']?></td>
                <td><? echo utf8_encode($usuario['nome'])?></td>
                <td><? echo utf8_encode($usuario['login']) ?></td>
                <? if($usuario['ativo']){?>
                    <td style="color:green">Ativo</td>
                    <td>
                    <button class="ui button mini orange" data-controller="autores_gerencia" id="editar" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <div title="Desativar usuário" class='ui vertical animated red desativa_usuario button mini' tabindex='0' data-controller='usuarios_gerencia' data-item="<?echo $usuario['id_usuario']?>">
                            <div class='hidden content'>Desativar</div>
                            <div class='visible content'>
                                <i class='ban icon'></i>
                            </div>
                        </div>
                    </td>
                <?}else{?>
                    <td style="color:red">Inativo</td>
                    <td>
                    <button class="ui button mini orange" data-controller="autores_gerencia" id="editar" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <div title="Reativar usuário" class='ui vertical animated green desativa_usuario button mini' tabindex='0' data-controller='usuarios_gerencia' data-item="<?echo $usuario['id_usuario']?>">
                            <div class='hidden content'>Reativar</div>
                            <div class='visible content'>
                                <i class='undo icon'></i>
                            </div>
                        </div>
                    </td>
                <?}?>
        </tr>
        <? } ?>
    </tbody>
</table>
