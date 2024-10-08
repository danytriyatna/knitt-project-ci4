<html>
<body>
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td style="padding: 20px 0 30px 0;">
			<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc;">
			<!-- <tr>
				<td align="center" style="padding: 40px 0 30px 0;">
				<img src="assets/images/logo.webp" alt="" width="150" height="100" style="display: block;" />
				</td>
			</tr> -->
			<tr>
				<td bgcolor="#ffffff" style="padding: 0px 30px 40px 30px;">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
					<tr>
					<td style="color: #153643; font-family: Arial, sans-serif;">
						<h1 style="font-size: 24px; margin: 0; text-align:center">REGISTRASI AKUN</h1>
					</td>
					</tr>
					<tr>
					<td style="text-align:center; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
						<p style="margin: 0;">
						Terima kasih telah mendaftar di <strong>Aplikasi Pengukuran Beban Kerja Jabatan Fungsional</strong>. Akun anda yang terdaftar di sistem kami adalah:
						</p>
					</td>
					</tr>
					<tr>
					<td align="center">
						<h2 style="font-size: 20px; margin: 0; text-align:center">USERNAME : <?= $identity ?></h2>
					</td>
					</tr>
					<tr>
					<td style="text-align:center; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
						<p style="margin: 0;">
						Untuk pertama kali, Anda harus mengaktifkannya terlebih dahulu, silahkan klik tombol dibawah ini untuk mengaktifkan.
						</p>
					</td>
					</tr>
					<tr>
					<td align="center">
						<?= anchor('auth/activate/' . $id . '/' . $activation, "AKTIFKAN AKUN", ['class' => 'btn btn-info']) ?>
					</td>
					</tr>
				</table>
				</td>
			</tr>
			</table>
			</td>
		</tr>
	</table>
</body>
</html>