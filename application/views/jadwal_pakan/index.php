<?php $this->load->view('layouts/header_admin'); ?>

<!-- ===== HEADER ===== -->
<div class="d-sm-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800 mb-3 mb-sm-0">
		<i class="fas fa-fw fa-clock"></i> Data Jadwal Pakan
	</h1>
</div>

<?= $this->session->flashdata('message'); ?>

<?php if ($umur_udang == NULL): ?>
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="alert alert-info mb-0">
				Data masih kosong.
			</div>
		</div>
	</div>
<?php endif ?>

<?php foreach ($umur_udang as $umur): ?>

	<div class="card shadow mb-4">

		<!-- ===== CARD HEADER ===== -->
		<div class="card-header py-3">
			<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary mb-2 mb-sm-0">
					<i class="fa fa-table"></i> <?= $umur->umur_udang ?>
				</h6>

				<a href="#tambah<?= $umur->id_umur ?>" data-toggle="modal"
				   class="btn btn-sm btn-primary align-self-start align-self-sm-auto">
					<i class="fa fa-plus"></i> Tambah Data
				</a>
			</div>
		</div>

		<!-- ===== MODAL TAMBAH ===== -->
		<div class="modal fade" id="tambah<?= $umur->id_umur ?>" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							<i class="fa fa-plus"></i> Tambah <?= $umur->umur_udang ?>
						</h5>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<?= form_open('Jadwal_pakan/store') ?>
					<div class="modal-body">
						<input type="hidden" name="id_umur" value="<?= $umur->id_umur ?>">
						<div class="form-group">
							<label class="font-weight-bold">Jadwal Pakan</label>
							<input type="time" name="jadwal" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Batal
						</button>
						<button type="submit" class="btn btn-primary">
							Simpan
						</button>
					</div>
					<?= form_close() ?>
				</div>
			</div>
		</div>

		<div class="card-body">

			<?php
			$jadwal_pakan = $this->Jadwal_pakan_model->data_jadwal_pakan($umur->id_umur);
			?>

			<!-- ===== DESKTOP TABLE ===== -->
			<div class="d-none d-md-block table-responsive">
				<table class="table table-bordered text-nowrap">
					<thead class="bg-primary text-white text-center">
						<tr>
							<th width="5%">No</th>
							<th>Jadwal Pakan</th>
							<th width="15%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($jadwal_pakan as $row): ?>
							<tr class="text-center">
								<td><?= $no++; ?></td>
								<td class="text-left"><?= $row['jadwal']; ?></td>
								<td>
									<a href="<?= base_url('jadwal_pakan/edit/' . $row['id_jadwal']) ?>"
									   class="btn btn-primary btn-sm">
										<i class="fa fa-edit"></i>
									</a>
									<a href="<?= base_url('Jadwal_pakan/delete/' . $row['id_jadwal']) ?>"
									   onclick="return confirm('Yakin hapus data ini?')"
									   class="btn btn-danger btn-sm">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- ===== MOBILE CARD ===== -->
			<div class="d-block d-md-none">
				<?php if (empty($jadwal_pakan)): ?>
					<div class="text-muted text-center">Belum ada jadwal.</div>
				<?php endif; ?>

				<?php foreach ($jadwal_pakan as $row): ?>
					<div class="card mb-3 border-left-primary shadow-sm">
						<div class="card-body">
							<h6 class="font-weight-bold text-primary mb-2">
								Jadwal: <?= $row['jadwal']; ?>
							</h6>

							<div class="d-flex">
								<a href="<?= base_url('jadwal_pakan/edit/' . $row['id_jadwal']) ?>"
								   class="btn btn-warning btn-sm w-50 mr-2">
									Edit
								</a>
								<a href="<?= base_url('Jadwal_pakan/delete/' . $row['id_jadwal']) ?>"
								   onclick="return confirm('Yakin hapus data ini?')"
								   class="btn btn-danger btn-sm w-50">
									Hapus
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	</div>

<?php endforeach ?>

<?php $this->load->view('layouts/footer_admin'); ?>
