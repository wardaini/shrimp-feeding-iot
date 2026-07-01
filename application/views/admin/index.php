<?php $this->load->view('layouts/header_admin'); ?>

<?php if($this->session->userdata('id_user_level') == '1'): ?>
<div class="mb-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-home"></i> Dashboard</h1>
    </div>
	
    <!-- Content Row -->
    <div class="alert alert-primary">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Selamat datang <span class="text-uppercase"><b><?= $this->session->username; ?>!</b></span>
    </div>

    <div class="row">
		
		<!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Suhu Air <sup>O</sup>C
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="ceksensor">Loading...</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-thermometer-full fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Jumlah Pakan (KG)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Earnings (Monthly) Card Example -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Pakan Diberikan (KG/Hari)</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Pending Requests Card Example -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                pakan selanjutnya</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">10.00</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <!-- <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4"> -->
                                <!-- Card Header - Dropdown -->
                                <!-- <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pakan Harian</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- Card Body -->
                                <!-- <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
    </div>
</div>
<?php endif; ?>
<?php if($this->session->userdata('id_user_level') == '2'): ?>
<div class="mb-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-home"></i> Dashboard</h1>
    </div>
	
    <!-- Content Row -->
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Selamat datang <span class="text-uppercase"><b><?= $this->session->username; ?>!</b></span> Anda bisa mengoperasikan sistem dengan wewenang tertentu melalui pilihan menu di bawah.
    </div>
    <div class="row">
		
		<div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="<?= base_url('Login/home'); ?>" class="text-secondary text-decoration-none">Dashboard</a></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="<?= base_url('Perhitungan/hasil'); ?>" class="text-secondary text-decoration-none">Data Hasil Akhir</a></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="<?= base_url('Profile'); ?>" class="text-secondary text-decoration-none">Data Profile</a></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<?php $this->load->view('layouts/footer_admin'); ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadSuhu() {
        $.ajax({
            url: "<?= base_url('suhu/get_latest') ?>", // ambil dari controller
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (data) {
                    $("#ceksensor").text(data.suhu + " °C");
                }
            }
        });
    }

    // Panggil setiap 2 detik
    setInterval(loadSuhu, 10);
    loadSuhu();
</script>