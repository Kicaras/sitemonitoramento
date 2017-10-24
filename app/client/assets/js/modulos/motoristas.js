
function hideForms_ShowCurrentFormOperation(id)
{
    let hideForms = new Promise((resolve, reject) =>{
        for( let f of document.querySelectorAll("form") )f.hidden=true
        resolve()
    })
    hideForms.then( document.querySelector(id).hidden=false )
}

function mountMotoristas(dados)
{
    let stringHTML = ""

    //montando a stringHTML que irá dentro da tabela
    dados.forEach(obj =>{
        stringHTML += `<tr><td>${obj.cpf}</td><td>${obj.nome}</td><td>${obj.email}</td><td><div class="btn danger" onclick="DeletarMotorista(${obj.cpf})">Deletar</div><label for="modal-one" class="btn warning" onclick="AlterarMotorista(${obj.cpf})">Alterar</label></td></tr>`
    })

    //CRIAR O CABEÇALHO DA TABELA
    document.querySelector("#titleTable").innerHTML = "<th>CPF</th><th>NOME</th><th>E-MAIL</th><th>AÇÃO</th>"

    //INPUT OS DADOS NA TABELA
    document.querySelector("#dados").innerHTML = stringHTML

    //DEIXO UM ATRIBUTO NO STAUS, PARA QUE EU CONTROLE POSTERIORMENTE A OPERAÇÃO
    document.querySelector("#status").setAttribute("operation", 'motoristas')
    document.querySelector("#status").innerText="motoristas"
}

function carregarMotoristas()
{
    //busca no servidor os dados
    axios.get(`${host}/motoristas`).then(res=> mountMotoristas(res.data) )
}

function DeletarMotorista(cpf)
{
    if(confirm("Tem certeza?"))axios.delete(`${host}/motoristas/${cpf}`).then(res=> carregarMotoristas() )
}

function AlterarMotorista(cpf)
{
    hideForms_ShowCurrentFormOperation("#updateMotoristas")
    axios.get(`${host}/motoristas/${cpf}`).then(res=>{
        document.querySelector("#updateMotoristas").innerHTML = JSON.stringify( res.data ) 

        //jogar dentro dos inputs do form alterar
    })
}           


  
  
  