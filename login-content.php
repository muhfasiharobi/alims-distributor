<h1>
	 Halaman Login
</h1>
<p>
	Sistem Informasi Yang Digunakan Untuk Memonitoring Transaksi Keluar Masuknya Barang Serta Mencetak Berbagai Laporan Penjualan, Pembelian dan Stok Barang.
</p>
<form action="config/check.php" class="login-form" method="post">
	<?php
		error_reporting(0);
		if ($_GET['action'] == "error")
		{
	?>
			<div class="alert alert-danger">
				<button class="close" data-close="alert"> </button>
				<span>
					Masukkan Nama Akun atau Kata Sandi Anda Dengan Benar.
				</span>
			</div>
	<?php
		}
		else
		{
	?>
			<div class="alert alert-danger display-hide">
				<button class="close" data-close="alert"> </button>
				<span>
					Masukkan Nama Akun atau Kata Sandi Anda Dengan Benar.
				</span>
			</div>
	<?php
		}
	?>
	<div class="row">
		<div class="col-xs-6">
			<input autocomplete="off" class="form-control form-control-solid placeholder-no-fix form-group" name="username" placeholder="Nama Akun" type="text" required>
		</div>
		<div class="col-xs-6">
			<input class="form-control form-control-solid placeholder-no-fix form-group" name="password" placeholder="Kata Sandi" type="password" required>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 text-right">
			<button class="btn blue btn-outline" type="submit">
				<i class="icon-login"></i>
				Masuk
			</button>
		</div>
	</div>
</form>