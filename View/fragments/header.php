<header>
  <nav class="navbar is-transparent mb-3 d-flex" style="background-color: #0A5517;">
    <div class="navbar-brand p-2" style="margin-right: auto!important;">
      <a class="navbar-item" href="
      
        <?php 

          if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario']) && $_SESSION['usuario']['id_tipo'] == 1){
            //* Se o usuário for do tipo 1 (admin) será redirecionado para o saguão do adm
            echo './../adm/saguaoAdm.php';
          }
          else if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario']) && $_SESSION['usuario']['id_tipo'] == 3){
            //* Se o usuário for do tipo do 3 (avalidor) será redirecionado para a tela do Avaliador
            echo './../avaliador/telaAvaliador.php';
          }
          else if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario']) && $_SESSION['usuario']['id_tipo'] == 2){
            //* Se o usuário for do tipo 2 (monitor) será redirecionado para a tela de Credenciamento
            echo './../credenciamento/telaCredenciamento.php';
          } 
          else{
            //* Caso não for nenhum dos anteriores, por padrão, ele vai apenas atualizar a página
            echo '#';
          }
          
        ?>">

          <img src="<?php echo absolutePathImg.'LogoFCTteste.png' ?>">
      </a>
    </div>

    <div class="navbar-item" style="display: flex; flex-direction: row; margin-right: 10px;">
      <div style="align-self: center;" class="p-2">
        <a style="font-weight: 600; color: white;"
          href="<?php echo absolutePath.'View/fragments/quemsomos.php'?>">
          © LADES 
        </a>
      </div>
    </div>
    
    <?php 
      if(!empty($_SESSION)){
    ?>

    <div class="navbar-item" style="display: flex; flex-direction: row; margin-right: 10px;">
      <div style="align-self: center;" class="p-2">
        <a style="font-weight: 600; color: white;"
          href="<?php echo absolutePath.'Controller/deslogarController.php'?>"> <!-- finalizar sessão -->
          Sair
        </a>
      </div>
    </div>

    <?php 
      }
    ?>

  </nav>
</header>