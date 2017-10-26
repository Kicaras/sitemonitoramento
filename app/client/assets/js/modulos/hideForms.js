export function hideForms_ShowCurrentFormOperation(id)
{
    let hideForms = new Promise((resolve, reject) =>{
        for( let f of document.querySelectorAll("form") )f.hidden=true
        resolve()
    })
    hideForms.then( document.querySelector(id).hidden=false )
};
