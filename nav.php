<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="main.php">BeeShy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="main.php" id="curNew">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tags.php" id="curTag">Tags</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ratings.php" id="curRate">Ratings</a>
            </li>
        </ul>
        <form class="form-inline" style="padding-right: 100px;">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName'];?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profile.php?id=<?php echo $_SESSION['user']['id']?>" id="curPro">Profile</a>
                        <?php
                            if($_SESSION['user']['type'] == 'client'){
                                echo '<a class="dropdown-item" href="edit_profile.php" id="curEdit">Edit profile</a>';
                                echo '<a class="dropdown-item" href="create.php" id="curCreate">Create</a>';
                            } else{
                                echo '<a class="dropdown-item" href="reports.php" id="curCreate">Reports</a>';
                            }
                        ?>
                        <div class= "dropdown-divider"></div>
                        <a class="dropdown-item" href="auth/signOut.php">Sign out</a>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</nav>