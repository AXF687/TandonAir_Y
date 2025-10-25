<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<?php
$db = \Config\Database::connect();
$query = $db->query('SELECT * FROM kendalirelay');
$row = $query->getRow();
?>
<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Kendali relay</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Static Navigation</li>
      </ol>
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Relay</h5>
          <p class="card-text">
            Status : &nbsp;&nbsp; <button <?php if ($row->relay == 1) { ?> class="btn btn-lg btn-secondary rounded-pill"
              <?php } else { ?> class="btn btn-lg btn-success rounded-pill" <?php } ?>
              onclick="ubah('<?= $row->id; ?>')">&nbsp;&nbsp;&nbsp;<?php if ($row->relay == 1) { ?> Kontak Relay OFF
              <?php } else { ?> Kontak Relay ON <?php } ?>&nbsp;&nbsp;&nbsp;</button>
          </p>
        </div>
      </div>
      <div style="height: 100vh"></div>
    </div>
  </main>

  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    function ubah(id) {
      $.ajax({
        type: 'GET',
        url: '<?= base_url("nilai-relay/"); ?>' + id,
        data: {
          _method: 'GET',
          id: id
        },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            window.location.href = "<?= base_url('kendali'); ?>"
          }
        }
      })
    }
  </script>

  <?= $this->endSection('content'); ?>