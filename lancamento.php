<?php
define('__ROOT__', dirname(__FILE__));

require_once __ROOT__.'/private/dao/ParcelaLancamentoDAO.class.php';
require_once __ROOT__.'/private/dao/CategoriaDAO.class.php';
require_once __ROOT__.'/private/dao/ContaDAO.class.php';
require_once __ROOT__.'/private/utils/util.php';


date_default_timezone_set('America/Sao_Paulo');

$mesAtual = date('m');
$anoAtual = date('Y');


$categoriaDAO = new CategoriaDAO();
$categorias = $categoriaDAO->getList();

$contaDAO = new ContaDAO();
$contas = $contaDAO->getList();

$cedenteSacadoDAO = new CedenteSacadoDAO();
$cedentesSacados = $cedenteSacadoDAO->getList();


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Finance Manager</title>

<link href="css/global.css" rel="stylesheet" type="text/css" />
<link type="text/css"
	href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.alphanumeric.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="js/fileuploader.js"></script>
<script type="text/javascript" src="js/utils.js"></script>

<script type="text/javascript">
        
$(document).ready(function (){

	SAVE = 0;
	UPDATE = 1;
	REMOVE = 2;
	

	showMonths(<?=$mesAtual?>, <?=$anoAtual?>, '.fm-div-months');


	$.get('lancamentoList.php', {month: <?=$mesAtual?>, year: <?=$anoAtual?>}, function(data){
		  $(".fm-div-list").html(data);
	});   
	
    $( "#new-transacao" )
	    .button()
	    .click(function() {
		$( "#dialog-form" ).dialog( "open" );
	});

    $( "#import" ).button();

    $("#valor").maskMoney({ decimal:",", thousands:"."});
    
  

    $( "#save-transacao" ).button().click(function() {
    	$.post('lancamentoUI.php', allFields(), function(message){
            $(".fm-div-message").html(message);
            $.get('lancamentoList.php', {month: <?=$mesAtual?>, year: <?=$anoAtual?>}, function(data){
                $(".fm-div-list").html(data);
            });  
        });      	
    });   




    $( "#dataVencimento" ).datepicker({dateFormat: 'dd/mm/yy',});
    
    $( "#dataPgto" ).datepicker({dateFormat: 'dd/mm/yy',});
    $( "#dialog" ).dialog( "destroy" );
	
	var tipoLancamento = $( "#tipoLancamento" ),
    	dataVencimento = $( "#dataVencimento" ),
    	dataPgto = $( "#dataPgto" ),
    	descricao = $( "#descricao" ),
    	historico = $( "#historico" ),
    	categoria = $( "#categoria" ),
    	cedenteSacado = $( "#cedenteSacado" ),
    	conta = $( "#conta" ),
    	valor = $( "#valor" ),
    	parcelas = $( "#parcelas" ),
    	formaPgtoAVista = $('#formaPgtoAVista'),
		formaPgtoParcelado = $('#formaPgtoParcelado');
	    repeticaoIndefinida = $('#repeticaoIndefinida');
		allFields = $( [] ).add( tipoLancamento )
		                .add( dataVencimento )
		                .add( descricao )
		                .add( categoria )
		                .add( conta )
		                .add( valor )
		                .add( parcelas )
		                .add( dataPgto )
		                .add( historico )
		                .add( cedenteSacado )
		                .add( repeticaoIndefinida ),
	    tips = $( ".validateTips" );

	function allValues(){
		return {
			tipoLancamento: $( "#tipoLancamento" ).val(),
	    	dataVencimento: $( "#dataVencimento" ).val(),
	    	dataPgto: $( "#dataPgto" ).val(),
	    	descricao: $( "#descricao" ).val(),
	    	historico: $( "#historico" ).val(),
	    	categoria: $( "#categoria" ).val(),
	    	cedenteSacado: $( "#cedenteSacado" ).val(),
	    	conta: $( "#conta" ).val(),
	    	valor: $( "#valor" ).val().replace('.','').replace(',','.'),
	    	parcelas: $( "#parcelas" ).val(),
	    	formaPgto: $('input[name=formaPgto]:radio:checked').val(),
	    	repeticaoIndefinida: $('[name=repeticaoIndefinida]').is(':checked'),
	    	action: SAVE
	    	};
	}
	
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 380,
		width: 750,
		modal: true,
		buttons: {
			Salvar: function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );


				bValid = bValid && checkLength( descricao, "descricao", 3, 60 );
				//bValid = bValid && checkLength( valor, "valor", 6, 80 );
				//bValid = bValid && checkLength( password, "password", 5, 16 );

				//bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter." );
				// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
				//bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
				//bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

				if ( bValid ) {
					var values = allValues();
					$.post('lancamentoUI.php', values, function(message){		
						showMessage(message);           
			            $.get('lancamentoList.php', {month: <?=$mesAtual?>, year: <?=$anoAtual?>}, function(data){
			                $(".fm-div-list").html(data);
			            });  
			        });   
					$( this ).dialog( "close" );
					
				}
			},
			Cancelar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
			formaPgtoAVista.attr("checked",true);
			formaPgtoParcelado.attr("checked",false);
			repeticaoIndefinida.attr("checked",false);
		}
	});

	$( "#dialog-remove" ).dialog({
		autoOpen: false,
		modal: true		
	});

	

	
	
});
		</script>
</head>
<body>

	<div class="fm-div-message"></div>
	<div class="fm-div-principal">

		<div class="fm-div-header">
			<?php require_once 'include/menu.php';?>
		</div>
		<div class="fm-div-content">
			<div class="fm-div-months"></div>
			<div class="fm-div-controls">			
				<button id="import">Importar</button>				
				<button id="new-transacao">Nova transação</button>
				

			
			</div>

			<div class="fm-div-list"></div>
		</div>
	</div>

	<!-- cadastro -->
	<div id="dialog-form" title="Cadastro de Transações">
		<p class="validateTips">*Campos obrigatórios!</p>

		<form>
			<div style="float: left; position: relative; width: 100%;">
				<div style="float: left; position: relative; width: 20%;">
					<label for="tipoLancamento">Tipo de Lançamento</label> <select
						name="tipoLancamento" id="tipoLancamento" class="text ">
						<option>--</option>
						<option value="<?=RECEITA?>">Receita</option>
						<option value="<?=DESPESA?>">Despesa</option>
						<option value="<?=TRANSFERENCIA?>">Transferência</option>
					</select>

				</div>
				<div style="float: left; position: relative; width: 15%;">
					<label for="valor">Valor*</label> 
					<input type="text" name="valor" id="valor" class="numeric " /> 
				</div>

				<div style="float: left; position: relative; width: 65%;">
					<label for="descricao">Descrição*</label> <input type="text"
						name="descricao" id="descricao" class="text " />
				</div>
			</div>



			<div style="float: left; position: relative; width: 100%;">
				<div style="float: left; position: relative; width: 20%;">
					<label for="dataVencimento">Data Vencimento*</label> <input
						type="text" name="dataVencimento" id="dataVencimento" value=""
						class="date " />
				</div>

				<div style="float: left; position: relative; width: 20%;">
					<label for="dataPgto">Data Pagamento</label> <input type="text"
						name="dataPgto" id="dataPgto" value="" class="date " />
				</div>

				<div style="float: left; position: relative; width: 20%;">
					<label for="categoria">Categoria*</label> <select name="categoria"
						id="categoria" class="text ">
						<option>--</option>
						<?php foreach ($categorias as $categoria){?>
						<option value="<?=$categoria->getId()?>">
							<?=$categoria->getNome()?>
						</option>
						<?php }?>
					</select>
				</div>

				<div style="float: left; position: relative; width: 20%;">
					<label for="cedenteSacado">Cedente/Sacado*</label> <select
						name="cedenteSacado" id="cedenteSacado" class="text ">
						<option>--</option>
						<?php foreach ($cedentesSacados as $cedenteSacado){?>
						<option value="<?=$cedenteSacado->getId()?>">
							<?=$cedenteSacado->getNome()?>
						</option>
						<?php }?>

					</select>
				</div>
				
				<div style="float: left; position: relative; width: 20%;">
					<label for="conta">Conta*</label> 
					<select name="conta" id="conta" class="text ">
						<option>--</option>
						<?php foreach ($contas as $conta){?>
						<option value="<?=$conta->getId()?>">
							<?=$conta->getNome()?>
						</option>
						<?php }?>
					</select> 
				</div>
			</div>

			<div style="float: left; position: relative; width: 100%;">
				<div style="float: left; position: relative; width: 33%;">
					<input type="checkbox" name="repeticaoIndefinida" id="repeticaoIndefinida"  />
					<label class="label-radio-check" for="repeticaoIndefinida">Repetir a cada mês</label> 
				</div> 
				
				<div style="float: left; position: relative; width: 33%;">
					<label for="formaPgto">Forma de Pagamento*</label> 
					<input type="radio" name="formaPgto" value="1" id="formaPgtoAVista"	checked="checked" /><label class="label-radio-check" for="formaPgtoAVista">A vista</label> 
					<input type="radio" name="formaPgto" value="2" id="formaPgtoParcelado" /><label class="label-radio-check" for="formaPgtoParcelado">parcelado </label>
				</div> 
				
				<div style="float: left; position: relative; width: 33%;">
					<label for="parcelas">Parcelas*</label>
					<input type="text" name="parcelas" id="parcelas" class="numeric" />
				</div>
			 </div>
			
			
			
			<label for="historico">Histórico</label>
			<textarea name="historico" id="historico" rows="3" ></textarea>

			



		</form>
	</div>

	<!-- remove -->
	<div id="dialog-remove" title="Remover Transação">
		<p class="validateTips">*Campos obrigatórios!</p>

		<form></form>
	</div>



</body>
</html>
