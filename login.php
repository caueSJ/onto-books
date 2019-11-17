<!DOCTYPE html>

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

	<!-- Fontes -->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Baixar essas fontes depois -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

	<!-- Plugin CSS -->
	<link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="assets/css/creative.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target="#mainNav">
	<div class="ui fullscreen basic modal base-modal-fullscreen  ">
	</div>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
		<div class="container">
			<a class="navbar-brand js-scroll-trigger" href="#page-top">
				<img class="if-logo" width="30px" style="margin-right: 10px;" height="35px" src="assets/img/if.png" alt="">Onto Books</a>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger home_login_link" href="index.php">Home</a>
						</li>              
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" href="#sobre">Sobre</a>
						</li>
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger active login_menu" href="#login">Entrar</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<?php
	$bg = array('book_1.jpg','book_2.jpg','book_3.jpg','book_4.jpg','book_5.jpg','book_6.jpg' ); // array of filenames
	$i = rand(0, count($bg)-1); // generate random number size of the array
	?>
	<header class="masthead" id="login" style="background-image: url('assets/img/fundo-header/<?echo $bg[$i]?>');" >
		<div class="header-content">
			<div class="header-content-inner">
				<h1 id="homeHeading">Login</h1>
				<img class="if-logo" width="440em" style="margin-right: 10px;" height="160em" src="assets/img/logo_if.png" alt="">
				<hr>
				<div class="ui left icon input">
					<input type="text" class="usuario_login" placeholder="Usuário">
					<i class="user icon"></i>
				</div>
				<div class="ui left icon input">
					<input type="password" class="senha_login" placeholder="Senha">
					<i class="lock icon"></i>
				</div>
				<hr>
				<div class="btn btn-primary btn-xl js-scroll-trigger confirma_login" style="margin-top: 10px;" >Confirmar</div>
			</div>
		</div>
	</header>


	<section class="p-0 hidden_content " style="margin-top: 10px; min-height: 100%;" id="resultados">
		<div class="resultados_container hidden_content" style="padding: 10px;"></div>
		<div class="loding_livros_container" style=" height: 1px;">
			<div class="bookshelf_wrapper " >
				<ul class="books_list">
					<li class="book_item first"></li>
					<li class="book_item second"></li>
					<li class="book_item third"></li>
					<li class="book_item fourth"></li>
					<li class="book_item fifth"></li>
					<li class="book_item sixth"></li>
				</ul>
				<div class="shelf"></div>
				<h2 id="homeHeading" style="text-align: center;margin-top: 20px; color:white;">Aguarde...</h2>;
			</div>
		</div>
		<div class="extra_busca">
			<div class="ic-search-wrapper extra_buscar_button hidden_content">
				<div class="icon-search-container" data-ic-class="search-trigger">
					<div action="#" method="post" class="">
						<span class="fa fa-search buscar_button" data-ic-class="search-icon"></span>

						<input type="text" class="search-input busca_livros" data-ic-class="search-input" placeholder="Search"/>
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
					<p>
						<a href="mailto:contato@ifsp.edu.br">contato@ifsp.edu.br</a>
					</p>
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
	<script src ="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src ="assets/plugins/pace.js"></script>
	<script src ="assets/plugins/jquery.cookie.js"></script>
	<script src ="assets/plugins/replaceSpecialChars.js"></script>
	<script src ="assets/plugins/jquery.validate.min.js"></script>
	<script src ="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src ="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
	<script src ="assets/plugins/Semantic/semantic.min.js"></script>
	<script src ="assets/plugins/SemanticAlerts/Semantic-UI-Alert.js" type="text/javascript"></script>
	<script src ="assets/plugins/jquery.tmpl.min.js"></script>
	<script src ="assets/js/sparql-methods.js"></script>

</body>

</html>
