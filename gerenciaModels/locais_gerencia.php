<?
if (file_exists('DAO/livrosDAO.php')) {
    require_once 'DAO/livrosDAO.php';
} else if (file_exists('../DAO/livrosDAO.php')) {
    require_once '../DAO/livrosDAO.php';
} else if (file_exists('../../DAO/livrosDAO.php')) {
    require_once '../../DAO/livrosDAO.php';
}
$dao = new livrosDAO;
$locais = $dao->getLocais();
$controller ='locais_gerencia';
?>
<h1 class="titulo_gerencia">Locais</h1>

<div class="ui styled sixteen fluid wide accordion novo_gerencia " >
    <div class=" title">
        <i class="dropdown icon"></i>
        <i class="add green icon"></i>Novo 
    </div>
    <div class=" content">
        <div class="ui mini form form-gerencia-<? echo $controller ?>">            
            <h4 class="ui dividing header titulo_edicao_gerencia"><i class="book  icon"></i>Editar Locais</h4>
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
                <div class="ui column eight wide centered" >
                    <div class="sixteen wide field  ui centered " style="text-align: center;"  data-indice = "1">
                        <i class="file image outline huge centered icon icon_image_preview" ></i>
                        <img class="img_preview" style="max-width: 250; max-height: 300px;">
                    </div>
                    <div class="sixteen wide field  ui centered " style="text-align: center; margin-top: 10px;"  data-indice = "1">
                        <div class="column one wide"  >
                            <label for="local_input"
                                   class="ui grande ontobooks_color label  label_anexo_default" > <i class="attach icon"></i> Anexar Imagem</label >                                                                                                            
                            <label style="background-color: red !important;" class="ui grande ontobooks_color label hidden_content  label_remove_anexo_default" >
                                <i class="remove circle icon"></i> Remover</label >                                                                                                            
                        </div>
                        <div class="column three wide " style="margin-left:2em; " >
                            <div  style="position: absolute !important;">                        
                                <input accept=".jpg" type="file" class="default_anexo <? echo $controller ?>_local_anexo"  style="display:none;"  id="local_input">                    
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
            <th>Descrição</th>            
        </tr>
    </thead>
    <tbody>
        <? foreach ($locais as $local) { ?>
            <tr class="local_edicao_gerencia edit_item_gerencia" data-item='<? echo $local['id']?>' <?if(file_exists('../img/locais/'.$local['id'].'.jpg')){?> imagem='ok' data-html="<div class='header ontobooks_titles' >Local:</div>
                    <img width='250px' height='300px' src='img/locais/<? echo $local['id']?>.jpg'>"
                     <?}?> data-controller="<?echo $controller?>">
                <td class="collapsing"><? echo $local['id']?></td>
                <td><? echo utf8_encode($local['text'])?></td>
            </tr>
        <? } ?>
    </tbody>
</table>
