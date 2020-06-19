<?php
require_once('Database/config.php');

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

if(isset($_GET["page"])){
    $page = $_GET["page"];
} else{
    $page = 1;
}
$per_page = 20;
$start_from = ($page-1) * $per_page;
$sql = "";
$tag = '';
if($_COOKIE['how'] == 'mix'){
    $tag ="sortBy=mix&";
    $sql = "SELECT * FROM users  WHERE user_id != 1 AND user_id != 0 ORDER BY  post_votes * 4 + comment_votes DESC LIMIT  " . $start_from . ", " . $per_page.";";
}
if($_COOKIE['how'] == 'com'){
    $tag ="sortBy=comm&";
    $sql = "SELECT * FROM users  WHERE user_id != 1 AND user_id != 0 ORDER BY  comment_votes DESC LIMIT " . $start_from . ", " . $per_page.";";
}
if($_COOKIE['how'] == 'post'){
    $tag ="sortBy=post&";
    $sql = "SELECT * FROM users  WHERE user_id != 1 AND user_id != 0 ORDER BY  post_votes DESC LIMIT " . $start_from . ", " . $per_page.";";
}
$result = mysqli_query($conn, $sql) or die("Error " . mysqli_error($conn));
if($result)
{
    $rows = mysqli_num_rows($result);

    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
        $cnt = ($page - 1) * $per_page + $i + 1;
        echo "<tr>";
        echo "<th scope='row'>".$cnt."</th>";
        echo "<th><a href='profile.php?id=".$_SESSION['user']['id']."'><img height='40px' width='40px' src='".$row[6]."'></a></th>";
        echo "<th>".$row[1]."</th>";
        echo "<th>".$row[2]."</th>";
        echo "<th>".$row[8]."</th>";
        echo "<th>".$row[9]."</th>";
        echo "</tr>";
    }
    mysqli_free_result($result);
}
echo " </tbody> </table></div>";
$sql = "SELECT COUNT(user_id) AS total FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $per_page);
print "<div class='btn-group mt-3' role='group' aria-label=\"Pages\">";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='?".$tag."page=$i' class='btn btn-secondary";
    if ($i == $page) echo " curPage active";
    echo "'>$i</a>";
};
print "</div>";