<?
if (file_exists('DAO/livrosDAO.php')) {
    require_once 'DAO/livrosDAO.php';
} else if (file_exists('../DAO/livrosDAO.php')) {
    require_once '../DAO/livrosDAO.php';
} else if (file_exists('../../DAO/livrosDAO.php')) {
    require_once '../../DAO/livrosDAO.php';
}
$dao = new livrosDAO;
$areas = $dao->getAreas();
$controller ='areas_gerencia';
?>
<h1 class="titulo_gerencia">Áreas</h1>

<div class="ui styled sixteen fluid wide accordion novo_gerencia " >
    <div class=" title">
        <i class="dropdown icon"></i>
        <i class="add green icon"></i>Novo 
    </div>
    <div class=" content">
        <div class="ui mini form form-gerencia-<? echo $controller ?>">            
            <h4 class="ui dividing header titulo_edicao_gerencia"><i class="book  icon"></i>Editar Áreas</h4>
            <div class="ui stackable fields grid sixteen wide   form-save-gerencia"> 
                <input type="hidden"  class="id_item_gerencia">
                <div class="ui column eight wide">
                    <div class="ui stackable fields grid sixteen wide   ">    
                        <div class="ui field sixteen wide  mini ">                                        
                            <div class=" sixteen wide  ui input labeled indice-1" data-indice = "1" tabindex="4">
                                <div class='ui label ontobooks_color grande'>Descrição</div>
                                <input class="ui sixteen wide labeled <? echo $controller ?>-nome" placeholder="Descrição" data-required='required' name="descricao" type="text" value="">
                            </div>
                        </div>              
                    </div>
                </div>
            </div>            
        </div>  
        <button class="ui red direita cancela_save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Cancelar</button>
        <button class="ui green direita save_gerencia button" data-controller='<?echo $controller?>' form-name='form-save-gerencia'>Salvar</button>        
    </div>
</div>

<table id="lista_gerencia" class="ui padded table" >
    <thead>
        <tr><th>ID</th>
            <th>Nome</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($areas as $area) { ?>
            <tr class="livro_edicao_gerencia edit_item_gerencia" data-item='<? echo $area['id']?>' data-controller="<?echo $controller?>">
                <td class="collapsing"><? echo $area['id']?></td>
                <td><? echo utf8_encode($area['text'])?></td>
            </tr>
        <? } ?>
    </tbody>
</table>
