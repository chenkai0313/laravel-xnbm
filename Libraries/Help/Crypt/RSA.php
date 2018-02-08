<?php
/**
 * Author: cuidongming
 * CreateTime: 2016/5/31 13:18
 * Description:
 */
namespace Libraries\Help\Crypt;


class RSA
{
	private $private_key = '-----BEGIN RSA PRIVATE KEY-----
-----END RSA PRIVATE KEY-----';

	private $pub_key = '-----BEGIN PUBLIC KEY-----
-----END PUBLIC KEY-----';

	private $prikey = '';
	private $pubkey = '';

	public function __construct()
	{
		$this->prikey = openssl_pkey_get_private($this->private_key);
		$this->pubkey = openssl_pkey_get_public($this->pub_key);
	}

	public function priencrypt($data)
	{
		if (openssl_private_encrypt($data, $crypted, $this->prikey)) {
			return base64_encode($crypted);
		}

		return '';
	}

	public function pridecrypt($data)
	{
		if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->prikey)) {
			return $decrypted;
		}

		return '';
	}

	public function pubencrypt($data)
	{
		if (openssl_public_encrypt($data, $encrypted, $this->pubkey)) {
			return base64_encode($encrypted);
		}

		return '';
	}

	public function pubdecrypt($data)
	{
		if (openssl_public_decrypt(base64_decode($data), $decrypted, $this->pubkey)) {
			return $decrypted;
		}

		return '';
	}
}
