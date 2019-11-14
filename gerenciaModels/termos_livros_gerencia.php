<?
if (file_exists('DAO/livrosDAO.php')) {
    require_once 'DAO/livrosDAO.php';
} else if (file_exists('../DAO/livrosDAO.php')) {
    require_once '../DAO/livrosDAO.php';
} else if (file_exists('../../DAO/livrosDAO.php')) {
    require_once '../../DAO/livrosDAO.php';
}
$dao = new livrosDAO;
$termosLivros = $dao->getTermosLivros();
$controller ='termos_livros_gerencia';
?>
<h1 class="titulo_gerencia">Livros & Termos</h1>
<div class="ui mini form form-gerencia-<? echo $controller ?>">        
    <div class="ui stackable fields grid centered sixteen wide  ">                    
        <div class="eight wide field  ui input labeled indice-1"  data-indice = "1">
            <div class='ui label ontobooks_color grande'>Livro</div>
            <div class="ui fluid search selection dropdown  labeled <? echo $controller ?>-livro indice-1" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                <input type="hidden" data-required="required" tabindex="1" name="id_autor"> 
                <i class="dropdown icon"></i>
                <div class="default text">Selecione o Livro</div>
                <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-livro-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                    <? foreach ($termosLivros as $livro){?>
                        <div class='item item-<?echo $controller.'-'.$livro['id_livro']?>' data-value='<?echo $livro['id_livro']?>'>									
                            <span class='text'><?echo utf8_encode($livro['titulo'])?></span>
                               </div>
                    <?}?>
                </div>
            </div>
            <button class="ui green direita hidden_content save_termos_livros  button" style="margin-left: 10px;" data-controller='<?echo $controller?>'>Salvar</button>        
        </div>
    </div>
    <div class="ui stackable fields grid  sixteen wide hidden_content <?echo $controller?>-relacionamentos ">  
        <div class="ui column five wide colour_border  " style="padding: 1.3rem ;" >
            <h4 class="titulo_gerencia" style="text-align: center;">Relacionamento Forte</h4>
            <div class="sixteen wide field  ui input labeled indice-1"  data-indice = "1">
                <div class='ui label ontobooks_color grande'>Termo</div>
                <div class="ui fluid search selection dropdown inserir_termo_dropdown labeled <? echo $controller ?>-termo-forte indice-1" tipo-termo="forte" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                    <input type="hidden" data-required="required" tabindex="1" name="id_autor"> 
                    <i class="dropdown icon"></i>
                    <div class="default text">Selecione o Termo</div>
                    <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-termo-forte-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                       
                    </div>
                </div>
            </div>
            <div class="ui column sixteen wide"  style="margin: 10px; text-align: center;">
                <button class="ui ontobooks_color  direita inserir_termo button" tipo-termo="forte" data-controller='<?echo $controller?>' ><i class="icon arrow down"></i>Inserir</button>        
            </div>
            <div class="ui column sixteen wide" style="margin-top: 25px;">
                <table id="lista_forte" class="ui  table" >
                    <thead>
                        <tr><th>Termo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="termos_forte_container">
                    </tbody>
                </table>
            </div>   
            
        </div>
        <div class="ui column five wide colour_border " style="padding: 1.3rem ;" >
            <h4 class="titulo_gerencia" style="text-align: center;">Relacionamento Médio</h4>
            <div class="sixteen wide field  ui input labeled indice-1"  data-indice = "1">
                <div class='ui label ontobooks_color grande'>Termo</div>
                <div class="ui fluid search selection dropdown inserir_termo_dropdown labeled <? echo $controller ?>-termo-medio indice-1" tipo-termo="medio" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                    <input type="hidden" data-required="required" tabindex="1" name="id_autor"> 
                    <i class="dropdown icon"></i>
                    <div class="default text">Selecione o Termo</div>
                    <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-termo-medio-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                       
                    </div>
                </div>
            </div>
            <div class="ui column sixteen wide"  style="margin: 10px; text-align: center;">
                <button class="ui ontobooks_color  direita inserir_termo button" tipo-termo="medio" data-controller='<?echo $controller?>' ><i class="icon arrow down"></i>Inserir</button>        
            </div>
            <div class="ui column sixteen wide" style="margin-top: 25px;">
                <table id="lista_medio" class="ui  table" >
                    <thead>
                        <tr><th>Termo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="termos_medio_container">
                    </tbody>
                </table>
            </div>   
        </div>
        <div class="ui column five wide colour_border " style="padding: 1.3rem ;" >
            <h4 class="titulo_gerencia" style="text-align: center;">Relacionamento Fraco</h4>
            <div class="sixteen wide field  ui input labeled indice-1"  data-indice = "1">
                <div class='ui label ontobooks_color grande'>Termo</div>
                <div class="ui fluid search selection dropdown inserir_termo_dropdown  labeled <? echo $controller ?>-termo-fraco indice-1" tipo-termo="fraco" tabindex="0" data-controller = "<? echo $controller ?>" data-indice="1">
                    <input type="hidden" data-required="required" tabindex="1" name="id_autor"> 
                    <i class="dropdown icon"></i>
                    <div class="default text">Selecione o Termo</div>
                    <div  style="width: 400px !important; padding-bottom: 5px;" class="menu form-termo-fraco-<? echo $controller ?> indice-1" data-controller = "<? echo $controller ?>">
                       
                    </div>
                </div>
            </div>
            <div class="ui column sixteen wide"  style="margin: 10px; text-align: center;">
                <button class="ui ontobooks_color  direita inserir_termo button" tipo-termo="fraco" data-controller='<?echo $controller?>' ><i class="icon arrow down"></i>Inserir</button>        
            </div>
            <div class="ui column sixteen wide" style="margin-top: 25px;">
                <table id="lista_fraco" class="ui  table" >
                    <thead>
                        <tr><th>Termo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="termos_fraco_container">
                    </tbody>
                </table>
            </div>   
        </div>
    </div>  
</div>

