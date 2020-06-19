<footer class="page-footer font-small bg-dark text-white pt-4 mt-5">
    <div class="container text-center text-md-left mt-5">
        <div class="row mt-3">
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold">BeeShy</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>Tell us about your observations and concerns. Do not be shy!</p>
                <p>Good Luck & Have Fun!</p>
            </div>
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold">Useful links</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <a href="main.php">News</a>
                </p>
                <p>
                    <a href="tags.php">Tags</a>
                </p>
                <?php
                if ($_SESSION['user']['type'] == 'client')
                    echo '<p><a href="create.php">Create</a></p>';
                ?>
                <p>
                    <a href="ratings.php">Ratings</a>
                </p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

                <h6 class="text-uppercase font-weight-bold">Contact</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <i class="fas fa-home mr-3"></i> Nur-sultan, KZ</p>
                <p>
                    <i class="fas fa-envelope mr-3"></i> beeshy@astanait.edu.kz</p>
                <p>
                    <i class="fas fa-phone mr-3"></i> + 7 777 111 2233</p>
                <p>
                    <i class="fas fa-phone mr-3"></i> + 7 776 208 6923</p>

            </div>
        </div>
    </div>
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
        <a> Shyngys Rakhad & Beigut Beisenkhan</a>
    </div>

</footer>
