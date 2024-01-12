let content = document.getElementById('content')
function showCompra(json){
    content.innerHTML="";
    let compras = JSON.parse(json);
    console.log(compras);
    for(let i = 0; i < compras.length; i++){
        content.innerHTML+=`
        <div class="producto">
            <h1>${compras[i].nombre}</h1>
            <h1>${compras[i].count}</h1>
            <a href="view.php?id=${compras[i].id}"><img src="${compras[i].imagen}"></img></a>
            <h2>${compras[i].precio}$</h2>
        </div>
        `;
    }
}
