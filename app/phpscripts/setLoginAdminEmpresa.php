<?php
if(isset($_QUERY['IdEmpresa'])){
	
	$rs = $db->query(sprintf("SELECT id_cliente, cpf, fone, email, responsavel, nome_fantasia, site, empresa, pasta_images, nivel_acesso, tipo_plano, limit_produto FROM `acesse_cadastro_clientes` WHERE ( id_cliente = '%s' ) LIMIT 1", base64_decode($_QUERY['IdEmpresa'])));
	$obj = $rs->fetch_object();
	$dados["id_cliente"] = $obj->id_cliente;
	$dados["cpf"] = $obj->cpf;
	$dados["fone"] = $obj->fone;
	$dados["email"] = $obj->email;
	$dados["responsavel"] = $obj->responsavel;
	$dados["nome_fantasia"] = $obj->nome_fantasia;
	$dados["site"] = $obj->site;
	$dados["empresa"] = $obj->empresa;
	$dados["pasta_images"] = $obj->pasta_images;
	$dados["nivel_acesso"] = $obj->nivel_acesso;
	$dados["tipo_plano"] = $obj->tipo_plano;
	$dados["limit_produto"] = $obj->limit_produto;
	$_SESSION["dados"] = $dados;
	
}
?>