<!DOCTYPE html>
<? session_start(); ?>
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

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/if_book.png">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Baixar essas fontes -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="css/creative.min.css" rel="stylesheet">-->
    <link href="assets/css/creative.css" rel="stylesheet">
</head>

<body id="page-top" data-spy="scroll" data-target="#mainNav">
    <div class="ui fullscreen basic modal base-modal-fullscreen  "></div>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img class="if-logo" width="30px" style="margin-right: 10px;" height="35px" src="assets/img/if.png" alt="">
                Onto Books
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="index.php">Home</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#sobre">Sobre</a>
                    </li>
                    <? if (isset($_SESSION['logged_in'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger active " href="#gerencia">Gerenciar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger logout_menu " href="#">Sair</a>
                        </li>
                        <h1 class=" divider"></h1>
                        <li class="nav-item">                    
                            <a class="nav-link js-scroll-trigger" href="#">Olá, <div style="color:#F05F40;display: inline;"><?echo  explode(" ", $_SESSION['user_name'])[0];?></div></a>
                        </li>
                    <? } else {
                        die("<script>location.href = 'index.php'</script>");
                    } ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php
        $bg = array('book_1.jpg', 'book_2.jpg', 'book_3.jpg', 'book_4.jpg', 'book_5.jpg', 'book_6.jpg');
        $i = rand(0, count($bg) - 1);
    ?>
    <header class="masthead" id="gerencia" style="background-image: url('assets/img/fundo-header/<? echo $bg[$i] ?>');" >
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading">Gerenciar Buscador</h1>

                <div class="ui  stackable relaxed grid" style="margin-top: 10px;">
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="livros_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="huge icon book" aria-hidden="true"></i>
                                <div class="header huge" >Livros</div>
                            </div>
                        </a>
                    </div>
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="autores_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="write huge icon ui"></i>
                                <div class="header huge" >Autores</div>
                            </div> 
                        </a>
                    </div>
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="editoras_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="building huge icon ui"></i>
                                <div class="header huge" >Editoras</div>
                            </div> 
                        </a>
                    </div>
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="areas_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="bookmark huge icon ui"></i>
                                <div class="header huge" >Áreas</div>
                            </div> 
                        </a>
                    </div>
                </div>      
                <div class="ui stackable relaxed grid" style="margin-top: 10px;">
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="termos_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="sort alphabet huge ascending icon"></i>
                                <div class="header huge" >Termos</div>
                            </div> 
                        </a>
                    </div>
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="termos_livros_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="huge icon exchange" aria-hidden="true"></i>
                                <div class="header huge" >Livros & Termos</div>
                            </div>
                        </a>
                    </div>
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="locais_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="pin map huge icon ui"></i>
                                <div class="header huge huge" >Locais</div>
                            </div> 
                        </a>
                    </div>
                    <div class="column four wide">
                        <a class="nav-link js-scroll-trigger edicao_gerencia" data-controller="usuarios_gerencia" href="#edicao" style="color: white;">
                            <div class="gerencia_menu_container">
                                <i class="user huge icon ui"></i>
                                <div class="header huge" >Usuários</div>
                            </div> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="p-0  hidden_content" style="margin-top: 10px; min-height: 100%;" id="edicao">
        <div class="edicao_gerencia_container hidden_content" style="padding: 10px; margin: 15px;"></div>
        <div class="loding_edicao_container" style=" height: 1px;">
            <i class="notched circle loading huge icon"></i>
            <div  style="text-align: center;margin-top: 20px;display: inline;font-size: 30px; color:white;">Carregando...</div>
        </div>
    </section>

    <section id="sobre">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-heading">Quer saber mais?</h2>
                    <hr class="primary">
                    <p>Esta é um projeto em desenvolvimento por um grupo de pesquisa no Instituto Federal de São Paulo campus São João da Boa Vista, na área de linguística computacional.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 ml-auto text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>(19) 3634-1100</p>
                </div>
                <div class="col-lg-4 mr-auto text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:contato@ifsp.edu.br">contato@ifsp.edu.br</a></p>
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
    <script src ="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src ="assets/plugins/pace.js"></script>
    <script src ="assets/plugins/jquery.cookie.js"></script>
    <script src ="assets/plugins/replaceSpecialChars.js"></script>
    <script src ="assets/plugins/jquery.validate.min.js"></script>
    <script src ="assets/plugins/DataTables-1.10.12/media/js/jquery.dataTables.min.js"></script>
    <script src ="assets/plugins/DataTables-1.10.12/media/js/dataTables.semanticui.min.js"></script>
    <script src ="assets/plugins/Semantic/semantic.min.js"></script>

    <script src ="assets/plugins/SemanticAlerts/Semantic-UI-Alert.js" type="text/javascript"></script>
    <script src ="assets/plugins/jquery.tmpl.min.js"></script>
    <script src ="assets/js/sparql-methods.js"></script>

</body>
</html>
