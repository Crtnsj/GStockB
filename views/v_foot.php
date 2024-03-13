</div>
</body>
<script>
    function closeErrorMessage() {
        // Supprimer le cookie errorMessage en définissant une date d'expiration passée
        document.cookie = "errorMessage=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        // Cacher la div contenant le message d'erreur
        const errorMessageDiv = document.querySelector(".pop-up-box");
        errorMessageDiv.style.display = "none";
    }

    // Gestionnaire d'événement pour le clic sur le document
    document.addEventListener("click", function(event) {
        const errorMessageDiv = document.querySelector(".pop-up-box");
        // Vérifier si l'élément cliqué est en dehors de la boîte d'erreur
        if (!errorMessageDiv.contains(event.target)) {
            // Fermer la boîte d'erreur
            closeErrorMessage();
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/icons-react/dist/index.umd.min.js"></script>

</html>