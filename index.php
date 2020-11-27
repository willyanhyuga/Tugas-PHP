<?php
	//koneksi database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "TugasPHP";

	global $koneksi;
	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));


	//jika tombol save di klik
	if (isset($_POST['bsave']))
	{
		//pengujian data akan diedit atau disimpan
		if($_GET['hal'] == "edit")
		{
			//data akan diedit
			$edit = mysqli_query($koneksi, "UPDATE siswa set
												nama = '$_POST[nama]',
												nis = '$_POST[nis]',
												alamat = '$_POST[alamat]',
												jurusan = '$_POST[jurusan]'
											WHERE id = '$_GET[id]'
											 ");
			if($edit)
			{
				echo "<script>
						alert('Edit Data Success');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Edit Data Failed');
						document.location='index.php'
					 </script>";
			}
		}
		else
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO siswa (nama, nis, alamat, jurusan)
											  VALUES ('$_POST[nama]',
											  		 '$_POST[nis]',
											  		 '$_POST[alamat]',
											  		 '$_POST[jurusan]')
											 ");
			if($simpan)
			{
				echo "<script>
						alert('Save Data Success');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Save Data Failed');
						document.location='index.php'
					 </script>";
			}
		}

	}

	//pengujian jika tombol edit atau delete di klik
	if(isset($_GET['hal']))
	{
		//pengujian jika edit data
		if($_GET['hal'] == "edit")
		{
			//tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ditemukan ditampung ke variable
				$nama = $data['nama'];
				$nis = $data['nis'];
				$alamat = $data['alamat'];
				$jurusan = $data['jurusan'];
			}
		}
		else if($_GET['hal'] == "hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE id = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Delete Data Success');
						document.location='index.php'
					 </script>";
			}
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<style>
		*{
			font-family: oswald;
		}
	</style>
	<title>CRUD Table Input</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
		<h1 class="text-center">Daftar Siswa SMK HOGWARTS</h1>
	</font>
	<div class="card mt-5">
	  <div class="card-header bg-warning text-white">
	    Form Daftar Siswa
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<lable>Nama</lable>
	    		<input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required>
	    	</div>
	    	<div class="form-group">
	    		<lable>NIS</lable>
	    		<input type="number" name="nis" class="form-control" placeholder="Masukan NIS" required>
	    	</div>
	    	<div class="form-group">
	    		<lable>Alamat</lable>
	    		<textarea class="form-control" name="alamat" placeholder="Masukan Alamat" required></textarea>
	    	</div>
	    	<div class="form-group">
	    		<label>Jurusan Murid</label>
	    		<select class="form-control" name="jurusan" required>
	    			<option></option>
	    			<option value="TKJ">TKJ (TEKNIK KOMPUTER JARINGAN)</option>
	    			<option value="TJA">TJA (TEKNIK JARINGAN AKSES)</option>
	    			<option value="RPL">RPL (REKAYASA PERANGKAT LUNAK)</option>
	    		</select>
	    	</div>
			<button type="submit" class="btn btn-success text-white" name="bsave">Kirim</button>
			<button type="reset" class="btn btn-danger" name="breset">Reset</button>
	    </form>
	  </div>
	</div>
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white font-18pt">
	    List Nama Murid
	  </div>
	  <div class="card-body">
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>No. </th>
	  			<th>Nama</th>
	  			<th>NIS</th>
	  			<th>Alamat</th>
	  			<th>Jurusan</th>
	  			<th>Aksi</th>
	  		</tr>
	  		<?php
	  			$no = 1;
	  			$tampil = mysqli_query($koneksi, "SELECT * from siswa order by id desc");
	  			while ($data = mysqli_fetch_array($tampil)):
	  		 ?>
	  		<tr>
	  			<td><?=$no++;?></td>
	  			<td><?=$data['nama'];?></td>
	  			<td><?=$data['nis'];?></td>
	  			<td><?=$data['alamat'];?></td>
	  			<td><?=$data['jurusan'];?></td>
	  			<td>
	  				<a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-success">Edit</a>
	  				<a href="index.php?hal=hapus&id=<?=$data['id']?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
	  			</td>
	  		</tr>
	  	<?php endwhile;?>
	  	</table>
	  </div>
	</div>
</div>
<footer class="mt-4">
	</footer>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".bg-loader").hide();
		})
	</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
