const container = document.querySelector(".connected-nav-bar");

const onglets = container.getElementsByClassName("accueil-link");

for (let i = 0; i < onglets.length; i++) {
    onglets[i].addEventListener("click", function() {
        const current = document.getElementsByClassName("test");
        current[0].className = current[0].className.replace(" test", "");
        this.className += " test";
    });
}