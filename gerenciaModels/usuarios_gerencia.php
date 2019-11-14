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

<div class="ui styled sixteen fluid wide accordion novo_gerencia " >
    <div class=" title">
        <i class="dropdown icon"></i>
        <i class="add green icon"></i>Novo 
    </div>
    <div class=" content">
        <div class="ui mini form form-gerencia-<? echo $controller ?>">            
            <h4 class="ui dividing header titulo_edicao_gerencia"><i class="book  icon"></i>Editar Usuário</h4>
            <div class="ui stackable fields grid sixteen wide   form-save-gerencia"> 
                <input type="hidden"  class="id_item_gerencia">
                <div class="ui column eight wide">
                    <div class="ui stackable fields grid sixteen wide   ">    
                        <div class="ui field sixteen wide  mini ">                                        
                            <div class=" sixteen wide  ui input labeled indice-1" data-indice = "1" tabindex="4">
                                <div class='ui label ontobooks_color grande'>Nome</div>
                                <input class="ui sixteen wide labeled <? echo $controller ?>-nome" placeholder="Nome" data-required='required' name="nome" type="text" value="">
                            </div>
                        </div>              
                    </div>
                    <div class="ui stackable fields grid sixteen wide   ">                    
                        <div class="ui field eight wide  mini ">                                        
                            <div class=" sixteen wide  ui input labeled indice-1" data-indice = "1" tabindex="4">
                                <div class='ui label ontobooks_color grande'>Usuário</div>
                                <input class="ui sixteen wide labeled <? echo $controller ?>-usuario" data-required='required' placeholder="Usuário"  name="login" type="text" value="">
                            </div>
                        </div>
                        <div class="ui field eight wide  mini ">                                        
                            <div class=" sixteen wide icon  ui input labeled " tabindex="4">
                                <div class='ui label ontobooks_color grande'>Senha</div>
                                <input class="ui sixteen wide labeled <? echo $controller ?>-senha" data-required='required' placeholder="Senha"  name="senha" type="password" value="">
                                <i class="lock icon link visualizar_senha" title="Visualizar senha" data-controller="<?echo $controller?>" ></i>
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
            <th>Usuário</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($usuarios as $usuario) { ?>
            <tr class="livro_edicao_gerencia edit_item_gerencia" data-item='<? echo $usuario['id_usuario']?>'  data-controller="<?echo $controller?>">
                <td class="collapsing"><? echo $usuario['id_usuario']?></td>
                <td><? echo utf8_encode($usuario['nome'])?></td>
                <td><? echo utf8_encode($usuario['login']) ?></td>
                <? if($usuario['ativo']){?>
                    <td style="color:green">Ativo</td>
                    <td  style='text-align:center;'>
                        <div class='ui vertical animated red desativa_usuario button  ' tabindex='0' data-controller='usuarios_gerencia' data-item="<?echo $usuario['id_usuario']?>">
                            <div class='hidden content '>Desativar</div>
                            <div class='visible content'>
                                <i class='ban icon'></i>
                            </div>
                        </div> 
                    </td>   
                <?}else{?>
                    <td style="color:red">Inativo</td>
                    <td  style='text-align:center;'>
                        <div class='ui vertical animated green desativa_usuario button  ' tabindex='0' data-controller='usuarios_gerencia' data-item="<?echo $usuario['id_usuario']?>">
                            <div class='hidden content '>Reativar</div>
                            <div class='visible content'>
                                <i class='undo icon'></i>
                            </div>
                        </div> 
                    </td>   
                <?} ?>
                 
                
               
            </tr>
        <? } ?>


    </tbody>
</table>
