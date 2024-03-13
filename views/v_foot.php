</div>
</body>
<script>
    //function for close a pop-up-box
    function closePopUp() {
        //delete cookie errorMessage
        document.cookie = "errorMessage=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        const urlParams = new URLSearchParams(window.location.search);
        const actionParam = urlParams.get('action');
        //return to view page if an other action is selected in url
        if (actionParam !== 'view' && actionParam !== null) {
            //update url
            urlParams.set('action', 'view');
            urlParams.delete('id');
            window.history.replaceState({}, '', `${window.location.pathname}?${urlParams}`);
        }
        //desable pop up
        const popUpDiv = document.querySelector(".pop-up-box");
        popUpDiv.style.display = "none";
    }

    // Listener for remove pop Up when click out off him
    document.addEventListener("click", function(event) {
        const popUpDiv = document.querySelector(".pop-up-box");
        if (!popUpDiv.contains(event.target)) {
            // close pop up
            closePopUp();
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/icons-react/dist/index.umd.min.js"></script>

</html>