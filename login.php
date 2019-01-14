<?php
	require "./module/login.php";
?>
<div class="bread"><b style="font-weight:bold">- Login :</b></div>
<br>
<form name="form1" method="post" action="">
  <table width="498" height="213" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td scope="col">Username</td>
      <td scope="col">:</td>
      <td scope="col"><span id="sprytextfield1">
        <input name="username" type="text" id="username" size="20">
        <span class="textfieldRequiredMsg">Input Masih Kosong!</span></span></td>
</tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><span id="sprytextfield2">
        <input name="password" type="password" id="password" size="20" maxlength="20">
        <span class="textfieldRequiredMsg">Input Masih Kosong!</span></span></td>
</tr>
    <tr>
      <td></td>
      <td></td>
      <td><span id="sprytextfield5">
       <img src="./plugins/captcha/captcha.php"><br><br>
         <input name="cap" type="text" id="cap" size="10" maxlength="10"><br>
        <span class="textfieldRequiredMsg">(Masukkan 3 kode di atas)</span></span></td>
</tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><input type="reset" name="lupa" id="lupa" value="Lupa Password" class="button green" onClick="window.location.href='index.php?module=lupa-password'">
						<input type="submit" name="login" id="login" value="Login" class="button blue">
						</td>
    </tr>
    <tr> </tr>
    <tr> </tr>
  </table><br>
  <div class="bread"><font style='color:#FF0000; font-weight:bold;'><em>Belum Punya Akun ? Silahkan <a href="index.php?module=daftar">Daftar Disini</a></em></font></div>

  <p>&nbsp;</p>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
