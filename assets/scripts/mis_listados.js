function busqueda_tr(_page) {
    var request = new XMLHttpRequest();
    request.open("POST", ruta);
    document.filtrocabecera.pagina_actual.value = _page;
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            setInnerHTML(document.getElementById('contenidotabla'), request.responseText);
            $('[data-toggle="tooltip"]').tooltip();
        }
    }
    request.send(new FormData(document.getElementById("filtrocabecera")));
}
/**
 * Función para cargar un HTML + SCRIPT
 * @param elm Elemento que se usará como contenedor
 * @param html El contenido HTML que se asignará
 */
function setInnerHTML(elm, html) {
    elm.innerHTML = html;
    Array.from(elm.querySelectorAll("script")).forEach(oldScript => {
        const newScript = document.createElement("script");
        Array.from(oldScript.attributes)
            .forEach(attr => newScript.setAttribute(attr.name, attr.value));
        newScript.appendChild(document.createTextNode(oldScript.innerHTML));
        oldScript.parentNode.replaceChild(newScript, oldScript);
    });
}