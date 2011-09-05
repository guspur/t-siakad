<?php
/*
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 * 		
 * 		created by ibnu yahya <ibnu.yahya@toroo.org>
 * 
 */
function auto_complete($query,$tb,$field){
	$q = strtolower($query);
	if (!$q) return;

	$sql = "select * from $tb where $field LIKE '%$q%'";
	$rsd = mysql_query($sql);
	$count = mysql_num_rows($rsd);
	if ($count > '0') {
		while($rs = mysql_fetch_array($rsd)) {
			echo ($rs[$field]."\n");
		}
	}
	else {
		echo "Data tidak ditemukan";
	}
	return $rsd;
}
function getfile($path) {
	$handle = opendir($path) or die("Unable to open $path");
	$file_arr = array();
	while ($file = readdir($handle)) {
		$file_arr[] = $file;
	}
	$replace = array("..,",".,");
	$getfile = str_replace($replace,"",implode(",",$file_arr));
	$array_getfile = explode(",",$getfile);
	closedir($handle);
	return $array_getfile;
}

function getplugin() {
	$handle = opendir("plugin/") or die("Unable to open plugin");
	$file_arr = array();
	while ($file = readdir($handle)) {
		$file_arr[] = $file;
	}
	$replace = array("..,",".,");
	$getfile = str_replace($replace,"",implode(",",$file_arr));
	$array_getfile = explode(",",$getfile);
	closedir($handle);
	return $array_getfile;
}

function getplugin_modul() {
	$handle = opendir("plugin/") or die("Unable to open plugin");
	$file_arr = array();
	while ($file = readdir($handle)) {
		if (file_exists("plugin/".$file."/info.php")) {
			include ("plugin/".$file."/info.php");
			if ($info == "modul") {
				$file_arr[] = $file;
			}
		}
	}
	$replace = array("..,",".,");
	$getfile = str_replace($replace,"",implode(",",$file_arr));
	$array_getfile = explode(",",$getfile);
	closedir($handle);
	return $array_getfile;
}

function getplugin_modul_report($dir) {

		if (file_exists("plugin/".$dir."/report.php")) {
			include ("plugin/".$dir."/report.php");
		} else {
			echo ("File not exist!");
		}
}

//koneksi ke database
function conn_db($hostname,$username,$password,$database) {
	mysql_connect($hostname,$username,$password) or die ("MySQL not connected : ".mysql_error());
	mysql_select_db($database) or die ("Database error : ".mysql_error());
}

//pengganti fungsi get dengan "/"

function path_info() {
		$path = explode("/",$_SERVER['PATH_INFO']);
		return $path;
}

//input data
function db_insert($tb,$array_field,$array_value) {
	$implode_field = implode(",",$array_field);
	$implode_value = implode("','",$array_value);
	$mysql_insert = "INSERT INTO $tb ($implode_field) value ('$implode_value')";
	$query = mysql_query($mysql_insert);
	return $query;
}
//delete data
function db_delete($tb,$id_field,$id_value) {
	$query = mysql_query("DELETE FROM $tb where $id_field='$id_value'") or die (mysql_error());
	return $query;
}
//update data
function db_update($tb,$field,$value,$id_field,$id_value) {
	$count=count($field);
	$i ='0';
		while ($i<$count) {
			$fv[$i]=$field[$i]."='".$value[$i]."'";
			$i++;
		}
	$field_value = implode(",",$fv);
	$query = mysql_query("UPDATE $tb SET $field_value where $id_field='$id_value'") or die (mysql_error());
	return $query;
}
//proses data
function db_select($tb) {
	$mysql_select = "SELECT * FROM $tb";
	$query = mysql_query($mysql_select) or die (mysql_error());
	return $query;
}
function db_select_where($tb,$id,$id_value) {
	$mysql_select = "SELECT * FROM $tb where $id='$id_value'";
	$query = mysql_query($mysql_select) or die (mysql_error());
	return $query;
}
function db_select_none($tb,$query) {
	$mysql_select = "SELECT * FROM $tb $query";
	$query = mysql_query($mysql_select) or die (mysql_error());
	return $query;
}
/*
 * membuat form input
 * - penulisan input_tag="<tag1>:</tag1>"; (berlaku untuk satu perulangan tag yang sama)
 *   input_tag=array("<tag1>:</tag1>","<tag2>:</tag2>"); (berlaku untuk satu perulangan tag yang sama)
 * - class dan id bisa di tulis $variable = "";
 * - array label menentukan banyaknya form yang akan di buat
 * - pengisian value pada type select $array_value="value1:value2:value3";
 *   jika menggunakan option selected value select harus di akhiri dengan tanda *select
 *   contoh : $array_value="value1:value2*select:value3";
 * 
*/
function form_input($array_label,$array_type,$array_name,$array_value,$array_class,$array_id,$input_tag) {
	$count=count($array_label);
	$count_type=count($array_type);
	$count_name=count($array_name);
	$count_value=count($array_value);
	$count_class=count($array_class);
	$count_id=count($array_id);
	$count_tag=count($input_tag);

	$i ='0';
		while ($i<$count) {	
			
				if ($count_tag == '1') {
					$style = explode(":",$input_tag);
				}
				else {
					$style = explode(":",$input_tag[$i]);
				}
				
			
				if ($count_class == '1') {
					$class = "class='".$array_class."'";
				}
				else {
					$class = "class='".$array_class[$i]."'";
				}
				
				if ($count_id == '1') {
					$id = "id='".$array_id."'";
				}
				else {
					$id = "id='".$array_id[$i]."'";
				}
				
				if ($count_type == '1') {
					$type = $array_type;
				}
				else {
					$type = $array_type[$i];
				}
				
				if ($count_name == '1') {
					$name = "name='".$array_name."'";
				}
				else {
					$name = "name='".$array_name[$i]."'";
				}
				
				if ($count_value == '1') {
					$value = $array_value;
				}
				else {
					$value = $array_value[$i];
				}
				
				
				echo ($style[0]);
				
						echo ("<label>".$array_label[$i]."</label>");
						
						if ($type == "text") {
							echo "<input type='text' ".$class." ".$id." ".$name." value='".$value."'>";
						}
						else if ($type == "hidden") {
							echo "<input type='hidden' ".$class." ".$id." ".$name." value='".$value."'>";
						}
						else if ($type == "password") {
							echo "<input type='password' ".$class." ".$id." ".$name." value='".$value."'>";
						}
						else if ($type == "submit") {
							echo "<input type='submit' ".$class." ".$id." ".$name." value='".$value."'>";
						}
						else if ($type == "reset") {
							echo "<input type='reset' ".$class." ".$id." ".$name." value='".$value."'>";
						}
						else if ($type == "textarea") {
							echo "<textarea ".$class." ".$id." ".$name.">".$value."</textarea>";
						}
						else if ($type == "file") {
							echo "<input type='file' ".$class." ".$id." ".$name." value='".$value."'>";
						}
						else if ($type == "select") {
							$select_value = explode(":",$value);
							$count_select_value = count($select_value);
							$j='0';
							echo "<select ".$class." ".$id." ".$name.">";
							while ($j<$count_select_value) {
								$selected = explode("*",$select_value[$j]);
								if ($selected[1] == "select") {
									echo "<option selected value='".$selected[0]."'>".$selected[0]."</option>";
								}
								else {
									echo "<option value='".$select_value[$j]."'>".$select_value[$j]."</option>";
								}
								$j++;
							}	
							echo "</select>";
						}
						
				
				echo ($style[1]);
				
				
			$i++;
		}
		
}

function jquery(){
	echo ("<script src='".HOSTNAME."inc/js/jquery.js'></script>\n");
}

function jquery_min(){
	echo ("<script src='".HOSTNAME."inc/js/jquery.min.js'></script>\n");
}

function jquery_ui_min(){
	echo ("<script src='".HOSTNAME."inc/js/jquery-ui.min.js'></script>\n");
}

function jquery_ui(){
	echo ("<script src='".HOSTNAME."inc/js/jquery-ui.js'></script>\n");
}
function js_ui($js_source){
	echo ("<script src='".HOSTNAME."inc/js/ui/ui.".$js_source.".js'></script>\n");
}
function css_widgets($css_source){
	echo ("<link rel='stylesheet' type='text/css' href='".HOSTNAME."inc/css/widgets/".$css_source."/jquery-ui.css'>\n");
}

function css_ui($css_source){
	echo ("<link rel='stylesheet' type='text/css' href='".HOSTNAME."inc/css/widgets/".$css_source."/ui.all.css'>\n");
}

function css_themes($themes,$css_source){
	echo ("<link rel='stylesheet' type='text/css' href='".HOSTNAME.THEMES.$themes."/css/".$css_source.".css'>\n");
}


function js_themes($themes,$js_source){
	echo ("<script src='".HOSTNAME.THEMES.$themes."/js/".$js_source.".js'></script>\n");
}

function js($js_source){
	echo ("<script src='".$js_source."'></script>\n");
}

function themes_show($themes){
	include (THEMES.$themes."/themes.php");
}

function themes_login($themes){
	include (THEMES.$themes."/login.php");
}

function themes_navigator($themes){
	include (THEMES.$themes."/navigator.php");
}

function themes_content($themes){
	include (THEMES.$themes."/content.php");
}
//content
function report(){
	include (INC."/report.php");
}
function setting(){
	include ("admin/setting.php");
}
function page($page){
		echo ("	<ul>");
		
				if (file_exists("plugin/".$page."/form.php")){
					echo ("<li><a href='#tabs-1'>Form Input ".ucfirst($page)."</a></li>");
				}
				if (file_exists("plugin/".$page."/report.php")){
					echo ("<li><a href='#tabs-2'>Raport ".ucfirst($page)."</a></li>");
				}
				if (file_exists("plugin/".$page."/import.php")){
					echo ("<li><a href='#tabs-3'>Import Data ".ucfirst($page)."</a></li>");
				}
				if (file_exists("plugin/".$page."/export.php")){
					echo ("<li><a href='#tabs-4'>Export Data ".ucfirst($page)."</a></li>");
				}
				
		echo ("</ul>");
		if (file_exists("plugin/".$page."/form.php")){
			echo ("<div id='tabs-1'><p>");
				include ("plugin/".$page."/form.php");
			echo ("</p></div>");
		}
		if (file_exists("plugin/".$page."/report.php")){
		echo ("<div id='tabs-2'><p>");
			include ("plugin/".$page."/report.php");
		echo ("</p></div>");
		}
		if (file_exists("plugin/".$page."/import.php")){
		echo ("<div id='tabs-3'><p>");
			include ("plugin/".$page."/import.php");
		echo ("</p></div>");
		}
		if (file_exists("plugin/".$page."/export.php")){
		echo ("<div id='tabs-4'><p>");
			include ("plugin/".$page."/export.php");
		echo ("</p></div>");
		}
}
//content

function ip_user() {
	if (getenv(HTTP_X_FORWARDED_FOR)) {
        $ip_address = getenv(HTTP_X_FORWARDED_FOR);
			} else {
				$ip_address = getenv(REMOTE_ADDR);
			}

	echo $ip_address;
}

function session(){
	if (!isset($_SESSION[user])){
	   echo	("<meta http-equiv='refresh' content='0;url=".HOSTNAME."index.php'>");
	}
}

//memunculkan kotak pesan
function dialogbox($message) {
	echo ("<script type='text/javascript'> alert('".$message."') </script>");
}
function dialogbox_direct($message,$url_direct) {
	echo ("<script type='text/javascript'> alert('".$message."') </script>
		   <meta http-equiv='refresh' content='0;url=".$url_direct."'>");
}
function direct($url_direct) {
	echo ("<meta http-equiv='refresh' content='0;url=".$url_direct."'>");
}

function del_image($themes){
	echo ("<img src='".HOSTNAME.THEMES."default/images/icon/delete.png'>");
}
function update_image($themes){
	echo ("<img src='".HOSTNAME.THEMES."default/images/icon/update.png'>");
}
function thn_ajaran(){
	$year_min= "2008";
	$year_maximum= date(Y) + 1;
	while ($year_min <= $year_maximum) {
		$year_max = $year_min + 1;
		if ($year_min != $year_maximum) {
		echo  ($year_min."/".$year_max."\n");
		}
		$year_min++;
	}
}
?>
