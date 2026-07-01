<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-4">
	<h1 class="h3 mb-3 mb-sm-0 text-gray-800">
		<i class="fas fa-fw fa-pen"></i> Edit Data Pakan Hari Ini
	</h1>

	<!-- BUTTON KEMBALI -->
	<a href="<?= site_url('Jadwal/index'); ?>"
	   class="btn btn-secondary btn-block d-sm-none mb-2">
		<i class="fas fa-arrow-left mr-1"></i> Kembali
	</a>

	<a href="<?= site_url('Jadwal/index'); ?>"
	   class="btn btn-secondary btn-icon-split d-none d-sm-inline-flex">
		<span class="icon text-white-50">
			<i class="fas fa-arrow-left"></i>
		</span>
		<span class="text">Kembali</span>
	</a>
</div>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">
			<i class="fas fa-fw fa-edit"></i> Edit Data Pakan Hari Ini
		</h6>
	</div>

	<form action="<?= base_url('Jadwal/update/' . $jadwal->id_jadwal_udang); ?>" method="post">
		<div class="card-body">
			<div class="form-group">
				<label for="jadwal" class="font-weight-bold">Jadwal</label>
				<input
					type="time"
					name="jadwal"
					id="jadwal"
					class="form-control"
					value="<?= $jadwal->jadwal; ?>"
					required
					autocomplete="off">
			</div>
		</div>

		<div class="card-footer text-right">
			<button type="submit" class="btn btn-success btn-block btn-sm-inline">
				<i class="fa fa-save"></i> Simpan
			</button>
		</div>
	</form>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>
