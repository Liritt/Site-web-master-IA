const container = document.querySelector(".connected-nav-bar");

const onglets = container.getElementsByClassName("accueil-link");

for (let i = 0; i < onglets.length; i++) {
    onglets[i].addEventListener("click", function() {
        const current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
    });
}