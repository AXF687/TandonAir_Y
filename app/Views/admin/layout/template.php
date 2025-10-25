<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?= base_url('asset-admin'); ?>/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?= $this->include('admin/layout/header.php'); ?>

<div id="layoutSidenav">
    <!-- panggil menu.php -->
    <?= $this->include('admin/layout/menu.php'); ?>
    <!-- potong -->

    <?= $this->renderSection('content') ?>
    <?= $this->include('admin/layout/footer.php'); ?>

</html>