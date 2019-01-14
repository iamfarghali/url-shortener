<?php

class Shortener
{
	private $domain = "http://sh.url/";
	protected $db;
	protected $host   = 'localhost';
	protected $dbName = 'shortener_url';
	protected $dbUser = 'root';
	protected $dbPass = '';
	public $url;

	public function __construct() {
		$this->connectToDB();
	}

	// connect to database
	private function connectToDB() {
		try {
			$this->db = new PDO("mysql:host=$this->host; dbname=$this->dbName", $this->dbUser, $this->dbPass);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo 'Connection Error: '.$e->getMessage();
		}
	}

	public function getCode() {
		$url = $this->validate($this->url);
		if ( $this->countLink($url) ) {
			$row = $this->getLink($url);
			return $row['code'];
		} else {
			if ( $this->insertLink($url) ) {
				$row = $this->getLink($url);
				$code = $this->generateCode($row['id']);
				$this->updateLink($code, $row['id']);
				return $code;
			} else {
				echo 'Insert a link is failed.';
			}
		}

	}

	protected function generateCode($num) {
		return base_convert($num, 10, 36);
	}

	public function prepareURL($code) {
		return $this->domain.$code;
	}

	private function validate($url) {
		$url = trim($url);
		$url = stripslashes($url);
		$url = htmlspecialchars($url);
		if (! filter_var($url, FILTER_VALIDATE_URL) ) {
			return '';
		} else {
			return $url;	
		}
	}
	

	// Methods deal with DB
	private function countLink($url) {
		$query = "SELECT url FROM links WHERE url = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$url]);
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	private function getLink($url) {
		$query = "SELECT * FROM links WHERE url = ? LIMIT 1";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$url]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	private function insertLink($url) {
		$query = "INSERT INTO links (url, created) VALUES (?, ?)";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$url, date('Y-m-d H:i:s')]);
		return true;
	}

	private function updateLink($code, $id) {
		$query = "UPDATE links SET code = (?) WHERE id = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$code, $id]);
		return true;
	}

	public function getURL($code) {
		$query = "SELECT url FROM links WHERE code = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute([$code]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['url'];
	}

}