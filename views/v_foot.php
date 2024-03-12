</div>
</body>
<script>
    function closeErrorMessage() {
        // Supprimer le cookie errorMessage en définissant une date d'expiration passée
        document.cookie = "errorMessage=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        // Cacher la div contenant le message d'erreur
        const errorMessageDiv = document.querySelector(".errorBox");
        errorMessageDiv.style.display = "none";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/icons-react/dist/index.umd.min.js"></script>

</html>