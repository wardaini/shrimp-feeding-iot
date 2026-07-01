<?php $this->load->view('layouts/header_admin'); ?>

<!-- ===== HEADER ===== -->
<div class="d-sm-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
	<h1 class="h3 mb-3 mb-sm-0 text-gray-800">
		<i class="fas fa-fw fa-pen"></i> Edit Data Udang
	</h1>

	<a href="<?= site_url('Data_udang/index'); ?>"
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
			<i class="fas fa-fw fa-edit"></i> Edit Data Udang
		</h6>
	</div>

	<form action="<?= site_url('Data_udang/update'); ?>" method="post">
		<div class="card-body">
			<div class="row">

				<input type="hidden" name="id_data" value="<?= $data_udang['id_data']; ?>">

				<div class="form-group col-12">
					<label class="font-weight-bold">Umur Udang (DOC)</label>
					<input type="number" name="umur_udang" id="umur_udang"
						   class="form-control"
						   value="<?= $data_udang['umur_udang']; ?>" required>
				</div>

				<div class="form-group col-12">
					<label class="font-weight-bold">Populasi</label>
					<input type="number" name="populasi" id="populasi"
						   class="form-control"
						   value="<?= $data_udang['populasi']; ?>" required>
				</div>

				<div class="form-group col-12">
					<label class="font-weight-bold">Rentang Umur</label>
					<select class="form-control" name="id_umur" required>
						<option value="">-- Pilih Rentang Umur --</option>
						<?php foreach ($umur_udang as $umur): ?>
							<option value="<?= $umur['id_umur']; ?>"
								<?= $umur['id_umur'] == $data_udang['id_umur'] ? 'selected' : ''; ?>>
								<?= $umur['umur_udang']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

			</div>
		</div>

		<!-- ===== FOOTER BUTTON ===== -->
		<div class="card-footer">
			<div class="d-flex flex-column flex-sm-row justify-content-end">
				<button type="submit" class="btn btn-success mb-2 mb-sm-0 mr-sm-2">
					<i class="fa fa-save"></i> Simpan
				</button>
				<button type="reset" class="btn btn-info">
					<i class="fa fa-sync-alt"></i> Reset
				</button>
			</div>
		</div>
	</form>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>
