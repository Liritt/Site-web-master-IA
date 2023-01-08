const currentUrl = window.location.href;

const hrefUrl = document.querySelectorAll("a.accueil-link")

hrefUrl.forEach((url) => {
    if (url.href === currentUrl) {
        url.style.backgroundColor = "#378E64";
    }
})