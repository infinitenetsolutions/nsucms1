<?php
include '../../framwork/main.php';
$limit = 50;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$s_no = $start_from + 1;
$condition = '1 LIMIT ' . $start_from . ',' . $limit;
searchWithPaginationAll("tbl_prospectus_view", $limit, 'nsuniv-prospectus-enquiry', 'true', 'edit', 'delete', 'Products List', $condition);
?>
