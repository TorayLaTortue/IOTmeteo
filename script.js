document.addEventListener('DOMContentLoaded', function() {
    // Gestion du modal d'inscription
    var modalInscription = document.getElementById('inscriptionModal');
    var btnInscription = document.getElementById('modalBtnInscription');
    var spanInscription = document.getElementsByClassName('close')[0]; // Utilisez l'indice 0 pour le premier élément 'close'

    // Ouvrir le modal d'inscription
    btnInscription.onclick = function() {
        modalInscription.style.display = 'block';
    }

    // Fermer le modal d'inscription en cliquant sur 'x'
    spanInscription.onclick = function() {
        modalInscription.style.display = 'none';
    }

    // Fermer le modal d'inscription en cliquant en dehors
    window.onclick = function(event) {
        if (event.target == modalInscription) {
            modalInscription.style.display = 'none';
        }
    }
});