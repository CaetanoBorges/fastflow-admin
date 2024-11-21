<?php
include("../FERRAMENTAS/AX.php");
include("../FERRAMENTAS/dbWrapper.php");
include("../FERRAMENTAS/Funcoes.php");

$funcoes = new Funcoes;
$db = new dbWrapper($funcoes::conexao());
$DADOS = $_POST;
$usuario = AX::attr($DADOS["user"]);
$produto = AX::attr($DADOS["produto"]);
$disponibilidade = AX::attr($DADOS["disponibilidade"]);

$res = $db->update("produto")->set(["disponivel=$disponibilidade"])->where(["identificador=$produto","usuario=$usuario"])->executaQuery();
echo true;