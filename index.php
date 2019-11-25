<!DOCTYPE html>
<? session_start();?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema bibliotecário baseado em ontologia">
    <meta name="author" content="Pedro Mazarini & Cauê Jesus">
    <title>Onto Books</title>

    <link href="assets/plugins/SemanticAlerts/Semantic-UI-Alert.css" rel="stylesheet">
    <link href="assets/plugins/Semantic/semantic.min.css" rel="stylesheet">
    <meta charset="utf-8">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/if_book.png">

    <!-- Fontes -->
    <link href="vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/creative.css" rel="stylesheet">
</head>

<body id="page-top" data-spy="scroll" data-target="#mainNav">
    <div class="ui fullscreen basic modal base-modal-fullscreen  "></div>

    

    <!-- Modal para adicionar área quando exporta um livro -->
    <div class="modal" id="modalCadastrarAreaUpload" tabindex="-1" role="dialog" aria-labelledby="modalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalArea">Cadastrar Área de Livro Recém Importado</h5>
                </div>
                <div class="modal-body">
                    <div class="ui styled sixteen fluid wide">
                        <div class="ui form form-gerencia-livros form-save-area">
                            <div class="field">
                                <div style="font-family: Lato;" class="ui search selection dropdown livros_gerencia-area indice-1" tabindex="0" data-controller = "livros_gerencia" data-indice="1">
                                    <input hidden="hidden" name="id_livro" value="" id="id_livro">
                                    <input type="hidden" data-required="required" tabindex="1" name="id_area">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Selecione a Área</div>
                                    <div  class="menu form-area-livros_gerencia indice-1" data-controller = "livros_gerencia">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="ui green direita save_gerencia_modal button" data-controller='livros_gerencia' form-name='form-save-area'>Cadastrar</button>
                </div>
            </div>
        </div>
    </div>

    <button data-backdrop="static" data-keyboard="false"  data-toggle="modal" id="abrirFecharModal" data-target="#modalCadastrarAreaUpload" hidden="hidden"></button>    

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img class="if-logo" width="30px" style="margin-right: 10px;" height="35px" src="assets/img/if.png" alt="Onto Books Logo">
                Onto Books
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Exibir/Esconder Menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#home">Home</a>
                    </li>
                    <li class="nav-item hidden_content resultados_menu">
                        <a class="nav-link js-scroll-trigger resultados_menu_link" id="resultados_link" href="#resultados">Resultados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#sobre">Sobre</a>
                    </li>
                    <?if(isset($_SESSION['logged_in'])){?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger " href="gerencia.php">Gerenciar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger logout_menu " href="#">Sair (<?echo  explode(" ", $_SESSION['user_name'])[0];?>)</a>
                        </li>
                    <?} else {?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="login.php">Entrar</a>
                        </li>
                    <?}?>
                </ul>
            </div>
        </div>
    </nav>
    <?php
        $bg = array('book_1.jpg','book_2.jpg','book_3.jpg','book_4.jpg','book_5.jpg','book_6.jpg' ); // Array das imagens do background
        $i = rand(0, count($bg)-1); // gera um número aleatório para pegar algum item do array
    ?>
    <header class="masthead" id="home" style="background-image: url('assets/img/fundo-header/<?echo $bg[$i]?>');" >
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading">Buscador Semântico</h1>
                <img class="if-logo" width="440em" style="margin-right: 10px;" height="160em" src="assets/img/logo_if.png" alt="Onto Book Logo">
                <hr>                
                <div class="ui labeled input" style="width: 100%;">
                    <div class="ui dropdown tipo_busca label ontobooks_color">
                        <div class="text">Assunto</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item active selected" data-value="1">Assunto</div>
                            <div class="item" data-value="2">Título</div>
                            <div class="item" data-value="3">Autor</div>
                            <div class="item" data-value="4">Editora</div>
                            <div class="item" data-value="5">Área</div>
                        </div>
                    </div>
                    <input type="text" class="search_field" placeholder="Digite sua busca">
                </div>
                <a class="btn btn-primary btn-xl js-scroll-trigger buscar_button" style="margin-top: 10px;" href="#resultados">Buscar</a>
                <div class="btn btn-primary" style="margin-top: 10px;">
                    <div class="custom-file">
                        <span>Importar Arquivo Marc21</span>
                        <input type="file" class="uploadArquivo" id="uploadArquivo" accept=".txt">
                    </div>
                </div>
                
                <!-- <a class="btn btn-primary btn-xl importar" style="margin-top: 10px;" >Importar arquivo MARC21</a> -->
            </div>
        </div>
    </header>

    <section class="hidden_content " style="margin-top: 10px; min-height: 100%;" id="resultados">
        <div class="resultados_container hidden_content" style="padding: 10px;"></div>
        <div class="loding_livros_container" style=" height: 1px;">
            <div class="bookshelf_wrapper">
                <ul class="books_list">
                    <li class="book_item first"></li>
                    <li class="book_item second"></li>
                    <li class="book_item third"></li>
                    <li class="book_item fourth"></li>
                    <li class="book_item fifth"></li>
                    <li class="book_item sixth"></li>
                </ul>
                <div class="shelf"></div>
                <h2 id="homeHeading" style="text-align: center;margin-top: 20px; color:white;">Aguarde...</h2>
            </div>
            <div class="sad_book hidden_content" style="text-align: center;">
                <div class="emoji  emoji--sad">
                    <div class="emoji__face">
                        <div class="emoji__eyebrows"></div>
                        <div class="emoji__eyes"></div>
                        <div class="emoji__mouth"></div>
                    </div>
                </div>
                <h2 id="homeHeading" style="margin-top: 20px; color:white;">Nenhum livro encontrado!</h2>
            </div>
        </div>
        <div class="extra_busca">
            <div class="ic-search-wrapper extra_buscar_button hidden_content">
                <div class="icon-search-container" data-ic-class="search-trigger">
                    <div action="#" method="post" class="">
                        <span class="fa fa-search buscar_button" data-ic-class="search-icon"></span>
                        <input type="text" class="search-input busca_livros" data-ic-class="search-input" placeholder="Buscar"/>
                        <span class="fa fa-times-circle" data-ic-class="search-clear"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="sobre">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-heading">Quer saber mais?</h2>
                    <hr class="primary">
                    <p>Esta é um projeto em desenvolvimento por um grupo de estudo do Instituto Federal de São Paulo (IFSP) campus São João da Boa Vista, na área de linguística computacional.</p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4 ml-auto text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>(19) 3634-1100</p>
                </div>
                <div class="col-lg-4 mr-auto text-center">
                    <i class="fas fa-envelope fa-3x sr-contact"></i>
                    <p><a href="mailto:biblioteca_sbv@ifsp.edu.br">biblioteca_sbv@ifsp.edu.br</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="assets/js/creative.js"></script>

    <script src ="assets/plugins/jquery3.1.1.js"></script>
    <script src ="assets/plugins/tether/dist/js/tether.min.js"></script>
    <script src ="assets/plugins/pace.js"></script>
    <script src ="assets/plugins/jquery.cookie.js"></script>
    <script src ="assets/plugins/replaceSpecialChars.js"></script>
    <script src ="assets/plugins/jquery.validate.min.js"></script>
    <script src ="assets/plugins/DataTables-1.10.12/media/js/jquery.dataTables.min.js"></script>
    <script src ="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src ="assets/plugins/Semantic/semantic.min.js"></script>
    <script src ="assets/plugins/SemanticAlerts/Semantic-UI-Alert.js" type="text/javascript"></script>
    <script src ="assets/plugins/jquery.tmpl.min.js"></script>
    <script src ="assets/js/sparql-methods.js"></script>

</body>
</html>