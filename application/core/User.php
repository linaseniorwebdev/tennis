<?php

class User {
	private $id;		    // User ID
	private $email;		    // User email
	private $first;		    // First name
	private $last;		    // Last name
	private $membership;    // Membership level
	private $expiration;    // Membership expire date
	private $status;        // User status

	public function __construct() {
		// Empty constructor
	}

	public static function init(array $arr) {
		$instance               = new self();
		$instance->id           = $arr['id'];
		$instance->email        = $arr['email'];
		$instance->first        = $arr['firstname'];
		$instance->last         = $arr['lastname'];
		$instance->membership   = (int)$arr['membership'];
		$instance->expiration   = $arr['expires_at'];
		$instance->status       = (int)$arr['status'];
		return $instance;
	}

	public function getId() {
		return $this->id;
	}

	public function getExpiration() {
		return $this->expiration;
	}

	public function getMembership() {
		return $this->membership;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getFirst() {
		return $this->first;
	}

	public function getLast() {
		return $this->last;
	}
}