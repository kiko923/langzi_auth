<?php
if(!defined('IN_CRONLITE'))exit();
class CACHE {
	public function read() {
		global $DB;
		$row=$DB->get_row("SELECT v FROM auth_config WHERE k='cache' limit 1");
		return $row['v'];
	}
	public function save($value) {
		if (is_array($value)) $value = serialize($value);
		if(CACHE_FILE==1) return file_put_contents($this->file_name,'<?php exit;//'.$value);
		global $DB;
		$value = addslashes($value);
		return $DB->query("update auth_config set v='$value' where k='cache'");
	}
	public function pre_fetch(){
		global $_CACHE;
		$_CACHE=array();
		$cache = $this->read();
		$_CACHE = array_merge(@unserialize($cache),$_COOKIE);
		if(empty($_CACHE['version']) || $_GET['clearcache'])$_CACHE = $this->update();
		return $_CACHE;
	}
	public function update() {
		global $DB;
		$cache = array();
		$query = $DB->query('SELECT * FROM auth_config where 1');
		while($result = $DB->fetch($query)){
			if($result['k']=='cache') continue;
			$cache[ $result['k'] ] = $result['v'];
		}
		$this->save($cache);
		return $cache;
	}
	public function clear() {
		global $DB;
		return $DB->query("update auth_config set v='' where k='cache'");
	}
}
