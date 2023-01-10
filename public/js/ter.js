function handleDragStart(e) {
    this.style.opacity = '0.4';

    dragSrcEl = this;

    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragEnd(e) {
    this.style.opacity = '1';

    items.forEach(function (item) {
        item.classList.remove('over');
    });
}

function handleDragOver(e) {
    e.preventDefault();
    return false;
}

function handleDrop(e) {
    e.stopPropagation();

    if (dragSrcEl !== this) {
        dragSrcEl.innerHTML = this.innerHTML;
        this.innerHTML = e.dataTransfer.getData('text/html');
        // Récupérez l'ID de la candidature déplacée
        let candidacyId = dragSrcEl.getAttribute('id');

        // Récupérez l'ID de la candidature à laquelle l'élément a été déplacé
        let targetId = this.getAttribute('id');
        // Envoyez une requête Ajax à votre contrôleur pour mettre à jour les champs orderNumber des candidatures concernées
        fetch('/ter/update-order-number', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'candidacyId=' + encodeURIComponent(candidacyId) + '&targetId=' + encodeURIComponent(targetId),
        }).then();
    }

    return false;
}

let items = document.querySelectorAll('.drag-target');
items.forEach(function(item) {
    item.addEventListener('dragstart', handleDragStart);
    item.addEventListener('dragover', handleDragOver);
    item.addEventListener('dragend', handleDragEnd);
    item.addEventListener('drop', handleDrop);
});

let link = document.getElementById("assign-ter-button").getElementsByTagName("a")[0];
let overlay = document.getElementById('overlay');
let yesButton = document.getElementById("overlay-yes-button");
let noButton = document.getElementById("overlay-no-button");

link.addEventListener("click", function(e) {
    e.preventDefault();
    overlay.style.display = "block";
});

yesButton.addEventListener("click", function() {
    overlay.style.display = "none";
    window.location.href = link.href;
});

noButton.addEventListener("click", function() {
    overlay.style.display = "none";
    alert("Action annulée");
});
