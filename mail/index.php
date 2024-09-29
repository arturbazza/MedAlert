<?php
include_once '../config/db.php';

echo "<b>" . " BASE_DIR: " . BASE_URL . " - DIR: " . __DIR__ . " " . " - SERVERNAME: " . $servername . " - USERNAME: "  . $username . " - PASS: " . $password. " - DBNAME: " . $dbname . " - BASE_URL: " . $base_url . "</b><br><br>";

include_once '../mail/funcao.php';

if(isset($_POST['nome']) && !empty($_POST['nome']))
{
    if(sendMail($_POST['email'],'arturbc@gmail.com.br', $_POST['mensagem'], 'Formulario de contato'))
    {
        echo "Sua mensagem foi enviada com sucesso!";
        echo "<br><a href='index.php'>Voltar</a>";
    }
    else
    {
        echo "Ocorreu um erro ao enviar";
        echo "<br><a href='index.php'>Voltar</a>";
    }    
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" type="text/css" media="all" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
	<h2>Formulario de contato</h2>
	
    <form method="post" id="formulario_contato" onsubmit="validaForm();" class="form">
		<p class="name">
            <label for="name">Nome</label>
            <input type="text" name="nome" id="nome" placeholder="Seu Nome" />
		</p>
		
		<p class="email">
            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" placeholder="mail@exemplo.com.br" />
		</p>		
	
		<p class="text">
            <label for="mensagem">Mensagem</label>
            <textarea name="mensagem" id="mensagem" placeholder="Escreva sua mensagem"></textarea>
		</p>
		
		<p class="submit">
            <input type="submit" value="Enviar" />
		</p>
	</form>
    <script type="text/javascript">
        function validaForm()
        {
            let erro = false;
            if($('#nome').val() == '')
            {
                alert('Você precisa preencher o campo Nome!'); erro = true;
            }
            if($('#email').val() == '' && !erro)
            {
                alert('Você precisa preencher o campo E-mail!'); erro = true;
            }
            if($('#mensagem').val() == '' && !erro)
            {
                alert('Você precisa preencher o campo Mensagem!'); erro = true;
            }
            
            // Se não houver erros, submete o formulário
            if(!erro)
            {
                $('#formulario_contato').submit();
            }
        }
    </script>
</body>
</html>
