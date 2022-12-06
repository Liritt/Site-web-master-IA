let chemin = document.location.href;
let links = document.querySelectorAll(".accueil-link");
links.forEach((link) => {
    if (link['href'] === chemin) {
        link.style.backgroundColor = "#378E64";
    }
})
