<?php
ob_start(); //ARMAZENA MEUS DADOS EM CACHE
session_start(); //INICIA A SESSÃO
if(isset($_SESSION['loginUser']) && (isset($_SESSION['passUser']))){
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprendendo PHP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
        <div class="col-lg-4"></div>
            <div class="col-lg-4">
            <form action="" method="post" enctype="multipart/form-data">
                    <h2>Formulário</h2>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Senha:</label>
                        <input type="password" name="pass" class="form-control">
                    </div>
                    
                    <hr>
                    <button type="submit" name="btn" class="btn btn-primary">Enviar</button>
                </form>
                <?php
                //Sessão foi criada, falta criar o encerramento da sessão, assistir a parte 3 no Criar Login LTI Treinamento
                                        include_once('config/conexao.php');
                                        if(isset($_POST['btn'])){
                                            $login=filter_input(INPUT_GET,'email', FILTER_DEFAULT);
                                            $pass=filter_input(INPUT_GET,'pass', FILTER_DEFAULT);

                                            $select="SELECT * FROM tbusers WHERE emailUser=:emailLog AND passUser=:passLog";

                                            try {

                                            $resultLogin = $conect->prepare($select);
                                            $resultLogin->bindParam(':emailLog',$login, PDO::PARAM_STR);
                                            $resultLogin->bindParam(':passLog',$pass, PDO::PARAM_STR);
                                            $resultLogin->execute();
                                
                                            $verificar = $resultLogin->rowCount();
                                            if ($verificar>0) {
                                                $login=$_POST['email'];
                                                $pass=$_POST['pass'];
                                                //CRIAR SESSAO »»
                                                $_SESSION['loginUser'] = $login;
                                                $_SESSION['passUser'] = $pass;
                                
                                                echo 'Seja bem-vindo(a) :)';
                                            
                                                header("Refresh: 3, home.php?acao=welcome");
                                            }else{
                                                echo "Usuário inválido";
                                            }
                                            } catch(PDOException $e){
                                            echo "<strong>ERRO DE LOGIN = </strong>".$e->getMessage();
                                            }
                                        }
                ?>
            </div>
            <div class="col-lg-4"></div>
            
        </div>
    </div>
</body>
</html>