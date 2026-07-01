<?php $this->load->view('layouts/header_admin'); ?>

<!-- ===== HEADER ===== -->
<div class="d-sm-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
	<h1 class="h3 mb-3 mb-sm-0 text-gray-800">
		<i class="fas fa-fw fa-calendar"></i> Data Umur Udang
	</h1>

	<a href="<?= base_url('Umur_udang/create'); ?>"
	   class="btn btn-primary align-self-start align-self-sm-auto">
		<i class="fa fa-plus"></i> Tambah Data
	</a>
</div>

<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">
			<i class="fa fa-table"></i> Daftar Data Umur Udang
		</h6>
	</div>

	<div class="card-body">

		<!-- ===== DESKTOP TABLE ===== -->
		<div class="d-none d-md-block table-responsive">
			<table class="table table-bordered text-nowrap" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-primary text-white text-center">
					<tr>
						<th width="5%">No</th>
						<th>Umur Udang (DOC)</th>
						<th>Frekuensi Pakan</th>
						<th width="15%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; foreach ($list as $value): ?>
						<tr class="text-center">
							<td><?= $no++; ?></td>
							<td><?= $value->umur_udang; ?></td>
							<td><?= $value->frekuensi_pakan; ?></td>
							<td>
								<a href="<?= base_url('Umur_udang/edit/' . $value->id_umur); ?>"
								   class="btn btn-primary btn-sm">
									<i class="fa fa-edit"></i>
								</a>
								<a href="<?= base_url('Umur_udang/destroy/' . $value->id_umur); ?>"
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
			<?php if (empty($list)): ?>
				<div class="text-center text-muted">Tidak ada data.</div>
			<?php endif; ?>

			<?php foreach ($list as $value): ?>
				<div class="card mb-3 shadow-sm border-left-primary">
					<div class="card-body">
						<h6 class="font-weight-bold text-primary mb-2">
							Umur Udang: <?= $value->umur_udang; ?> DOC
						</h6>

						<p class="mb-3">
							<strong>Frekuensi Pakan:</strong>
							<?= $value->frekuensi_pakan; ?>
						</p>

						<div class="d-flex">
							<a href="<?= base_url('Umur_udang/edit/' . $value->id_umur); ?>"
							   class="btn btn-warning btn-sm w-50 mr-2">
								Edit
							</a>
							<a href="<?= base_url('Umur_udang/destroy/' . $value->id_umur); ?>"
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

<?php $this->load->view('layouts/footer_admin'); ?>
