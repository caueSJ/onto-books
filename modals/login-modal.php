
<?
$titulo = 'Alerta';
$mensagem = 'Deseja Cancelar mesmo? Podem haver conteúdos não salvos, ao continuar essas informações serão perdidas';
$icone = 'warning circle red';

if(isset($_POST['titulo'])) $titulo = $_POST['titulo'];

?>

<div class="header">
    <?echo $titulo?>
</div>
<div class="ui form" style="text-align: center;">
        
    <div class="ui left icon input">
  <input type="text" placeholder="Usuário">
      <i class="user icon"></i>
  </div>
  <div class="ui left icon input">
      <input type="password" placeholder="Senha">
      <i class="lock icon"></i>
  </div>
        
    
</div>
<div class="actions"  style="text-align: center;">
    <div class="">
        <div class="ui cancel nao_button_modal red  inverted button">
            <i class="remove icon"></i>
            Cancelar
        </div>
        <div class="ui ok green sim_button_modal inverted button">
            <i class="checkmark icon"></i>
            Confirmar
        </div>
    </div>
</div>