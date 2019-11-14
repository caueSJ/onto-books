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
<h1 class="titulo_gerencia">Livros</h1>

<div class="ui styled sixteen fluid wide accordion novo_gerencia " >
    <div class=" title">
        <i class="dropdown icon"></i>
        <i class="add green icon"></i>Novo 
    </div>
    <div class=" content">
        <div class="ui mini form form-gerencia-<? echo $controller ?>">            
            <h4 class="ui dividing header titulo_edicao_gerencia"><i class="book  icon"></i>Editar Livro</h4>
            <div class="ui stackable fields grid sixteen wide   form-save-gerencia"> 
                <input type="hidden"  class="id_item_gerencia">
                <div class="ui column eight wide">
                    <div class="ui stackable fields grid sixteen wide   ">    
                        <div class="ui field sixteen wide  mini ">                                        
                            <div class=" sixteen wide  ui input labeled indice-1" data-indice = "1" tabindex="4">
                                <div class='ui label ontobooks_color grande'>Título</div>
                                <input class="ui sixteen wide labeled <? echo $controller ?>-titulo" placeholder="Título" data-required='required' name="titulo" type="text" value="">
                            </div>
                        </div>              
                    </div>
                    <div class="ui stackable fields grid sixteen wide   ">                    
                        <div class="ui field eight wide  mini ">                                        
                            <div class=" sixteen wide  ui input labeled indice-1" data-indice = "1" tabindex="4">
                                <div class='ui label ontobooks_color grande'>Nº de Páginas</div>
                                <input class="ui sixteen wide labeled <? echo $controller ?>-paginas" data-required='required' placeholder="Nº de Páginas"  name="paginas" type="number" value="">
                            </div>
                        </div>
                        <div class="ui field eight wide  mini ">                                        
                            <div class=" sixteen wide  ui input labeled " tabindex="4">
                                <div class='ui label ontobooks_color grande'>Edição</div>
                                <input class="ui sixteen wide labeled <? echo $controller ?>-edicao" data-required='required' placeholder="Edição"  name="edicao" type="number" value="">
                            </div>
                        </div>
                    </div>
                    <div class="ui stackable fields grid sixteen wide  ">                    
                        <div class="eight wide field  ui input labeled indice-1"  data-indice = "1">
                            <div class='ui label ontobooks_color grande'>Autor</div>
                            <div class="ui fluid search selection dropdown  labeled <? echo $controller ?>-autor indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                                <input type="hidden" data-required="required" tabindex="1" name="id_autor"> 
                                <i class="dropdown icon"></i>
                                <div class="default text">Selecione o Autor</div>
                                <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-autor-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                                </div>
                            </div>
                        </div>
                        <div class="eight wide field  ui input labeled indice-1"  data-indice = "1">
                            <div class='ui label ontobooks_color grande'>Editora</div>
                            <div class="ui fluid search selection dropdown  labeled <? echo $controller ?>-editora indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                                <input type="hidden" data-required="required" tabindex="1" name="id_editora"> 
                                <i class="dropdown icon"></i>
                                <div class="default text">Selecione a Editora</div>
                                <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-editora-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="ui stackable fields grid sixteen wide  ">                    
                        <div class="eight wide field  ui input labeled indice-1"  data-indice = "1">
                            <div class='ui label ontobooks_color grande'>Área</div>
                            <div class="ui fluid search selection dropdown  labeled <? echo $controller ?>-area indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                                <input type="hidden" data-required="required" tabindex="1" name="id_area"> 
                                <i class="dropdown icon"></i>
                                <div class="default text">Selecione a Área</div>
                                <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-area-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                                </div>
                            </div>
                        </div>
                        <div class="eight wide field  ui input labeled indice-1"  data-indice = "1">
                            <div class='ui label ontobooks_color grande'>Local</div>
                            <div class="ui fluid search selection dropdown  labeled <? echo $controller ?>-local indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                                <input type="hidden" data-required="required" tabindex="1" name="id_local"> 
                                <i class="dropdown icon"></i>
                                <div class="default text">Selecione o Local</div>
                                <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-local-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                                </div>
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
                            <label for="capa_livro_input"
                                   class="ui grande ontobooks_color label  label_anexo_default" > <i class="attach icon"></i> Anexar Capa</label >                                                                                                            
                            <label style="background-color: red !important;" class="ui grande ontobooks_color label hidden_content  label_remove_anexo_default" >
                                <i class="remove circle icon"></i> Remover</label >                                                                                                            
                        </div>
                        <div class="column three wide " style="margin-left:2em; " >
                            <div  style="position: absolute !important;">                        
                                <input accept=".jpg" type="file" class="default_anexo <? echo $controller ?>_capa_anexo"  style="display:none;"  id="capa_livro_input">                    
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
            <th>Título</th>
            <th>Autor</th>
            <th>Editora</th>
            <th>Edição</th>
            <th>Área</th>
            <th>Páginas</th>
            <th>Local</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($livros as $livro) { ?>
            <tr class="livro_edicao_gerencia edit_item_gerencia" data-item='<? echo $livro['id_livro']?>' <?if(file_exists('../img/livros/'.$livro['id_livro'].'.jpg')){?> imagem='ok' data-html="<div class='header ontobooks_titles' >CAPA:</div>
                    <img width='250px' height='300px' src='img/livros/<? echo $livro['id_livro']?>.jpg'>"
                     <?}?> data-controller="<?echo $controller?>">
                <td class="collapsing"><? echo $livro['id_livro']?></td>
                <td title="<? echo utf8_encode($livro['titulo'])?>"><? echo utf8_encode($livro['titulo_short'])?></td>
                <td><? echo utf8_encode($livro['autor']) ?></td>
                <td><? echo utf8_encode($livro['editora']) ?></td>
                <td class="collapsing"><? echo utf8_encode($livro['edicao']) ?></td>
                <td><? echo utf8_encode($livro['area']) ?></td>
                <td class="collapsing"><? echo utf8_encode($livro['paginas']) ?></td>
                <td><? echo utf8_encode($livro['local']) ?></td>
            </tr>
        <? } ?>


    </tbody>
</table>
