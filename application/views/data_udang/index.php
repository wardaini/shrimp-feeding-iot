<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
	<h1 class="h3 mb-3 mb-sm-0 text-gray-800">
		<i class="fas fa-fw fa-database"></i> Data Udang
	</h1>

	<a href="<?= base_url('Data_udang/create'); ?>"
	   class="btn btn-primary align-self-start align-self-sm-auto">
		<i class="fa fa-plus"></i> Tambah Data
	</a>
</div>


<?= $this->session->flashdata('message'); ?>

<div class="card shadow mb-4">

	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">
			<i class="fa fa-table"></i> Data Udang
		</h6>
	</div>

	<div class="card-body">

		<!-- ================= DESKTOP VIEW ================= -->
		<div class="d-none d-md-block">
			<div class="table-responsive">
				<table class="table table-bordered text-nowrap" id="dataTable" width="100%" cellspacing="0">
					<thead class="bg-primary text-white">
						<tr>
							<th>No</th>
							<th>Umur Udang</th>
							<th>Populasi</th>
							<th>Tanggal</th>
							<th>Rentang Umur</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($data_udang)): ?>
							<?php foreach ($data_udang as $key => $data): ?>
								<tr>
									<td><?= $key + 1; ?></td>
									<td><?= $data['umur_udang']; ?> Hari</td>
									<td><?= number_format($data['populasi']); ?> Ekor</td>
									<td><?= date('d-m-Y H:i:s', strtotime($data['tanggal'])); ?></td>
									<td><?= $data['rentang_umur'] ?? 'Tidak ada data'; ?></td>
									<td>
										<a href="<?= site_url('Data_udang/edit/' . $data['id_data']); ?>"
											class="btn btn-warning btn-sm">Edit</a>
										<a href="<?= site_url('Data_udang/delete/' . $data['id_data']); ?>"
											onclick="return confirm('Yakin ingin menghapus data ini?')"
											class="btn btn-danger btn-sm">Hapus</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="6" class="text-center">Tidak ada data yang tersedia.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- ================= MOBILE VIEW ================= -->
		<div class="d-block d-md-none">
			<?php if (!empty($data_udang)): ?>
				<?php foreach ($data_udang as $data): ?>
					<div class="card mb-3 shadow-sm">
						<div class="card-body">

							<h6 class="font-weight-bold text-primary mb-2">
								Umur Udang: <?= $data['umur_udang']; ?> Hari
							</h6>

							<p class="mb-1">
								<strong>Populasi:</strong>
								<?= number_format($data['populasi']); ?> Ekor
							</p>

							<p class="mb-1">
								<strong>Tanggal:</strong>
								<?= date('d-m-Y H:i', strtotime($data['tanggal'])); ?>
							</p>

							<p class="mb-3">
								<strong>Rentang Umur:</strong>
								<?= $data['rentang_umur'] ?? '-'; ?>
							</p>

							<div class="d-flex">
								<a href="<?= site_url('Data_udang/edit/' . $data['id_data']); ?>"
									class="btn btn-warning btn-sm w-50 mr-2">
									Edit
								</a>

								<a href="<?= site_url('Data_udang/delete/' . $data['id_data']); ?>"
									onclick="return confirm('Yakin ingin menghapus data ini?')"
									class="btn btn-danger btn-sm w-50">
									Hapus
								</a>
							</div>

						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="text-center text-muted">
					Tidak ada data yang tersedia.
				</div>
			<?php endif; ?>
		</div>

	</div>
</div>

<?php $this->load->view('layouts/footer_admin'); ?>
