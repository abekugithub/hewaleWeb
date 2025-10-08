    </div>
</div>
    <script src="media/js/notify.min.js" ></script>
<script>
        /* Modal Builder JS */
        function closeMod(modal = string) {
            var modal = document.getElementById(modal);
            modal.style.display = "none";
        };

        function mod(modal = string) {
            var modal = document.getElementById(modal);
            var span = document.getElementsByClassName("close");
            modal.style.display = "block";


            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>

</body>

</html>