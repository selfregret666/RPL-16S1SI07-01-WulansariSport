<?php
// PENCARIAN //

if(isset($_POST['search'])){
		$item_cari=htmlentities(addslashes($_POST['search']));
	}else{
		$item_cari=htmlentities(addslashes($_GET['cari']));
		
};

// -- //


// SQL PRODUK //
	
if(isset($kategori)){
		$sql_produk=mysql_query("select * from t_produk where id_kategori='".$kategori."' order by tgl_post DESC limit ".$MulaiAwal.",".$BatasAwal."");
		$kat="&kategori=".$kategori."";
}elseif($module=="cari"){
		$sql_produk=mysql_query("select * from t_produk where nama_produk LIKE '%".$item_cari."%' order by tgl_post DESC limit ".$MulaiAwal.",".$BatasAwal."");
		$cari="&module=cari&cari=".$_POST['search']."";
}else{
		$sql_produk=mysql_query("select * from t_produk order by tgl_post DESC limit ".$MulaiAwal.",".$BatasAwal."");
}

// -- //


// SQL PAGING //

	if(isset($kategori)){
		$check=mysql_query("select id_produk from t_produk where id_kategori='".$kategori."' order by tgl_post DESC");
	}elseif($module=="cari"){
		$check=mysql_query("select id_produk from t_produk where nama_produk LIKE '%".$item_cari."%' order by tgl_post DESC");
	}else{
		$check=mysql_query("select id_produk from t_produk order by tgl_post DESC");
	}
    $jumlahData = mysql_num_rows($check);

// -- //


// FUNGSI SLIDER //

function slider(){
	$sql_slide=mysql_query("select *from t_slider");
	while($row_slide=mysql_fetch_assoc($sql_slide)){
		echo '<li>
				<img src="'.$row_slide['foto_slider'].'"  alt="'.$row_slide['deskripsi_slider'].'" title="'.$row_slide['nama_slider'].'" width="100%" height="280px"/>
			  </li>';
		}
	
}
// -- //



	
?>