<?php
//componentes de conexao ao MySQL
@ini_set("max_execution_time", 60*60*12);

$date = date("d-m-Y");


// gerando um arquivo sql. Como?
// a função fopen, abre um arquivo, que no meu caso, será chamado como: nomedobanco.sql
// note que eu estou concatenando dinamicamente o nome do banco com a extensão .sql.
$pasta = sprintf("./backupFinan/%s/", $date);
@mkdir( $pasta, 0777);
$back = fopen($pasta . date("d-m-Y_H").".sql","w");

// aqui, listo todas as tabelas daquele banco selecionado acima
$res = mysqli_list_tables(BANCO) or die(mysqli_error());

// resgato cada uma das tabelas, num loop
while ($row = mysqli_fetch_row($res)) {
$table = $row[0]; 
// usando a função SHOW CREATE TABLE do mysql, exibo as funções de criação da tabela, 
// exportando também isso, para nosso arquivo de backup
$res2 = mysqli_query($conexao,"SHOW CREATE TABLE $table");
// digo que o comando acima deve ser feito em cada uma das tabelas

	while ( $lin = mysqli_fetch_row($res2)){ 
		// instruções que serão gravadas no arquivo de backup
		fwrite($back,"\n#\n# Criação da Tabela : $table\n#\n\n");
		fwrite($back,"$lin[1] ;\n\n#\n# Dados a serem incluídos na tabela\n#\n\n");


// seleciono todos os dados de cada tabela pega no while acima
// e depois gravo no arquivo .sql, usando comandos de insert
		$res3 = mysqli_query($conexao,"SELECT * FROM $table");
		while($r=mysqli_fetch_row($res3)){ 
			$sql="INSERT INTO $table VALUES (";


		// este laço irá executar os comandos acima, gerando o arquivo ao final, 
		// na função fwrite (gravar um arquivo)
		// este laço também irá substituir as aspas duplas, simples e campos vazios
		// por aspas simples, colocando espaços e quebras de linha ao final de cada registro, etc
		// deixando o arquivo pronto para ser importado em outro banco
   
				for($j=0; $j<mysqli_num_fields($res3);$j++)
		        {
		            if(!isset($r[$j]))
		                $sql .= " NULL,";
		            elseif($r[$j] != "")
                        $sql .= " '".addslashes($r[$j])."',";
		            else
		                $sql .= " '',";
		        }
                        $sql .= @preg_replace(",$j", "", $sql);
		                $sql .= ");\n";
						$sql = @str_replace(",)", ")", $sql);
						
						

			fwrite($back,$sql);
		}
		
		mysqli_free_result($res3);
	}
	
	mysqli_free_result($res2);
}

// fechar o arquivo que foi gravado
fclose($back);
$arquivo = date("d-m-Y_H") .".sql";
/*
// gerando o arquivo para download, com o nome do banco e extensão sql.
	$arquivo = $date.".sql";
	Header("Content-type: application/sql");
 	Header("Content-Disposition: attachment; filename=$arquivo");
// lê e exibe o conteúdo do arquivo gerado
 	readfile($arquivo);
*/


function removeTreeRec($rootDir)
/**
*  Função recursiva para remover um diretório sem ter que apagar manualmente cada arquivo e pasta dentro dele
*
*  ATENÇÃO!
*
*  Muito cuidado ao utilizar esta função! Ela apagará todo o conteúdo dentro do diretório 
*  especificado sem pedir qualquer confirmação. Os arquivos não poderão ser recuperados.
*  Portanto, só utilize-a se tiver certeza de que deseja apagar o diretório.
*
*
*  Autor: Carlos Reche
*  E-mail: carlosreche@yahoo.com
*
*  Por favor, mantenha os créditos : )
*
*/
{
    if (!is_dir($rootDir))
    {
        return false;
    }

    if (!preg_match("/\\/$/", $rootDir))
    {
        $rootDir .= '/';
    }


    $dh = opendir($rootDir);

    while (($file = readdir($dh)) !== false)
    {
        if ($file == '.'  ||  $file == '..')
        {
            continue;
        }


        if (is_dir($rootDir . $file))
        {
            removeTreeRec($rootDir . $file);
        }

        else if (is_file($rootDir . $file))
        {
            unlink($rootDir . $file);
        }
    }

    closedir($dh);

    rmdir($rootDir);

    return true;
}

$file_del = sprintf("./backupFinan/%s",  date('d-m-Y', strtotime("-10 days")));
if(file_exists($file_del)){
	removeTreeRec($file_del);
}
mysqli_free_result($res);
mysqli_close($conexao);
?>