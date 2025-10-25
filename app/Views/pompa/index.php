<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<?php
$db = \Config\Database::connect();
$query = $db->query('SELECT * FROM pompa');
$row = $query->getRow();

// Get current mode
$modeQuery = $db->query('SELECT * FROM mode WHERE id = 1');
$ModeSaiki = $modeQuery->getRow()->mode;
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 ">Water Level Monitoring And Control</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Static Navigation</li>
            </ol>

            <div class="row">
                <div class="col-lg-12 mt-1">
                    <div class="card" style="background-color: #C1D8C3;">
                        <div class="card-body" style="text-align: center;">
                            <h5 class="card-title"><i class="bi-thermometer-sun text-white"></i> Water level monitor</h5>
                            <button type="button" class="btn btn-lg mb-2 text-white" style="background-color: #6A9C89; border-color: #6A9C89;">
                                Level: &nbsp;<span id="cekpompa" class="badge bg-white" style="color: #6A9C89;">Loading...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-6 mt-1">
                    <div class="card" style="background-color: #C1D8C3;">
                        <div class="card-body" style="text-align: center;">
                            <h5 class="card-title">Status Relay : </h5>
                            <p class="card-text">
                                &nbsp;&nbsp; <button <?php if ($row->manual == 1) { ?> class="btn btn-lg rounded-pill" style="background-color: #FFF5E4; border-color: #FFF5E4;"
                                    <?php } else { ?> class="btn btn-lg rounded-pill" style="background-color: #6A9C89; border-color: #6A9C89;" <?php } ?>
                                    onclick="ganti('<?= $row->id; ?>')" <?= ($ModeSaiki == 'Auto') ? 'disabled' : ''; ?>>&nbsp;&nbsp;&nbsp;<?php if ($row->manual == 1) { ?> Kontak Relay OFF
                                <?php } else { ?> Kontak Relay ON <?php } ?>&nbsp;&nbsp;&nbsp;</button>
                            </p>
                            <small class="text-muted"><?= ($ModeSaiki == 'Auto') ? 'Mode Auto aktif - relay hanya dapat di kontrol saat mode manual' : 'Mode Manual aktif - Anda dapat mengontrol relay'; ?></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-1">
                    <div class="card" style="background-color: #C1D8C3;">
                        <div class="card-body" style="text-align: center;">
                            <h5 class="card-title"><i class="bi-gear-fill text-white"></i> Pompa Mode</h5>
                            <p class="card-text">
                                Mode saat ini: <strong><?= $ModeSaiki; ?></strong>
                            </p>
                            <button id="switchMode" class="btn btn-lg mb-2 text-white" style="background-color: #6A9C89; border-color: #6A9C89;">
                                Ubah ke <?= ($ModeSaiki == 'Auto') ? 'Manual' : 'Auto'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-6 mt-1">
                    <div class="card" style="background-color: #FFF5E4;">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Pompa</h5>
                            <canvas id="myChart"></canvas>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                            <script>
                                let dataPompa;
                                setInterval(tampilGrafik, 1000);

                                function tampilGrafik() {
                                    $.ajax({
                                        type: 'GET',
                                        url: '<?= base_url('pompa/grafikpompa'); ?>',
                                        data: {
                                            functionName: 'getPompa'
                                        },
                                        success: function(response) {
                                            //console.log(response)
                                            let grafikPompa = JSON.parse(response)
                                            let xpompa = collect(grafikPompa).map(function(item) {
                                                return item.pompa
                                            }).all()
                                            console.log(xpompa)
                                            dataPompa = xpompa;
                                        }
                                    });
                                }

                                var categories = ["Pompa"];
                                var initialData = [dataPompa];
                                var updatedDataSet;
                                var ctx = document.getElementById("myChart");
                                var barChart = new Chart(ctx, {
                                    type: "bar",
                                    data: {
                                        labels: categories,
                                        datasets: [{
                                            label: dataPompa + ' CM',
                                            data: initialData
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });

                                function updateBarGraph(chart, data) {
                                    console.log(chart.data);
                                    chart.data.datasets.pop();
                                    chart.data.datasets.push({
                                        label: dataPompa + ' CM',
                                        data: data,
                                        backgroundColor: [
                                            'rgba(0, 121, 73, 0.28)'
                                        ],
                                        borderColor: [
                                            'rgba(0, 121, 73, 0.28)',
                                        ],
                                        borderWidth: 1
                                    });
                                    chart.update();
                                }

                                // update per 1 detik
                                setInterval(function() {
                                    updatedDataSet = [dataPompa];
                                    console.log(updatedDataSet);
                                    updateBarGraph(barChart, updatedDataSet);
                                }, 1000);
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-1">
                    <div class="card dashboard-glass h-100" style="background-color: #FFF5E4;">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div>
                                    <h3 class="mb-0">Pompa Relay Status</h3>
                                    <span class="text-muted">Hanya Berfungsi Saat Mode Auto</span>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <div id="relayStatus" class="status-pulse btn btn-lg rounded-pill px-5">
                                    <span class="fw-bold text-white">Loading...</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Pompa Level: <span id="waterLevelDisplay">0</span> cm</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function() {
                $("#cekpompa").load("<?= base_url('cekpompa'); ?>");
            }, 1000);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        function ganti(id) {
            $.ajax({
                type: 'GET',
                url: '<?= base_url("value-relay/"); ?>' + id,
                data: {
                    _method: 'GET',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = "<?= base_url('manual'); ?>"
                    }
                }
            })
        }

        // Script mode
        $(document).ready(function() {
            $('#switchMode').click(function() {
                const newMode = ($(this).text().trim() === 'Ubah ke Manual') ? 'Manual' : 'Auto';

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("switch-mode"); ?>',
                    data: {
                        mode: newMode
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.success);
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error changing mode: ' + error);
                    }
                });
            });
        });
    </script>

<script>
    
    let lastRelayStatus = null;
    
    function updateRelayStatus() {
        $.ajax({
            url: '<?= base_url('pompa/grafikpompa') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const pumpStatus = parseInt(response[0].pompa);
                const relayElement = $('#relayStatus');
                const waterLevelDisplay = $('#waterLevelDisplay');
                
                // Update tampilan level air
                waterLevelDisplay.text(pumpStatus);
                
                // Logika status relay
                if (pumpStatus >= 14) {
                    // Relay ON (Merah)
                    relayElement.removeClass('btn-danger btn-warning').addClass('btn-success');
                    relayElement.find('span').text('ON');
                    lastRelayStatus = 'ON';
                } else if (pumpStatus <= 3) {
                    // Relay OFF (Hijau)
                    relayElement.removeClass('btn-success btn-warning').addClass('btn-danger');
                    relayElement.find('span').text('OFF');
                    lastRelayStatus = 'OFF';
                } else {
                    // Status antara 4-13 cm
                    if (lastRelayStatus === 'ON') {
                        relayElement.removeClass('btn-danger btn-warning').addClass('btn-success');
                        relayElement.find('span').text('ON');
                    } else {
                        relayElement.removeClass('btn-success btn-warning').addClass('btn-danger');
                        relayElement.find('span').text('OFF');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Pompa error!! ada kesalahan:', error);
            }
        });
    }

    // Update status ben 100 ml dtk
    setInterval(updateRelayStatus, 100);

    // Panggil fungsi pertama kali saat halaman dimuat
    $(document).ready(function() {
        updateRelayStatus();
    });
</script>

    <?= $this->endSection('content'); ?>