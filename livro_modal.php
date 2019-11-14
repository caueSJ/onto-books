<?
if(file_exists('DAO/livrosDAO.php')) {
    require_once 'DAO/livrosDAO.php';
} else if(file_exists('../DAO/livrosDAO.php')) {
    require_once '../DAO/livrosDAO.php';
} else if(file_exists('../../DAO/livrosDAO.php')) {
    require_once '../../DAO/livrosDAO.php';
}
$ids = $_POST['livros'];

$dao = new livrosDAO;
$livros = $dao->getLivros($ids);
?>
<div class="ui link tiny cards" style="margin-left: 10px;">
    <?foreach ($livros as $livro){?>
        <div class="card livro_modal_card ui hidden transition">
            <div class="image ">
                <?if(file_exists('assets/img/livros/'.$livro['id_livro'].'.jpg')){?>
                    <img src="assets/img/livros/<?echo $livro['id_livro']?>.jpg" style="height: 18em !important;">
                <?}else{?>
                    <img src="assets/img/livros/default.jpg" style="height: 18em !important;">
                <?}?>
            </div>
            <div class="content">
                <div class="header"><?echo utf8_encode($livro['titulo'])?></div>
                <div class="meta">
                    <a>Por: <?echo utf8_encode($livro['autor'])?></a>
                </div>
                <div class="description locais_livros"
                     <?if(file_exists('assets/img/locais/'.$livro['id_local'].'.jpg')){?>data-html="<div class='header'>Encontre aqui:</div>
                    <img width='700px' height='400px' src='assets/img/locais/<? echo $livro['id_local']?>.jpg'>"
                     <?}?>>
                    Editora: <?echo utf8_encode($livro['editora'])?><br>
                    Assunto: <?echo utf8_encode($livro['area'])?><br>
                    <i class="map pin icon " ></i>Local: <?echo utf8_encode($livro['local'])?>
                </div>
                <div class="ui very relaxed grid" style="font-size: 10px; color: grey;">
                    <div class="ui eight wide column">
                        <?echo $livro['edicao']?> Edição.
                    </div>
                    <div class="ui eight wide column">
                        <i class="book icon"></i>
                        <?echo $livro['paginas']?> Páginas.
                    </div>
                </div>
            </div>
            <div class="extra content">


            </div>
        </div>
    <?}?>
</div>
