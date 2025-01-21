/* Js para cargar dinamicamente el nav en cada pagina */

document.addEventListener("DOMContentLoaded", function () {
    const navContainer = document.querySelector(".nav");

    if (navContainer) {
        fetch("../../assets/templates/nav.html")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al cargar el archivo de navegación");
                }
                return response.text();
            })
            .then(html => {
                navContainer.innerHTML = html;

                // Carga el script active-link.js dinámicamente
                const currentScript = document.createElement("script");
                currentScript.src = "../../assets/js/active-link.js"; 
                document.body.appendChild(currentScript);
            })
            .catch(error => console.error("Error: ", error));
    }
});
