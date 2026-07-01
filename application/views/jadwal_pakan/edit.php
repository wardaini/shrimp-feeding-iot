<?php $this->load->view('layouts/header_admin'); ?>

<!-- ===== HEADER ===== -->
<div class="d-sm-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
	<h1 class="h4 mb-3 mb-sm-0 text-gray-800">
		<i class="fas fa-fw fa-clock"></i> Edit Jadwal Pakan
	</h1>

	<a href="<?= base_url('jadwal_pakan'); ?>"
	   class="btn btn-secondary btn-icon-split align-self-start align-self-sm-auto">
		<span class="icon text-white-50">
			<i class="fas fa-arrow-left"></i>
		</span>
		<span class="text">Kembali</span>
	</a>
</div>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">
			<i class="fa fa-edit"></i> Form Edit Jadwal
		</h6>
	</div>

	<div class="card-body">
		<?= form_open('jadwal_pakan/update/' . $jadwal->id_jadwal); ?>

		<div class="form-group">
			<label class="font-weight-bold">Jadwal Pakan</label>
			<input type="time" name="jadwal" class="form-control"
				   value="<?= set_value('jadwal', $jadwal->jadwal) ?>" required>
		</div>

		<div class="d-flex flex-column flex-sm-row justify-content-end mt-4">
			<button type="submit" class="btn btn-primary mb-2 mb-sm-0 mr-sm-2">
				<i class="fa fa-save"></i> Update
			</button>
			<a href="<?= base_url('jadwal_pakan'); ?>" class="btn btn-secondary">
				<i class="fa fa-arrow-left"></i> Kembali
			</a>
		</div>

		<?= form_close(); ?>
	</div>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>
