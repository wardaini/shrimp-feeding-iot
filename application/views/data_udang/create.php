<?php $this->load->view('layouts/header_admin'); ?>

<!-- ===== HEADER ===== -->
<div class="d-sm-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
	<h1 class="h3 mb-3 mb-sm-0 text-gray-800">
		<i class="fas fa-fw fa-calendar"></i> Data Udang
	</h1>

	<a href="<?= base_url('Data_udang'); ?>"
	   class="btn btn-secondary btn-icon-split align-self-start align-self-sm-auto">
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
			<i class="fas fa-fw fa-plus"></i> Tambah Data Udang
		</h6>
	</div>

	<?php echo form_open('data_udang/submit'); ?>
	<div class="card-body">
		<div class="row">

			<div class="form-group col-12">
				<label class="font-weight-bold">Umur Udang (DOC)</label>
				<input type="number" name="umur_udang" id="umur_udang"
					   required class="form-control" autocomplete="off">
			</div>

			<div class="form-group col-12">
				<label class="font-weight-bold">Populasi</label>
				<input type="number" name="populasi" id="populasi"
					   required class="form-control" autocomplete="off">
			</div>

			<div class="form-group col-12">
				<label class="font-weight-bold">Pilih Rentang Umur Udang</label>
				<select name="id_umur" id="id_umur" required class="form-control">
					<?php foreach ($umur_udang_options as $row) { ?>
						<option value="<?= $row->id_umur; ?>">
							<?= $row->umur_udang; ?>
						</option>
					<?php } ?>
				</select>
			</div>

		</div>
	</div>

	<!-- ===== FOOTER BUTTON ===== -->
	<div class="card-footer">
		<div class="d-flex flex-column flex-sm-row justify-content-end">
			<button type="submit" class="btn btn-primary mb-2 mb-sm-0 mr-sm-2">
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
