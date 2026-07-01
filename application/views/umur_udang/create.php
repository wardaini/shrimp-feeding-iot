<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">
		<i class="fas fa-fw fa-calendar"></i> Data Umur Udang
	</h1>

	<!-- 🔹 TOMBOL KEMBALI (RESPONSIVE FIX) -->

	<!-- Mobile -->
	<a href="<?= base_url('Umur_udang'); ?>" 
	   class="btn btn-secondary btn-block d-sm-none mt-3">
		<i class="fas fa-arrow-left mr-1"></i> Kembali
	</a>

	<!-- Desktop -->
	<a href="<?= base_url('Umur_udang'); ?>" 
	   class="btn btn-secondary btn-icon-split d-none d-sm-inline-flex">
		<span class="icon text-white-50">
			<i class="fas fa-arrow-left"></i>
		</span>
		<span class="text">Kembali</span>
	</a>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">
			<i class="fas fa-fw fa-plus"></i> Tambah Data Umur Udang
		</h6>
	</div>

	<?php echo form_open('Umur_udang/store'); ?>
	<div class="card-body">
		<div class="row">
			<div class="form-group col-md-12">
				<label class="font-weight-bold">Umur Udang (DOC)</label>
				<input type="text" name="umur_udang" required class="form-control" />
			</div>

			<div class="form-group col-md-12">
				<label class="font-weight-bold">Frekuensi Pakan</label>
				<input type="number" name="frekuensi_pakan" required class="form-control" />
			</div>
		</div>
	</div>

	<!-- 🔹 TOMBOL SIMPAN & RESET (MOBILE FRIENDLY) -->
	<div class="card-footer">
		<button type="submit" class="btn btn-primary btn-block mb-2">
			<i class="fa fa-save"></i> Simpan
		</button>
		<button type="reset" class="btn btn-info btn-block">
			<i class="fa fa-sync-alt"></i> Reset
		</button>
	</div>

	<?php echo form_close(); ?>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>
