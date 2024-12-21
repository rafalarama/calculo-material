<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculo de materiais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        #parede-espera {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            background: #c3c3c3;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        #parede-espera p {
            font-weight: bold;
        }

    </style>


</head>
<body>
    
<main>
    <h1 class="text-center mt-md-2">Calculadora de Materiais</h1>

    <div class="container">
        <div class="row g-2">
            <fieldset class="row g-2">
                <legend>Identificação</legend>

                <div class="col-md-6">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" required>
                    <span id="cliente-validacao" class="text-danger invisible"></span>
                </div>

                <div class="col-md-6">
                    <label for="nomeComodo" class="form-label">Comôdo</label>
                    <input type="text" class="form-control" id="nomeComodo" required>
                    <span id="nomeComodo-validacao" class="text-danger invisible"></span>
                </div>
            </fieldset>

            <fieldset class="row g-2">
                <legend>Comôdo</legend>
                <div class="col-md-6">
                    <label for="comodo-largura" class="form-label">Largura(m)</label>
                    <input type="number" class="form-control" id="comodo-largura" required>
                    <span id="comodo-largura-validacao" class="text-danger invisible"></span>
                </div>
                <div class="col-md-6">
                    <label for="comodo-comprimento" class="form-label">Comprimento(m)</label>
                    <input type="number" class="form-control" id="comodo-comprimento" required>
                    <span id="comodo-comprimento-validacao" class="text-danger invisible"></span>
                </div>
            </fieldset>
            <fieldset class="row g-2">
            <legend>Piso</legend>
                <div class="col-md-6">
                    <label for="piso-largura" class="form-label">Largura(m)</label>
                    <input type="number" class="form-control" id="piso-largura" required>
                    <span id="piso-largura-validacao" class="text-danger invisible"></span>
                </div>
                <div class="col-md-6">
                    <label for="piso-comprimento" class="form-label">Comprimento(m)</label>
                    <input type="number" class="form-control" id="piso-comprimento" required>
                    <span id="piso-comprimento-validacao" class="text-danger invisible"></span>
                </div>
            </fieldset>
            <div class="col-md-12"> 
                <label for="margem" class="form-label">Margem(%)</label>
                <input type="number" class="form-control" id="margem" required>
                <span id="margem-validacao" class="text-danger invisible"></span>
            </div>
            <div class="d-grid gap-2 col-md-3 col-sm-12 mx-auto">
                <button class="btn btn-primary" id="btn-calcular" onclick="processar();">Calcular</button>
            </div>           
        </div> 

        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3" id="resultados">

        </div>

        <div id="template-card" class="invisible">
            <div class="col">
                <div class="card me-2 mb-2" >
                    <div class="card-body">
                        <h5 class="card-title"><span class="nome-cliente"><span></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary nome-comodo"></h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-success">Cômodo: <i class="fa-solid fa-tent-arrow-left-right"></i> Área: <span class="area-comodo"></span>m² </li>
                        <li class="list-group-item">Cerâmica: 
                            <i class="fa-solid fa-ruler-combined"></i> <span class="area-piso"></span>m² | 
                            <i class="fa-solid fa-table-cells-large"></i> <span class="qtde-piso"></span> | 
                            <i class="fa-solid fa-percent"></i> <span class="margem-piso"></span>
                        </li>
                        <li class="list-group-item">Comprar: 
                            <i class="fa-solid fa-cart-shopping"></i> <span class="qtde-total"></span>
                        </li>
                    </ul>
                    <div class="card-body">                    
                        <a href="#" class="card-link">Alterar</a>
                        <a href="#" class="card-link">Excluir</a>
                    </div>   
                    <div class="card-footer text-body-secondary px-0 text-center">
                        Há 2 dias
                    </div>                
                </div>  
            </div>  
        </div> 
    </div>

    <div id="parede-espera" class="opacity-75 invisible">
        <img src="images/carregando.gif" alt="Carregando">
        <p>Por favor, aguarde.</p>
    </div>

    
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a7891e202e.js" crossorigin="anonymous"></script>
<script>
    
    realizarBinds();
    recuperarOrcamentos();


    function recuperarOrcamentos(){
        const chaves = Object.keys(localStorage);
        for(let i = 0; i < chaves.length; i++){
            console.log(chaves[i]);

            var jsonString = localStorage.getItem(chaves[i]);
            const resultado = JSON.parse(jsonString);

            exibirOrcamentos(resultado.nomeCliente, resultado.nomeComodo, resultado.areaComodo, 
                                        resultado.areaPiso, Math.ceil(resultado.quantidade), 
                                        Math.ceil(resultado.quantidadeMargem), Math.ceil(resultado.quantidadeTotal));

        }
    }

    function realizarBinds()    {
        const identificador = document.getElementById("identificador");
        const comodoLargura = document.getElementById("comodo-largura");
        const comodoComprimento = document.getElementById("comodo-comprimento");
        const pisoLargura = document.getElementById("piso-largura");
        const pisoComprimento = document.getElementById("piso-comprimento");
        const margem = document.getElementById("margem");

        comodoLargura.addEventListener("focus", removerMensagemErro);
        comodoComprimento.addEventListener("focus", removerMensagemErro);
        pisoLargura.addEventListener("focus", removerMensagemErro);
        pisoComprimento.addEventListener("focus", removerMensagemErro);
        margem.addEventListener("focus", removerMensagemErro);
    }

    function toggleLoading(){
        //recuperamos a div
        const div = document.getElementById("parede-espera");

        //alternamos entre ligado e desligado
        div.classList.toggle("invisible");
    }

    function copiarCard(){
        //id do componente de template
        const idTemplate = "template-card";

        //recuperamos o template de card e extraímos o html para criar uma cópia
        const cardTemplate = document.getElementById(idTemplate);
        var htmlCard = cardTemplate.getHTML();

        //adicionamos a cópia ao container de resultados
        const containerResultado = document.getElementById("resultados");
        containerResultado.insertAdjacentHTML("beforeend", htmlCard)
    }

    function preencherInformacaoCard(nomeCliente, nomeComodo, areaComodo, areaPiso, qtdePiso, margemPiso, qtdeTotal){
        const cards = document.getElementsByClassName("card");
        const ultimoCard = cards[cards.length -2]

        ultimoCard.getElementsByClassName("nome-cliente")[0].innerText = nomeCliente;
        ultimoCard.getElementsByClassName("nome-comodo")[0].innerText = nomeComodo;
        ultimoCard.getElementsByClassName("area-comodo")[0].innerText = areaComodo;
        ultimoCard.getElementsByClassName("area-piso")[0].innerText = areaPiso;
        ultimoCard.getElementsByClassName("qtde-piso")[0].innerText = qtdePiso;
        ultimoCard.getElementsByClassName("margem-piso")[0].innerText = margemPiso;
        ultimoCard.getElementsByClassName("qtde-total")[0].innerText = qtdeTotal;
    }

    function processar(){
        try {

            toggleLoading();

            const nomeCliente = document.getElementById("cliente").value;
            const nomeComodo = document.getElementById("nomeComodo").value;
            const comodoLargura = document.getElementById("comodo-largura").value;
            const comodoComprimento = document.getElementById("comodo-comprimento").value;
            const pisoLargura = document.getElementById("piso-largura").value;
            const pisoComprimento = document.getElementById("piso-comprimento").value;
            const margem = document.getElementById("margem").value;

            // if(comodoLargura <= 0){
            //     alert("A largura do comôdo deve ser maior que 0");
            //     return;
            // }

            // if(comodoComprimento <= 0){
            //     alert("O comprimento do comôdo deve ser maior que 0");
            //     return;
            // }

            // if(pisoLargura <= 0){
            //     alert("A largura do piso deve ser maior que 0");
            //     return;
            // }

            // if(pisoComprimento <= 0){
            //     alert("O comprimento do piso deve ser maior que 0");
            //     return;
            // }

            // if(margem <= 0){
            //     alert("A margem deve ser maior que 0");
            //     return;
            // }

            const medidas = {
                nomeCliente,
                nomeComodo,
                comodoLargura,
                comodoComprimento,
                pisoLargura,
                pisoComprimento,
                margem
            }

            const dados = JSON.stringify(medidas);

            fetch('/calculo.php', {
                method: 'POST',
                headers: {'Content-Type':'application/json'},
                body: dados
            })
            .then(resposta => {
                toggleLoading();
                return resposta.json()
            })
            .then(resultado =>{
                let elementoResultado = document.getElementById("resultado");

                if(resultado.erro){
                    //alert(resultado.erro);
                    //elementoResultado.innerHTML = resultado.erro;
                    resultado.erro.forEach(erroMsg => {
                        exibirErro(erroMsg.idCampo, erroMsg.mensagem);
                    });
                    return;
                }

                //elementoResultado.innerHTML = '';

                // const exibir =
                // "<p> Área do comodo: " + resultado.areaComodo + " </p>" +
                // "<p> Área do piso: " + resultado.areaPiso + " </p>" +
                // "<p> Quantidade de piso: " + resultado.quantidade + " </p>" +
                // "<p> Quantidade para margem: " + resultado.quantidadeMargem + " </p>" +
                // "<p> Total a ser comprado: " + resultado.quantidadeTotal + " </p>" ;

                // elementoResultado.innerHTML = exibir;

                exibirOrcamentos(nomeCliente, nomeComodo, resultado.areaComodo, 
                                        resultado.areaPiso, Math.ceil(resultado.quantidade), 
                                        Math.ceil(resultado.quantidadeMargem), Math.ceil(resultado.quantidadeTotal));

                const jsonString = JSON.stringify(resultado);

                const chave = `${nomeCliente.replaceAll(" ", "_").toLowerCase()}_${nomeComodo.replaceAll(" ", "_").toLowerCase()}`;

                localStorage.setItem(chave, jsonString);
            })
            .catch(erro => {
                alert("Ocorreu um erro");
                console.error(erro);  
                toggleLoading();              
            });
        }
        catch(e){
            alert("Ocorreu um erro ao atender a sua solicitação.");
            console.error("Ocorreu um erro ao atender a sua solicitação. Detalhes", e);
            toggleLoading();            
        }
    }

    function exibirOrcamentos(nomeCliente, nomeComodo, areaComodo, 
                                        areaPiso,quantidade, quantidadeMargem, quantidadeTotal){
        copiarCard();
                preencherInformacaoCard(nomeCliente, nomeComodo, areaComodo, 
                                        areaPiso, Math.ceil(quantidade), 
                                        Math.ceil(quantidadeMargem), Math.ceil(quantidadeTotal));
    }

    function exibirErro(idElemento, mensagemErro){
        const spanId = idElemento+"-validacao";
        const input = document.getElementById(idElemento);
        const spanErro = document.getElementById(spanId);

        //adicionar a mensagem de erro na span
        spanErro.innerHTML = mensagemErro;

        //tornar a span visivel
        spanErro.classList.remove("invisible");

        //adicionar as bordas vermelhas no input
        input.classList.add("border", "border-danger-subtle");
    }

    function removerMensagemErro(e){        
        const spanId = e.srcElement.id+"-validacao";
        const input = e.srcElement;
        const spanErro = document.getElementById(spanId);

        //limpar a mensagem de erro na span
        spanErro.innerHTML = "";

        //tornar a span invisivel
        spanErro.classList.add("invisible");

        //remover as bordas vermelhas no input
        input.classList.remove("border", "border-danger-subtle");
    }

</script>
</body>
</html>