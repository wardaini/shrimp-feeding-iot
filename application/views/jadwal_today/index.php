<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">
		<i class="fas fa-fw fa-list"></i> Pakan Hari Ini
	</h1>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">
			<i class="fa fa-table"></i> Data Pakan Hari Ini
		</h6>
	</div>

	<!-- ================= DESKTOP TABLE ================= -->
	<div class="card-body d-none d-md-block">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%">
				<thead class="bg-primary text-white text-center">
					<tr>
						<th>Populasi</th>
						<th>Umur Udang</th>
						<th>Pakan Harian (gram)</th>
						<th>Frekuensi Pakan</th>
						<th>Pakan / Frekuensi (gram)</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php if (!empty($data_udang)): foreach ($data_udang as $udang): ?>
						<tr>
							<td><?= $udang['populasi']; ?></td>
							<td><?= $udang['umur_udang']; ?></td>
							<td><?= number_format($udang['pakan_harian'], 0); ?></td>
							<td>
								<?php
								if ($udang['umur_udang'] <= 10) echo 4;
								elseif ($udang['umur_udang'] <= 20) echo 6;
								elseif ($udang['umur_udang'] <= 30) echo 8;
								else echo '-';
								?>
							</td>
							<td><?= number_format($udang['pakan_per_frekuensi'], 0); ?></td>
						</tr>
					<?php endforeach; else: ?>
						<tr>
							<td colspan="5" class="text-center">Tidak ada data</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- ================= MOBILE TABLE ================= -->
	<div class="card-body d-block d-md-none">
		<?php if (!empty($data_udang)): foreach ($data_udang as $udang): ?>
			<table class="table table-bordered mb-3">
				<tr>
					<th width="45%">Populasi</th>
					<td><?= $udang['populasi']; ?></td>
				</tr>
				<tr>
					<th>Umur Udang</th>
					<td><?= $udang['umur_udang']; ?></td>
				</tr>
				<tr>
					<th>Pakan Harian</th>
					<td><?= number_format($udang['pakan_harian'], 0); ?> gram</td>
				</tr>
				<tr>
					<th>Frekuensi</th>
					<td>
						<?php
						if ($udang['umur_udang'] <= 10) echo 4;
						elseif ($udang['umur_udang'] <= 20) echo 6;
						elseif ($udang['umur_udang'] <= 30) echo 8;
						else echo '-';
						?>
					</td>
				</tr>
				<tr class="bg-light">
					<th>Pakan / Frek</th>
					<td><strong><?= number_format($udang['pakan_per_frekuensi'], 0); ?> gram</strong></td>
				</tr>
			</table>
		<?php endforeach; else: ?>
			<p class="text-center">Tidak ada data</p>
		<?php endif; ?>
	</div>
</div>

<!-- ================= JADWAL ================= -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Jadwal Pakan Hari Ini</h6>
	</div>

	<!-- DESKTOP -->
	<div class="card-body d-none d-md-block">
		<div class="table-responsive">
			<table class="table table-bordered text-center">
				<thead class="bg-primary text-white">
					<tr>
						<th>No</th>
						<th>Jadwal</th>
						<th>Tanggal</th>
						<th>Pakan</th>
						<th>Suhu</th>
						<th>Fuzzy</th>
						<th>Berat Akhir</th>
						<th>Selisih</th>
						<th>%</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody id="jadwal-body">
					<?php if (!empty($jadwal_today)): foreach ($jadwal_today as $i => $j): ?>
						<?php
						$sel = (!is_null($j->berat_akhir) && $j->fuzzy_pakan)
							? $j->berat_akhir - $j->fuzzy_pakan : null;
						$persen = ($sel && $j->fuzzy_pakan) ? ($sel / $j->fuzzy_pakan) * 100 : null;
						?>
						<tr>
							<td><?= $i + 1; ?></td>
							<td><?= $j->jadwal; ?></td>
							<td><?= $j->tanggal; ?></td>
							<td><?= number_format($j->pakan_per_frekuensi ?? 0); ?></td>
							<td><?= $j->suhu; ?></td>
							<td><?= $j->fuzzy_pakan; ?></td>
							<td><?= $j->berat_akhir; ?></td>
							<td><?= $sel; ?></td>
							<td><?= $persen ? number_format($persen,2).'%' : ''; ?></td>
							<td>
								<a href="<?= base_url('Jadwal/edit/'.$j->id_jadwal_udang); ?>" class="btn btn-warning btn-sm">Edit</a>
								<a href="<?= base_url('Jadwal/delete/'.$j->id_jadwal_udang); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
							</td>
						</tr>
					<?php endforeach; else: ?>
						<tr><td colspan="10">Tidak ada data</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

<!-- MOBILE -->
<div class="card-body d-block d-md-none">
	<?php if (!empty($jadwal_today)): foreach ($jadwal_today as $jadwal): ?>
		<?php
			if (!is_null($jadwal->berat_akhir) && !is_null($jadwal->fuzzy_pakan) && $jadwal->fuzzy_pakan != 0) {
				$selisih = $jadwal->berat_akhir - $jadwal->fuzzy_pakan;
				$selisih_percent = ($selisih / $jadwal->fuzzy_pakan) * 100;
			} else {
				$selisih = null;
				$selisih_percent = null;
			}
		?>

		<table class="table table-bordered mb-3">
			<tr>
				<th width="45%">Jadwal</th>
				<td><?= $jadwal->jadwal; ?></td>
			</tr>
			<tr>
				<th>Tanggal</th>
				<td><?= $jadwal->tanggal; ?></td>
			</tr>
			<tr>
				<th>Pakan Awal</th>
				<td><?= number_format($jadwal->pakan_per_frekuensi ?? 0, 2); ?></td>
			</tr>
			<tr>
				<th>Suhu (°C)</th>
				<td><?= $jadwal->suhu; ?></td>
			</tr>
			<tr>
				<th>Pakan Fuzzy</th>
				<td><?= number_format($jadwal->fuzzy_pakan ?? 0, 2); ?></td>
			</tr>
			<tr>
				<th>Berat Akhir</th>
				<td>
					<?= !is_null($jadwal->berat_akhir) && $jadwal->berat_akhir != 0
						? number_format($jadwal->berat_akhir, 2)
						: '-' ?>
				</td>
			</tr>
			<tr>
				<th>Selisih</th>
				<td>
					<?= !is_null($selisih)
						? number_format($selisih, 2)
						: '-' ?>
				</td>
			</tr>
			<tr>
				<th>Selisih (%)</th>
				<td>
					<?= !is_null($selisih_percent)
						? number_format($selisih_percent, 2) . '%'
						: '-' ?>
				</td>
			</tr>
			<tr class="bg-light">
				<th>Aksi</th>
				<td>
					<a href="<?= base_url('Jadwal/edit/' . $jadwal->id_jadwal_udang); ?>"
					   class="btn btn-warning btn-sm btn-block mb-2">
						Edit
					</a>
					<a href="<?= base_url('Jadwal/delete/' . $jadwal->id_jadwal_udang); ?>"
					   onclick="return confirm('Yakin ingin menghapus data ini?')"
					   class="btn btn-danger btn-sm btn-block">
						Hapus
					</a>
				</td>
			</tr>
		</table>
	<?php endforeach; else: ?>
		<p class="text-center">Tidak ada data yang tersedia.</p>
	<?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function loadJadwal() {
    $.ajax({
        url: "<?= base_url('Jadwal/get_jadwal_today'); ?>",
        method: "GET",
        dataType: "json",
        success: function(data) {

            let html = "";

            data.forEach((j, i) => {

                let sel = (j.berat_akhir != null && j.fuzzy_pakan != null)
                    ? (j.berat_akhir - j.fuzzy_pakan)
                    : "";

                let persen = (sel !== "" && j.fuzzy_pakan != 0)
                    ? ((sel / j.fuzzy_pakan) * 100).toFixed(2) + "%"
                    : "";

                html += `
                <tr>
                    <td>${i+1}</td>
                    <td>${j.jadwal}</td>
                    <td>${j.tanggal}</td>
                    <td>${j.pakan_per_frekuensi ?? 0}</td>
                    <td>${j.suhu ?? ''}</td>
                    <td>${j.fuzzy_pakan ?? ''}</td>
                    <td>${j.berat_akhir ?? ''}</td>
                    <td>${sel}</td>
                    <td>${persen}</td>
                    <td>
                        <a href="<?= base_url('Jadwal/edit/'); ?>${j.id_jadwal_udang}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= base_url('Jadwal/delete/'); ?>${j.id_jadwal_udang}" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                    </td>
                </tr>`;
            });

            $("#jadwal-body").html(html);
        }
    });
}

// load pertama kali
loadJadwal();

// refresh tiap 5 detik
setInterval(loadJadwal, 5000);
</script>

<?php $this->load->view('layouts/footer_admin'); ?>
