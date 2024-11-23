<?php
//Diz ao PHP que vamos trabalhar usando o protocolo Json para comunicação
header('Content-Type: application/json');

//Verificamos se a requisição é do tipo POST, caso não seja, retornamos uma mensagem de erro
if($_SERVER['REQUEST_METHOD'] =='POST'){
//Filtramos os dados da requisão e atribuimos á uma variavel chamada #dados
    $dados = json_decode(file_get_contents("php://input"));

//Calculos
        $areacomodo = $dados -> comodoLargura * $dados -> comodoComprimento;
        $areapiso = $dados -> pisoLargura * $dados -> pisoComprimento;
        $quantidadePiso = $areacomodo / $areapiso;
        $margem = $quantidadePiso * ($dados -> Margem / 100);
        $quantidadeTotal = $quantidadePiso + $margem;
        
//retorno em json
        echo json_encode([
            "areaComodo" => $areapiso,
            "areaPiso" => $areapiso,
            "quantidade" => $quantidadePiso,
            "quantidademargem" => $margem,
            "quantidadeTotal" =>$quantidadeTotal
        ]);

} else {
    echo json_encode(['erro'=> 'Método não suportado. Use o POST']);
}
?>


