<?php
//session_start();

	include_once(dirname(dirname(__DIR__))."/Controller/loginController.php");

// if (!empty($_SESSION) && isset($_SESSION) && isset($_SESSION['administrador'])) {
	if(isset($_SESSION) && !empty($_SESSION) && verificaLogado($_SESSION['usuario'], 1)){

	include_once __DIR__ . '/../fragments/paths.php';
	require_once __DIR__ . '/../../Util/conectaPDO.php';
	require_once __DIR__ . '/../../Controller/trabalhoController.php';


?>
	<!DOCTYPE html>
	<html lang="en" style="background-color: #f5f5f5;">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="../img/IconFCT.png" type="image/x-icon">
		<title>Saguao Adm</title>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
		<link rel="stylesheet" href=<?php require_once './../fragments/paths.php';
					echo absolutePath . "View/css/estilo.css"; ?>>
		<link rel="stylesheet" href="<?=absolutePath . 'View/css/telaAvaliador.css' ?>">

		<style>
			.table-container {
				overflow: auto !important;
				overflow-scrolling: touch !important;
			}

			.pagination {
				display: flex;
				justify-content: center;
				margin-top: 20px;
			}

			.page-link {
				padding: 10px 20px;
				margin: 0 5px;
				text-decoration: none;
				color: #30F06E;
				border: 1px solid #30F06E;
				border-radius: 5px;
			}

			.page-link.active {
				background-color: #30F06E;
				color: #fff;
			}

			@media screen and (max-width: 850px) {
				#divPrincipal {
					flex-direction: column;
					width: 100% !important;
					height: 514px !important;
					text-align: center !important;
					padding: 0 !important;
				}

				#popUp {
					left: unset !important;
					width: 100% !important;
					top: 150px !important;
				}

				.menuzinho {
					width: 100% !important;
				}

				table tr td {
					vertical-align: middle !important;
				}

				video {
					display: none !important;
				}

				.pagination{
					left: 25%;
				}
			}
		</style>

		<script>
			function mostrarSecao(secao, event) {
				event.preventDefault();
				if (secao === 1) {
					document.getElementById('secao1').style.display = 'block';
					document.getElementById('secao2').style.display = 'none';
					document.getElementById('secao3').style.display = 'none';

					document.getElementById('pag1').style.backgroundColor = '#30F06E';
					document.getElementById('pag1').style.color = '#fff';

					document.getElementById('pag2').style.backgroundColor = 'unset';
					document.getElementById('pag2').style.color = '#30F06E';
					document.getElementById('pag3').style.backgroundColor = 'unset';
					document.getElementById('pag3').style.color = '#30F06E';
				} else if (secao === 2) {
					document.getElementById('secao2').style.display = 'block';
					document.getElementById('secao1').style.display = 'none';
					document.getElementById('secao3').style.display = 'none';

					document.getElementById('pag2').style.backgroundColor = '#30F06E';
					document.getElementById('pag2').style.color = '#fff';

					document.getElementById('pag1').style.backgroundColor = 'unset';
					document.getElementById('pag1').style.color = '#30F06E';
					document.getElementById('pag3').style.backgroundColor = 'unset';
					document.getElementById('pag3').style.color = '#30F06E';

				} else if (secao === 3) {
					document.getElementById('secao3').style.display = 'block';
					document.getElementById('secao1').style.display = 'none';
					document.getElementById('secao2').style.display = 'none';

					document.getElementById('pag3').style.backgroundColor = '#30F06E';
					document.getElementById('pag3').style.color = '#fff';

					document.getElementById('pag1').style.backgroundColor = 'unset';
					document.getElementById('pag1').style.color = '#30F06E';
					document.getElementById('pag2').style.backgroundColor = 'unset';
					document.getElementById('pag2').style.color = '#30F06E';
				}
			}


			function fechaPop(acao) {
				var importar = document.getElementById('importar');
				var exportar = document.getElementById('exportar');

				var popID_importar = document.getElementById('popUp_Importar');
				var popID_exportar = document.getElementById('popUp_Exportar');

				if (acao == 'importar' && popID_importar.style.display == 'flex') { //verifica se foi o importar ou exportar que chamou a função
					popID_importar.style.display = 'none';
				} else if (acao == 'exportar' && popID_exportar.style.display == 'flex') { //verifica se foi o exportar ou exportar que chamou a função
					popID_exportar.style.display = 'none';
				}

				//* Faz desaparecer a div que escurece o fundo
				document.getElementById('ofuscaTela').style.display = 'none';

			}


			function popUpInfos(acao) {

				var importar = document.getElementById('importar');
				var exportar = document.getElementById('exportar');

				var popID_importar = document.getElementById('popUp_Importar');
				var popID_exportar = document.getElementById('popUp_Exportar');

				if (acao == 'importar' && popID_importar.style.display == 'none') { //verifica se foi o importar ou exportar que chamou a função
					document.getElementById('ofuscaTela').style.display = 'unset';
					popID_importar.style = 'width: 500px; height: 200px; display: flex; z-index: 2; text-align: center; position: absolute; flex-direction: column; left: 33%; top: 15vw;';
				} else if (acao == 'exportar' && popID_exportar.style.display == 'none') { //verifica se foi o exportar ou exportar que chamou a função
					document.getElementById('ofuscaTela').style.display = 'unset';
					popID_exportar.style = 'width: 500px; height: 200px; display: flex; z-index: 2; text-align: center; position: absolute; flex-direction: column; left: 33%; top: 15vw;';
				}

			}
		</script>
		<?php
		$PAGE = 'saguaoAdm.php';
		?>

	</head>


	<div id="ofuscaTela" style="display: none;">
		<div style="width: 100%; height: 100%; background-color: black; position: fixed; z-index: 1; opacity: 0.4;">
		</div>
	</div>



	<body>

		<?php
		if (isset($_GET['msg']) || !empty($_GET['msg'])) { 
			echo "<script> alert('" . $_GET['msg'] . "'); </script>";
		}

		?>


		<?php
		include __DIR__ . '/../fragments/header.php';
		?>

		<!-- popUp do Importar -->
		<div class="notification" style="display: none;" id="popUp_Importar">
			<button class="delete" onclick="fechaPop('importar')"></button>

			<div>
				<a class="button verde is-small" href="./../../Service/processaTabelaAvaliadores.php" style="font-size: 100%; color: white; font-weight: 600; width: 80%; height: 5rem;">
					Avaliadores
				</a>
			</div>

			<div>
				<a class="button verde is-small" href="./../../Service/processaTabelaTrabalho.php" style="font-size: 100%; color: white; font-weight: 600; width: 80%; height: 5rem;">
					Trabalhos
				</a>
			</div>
		</div>

		<!-- popUp do Exportar -->
		<div class="notification" style="display: none;" id="popUp_Exportar">
			<button class="delete" onclick="fechaPop('exportar')"></button>

			<div>
				<a class="button verde is-small" href="<?="./../../ClassificacaoPDF?action=avaliadorPDF" ?>" style="font-size: 100%; color: white; font-weight: 600; width: 80%; height: 5rem;">
					Avaliadores
				</a>
			</div>

			<div>
				<a class="button verde is-small" href=".<?="./../ClassificacaoPDF?action=trabalhoPDF" ?>" style="font-size: 100%; color: white; font-weight: 600; width: 80%; height: 5rem;">
					Trabalhos
				</a>
			</div>
		</div>

		<main class="alinhamento">

			<div style="width: 70%; height: 36rem; margin-top: 5vh; margin-bottom: 5vh; display: flex; justify-content: space-around; padding: 2%; background-color:#fff; box-shadow: 0.4em 0.5em 0.7em -0.125em rgba(10,10,10, .3);" id="divPrincipal">
				<div class="menuzinho" style="width: 90%; height: 100%; padding: 2%;">

					<div id="secao1">
						<?php if (!countTrabAvaliadores()) { ?>
							<div style="margin:1%;">
								<a class="button verde is-small" id="btnDistribuir" onclick="return confirm('Este botão é definitivo, tem certeza?')" href=<?=absolutePath . 'Controller/distribuicaoController.php' ?> style="font-size: 100%; color: white; font-weight: 600; width: 80%; height: 5rem;">
									Distribuir
								</a>
							</div>
						<?php } ?>

						<?php if (countTrabAvaliadores()) { ?>
							<div style="margin:1%;">
								<a class="button verde is-small" id="btnLog" href=<?=absolutePath . 'View/adm/logDistribuicao.php' ?> style="color: white; font-weight: 600; width: 80%; font-size: 100%; height:  5rem;">
									Log Distribuição
								</a>
							</div>
						<?php } ?>

						<div style="margin:1%;">
							<a class="button verde is-small" id="btnMostrar" onclick="mostraAvaliacoes()" href="./resumoTrabalhos.php" style="font-size: 100%; color: white; font-weight: 600; margin:
					auto; width: 80%; height:  5rem;">
								Resumo Trabalhos
							</a>
						</div>

						<div style="margin:1%;">
							<a class="button verde is-small" id="btnListar" href="<?=absolutePath . "View/adm/listarAvaliador.php" ?>" style="font-size: 100%; color: white; font-weight: 600; margin:
					auto; width: 80%; height:  5rem;">
								Listar
							</a>
						</div>

						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" href="<?=absolutePath . "View/adm/cadastrarAvaliador.php" ?>" style="font-size: 100%; color: white; font-weight: 600; margin:
					auto; width: 80%; height:  5rem;">
								Cadastrar Avaliador
							</a>
						</div>

						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" onclick="popUpInfos('importar');" href="#" id="importar" style="font-size: 100%; color: white; font-weight: 600; margin: auto; width: 80%; height:
							5rem;">
								Importar
							</a>
						</div>


					</div>


					<div id="secao2" style="display: none;">
						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" target="_blank" href="<?=absolutePath . "ClassificacaoPDF?action=classificacaoPDF" ?>" style="font-size: 100%; color: white; font-weight: 600; margin:
					auto; width: 80%; height:  5rem;">
								Classificação
							</a>
						</div>


						<!-- Botão desabilitado durante a feira  -->

						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" onclick="popUpInfos('exportar');" href="#" id="exportar" style="font-size: 100%; color: white; font-weight: 600; margin: auto; width: 80%; height:
							5rem;">
								Baixar PDF
							</a>
						</div>

						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" href="<?=absolutePath . "View/adm/historicoFeiras.php" ?>" style="font-size: 100%; color: white; font-weight: 600; margin:
					auto; width: 80%; height:  5rem;">
								Histórico de Feiras
							</a>
						</div>
						
						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" href="<?=absolutePath . "View/adm/relatorioInfos.php" ?>" style="font-size: 100%; color: white; font-weight: 600; margin:
					auto; width: 80%; height:  5rem;">
								Relatórios
							</a>
						</div>
						
						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" href="<?=absolutePath . "View/adm/logFeira.php" ?>" style="font-size: 100%; color: white; font-weight: 600; margin:
					auto; width: 80%; height:  5rem;">
								Log
							</a>
						</div>
					</div>

					<div id="secao3" style="display: none;">
						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" onclick="return confirm('Este botão é definitivo, tem certeza?')" href="<?=absolutePath . "Util/atalhoDB.php?action=criarDB" ?>" style="font-size: 100%; color: white; font-weight: 600; margin: auto; width: 80%; height:  5rem;">
								Resetar Database
							</a>
						</div>
						
						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" href="<?=absolutePath . "View/adm/cadastrarEvento.php" ?>" style="font-size: 100%; color: white; font-weight: 600; margin: auto; width: 80%; height:  5rem;">
								Cadastrar Evento
							</a>
						</div>
						
						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" href="<?=absolutePath . "Service/processaEstudante.php?act=zeraPresenca" ?>" style="font-size: 100%; color: white; font-weight: 600; margin: auto; width: 80%; height:  5rem;">
								Zerar presenças
							</a>
						</div>
						
						<div style="margin:1%;">
							<a class="button verde is-small" id="btnCadastrar" href="<?=absolutePath . "View/adm/telaPresencaAvaliadores.php" ?>" style="font-size: 100%; color: white; font-weight: 600; margin: auto; width: 80%; height:  5rem;">
								Presença de Avaliadores
							</a>
						</div>
					</div>

				</div>

				<div class="pagination" style="position: absolute; top: 80%;">
					<a href="#" class="page-link active" id="pag1" onclick="mostrarSecao(1, event)">1</a>
					<a href="#" class="page-link" id="pag2" onclick="mostrarSecao(2, event)">2</a>
					<a href="#" class="page-link" id="pag3" onclick="mostrarSecao(3, event)">3</a>
				</div>


				<div class="anime" style="padding: 0; display: flex;" height="100%">
					<video width="96.5%" muted autoplay loop style="vertical-align: middle;">
						<source src="/../fecintec/View/img/anime.mp4" type="video/mp4">
					</video>
				</div>


			</div>

		</main>

		<?php
		include __DIR__ . './../fragments/footer.php';
		?>
	</body>



	</html>

<?php 
} else{
echo "Você não tem permissão para acessar esta página.";
header("Refresh:2; URL=../avaliador/login.php");
}

?>