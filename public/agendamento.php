<?php 
    $conexao = pg_connect("host=localhost port=5432 dbname=houzion user=houzion password=bj2fF4");
    if(!$conexao)
    {
        echo "Não foi possível efetuar conexão com o banco de dados";
    }
    else
    {
        $cod_usuario= $_POST["cod_usuario"];
        $cod_controle= $_POST["cod_controle"];
        $descricao= $_POST["descricao"];
        $status= $_POST["status"];
        $hora= $_POST["hora"];
        $dias= $_POST["dias"];
        $offset = 0;
        
        $sql = "INSERT INTO agendamento VALUES($cod_usuario,$cod_controle,'$descricao',$status,'$hora',$dias,$offset)";
            var_dump($sql);
            $result=pg_query($conexao,$sql);
            $linhas = pg_affected_rows($result);
            if($linhas >0)
                echo "Dados gravados com sucesso";
            else
                echo "Dados nao gravados";
        
      
    }
?>