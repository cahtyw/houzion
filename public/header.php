<?php
    session_start();
    if($_SESSION['logged']){
        $login_name = $_SESSION['login-name'];
    }
?>

<div class="header-bg sticky-top">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <a href="" class="">
                    <img src="../images/logo/logo_64.png" alt="" class="header-logo">
                </a>
            </div>
            <div class="col-md-4 header-nav">
                <div class="navbar-light header-msg bg-white">
                    <div class="row">
                        <div class="col-md-7">
                            <span class="navbar-text "><?php echo($_SESSION['logged']? "Olá, $login_name!" : "Você não está logado(a)!") ?></span>
                        </div>
                        <div class="col-md-5">
                            <div class="btn-group btn-login">
                                <button class="btn bg-white text-lighter dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Minha conta
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Entrar</a>
                                    <a class="dropdown-item" href="#">Esqueci minha senha</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Solicitar contato</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg slick-top navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php echo (!(strpos($_SERVER['PHP_SELF'], 'index.php'))) ?: 'active' ?>">
                        <a class="nav-link" href="index.php">Início</a>
                    </li>
                    <li class="nav-item <?php echo (!(strpos($_SERVER['PHP_SELF'], 'about.php'))) ?: 'active' ?>">
                        <a class="nav-link" href="#">Sobre nós</a>
                    </li>
                    <li class="nav-item <?php echo (!(strpos($_SERVER['PHP_SELF'], 'contact.php'))) ?: 'active' ?>">
                        <a class="nav-link" href="contact.php">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Menu 4</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Menu 5</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Menu 6</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Pesquisa" aria-label="Pesquisar">
                    <button class="btn my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>
</div>