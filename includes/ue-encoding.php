<?php
function ue_csr_generator(){
	if(!file_exists(UE_PLUGIN_DIR . 'includes/private.pem') && !file_exists(UE_PLUGIN_DIR . 'includes/csr.pem')){
		$dn = array(
		   "commonName" => "test user extension"
		);
		$config = array(
			"digest_alg" => "sha512",
			"private_key_bits" => 1024,
			"private_key_type" => OPENSSL_KEYTYPE_RSA
		);
		  
		// Create the private and public key
		
		$res = openssl_pkey_new($config);
		$csr = openssl_csr_new($dn, $res);
		openssl_pkey_export_to_file($res, UE_PLUGIN_DIR . 'includes/private.pem');
		openssl_csr_export_to_file($csr, UE_PLUGIN_DIR . 'includes/csr.pem');
	}
}

function ue_encode($data){
	$getcsr = file_get_contents(UE_PLUGIN_DIR . 'includes/csr.pem');
	$pubKey = openssl_csr_get_public_key($getcsr);
	openssl_public_encrypt($data, $encrypted, $pubKey);
	return base64_encode($encrypted);
}

function ue_decode($data){
	$privKey = file_get_contents(UE_PLUGIN_DIR . 'includes/private.pem');
	$d_data = base64_decode($data);
	openssl_private_decrypt($d_data, $decrypted, $privKey);
	return $decrypted;
}
