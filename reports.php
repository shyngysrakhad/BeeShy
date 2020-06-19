<?php
session_start();
include_once 'sessionCheck.php';
?>

<!DOCTYPE html>
<hmtl>
    <head>
        <title>Reports</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            *{
                color: #495057;
            }
            li {
                padding-left: 20px;
                padding-right: 20px;
            }
            .navbar-brand {
                padding-left: 100px;
            }
            .item-content {
                display: flex;
            }
            .title small, .content small {
                width: 200px;
                text-align: right;
            }
            p small {
                display: block;
            }
            .title small {
                font-weight: bold;
            }
            .main{
                display: flex;
                justify-content: space-between;
            }
            .curPage{
                pointer-events: none;
            }
            footer h6, footer p, footer a, footer a:hover{
                color: white;
                text-decoration: none;
            }
            footer hr{
                background-color: white;
            }
            .btn-group-toggle a{
                color: white;
            }
        </style>
    </head>
    <body>
    <?php
    include_once 'nav.php';
    ?>
    <div class="container mt-5">
        <div class="list-group">
            <?php
            require_once 'Report.php';

            $per_page = 5;

            if(isset($_GET["page"])){
                $page = $_GET["page"];
            } else{
                $page = 1;
            }

            $start_from = ($page-1) * $per_page;

                $result = Report::getAllReports($start_from, $per_page);
                $total_pages = ceil(Report::getAllReportsCount() / $per_page);

            $sort = '';
            for ($i = 0; $i < sizeof($result); ++$i){
                $current_report = new Report($result[$i]['report_id']);
                ?>
                <a href="content.php?id=<?php echo $result[$i]['post_id']?>" class="list-group-item list-group-item-action">
                    <div class="item-content">
                        <div class="w-100">
                            <div class="d-flex w-100 justify-content-between content">
                                <h5 class="mb-1">To Post: <?php
                                    require_once 'Post.php';
                                    $po = new Post($result[$i]['post_id']);
                                    echo $po->getTitle()?></h5>
                                <small><?php
                                    require_once 'User.php';
                                    $au = new User($result[$i]['author_id']);
                                    echo $au->getFirstName().' ' . $au->getLastName()?></small>
                            </div>
                            <div class="d-flex w-100 justify-content-between content">
                                <p class="mb-1"><?php echo $result[$i]['content']?></p>
                                <small><?php echo $result[$i]['date_']?></small>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <?php
        print "<div class='btn-group mt-3' role='group' aria-label=\"Pages\">";
        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
                    echo "<a href='?page=$i' class='btn btn-secondary";
            if ($i == $page) echo " curPage active";
            echo "'>$i</a>";
        };
        print "</div>"
        ?>

    </div>
    <?php
    include_once 'footer.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</hmtl>