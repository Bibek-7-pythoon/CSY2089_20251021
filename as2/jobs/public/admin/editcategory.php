<?php
$id = isset($_GET['id']) ? '&id=' . urlencode($_GET['id']) : '';
header('Location: index.php?action=editCategory' . $id);
exit;
