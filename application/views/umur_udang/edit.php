<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">
		<i class="fas fa-fw fa-pen"></i> Edit Data Umur Udang
	</h1>

	<!-- 🔹 TOMBOL KEMBALI RESPONSIVE -->

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

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">
			<i class="fas fa-fw fa-edit"></i> Edit Data Umur Udang
		</h6>
	</div>

	<?php echo form_open('Umur_udang/update/' . $umur_udang->id_umur); ?>
	<div class="card-body">
		<div class="row">
			<?= form_hidden('id_umur', $umur_udang->id_umur); ?>

			<div class="form-group col-md-12">
				<label class="font-weight-bold">Umur Udang (DOC)</label>
				<input type="text" name="umur_udang"
					value="<?= $umur_udang->umur_udang; ?>"
					required class="form-control" />
			</div>

			<div class="form-group col-md-12">
				<label class="font-weight-bold">Frekuensi Pakan</label>
				<input type="number" name="frekuensi_pakan"
					value="<?= $umur_udang->frekuensi_pakan; ?>"
					required class="form-control" />
			</div>
		</div>
	</div>

	<!-- 🔹 FOOTER TOMBOL RESPONSIVE -->
	<div class="card-footer">

		<!-- Mobile -->
		<div class="d-sm-none">
			<button type="submit" class="btn btn-success btn-block mb-2">
				<i class="fa fa-save"></i> Simpan
			</button>
			<button type="reset" class="btn btn-info btn-block">
				<i class="fa fa-sync-alt"></i> Reset
			</button>
		</div>

		<!-- Desktop -->
		<div class="d-none d-sm-flex justify-content-end">
			<button type="submit" class="btn btn-success mr-2">
				<i class="fa fa-save"></i> Simpan
			</button>
			<button type="reset" class="btn btn-info">
				<i class="fa fa-sync-alt"></i> Reset
			</button>
		</div>

	</div>
	<?php echo form_close(); ?>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>
