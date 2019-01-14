<?php
session_start();
	if(!isset($_SESSION['id_user']) && !isset($_SESSION['username'])){
			  header('location:login.php');
	}
	
$table='t_produk';
$link='index.php?module=produk';
$pk='id_produk';

// Simpan //
if(isset($_POST['simpan'])){	

// ID //
	
	$id_kategori=$_POST['id_kategori'];
	$sql_auto=mysql_query("SELECT id_produk, SUBSTRING(id_produk,4,5) * 1 AS URUT FROM t_produk where id_kategori='".$id_kategori."' order by URUT DESC limit 1");
	$row_auto=mysql_fetch_assoc($sql_auto);
	$idp=explode("-", $row_auto['id_produk']);
	$ida=$idp[1]+1;
	$id_c="$id_kategori-$ida";
	$id_produk="$id_kategori-$ida";	
	
// Upload Foto //	
	if(!empty($_FILES['foto']['name'])){		
			$list_ekstensi = array("bmp", "jpg", "gif", "png", "jpeg"); // Extension Yang Diperbolehkan //
			$list_tipe= array("image/gif","image/jpeg","image/png","image/bmp"); // Tipe Yang Diperbolehkan //
			$namaFile = $_FILES['foto']['name'];
			$tipe=$_FILES['foto']['type'];
			$pecah = explode(".", $namaFile);
			$pecah_ekstensi = $pecah[1];
			$jenis=".$pecah_ekstensi";
			$namaFileNew=$id_produk.$jenis;
			$namaDir = '../images/produk/';
			$pathFile = $namaDir . $namaFile;
		if (in_array($pecah_ekstensi, $list_ekstensi)){
				if(in_array($tipe, $list_tipe)){   
					if (move_uploaded_file($_FILES['foto']['tmp_name'], $pathFile))	{
							$foto='./images/produk/'.$namaFileNew;
							rename($namaDir.$namaFile,$namaDir.$namaFileNew);
							$status='sukses';
					}
				}else{
					echo "<script>alert('Tipe File tidak diperbolehkan!');</script>";
					$status='failed';
				}
			}else{
				echo "<script>alert('Tipe File Tidak Diperbolehkan!');</script>";
				$status='failed';
			}
	}elseif(empty($_FILES['foto']['name'])){
		$foto=$_POST['gbr'];
		$status='sukses';
		
	}
		

if(isset($id) && $status=='sukses'){ 
// Simpan Edit //
			$sql_aksi=mysql_query("update ".$table." SET id_kategori='".htmlentities($_POST['id_kategori'])."',nama_produk='".htmlentities($_POST['nama_produk'])."',harga_produk='".htmlentities($_POST['harga_produk'])."',gambar_produk='$foto',deskripsi_produk='".htmlentities($_POST['deskripsi_produk'])."',berat='".htmlentities($_POST['berat'])."',stok='".htmlentities($_POST['stok'])."',tgl_post='".$tgl_sekarang."' where $pk='".$id."'");
			$alert='Diperbarui'; 
		}else{
// Check Duplikat //
			$sql_check=mysql_query("select *from ".$table." where ".$pk."='".$_POST['id_produk']."'");
			$row_check=mysql_num_rows($sql_check);
	if($row_check!=0){
		echo "<script>alert('ID Produk Sudah Dipakai!');</script>";
		$alert='Ditambahkan';
	}else{
// Simpan Tambah //
	  	$sql_aksi=mysql_query("insert into ".$table." VALUES (	'".$id_produk."','".htmlentities($_POST['id_kategori'])."','".htmlentities($_POST['nama_produk'])."','".htmlentities($_POST['harga_produk'])."','$foto','".htmlentities($_POST['deskripsi_produk'])."','".htmlentities($_POST['berat'])."','".htmlentities($_POST['stok'])."','".$tgl_sekarang."')") or die(mysql_error());
	  	$alert='Ditambahkan';
	}
}

// Alert //
			if($sql_aksi){
					echo "<script>alert('Data Berhasil ".$alert."');window.location=('".$link."');</script>";
			}else{
					echo "<script>alert('Data Gagal ".$alert."');window.location=('".$link."');</script>";
			}
}else{
	echo "<script>alert('Gagal, Silahkan Check Kembali');</script>";
}


// Tampil Edit & Hapus //
if(isset($id) || $aksi=='hapus'){
	$sql_check=mysql_query("select *from t_produk where id_produk='".$id."'");
	$hitung_check=mysql_num_rows($sql_check);
	if($hitung_check==1){
			
		if($aksi=='hapus'){
				$sql_aksi=mysql_query("delete from $table where $pk='".$id."'");
				$sql_d=mysql_query("select *from $table where $pk='".$id."'") or die(mysql_error());
				$r_d=mysql_fetch_assoc($sql_d);
			if($r_d['gambar_produk']!=''){
				$del=".".$r_d['gambar_produk']."";
				unlink($del);
			}else{};
			
				if($sql_aksi){
					echo "<script>alert('Data Berhasil Dihapus!');window.location=('".$link."');</script>";
				}else{
					echo "<script>alert('Data Gagal Dihapus!');window.location=('".$link."');</script>";
		}
		}else{
			$sql_edit=mysql_query("select * from ".$table." where ".$pk."='".$id."'");
			$row_edit=mysql_fetch_assoc($sql_edit);
		}
		
	}else{
		echo "<script>alert('Produk Tidak Tersedia!');window.location='index.php';</script>";
	}

}

if(isset($aksi) && isset($id)){
	$judul="- Edit Produk ".$id." :";
}else{
	$judul="- Tambah Produk :";
}


?>


<div class="path"><h3><?php echo "".$judul."" ?> </h3></div>
<div class="input">
<table width="587" height="362" align="center" cellpadding="0" cellspacing="0">
  <tr align="left">
    <td width="462" valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table width="555" height="420" align="center" cellpadding="0" cellspacing="0">
        <tr align="left">
          <td width="130" height="30">Kategori</td>
          <td width="10">:</td>
          <td width="347">
  <select name="id_kategori" id="id_kategori">
  <?php 		
		// Get Data Sesuai ID //
			if(isset($id)) {
				$sqll=mysql_query("select *from t_kategori where id_kategori='".$row_edit['id_kategori']."'");
				$rowl=mysql_fetch_assoc($sqll);
				echo "<option value=".$row_edit['id_kategori']." hidden>".$row_edit['id_kategori']." > ".$rowl['nama_kategori']."</option>";
			}
		// Get Data $Table 2 //
			$sqlg=mysql_query("select *from t_kategori order by id_kategori ");
			while($rowg=mysql_fetch_assoc($sqlg))
			{
		?>
    <option value="<?php echo "".$rowg['id_kategori'].""; ?>"><?php echo "".$rowg['id_kategori'].""; ?> > <?php echo "".$rowg['nama_kategori'].""; ?></option>
    <?php
			}
		?></select>
            
            </td>
        </tr>
        <tr align="left">
          <td height="40">Nama Produk</td>
          <td>:</td>
          <td align="left"><span id="sprytextfield3">
     
            <input name="nama_produk" type="text" id="nama_produk" size="50" maxlength="50" value="<?php echo $row_edit['nama_produk']; ?>" /><br /><span class="textfieldRequiredMsg">Input Masih Kosong!</span></span></td>
          </tr>
        <tr align="left">
          <td height="40">Harga Produk</td>
          <td>:</td>
          <td align="left"><span id="sprytextfield4">
        
            <input name="harga_produk" type="text" id="harga_produk" size="40" onkeypress='return harusangka(event)' maxlength="40" value="<?php echo $row_edit['harga_produk']; ?>" />
            <br /><span class="textfieldRequiredMsg">Input Masih Kosong!</span></span></td>
          </tr>
		<tr align="left">
          <td height="40">Berat</td>
          <td>:</td>
          <td align="left"><span id="sprytextfield5">
            <input name="berat_produk" type="text" id="berat_produk" size="5"  maxlength="5" value="<?php echo $row_edit['berat']; ?>" /> Kg
            <br /><span class="textfieldRequiredMsg">Input Masih Kosong!</span></span></td>
          </tr>
        <tr align="left">
          <td height="40">Gambar Produk</td>
          <td>:</td>
          <td align="left"> <?php 
		 		if(isset($id)) { 
				echo "<img src=.".$row_edit['gambar_produk']." width='100' height='100'>"; 
				} 			
			?>
            <input type="file" name="foto" id="foto" />
            <input type="hidden" name="gbr" value="<?php echo $row_edit['gambar_produk']; ?>"
            </td>
          </tr>
        <tr align="left">
          <td height="40">Deskripsi Produk</td>
          <td>:</td>
          <td align="left"><span id="sprytextarea1">
           
            <textarea name="deskripsi_produk" id="harga_produk" cols="45" rows="5" ><?php echo $row_edit['deskripsi_produk'];?></textarea>
            <br /><span class="textareaRequiredMsg">Input Masih Kosong!</span></span></td>
          </tr>
        <tr align="left">
          <td>Stok</td>
          <td>:</td>
          <td align="left"><select name="stok" id="stok"><?php if(isset($id)){ echo "
            	<option value=".$row_edit['stok']." hidden=hidden>".$row_edit['stok']."</option>
				   <option value=Masih>Masih</option>
            <option value=Habis>Habis</option>
				"; }else{ echo"
            <option value=Masih>Masih</option>
            <option value=Habis>Habis</option>
           
         "; } ?> </select></td>
        </tr>
        <tr align="left">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><input type="reset" name="batal" id="batal" value="Batal" class="button red" onClick="window.location.href='index.php?module=produk'">
            <input type="submit" name="simpan" class="button green" id="simpan" value="Simpan" /></td>
          </tr>
        </table>
    </form>&nbsp;</td>
  </tr>
</table>
</div>
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>
