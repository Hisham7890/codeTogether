<!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container d-md-flex py-4">
            <div class="text-center w-100">
                
                <div class="credits">
                    Developed by 444 students developers 
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->
    <div id="preloader"></div>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/scripts.js"></script>
    <?php if(basename($_SERVER['PHP_SELF']) == "my_questions.php") { ?>
    <script src="assets/js/my_questions.js"></script>
    <?php } else if(basename($_SERVER['PHP_SELF']) == "search.php") { ?>
    <script src="assets/js/search.js"></script>
    <?php }  ?>
</body>
</html>