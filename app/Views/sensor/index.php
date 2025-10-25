<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Temperature & humidity monitoring</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Static Navigation</li>
      </ol>
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body" style="text-align: center;">
              <h5 class="card-title"><i class="bi-thermometer-sun"></i> Sensor Suhu</h5>
              <button type="button" class="btn btn-lg btn-success mb-2">
                Suhu: Normal &nbsp;<span id="ceksuhu" class="badge bg-white text-success">4 &nbsp; <sup>o</sup>C</span>
              </button>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body" style="text-align: center;">
              <h5 class="card-title"><i class="bi-thermometer-snow"></i> Sensor kelembaban</h5>
              <button type="button" class="btn btn-lg btn-warning mb-2">
                Kelembaban: Normal &nbsp;<span id="cekkelembaban" class="badge bg-white text-success">4 &nbsp; (<i>gram/m<sup>3</sup></i>)</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Sensor Suhu</h5>
              <canvas id="myChart"></canvas>
              <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

              <script>
                let dataSuhu;
                setInterval(tampilGrafik, 3000);

                function tampilGrafik() {
                  $.ajax({
                    type: 'GET',
                    url: '<?= base_url('sensor/grafiksuhu'); ?>',
                    data: {
                      functionName: 'getSuhu'
                    },
                    success: function(response) {
                      //console.log(response)
                      let grafikSuhu = JSON.parse(response)
                      let xsuhu = collect(grafikSuhu).map(function(item) {
                        return item.suhu
                      }).all()
                      console.log(xsuhu)
                      dataSuhu = xsuhu;
                    }
                  });
                }

                var categories = ["Suhu"];
                var initialData = [dataSuhu];
                var updatedDataSet;
                var ctx = document.getElementById("myChart");
                var barChart = new Chart(ctx, {
                  type: "bar",
                  data: {
                    labels: categories,
                    datasets: [{
                      label: dataSuhu + ' Derajat Celcius',
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
                    label: dataSuhu + ' Derajat Celcius',
                    data: data,
                    backgroundColor: [
                      'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                      'rgb(255, 99, 132)',
                    ],
                    borderWidth: 1
                  });
                  chart.update();
                }

                // update each 1 sec
                setInterval(function() {
                  updatedDataSet = [dataSuhu];
                  console.log(updatedDataSet);
                  updateBarGraph(barChart, updatedDataSet);
                }, 3000);
              </script>
            </div>
          </div>
        </div>

        <!-- kelembaban -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Sensor Kelembaban</h5>

              <!-- Bar Chart -->
              <canvas id="barChart2" style="max-height: 400px;"></canvas>
              <script>
                let dataKelembaban;
                setInterval(tampilGrafik2, 3000);

                function tampilGrafik2() {
                  $.ajax({
                    type: 'GET',
                    url: '<?= base_url('sensor/grafiksuhu'); ?>',
                    data: {
                      functionName: 'getSuhu'
                    },
                    success: function(response) {
                      //console.log(response)
                      let grafikKelembaban = JSON.parse(response)
                      let xkelembaban = collect(grafikKelembaban).map(function(item) {
                        return item.kelembaban
                      }).all()
                      console.log(xkelembaban)
                      dataKelembaban = xkelembaban;
                    }
                  });
                }

                var categories2 = ["Kelembaban"];
                var initialData2 = [dataKelembaban]
                var updatedDataSet2;
                var ctx2 = document.getElementById("barChart2");
                var barChart3 = new Chart(ctx2, {
                  type: 'bar',
                  data: {
                    labels: categories2,
                    datasets: [{
                      label: dataKelembaban + ' %',
                      data: initialData2
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

                function updateBarGraph2(chart, data) {
                  console.log(chart.data);
                  chart.data.datasets.pop();
                  chart.data.datasets.push({
                    label: dataKelembaban + ' %',
                    data: data,
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgb(54, 162, 235)'],
                    borderWidth: 1
                  });
                  chart.update();
                }

                // update each 1 sec
                setInterval(function() {
                  updatedDataSet2 = [dataKelembaban];
                  console.log(updatedDataSet2);
                  updateBarGraph2(barChart3, updatedDataSet2);
                }, 3000);
              </script>
              <!-- End Bar CHart -->

            </div>
          </div>
        </div>
      </div>

  </main>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- load otomatis / realtime -->
  <script type="text/javascript">
    $(document).ready(function() {
      setInterval(function() {
        $("#ceksuhu").load("<?= base_url('ceksuhu'); ?>");
        $("#cekkelembaban").load("<?= base_url('cekkelembaban'); ?>");
      }, 1000);
    });
  </script>

  <?= $this->endSection('content'); ?>