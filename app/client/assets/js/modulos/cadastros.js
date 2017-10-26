//abrir formulário de cadastro
document.querySelector("#btnNew").addEventListener("click", ()=>{
    let status = document.querySelector("#status").getAttribute("operation")

    switch( status )
    {
        case 'motoristas':
            hideForms_ShowCurrentFormOperation("#insertMotoristas")
        break;

        case 'cargas':
            hideForms_ShowCurrentFormOperation("#updateCargas")
        break;

        default:
            console.log("operação desconhecida")
        break;
    }
})