$('.ui.dropdown.tipo_busca').dropdown();
var tableInitiated = false;

$(document).on("keydown", ".busca_livros", function(event){
    if (event.keyCode == 13) {
        var busca = $(".busca_livros").val();
        $('.icon-search-container').removeClass('active');
        if(busca){
            $(".search_field").val(busca);
            $('.buscar_button')[0].click();
            $('.search-input').blur();
            $('.search_field').blur();
        }else{
            semanticAlert('Digite sua busca!', '',3, 'warning');
        }
    }
});

$(document).on("change", ".default_anexo", function(event){
    readURL(this);
});
$(document).on("click", ".logout_menu", function(event){
    defaultAJAX('login','logout');
});
$(document).on("click", ".importar", function(event){
    defaultAJAX('termos_livros_gerencia','importar');
});
$(document).on("click", ".label_remove_anexo_default", function(event){
	$('.label_anexo_default').removeClass('hidden_content');
    $('.label_remove_anexo_default').addClass('hidden_content');
    $('.default_anexo').val('');
    $('.img_preview').attr('src','');
    $('.icon_image_preview').removeClass('hidden_content');
});
$(document).on("click", ".confirma_login", function(event){
	var login = $('.usuario_login').val();
	var senha = $('.senha_login').val();
	if((login)&&(senha)){
		defaultAJAX('login','login', {login:login,senha:senha});
	}else{
		semanticAlert('Preencha os campos corretamente!', '',3, 'warning');
	}

});
$(document).on("click", ".save_gerencia", function(event){
	var controller = $(this).attr('data-controller');
	var formName = $(this).attr('form-name');
	formSaveDefault(controller,formName);
});
$(document).on("click", ".visualizar_senha", function(event){
	var controller = $(this).attr('data-controller');
	if($(this).hasClass('lock')){
		$(this).removeClass('lock');
		$(this).addClass('unlock');
		$('.'+controller+'-senha').attr('type','text');
	}else{
		$(this).addClass('lock');
		$(this).removeClass('unlock');
		$('.'+controller+'-senha').attr('type','password');
	}
});

$(document).on("keydown", ".search_field", function(event){
    if (event.keyCode == 13) {
        var busca = $(".search_field").val();
        if(busca){
            $('."buscar_button"')[0].click();
            $('.search-input').blur();
            $('.search_field').blur();
        }else{
            semanticAlert('Digite sua busca!', '',3, 'warning');
        }
    }
});

$(document).on("keydown", ".inserir_termo_dropdown", function(event){
	var controller = $(this).attr('data-controller');
	if (event.keyCode == 13) {
		var tipoTermo = $(this).attr('tipo-termo');
		var termo = $('.'+controller+'-termo-'+tipoTermo).dropdown('get value');
		if(termo){
			inserirTermoLivro(tipoTermo, termo);
		}else{
			semanticAlert('Selecione um termo para inserção.', '',3, 'danger');
		}
	}
});
$(document).on("click", ".inserir_termo", function(event){
	var controller = $(this).attr('data-controller');
	var tipoTermo = $(this).attr('tipo-termo');
	var termo = $('.'+controller+'-termo-'+tipoTermo).dropdown('get value');
	if(termo){
		inserirTermoLivro(tipoTermo, termo);
	}else{
		semanticAlert('Selecione um termo para inserção.', '',3, 'danger');
	}

});


$(document).on("keydown", "body", function(event){
	if ((event.keyCode == 81)&&(!$('input').is(':focus'))) {
		event.preventDefault();
		$('.icon-search-container').addClass('active');
		$('.search-input').focus();
	}
});
$(document).on("click", ".buscar_button", function(event){
	$('.search-input').val($('.search_field').val());
	console.log('teste: '+$('.search_field').val());
});

$(document).on("click", ".desativa_usuario", function(event){
	var id = $(this).attr('data-item');
	console.log('>>>>>>>>>>>>>>>> IDEE '+id);
	defaultAJAX('usuarios_gerencia','toggle_usuario',{id:id});
});

$(document).on("click", ".cancela_save_gerencia", function(event){
	$('.edicao_gerencia_container').html('');
	$('.loding_edicao_container').removeClass('hidden_content');
	var controller = $(this).attr('data-controller');
	$("#edicao").removeClass('hidden_content');
	setTimeout(function(){
    	appendDefault('gerenciaModels/'+controller, 'edicao_gerencia_container');
    }, 1000);
});

// Double Click na Lista para Editar
$(document).on("dblclick", ".edit_item_gerencia", function(event){
	var controller = $(this).attr('data-controller');
	editItemGerencia($(this),controller);
});

// $(document).on("click", ".editar", function(event){
// 	console.log("Opa");
// 	var controller = $(this).attr('data-controller');
// 	editItemGerencia($(this),controller);
// });


$(document).on("click", ".remove_termo_livro", function(event){
	var controller = $(this).attr('data-controller');
	var item = $(this).attr('data-value');
	$('.item_termo_input#'+item).attr('name','');
	$('.item_termo_input#'+item).parent().addClass('removed_termo');
	$('.label_termo_'+item).html("<strike>"+$('.label_termo_'+item).html()+"</strike>");
	$(this).toggleClass('red blue remove_termo_livro desfazer_remove_termo');
	$(this).find('.content.small').html('Desfazer');
	$(this).find('i').toggleClass('trash undo');
	$(this).blur();
	$('.save_termos_livros').removeClass('hidden_content');
});

$(document).on("click", ".desfazer_remove_termo", function(event){
	var item = $(this).attr('data-value');
	$('.item_termo_input#'+item).attr('name','termo');
	$('.item_termo_input#'+item).parent().removeClass('removed_termo');
	$('.label_termo_'+item).html(item);
	$(this).toggleClass('red blue remove_termo_livro desfazer_remove_termo');
	$(this).find('.content.small').html('Remover');
	$(this).find('i').toggleClass('trash undo');
	$(this).blur();
});

$(document).on("click", ".save_termos_livros", function(event){
	saveTermosLivros();
});


function buscaLivros(busca,tipo) {
    $.ajax({
        url: 'controller/ontologiaController.php',
        type: 'POST',
        dataType: 'JSON',
        data: {busca:busca,tipo:tipo}
    })
    .done(function(data) {
        if(data){
            console.log(JSON.stringify(data)+'<<<<<<<<<<<<<>>>>>>' +tipo);
            setTimeout(function(){
                appendDefault('livro_modal','resultados_container',{livros:data.join()});
            }, 3000);
        }else{
            $('.bookshelf_wrapper').addClass('hidden_content');
            $('.sad_book').removeClass('hidden_content');
        }
        console.log('Complete busca <<<<>>>>>>' +data);
    })
    .fail(function(data) {
            console.log(JSON.stringify(data));
            semanticAlert('Não foi possível concluir sua busca, verifique sua conexão com a internet.', '',4, 'danger');
    })
    .always(function() {
            console.log("Busca completa:"+busca);
    });
}


function semanticAlert(textHead, text='',time = 1, type='info',position = 'top-center', permanent=false){

	switch(type){
		case 'info':
			$.uiAlert({
				textHead: textHead, // header
				text: text, // Text
				bgcolor: '#55a9ee', // background-color
				textcolor: '#fff', // color
				position: position,// position . top And bottom ||  left / center / right
				icon: 'info circle', // icon in semantic-UI
				time: time, // time
				permanent: permanent
		    });
		    break;
		case 'success':
			$.uiAlert({
				textHead: textHead, // header
				text: text, // Text
				bgcolor: '#19c3aa', // background-color
				textcolor: '#fff', // color
				position: position,// position . top And bottom ||  left / center / right
				icon: 'checkmark box', // icon in semantic-UI
				time: time, // time
				permanent: permanent
		    });
		    break;
		case 'warning':
			$.uiAlert({
				textHead: textHead, // header
				text: text, // Text
				bgcolor: '#F2711C', // background-color
				textcolor: '#fff', // color
				position: position,// position . top And bottom ||  left / center / right
				icon: 'warning sign', // icon in semantic-UI
				time: time, // time
				permanent: permanent
		    });
		    break;
		case 'danger':
			$.uiAlert({
				textHead: textHead, // header
				text: text, // Text
				bgcolor: '#DB2828', // background-color
				textcolor: '#fff', // color
				position: position,// position . top And bottom ||  left / center / right
				icon: 'remove circle', // icon in semantic-UI
				time: time, // time
				permanent: permanent
		    });
		    break;
	}
}

function appendDefault(formName, container, variaveis={}){

	var fd = new FormData();
    for(var key in variaveis){
        if(variaveis.hasOwnProperty(key)){
            fd.append(key, variaveis[key]);
        }
    }

	$.ajax({
		url: formName+'.php',
		type: 'POST',
		dataType: 'html',
		data:fd,
		cache: false,
		processData: false,
		contentType: false
	})
	.done(function(data) {
		$("."+container).append(data);
		appendDefaultCallBack(formName, container, variaveis);
	})
	.fail(function() {
		console.log("error"+ formName);
	})
	.always(function() {
		console.log("complete "+formName);
	});
}

function appendDefaultCallBack(formName, container, variaveis){
	switch(formName){
		case 'livro_modal':
			$(".resultados_container").removeClass('hidden_content');
			$('.bookshelf_wrapper').addClass('hidden_content');
			$('.search-input').val($('.search_field').val());

			$('.livro_modal_card').transition({
				animation:'fade up',
				duration: '500ms'});
			break;
		case 'gerenciaModels/livros_gerencia':
			initiateDataTable($('#lista_gerencia'),1);
			$('.ui.accordion').accordion({'onChange':function(){
				$('.novo_gerencia').toggleClass('bordas');
				}
			});
			$('.livro_edicao_gerencia').popup({
			    on: 'hover',
			    lastResort: 'bottom left',
			    hoverable:true,
		        onShow: function(){
		            resizePopup();
		        },
			  });
			$(".edicao_gerencia_container").removeClass('hidden_content');
			$('.loding_edicao_container').addClass('hidden_content');
			getListaSemantic('livros_gerencia', 1, 'get_autores', 'form-autor');
			getListaSemantic('livros_gerencia', 1, 'get_editoras', 'form-editora');
			getListaSemantic('livros_gerencia', 1, 'get_areas', 'form-area');
			getListaSemantic('livros_gerencia', 1, 'get_locais', 'form-local');
			break;
		case 'gerenciaModels/locais_gerencia':
			initiateDataTable($('#lista_gerencia'));
			$('.ui.accordion').accordion({'onChange':function(){
				$('.novo_gerencia').toggleClass('bordas');
				}
			});
			$('.local_edicao_gerencia').popup({
			    on: 'hover',
			    lastResort: 'bottom left',
			    hoverable:true,
		        onShow: function(){
		            resizePopup();
		        },
			  });
			$(".edicao_gerencia_container").removeClass('hidden_content');
			$('.loding_edicao_container').addClass('hidden_content');
			break;
		case 'gerenciaModels/termos_livros_gerencia':
			$('.ui.dropdown.termos_livros_gerencia-livro').dropdown({forceSelection:false});
			tableInitiated = false;
			$('.ui.dropdown.termos_livros_gerencia-livro').dropdown({onChange: function (livro) {
				if(livro){
					$('.save_termos_livros').addClass('hidden_content');
					getListaSemantic('termos_livros_gerencia', 1, 'get_termos', 'form-termo-forte',0,{rel:'forte'});
					getListaSemantic('termos_livros_gerencia', 1, 'get_termos', 'form-termo-medio',0,{rel:'medio'});
					getListaSemantic('termos_livros_gerencia', 1, 'get_termos', 'form-termo-fraco',0,{rel:'fraco'});
					$('.termos_livros_gerencia-relacionamentos').removeClass('hidden_content');
					defaultAJAX('termos_livros_gerencia','get_termos_livros', {id:livro});
				}else{
					$('.termos_livros_gerencia-relacionamentos').addClass('hidden_content');
				}
			},forceSelection:false});
			$(".edicao_gerencia_container").removeClass('hidden_content');
			$('.loding_edicao_container').addClass('hidden_content');
			break;
		default:
			initiateDataTable($('#lista_gerencia'),1);
			$('.ui.accordion').accordion({'onChange':function(){
				$('.novo_gerencia').toggleClass('bordas');
				}
			});
			$(".edicao_gerencia_container").removeClass('hidden_content');
			$('.loding_edicao_container').addClass('hidden_content');
			break;
	}
}

var resizePopup = function(){$('.ui.popup').css('max-height', $(window).height());};
$(window).resize(function(e){
    resizePopup();
});

function showDefaultModal(messageController,variaveis={},parametrosMsg={}, modalName='default-modal',closable =false,size='small',type='basic'){
	//$('.base-modal').removeClass('large');

	switch(type){
		case 'basic':
			$('.base-modal').addClass(size);
			$('.base-modal').load('view/modals/'+modalName+'.php',parametrosMsg,function() {
				readyModalCallback(messageController,variaveis);
			});
			$('.ui.basic.modal.base-modal')
		      .modal({
		      	backdrop: 'static',
		        closable  : closable,
		        onDeny    : function(){
		        	modalResponseCallback(messageController, false, variaveis);
		    		},
		    	onApprove : function() {
		    		modalResponseCallback(messageController, true, variaveis);
				    }
		      	})
		      	.modal('show');
			break;
		case 'fullscreen':
			$('.base-modal-fullscreen').addClass(size);
			$('.base-modal-fullscreen').load('modals/'+modalName+'.php',parametrosMsg,function() {
				readyModalCallback(messageController,variaveis);
			});
			$('.ui.modal.base-modal-fullscreen')
		      .modal({
		      	backdrop: 'static',
		        closable  : 'closable',
		        onDeny    : function(){
		        	modalResponseCallback(messageController, false, variaveis);
		    		},
		    	onApprove : function() {
		    		modalResponseCallback(messageController, true, variaveis);
				    }
		      	})
		      	.modal('show');
			break;
		case 'standard':
			$('.base-modal-standard').addClass(size);
			$('.base-modal-standard').load('view/modals/'+modalName+'.php',parametrosMsg,function() {
				//readyModalCallback(messageController,variaveis);
			});
			$('.ui.modal.base-modal-standard')
		      .modal({
		      	backdrop: 'static',
		        closable  : closable,
		        onDeny    : function(){
		        	modalResponseCallback(messageController, false, variaveis);
		    		},
		    	onApprove : function() {
		    		modalResponseCallback(messageController, true, variaveis);
				    }
		      	})
		      	.modal('show');
			break;

	}
}

function modalResponseCallback(messageController, response, variaveis){
	}

function defaultAJAX(controller,action, variaveis={}, dataType ='JSON',fd = new FormData()){
    fd.append('action', action);
    for(var key in variaveis){
        if(variaveis.hasOwnProperty(key)){
            fd.append(key, variaveis[key]);
        }
    }
	$.ajax({
		url: 'controller/'+controller+'Controller.php',
		type: 'POST',
		dataType: dataType,
		data: fd,
		cache: false,
        processData: false,
        contentType: false
	})
	.done(function(data) {
		console.log(data);
		defaultAJAXCallback(controller,action,data,variaveis);
	})
	.fail(function(data) {
		console.log("fail DEFAULT AJAX:"+controller+' Action:'+action+ ' DATA: '+JSON.stringify(data));
		defaultAJAXCallback(controller,action,false,variaveis);

	})
	.always(function() {
		console.log("complete DEFAULT AJAX: "+ controller);
	});
}

function defaultAJAXCallback(controller, action, data, variaveis){
	switch(controller){
		case 'login':
			switch(action){
				case 'login':
					if(data){
						window.location.href = "index.php";
					}else{
						semanticAlert('Erro ao efetuar login, confira seu usuário e senha!', '',3, 'danger');
					}

				break;
				case 'logout':
					//semanticAlert('Logout efetuado!', '',3, 'info');
					location.reload();
				break;
			}
			break;
		case 'livros_gerencia':
			switch(action){
				case 'save':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/livros_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Livro registrado com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível salvar!', '',3, 'danger');
					}
					break;
				case 'get_livro':
					if(data){
						var livro = data[0];
						var tituloHtml = "<i class='book  icon'></i>Editar Livro - "+livro.id_livro+"</h4>"
						$('.titulo_edicao_gerencia').html(tituloHtml);
					    getListaSemantic('livros_gerencia', 1, 'get_autores', 'form-autor',0,{id:livro.id_autor});
						getListaSemantic('livros_gerencia', 1, 'get_editoras', 'form-editora',0,{id:livro.id_editora});
						getListaSemantic('livros_gerencia', 1, 'get_areas', 'form-area',0,{id:livro.id_area});
						// getListaSemantic('livros_gerencia', 1, 'get_locais', 'form-local',0,{id:livro.id_local});
						$('.'+controller+'-titulo').val(livro.titulo);
						$('.'+controller+'-paginas').val(livro.paginas);
						$('.'+controller+'-edicao').val(livro.edicao);
						if(variaveis.imagem){
							$('.img_preview').attr('src', "img/livros/"+livro.id_livro+".jpg");
				            $('.icon_image_preview').addClass('hidden_content');
				            $('.label_anexo_default').addClass('hidden_content');
				            $('.label_remove_anexo_default').removeClass('hidden_content');
						}
						$('.id_item_gerencia').attr('name','id_livro');
						$('.id_item_gerencia').val(livro.id_livro);
						$('.ui.accordion').accordion('open',0);
						doScrolling("#edicao",1000);
					}else{
						semanticAlert('Erro ao editar livro!', '',3, 'danger');
					}
					break;
			}
			break;
		case 'autores_gerencia':
			switch(action){
				case 'save':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/autores_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Autor registrado com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível salvar!', '',3, 'danger');
					}
					break;
				case 'get_autores':
					if(data){
						var autor = data[0];
						var tituloHtml = "<i class='book  icon'></i>Editar Autor - "+autor.id+"</h4>"
						$('.titulo_edicao_gerencia').html(tituloHtml);
						$('.'+controller+'-nome').val(autor.text);
						$('.id_item_gerencia').attr('name','id_autor');
						$('.id_item_gerencia').val(autor.id);
						$('.ui.accordion').accordion('open',0);
						doScrolling("#edicao",1000);
					}else{
						semanticAlert('Erro ao editar autor!', '',3, 'danger');
					}
					break;
			}
			break;
		case 'editoras_gerencia':
			switch(action){
				case 'save':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/editoras_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Editora registrada com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível salvar!', '',3, 'danger');
					}
					break;
				case 'get_editoras':
					if(data){
						var editora = data[0];
						var tituloHtml = "<i class='book  icon'></i>Editar Editora - "+editora.id+"</h4>"
						$('.titulo_edicao_gerencia').html(tituloHtml);
						$('.'+controller+'-nome').val(editora.text);
						$('.id_item_gerencia').attr('name','id_editora');
						$('.id_item_gerencia').val(editora.id);
						$('.ui.accordion').accordion('open',0);
						doScrolling("#edicao",1000);
					}else{
						semanticAlert('Erro ao editar editora!', '',3, 'danger');
					}
					break;
			}
			break;
		case 'areas_gerencia':
			switch(action){
				case 'save':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/areas_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Área registrada com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível salvar!', '',3, 'danger');
					}
					break;
				case 'get_areas':
					if(data){
						var area = data[0];
						var tituloHtml = "<i class='book  icon'></i>Editar Área - "+area.id+"</h4>"
						$('.titulo_edicao_gerencia').html(tituloHtml);
						$('.'+controller+'-nome').val(area.text);
						$('.id_item_gerencia').attr('name','id_area');
						$('.id_item_gerencia').val(area.id);
						$('.ui.accordion').accordion('open',0);
						doScrolling("#edicao",1000);
					}else{
						semanticAlert('Erro ao editar área!', '',3, 'danger');
					}
					break;
			}
			break;
		case 'termos_gerencia':
			switch(action){
				case 'save':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/termos_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Termo registrada com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível salvar!', '',3, 'danger');
					}
					break;
				case 'get_termos':
					if(data){
						var termo = data[0];
						var tituloHtml = "<i class='book  icon'></i>Editar Termo - "+termo.id+"</h4>"
						$('.titulo_edicao_gerencia').html(tituloHtml);
						$('.'+controller+'-nome').val(termo.text);
						$('.id_item_gerencia').attr('name','id_termo');
						$('.id_item_gerencia').val(termo.id);
						$('.ui.accordion').accordion('open',0);
						doScrolling("#edicao",1000);
					}else{
						semanticAlert('Erro ao editar termo!', '',3, 'danger');
					}
					break;
			}
			break;
		case 'locais_gerencia':
			switch(action){
				case 'save':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/locais_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Local registrado com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível salvar!', '',3, 'danger');
					}
					break;
				case 'get_locais':
					if(data){
						var local = data[0];
						var tituloHtml = "<i class='book  icon'></i>Editar Local - "+local.id+"</h4>"
						$('.titulo_edicao_gerencia').html(tituloHtml);
						$('.'+controller+'-nome').val(local.text);
						if(variaveis.imagem){
							$('.img_preview').attr('src', "img/locais/"+local.id+".jpg");
				            $('.icon_image_preview').addClass('hidden_content');
				            $('.label_anexo_default').addClass('hidden_content');
				            $('.label_remove_anexo_default').removeClass('hidden_content');
						}
						$('.id_item_gerencia').attr('name','id_local');
						$('.id_item_gerencia').val(local.id);
						$('.ui.accordion').accordion('open',0);
						doScrolling("#edicao",1000);
					}else{
						semanticAlert('Erro ao editar local!', '',3, 'danger');
					}
					break;
			}
			break;
		case 'usuarios_gerencia':
			switch(action){
				case 'toggle_usuario':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/usuarios_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Usuário alterado com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível editar!', '',3, 'danger');
					}
					break;
				case 'save':
					if(data){
						$('.edicao_gerencia_container').html('');
						$('.loding_edicao_container').removeClass('hidden_content');
						$("#edicao").removeClass('hidden_content');
						setTimeout(function(){
				        	appendDefault('gerenciaModels/usuarios_gerencia', 'edicao_gerencia_container');
				        }, 1000);
					    semanticAlert('Usuário registrado com sucesso!', '',3, 'success');
					}else{
						semanticAlert('Não foi possível salvar!', '',3, 'danger');
					}
					break;
				case 'get_usuarios':
					if(data){
						var usuario = data[0];
						var tituloHtml = "<i class='book  icon'></i>Editar Usuário - "+usuario.id_usuario+"</h4>"
						$('.titulo_edicao_gerencia').html(tituloHtml);
						$('.'+controller+'-nome').val(usuario.nome);
						$('.'+controller+'-usuario').val(usuario.login);
						$('.id_item_gerencia').attr('name','id_usuario');
						$('.id_item_gerencia').val(usuario.id_usuario);
						$('.ui.accordion').accordion('open',0);
						doScrolling("#edicao",1000);
					}else{
						semanticAlert('Erro ao editar usuário!', '',3, 'danger');
					}
					break;
			}
			break;
		case 'termos_livros_gerencia':
			switch(action){
				case 'save':
					console.log('IMPORTAAAAR >>>>   '+JSON.stringify(data));
					break;
				case 'save':
					console.log('fiiiiim >>>>   '+JSON.stringify(data));
					if(data== true){
						semanticAlert("Termos relacionados com sucesso!", '',3, 'success');
						$('.edicao_gerencia_container').html('');
						appendDefault('gerenciaModels/'+controller, 'edicao_gerencia_container');
					}else{
						semanticAlert("Erro ao relacionar termos!", '',3, 'danger');
					}
					break;
				case 'get_termos_livros':
					if(data){
						$('.termos_forte_container').html('');
                        $('.termos_medio_container').html('');
                        $('.termos_fraco_container').html('');
						$.each(data, function(index, termo) {
							var html = "<tr class='item_termo_"+termo.relacionamento+"'> <input type='hidden' class='item_termo_input' name='termo' value='"+termo.termo+"' id='"+termo.termo+"' > "
							html += "<td class='label_termo_"+termo.termo+"'>"+termo.termo+"</td><td  style='text-align:right;'>"+
									"<div class='ui vertical animated red remove_termo_livro button mini ' tabindex='0' data-controller='"+controller+"' data-value='"+termo.termo+"'>"+
                                       "<div class='hidden content small'>Remover</div>"+
                                        "<div class='visible content'>"+
                                            "<i class='trash icon'></i>"+
                                        " </div>"+
                                    "</div> </td></tr>" ;

							switch(termo.relacionamento){
								case 'forte':
									$('.termos_forte_container').append(html);
									break;
								case 'medio':
									$('.termos_medio_container').append(html);
									break;
								case 'fraco':
									$('.termos_fraco_container').append(html);
									break;
							}
						});
						if(!tableInitiated){
							initiateDataTable($('#lista_forte'),0,  'asc',  100);
							initiateDataTable($('#lista_medio'),0,  'asc',  100);
							initiateDataTable($('#lista_fraco'),0,  'asc',  100);
							tableInitiated = true;
						}

					}else{
						semanticAlert("Não foi possível carregar os termos para este livro!", '',3, 'danger');
					}
					break;

			}
			break;
	}
}

function getElementY(query) {
  return window.pageYOffset + document.querySelector(query).getBoundingClientRect().top
}

function doScrolling(element, duration) {
	var startingY = window.pageYOffset
  var elementY = getElementY(element)
  // If element is close to page's bottom then window will scroll only to some position above the element.
  var targetY = document.body.scrollHeight - elementY < window.innerHeight ? document.body.scrollHeight - window.innerHeight : elementY
	var diff = targetY - startingY
  // Easing function: easeInOutCubic
  // From: https://gist.github.com/gre/1650294
  var easing = function (t) { return t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1 }
  var start

  if (!diff) return

	// Bootstrap our animation - it will get called right before next frame shall be rendered.
	window.requestAnimationFrame(function step(timestamp) {
    if (!start) start = timestamp
    // Elapsed miliseconds since start of scrolling.
    var time = timestamp - start
		// Get percent of completion in range [0, 1].
    var percent = Math.min(time / duration, 1)
    // Apply the easing.
    // It can cause bad-looking slow frames in browser performance tool, so be careful.
    percent = easing(percent)

    window.scrollTo(0, startingY + diff * percent)

		// Proceed with animation as long as we wanted it to.
    if (time < duration) {
      window.requestAnimationFrame(step)
    }
  })
}


function initiateDataTable(element, coluna =0, cardinal = 'asc', length = 10){
	element.DataTable({
				responsive: true,
				aaSorting: [[coluna, cardinal]],
				columnDefs: [{ targets: 6, orderable: false }],
				pageLength: length,
				"language":{
				    "sEmptyTable": "Nenhum registro encontrado",
				    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
				    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
				    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
				    "sInfoPostFix": "",
				    "sInfoThousands": ".",
				    "sLengthMenu": "_MENU_ Resultados por página",
				    "sLoadingRecords": "Carregando...",
				    "sProcessing": "Processando...",
				    "sZeroRecords": "Nenhum registro encontrado",
				    "sSearch": "Pesquisar",
				    "oPaginate": {
				        "sNext": "Próximo",
				        "sPrevious": "Anterior",
				        "sFirst": "Primeiro",
				        "sLast": "Último"
				    },
				    "oAria": {
				        "sSortAscending": ": Ordenar colunas de forma ascendente",
				        "sSortDescending": ": Ordenar colunas de forma descendente"
				    },
				}
			});
}

function getListaSemantic(controller, indice, action, form, id=0,variaveis={}){ //Generico para qualquer lista
	//console.log("TIIIPO>"+id);
	var fd = new FormData();

    for(var key in variaveis){
        if(variaveis.hasOwnProperty(key)){
            fd.append(key, variaveis[key]);
        }
    }
    fd.append('action', action);
    fd.append('id', id);
	$.ajax({
		url: 'controller/'+controller+'Controller.php',
		type: 'POST',
		dataType: 'json',
		data: fd,
        cache: false,
        processData: false,
        contentType: false // ID auxiliar para busca generica
	})
	.done(function(data) {
			var options = $("."+form+"-"+controller+".indice-"+indice);
			options.html('');
			$.each(data, function() {
				if(this.id=='header'){
					options.append("<div class='header "+this.headerClass+"'>"+
                                    "	<i class='"+this.headerIcon+"'></i>"+
                                    	this.headerText+
                                    "</div>" );
				}else{
					var html = " <div class='item item-"+controller+"-"+this.id+"' data-value='"+this.id+"'>"+
                                     "<span class='text "+this.class+"'>"+this.text+"</span>";
					if(this.span){
						html += "<span class='description'>"+this.span.toUpperCase()+"</span>";
					}
					html += "</div>";
					options.append(html);
				}
				//console.log(' itens para:'+form);
				if (this.disabled) {
					if (this.disabled == 1) {
						$(".item-"+controller+"-"+this.id).addClass('disabled');
					}
				}

			});

			getListaSemanticCallBack(controller, indice, action, form,variaveis,data);

	})
	.fail(function(data) {
		console.log(this.id);
		console.log(this.text);
		console.log(JSON.stringify(data));
		console.log("error "+form);
		variaveis.form = form;
		variaveis.id = id;

	})
	.always(function() {
		console.log("complete "+form);
	});
}

function getListaSemanticCallBack(controller, indice, action, formName,variaveis, data){
	switch(controller){
		case 'livros_gerencia':
			switch(action){
				case 'get_autores':
					$('.ui.dropdown.'+controller+'-autor').dropdown({fullTextSearch:true,message:{noResults: 'Autor não encontrado, cadastre na opção acima.'}});
					if(variaveis.id){
						$('.ui.dropdown.'+controller+'-autor').dropdown('set selected',variaveis.id);
					}
					break;
				case 'get_editoras':
					$('.ui.dropdown.'+controller+'-editora').dropdown({fullTextSearch:true,message:{noResults: 'Editora não encontrada, cadastre na opção acima.'}});
					if(variaveis.id){
						$('.ui.dropdown.'+controller+'-editora').dropdown('set selected',variaveis.id);
					}
					break;
				case 'get_areas':
					$('.ui.dropdown.'+controller+'-area').dropdown({fullTextSearch:true,message:{noResults: 'Área não encontrada, cadastre na opção acima.'}});
					if(variaveis.id){
						$('.ui.dropdown.'+controller+'-area').dropdown('set selected',variaveis.id);
					}
					break;
				case 'get_locais':
					$('.ui.dropdown.'+controller+'-local').dropdown({fullTextSearch:true});
					if(variaveis.id){
						$('.ui.dropdown.'+controller+'-local').dropdown('set selected',variaveis.id);
					}
					break;
			}
			break;
		case 'termos_livros_gerencia':
			switch(action){
				case 'get_termos':
					switch(variaveis.rel){
						case 'forte':
							$('.ui.dropdown.'+controller+'-termo-forte').dropdown({fullTextSearch:true});
							break;
						case 'medio':
							$('.ui.dropdown.'+controller+'-termo-medio').dropdown({fullTextSearch:true});
							break;
						case 'fraco':
							$('.ui.dropdown.'+controller+'-termo-fraco').dropdown({fullTextSearch:true});
							break;
					}

					break;
			}
			break;
	}
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.img_preview').attr('src', e.target.result);
            $('.icon_image_preview').addClass('hidden_content');
            $('.label_anexo_default').addClass('hidden_content');
            $('.label_remove_anexo_default').removeClass('hidden_content');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function formSaveDefault(controller,formName){
	if(formValidateDefault(controller, formName)){
		var form = $('.'+formName).find("select, input, textarea").serialize();
		var anexo = $('.default_anexo');
		var fd = new FormData();
		fd.append('form',form);
		$('.default_anexo').each(function(index, el) {
			if(($(this).val())&&(el.files.length>0)){
				fd.append("anexo_gerencia", anexo[0].files[0]);
			}
		});
		console.log("FORM  :"+form+'     . ');
		defaultAJAX(controller,'save', {}, 'JSON',fd);
	}
}

function  formValidateDefault(controller, formName){
	var erro = false;
	$("."+formName+" :input").each(function(){//pra cada input do formulário
	    var valida = $(this).attr('data-required');  // alterado form-pessoa-geral, nao vai funcionar cliente
	    if (valida == "required"){
	        if (($(this).val() == "")){
	            $(this).addClass('error-input');
	            $(this).parent().addClass('error-input');
	            erro = true;
	        }else{
	            $(this).removeClass('error-input');
	            $(this).parent().removeClass('error-input');
	        }
	    }
	});
	if(erro){
		 semanticAlert('Verifique os campos em vermelho!', '',3, 'danger');
		return false;
	}else{
		return true;
	}
}

function editItemGerencia(el,controller){
	switch(controller){
		case 'livros_gerencia':
			var id = el.attr('data-item');
			var imagem = false;
			if(el.attr('imagem')){imagem = true;}
			defaultAJAX('livros_gerencia','get_livro',{id:id, imagem:imagem});
			break;
		case 'autores_gerencia':
			var id = el.attr('data-item');
			defaultAJAX('autores_gerencia','get_autores',{id:id});
			break;
		case 'editoras_gerencia':
			var id = el.attr('data-item');
			defaultAJAX('editoras_gerencia','get_editoras',{id:id});
			break;
		case 'areas_gerencia':
			var id = el.attr('data-item');
			defaultAJAX('areas_gerencia','get_areas',{id:id});
			break;
		case 'termos_gerencia':
			var id = el.attr('data-item');
			defaultAJAX('termos_gerencia','get_termos',{id:id});
			break;
		case 'locais_gerencia':
			var id = el.attr('data-item');
			var imagem = false;
			if(el.attr('imagem')){imagem = true;}
			defaultAJAX('locais_gerencia','get_locais',{id:id, imagem:imagem});
			break;
		case 'usuarios_gerencia':
			var id = el.attr('data-item');
			defaultAJAX('usuarios_gerencia','get_usuarios',{id:id});
			break;

	}
}
function buscarEdicaoGerencia(controller){
	$('.loding_edicao_container').removeClass('hidden_content');
	$("#edicao").removeClass('hidden_content');
	setTimeout(function(){
    	appendDefault('gerenciaModels/'+controller, 'edicao_gerencia_container');
    }, 1000);
}

function inserirTermoLivro(tipoTermo, termo){
	var inserir = true;
	$('.item_termo_forte').each(function(){
		if($(this).find('input').attr('id') == termo){
			if($(this).find('input').attr('name') == 'termo'){
				semanticAlert('Termo ja possui um "Relacionamento Forte" com o livro!', '',4, 'warning');
				inserir = false;
			}else if(termo == 'forte'){
				inserir = false;
				$('.item_termo_input#'+termo).attr('name','termo');
				$('.item_termo_input#'+termo).parent().removeClass('removed_termo');
				$('.label_termo_'+termo).html(termo);
				$(this).find('.desfazer_remove_termo').find('.content.small').html('Remover');
				$(this).find('.desfazer_remove_termo').find('i').toggleClass('trash undo');
				$(this).find('.desfazer_remove_termo').blur();
				$(this).find('.desfazer_remove_termo').toggleClass('red blue remove_termo_livro desfazer_remove_termo');
			}else{
				semanticAlert('Termo ja possui um "Relacionamento Forte" com o livro!', '',4, 'warning');
				inserir = false;
			}
		}
	});
	$('.item_termo_medio').each(function(){
		if($(this).find('input').attr('id') == termo){
			if($(this).find('input').attr('name') == 'termo'){
				semanticAlert('Termo ja possui um "Relacionamento Médio" com o livro!', '',4, 'warning');
				inserir = false;
			}else if(termo == 'medio'){
				inserir = false;
				$('.item_termo_input#'+termo).attr('name','termo');
				$('.item_termo_input#'+termo).parent().removeClass('removed_termo');
				$('.label_termo_'+termo).html(termo);
				$(this).find('.desfazer_remove_termo').find('.content.small').html('Remover');
				$(this).find('.desfazer_remove_termo').find('i').toggleClass('trash undo');
				$(this).find('.desfazer_remove_termo').blur();
				$(this).find('.desfazer_remove_termo').toggleClass('red blue remove_termo_livro desfazer_remove_termo');
			}else{
				semanticAlert('Termo ja possui um "Relacionamento Médio" com o livro!', '',4, 'warning');
				inserir = false;
			}
		}
	});
	$('.item_termo_fraco').each(function(){
		if($(this).find('input').attr('id') == termo){
			if($(this).find('input').attr('name') == 'termo'){
				semanticAlert('Termo ja possui um "Relacionamento Fraco" com o livro!', '',4, 'warning');
				inserir = false;
			}else if(termo == 'medio'){
				inserir = false;
				$('.item_termo_input#'+termo).attr('name','termo');
				$('.item_termo_input#'+termo).parent().removeClass('removed_termo');
				$('.label_termo_'+termo).html(termo);
				$(this).find('.desfazer_remove_termo').find('.content.small').html('Remover');
				$(this).find('.desfazer_remove_termo').find('i').toggleClass('trash undo');
				$(this).find('.desfazer_remove_termo').blur();
				$(this).find('.desfazer_remove_termo').toggleClass('red blue remove_termo_livro desfazer_remove_termo');
			}else{
				semanticAlert('Termo ja possui um "Relacionamento Fraco" com o livro!', '',4, 'warning');
				inserir = false;
			}
		}
	});
	if(inserir){
		$('.save_termos_livros').removeClass('hidden_content');
		var html = "<tr class='item_termo_"+tipoTermo+"'> <input type='hidden' class='item_termo_input' name='termo' value='"+termo+"' id='"+termo+"' > "
		html += "<td class='label_termo_"+termo+"'>"+termo+"</td><td  style='text-align:right;'>"+
				"<div class='ui vertical animated red remove_termo_livro button mini ' tabindex='0' data-controller='termos_livros_gerencia' data-value='"+termo+"'>"+
	               "<div class='hidden content small'>Remover</div>"+
	                "<div class='visible content'>"+
	                    "<i class='trash icon'></i>"+
	                " </div>"+
	            "</div> </td></tr>"
		switch(tipoTermo){
			case 'forte':
				$('.termos_forte_container').append(html);
				$('.termos_forte_container').find('.dataTables_empty').parent().remove();
				break;
			case 'medio':
				$('.termos_medio_container').append(html);
				$('.termos_medio_container').find('.dataTables_empty').parent().remove();
				break;
			case 'fraco':
				$('.termos_fraco_container').append(html);
				$('.termos_fraco_container').find('.dataTables_empty').parent().remove();
				break;
		}
	}
	$('.ui.dropdown.termos_livros_gerencia-termo-'+tipoTermo).dropdown('clear');
	$('.ui.dropdown.termos_livros_gerencia-termo-'+tipoTermo).find('.search').focus();
}

function saveTermosLivros(){
	var idLivro = $('.ui.dropdown.termos_livros_gerencia-livro').dropdown('get value');
	var termos = [];
	cont = 0;
	$('.item_termo_forte').each(function(){
		if($(this).find('input').attr('name') == 'termo'){
			var termo = {relacionamento:'forte',termo:$(this).find('input').val()};
			termos[cont]=  termo;
			cont++;
		}
	});
	$('.item_termo_medio').each(function(){
		if($(this).find('input').attr('name') == 'termo'){
			var termo = {relacionamento:'medio',termo:$(this).find('input').val()};
			termos[cont]=  termo;
			cont++;
		}
	});
	$('.item_termo_fraco').each(function(){
		if($(this).find('input').attr('name') == 'termo'){
			var termo = {relacionamento:'fraco',termo:$(this).find('input').val()};
			termos[cont]=  termo;
			cont++;
		}
	});
	defaultAJAX('termos_livros_gerencia','save', {termos:JSON.stringify(termos),livro:idLivro});
}

