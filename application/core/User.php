<?php

class User {
	private $id;		    // User ID
	private $username;      // Username
	private $membership;    // Phone Number
	private $expiration;    // Phone Number

	public function __construct() {
		// Empty constructor
	}

	public static function init(array $arr) {
		$instance = new self();
		$instance->id = $arr['id'];
		$instance->username = $arr['username'];
		$instance->membership = $arr['membership'];
		$instance->expiration = $arr['expires_at'];
		return $instance;
	}

	public function getId() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getExpiration() {
		return $this->expiration;
	}

	public function getMembership() {
		return $this->membership;
	}
}