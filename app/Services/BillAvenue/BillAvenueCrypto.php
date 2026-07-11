<?php

namespace App\Services\BillAvenue;

use RuntimeException;

/**
 * AES-128-CBC encryption for the BillAvenue BBPS API.
 *
 * Confirmed scheme (from BillAvenue-provided reference implementation):
 *   - key = MD5(working_key) -> raw 16-byte digest, used directly as the AES-128 key
 *   - iv  = fixed bytes 0x00..0x0f (not secret, same for every Agent Institution)
 *   - cipher = AES-128-CBC, PKCS7/PKCS5 padding
 *   - ciphertext is hex-encoded for the `encRequest` request parameter
 *
 * Responses may come back hex-encoded (primary), base64-encoded (fallback), or as
 * plain unencrypted XML/JSON/HTML (e.g. error pages) — decrypt() handles all three.
 */
class BillAvenueCrypto
{
    private const CIPHER = 'aes-128-cbc';

    private readonly string $key;

    private readonly string $iv;

    public function __construct(string $workingKey)
    {
        $this->key = md5($workingKey, true);
        $this->iv = hex2bin('000102030405060708090a0b0c0d0e0f');
    }

    /**
     * Encrypt a plaintext payload (JSON or XML string) for the `encRequest` parameter.
     */
    public function encrypt(string $plaintext): string
    {
        $ciphertext = openssl_encrypt($plaintext, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $this->iv);

        if ($ciphertext === false) {
            throw new RuntimeException('BillAvenue request encryption failed.');
        }

        return bin2hex($ciphertext);
    }

    /**
     * Decrypt a raw API response, tolerating hex, base64, or plain (unencrypted) bodies.
     */
    public function decrypt(string $raw): string
    {
        $raw = trim($raw);

        if ($raw === '') {
            return $raw;
        }

        if (str_starts_with($raw, '<!DOCTYPE') || stripos($raw, '<html') === 0) {
            throw new RuntimeException('BillAvenue returned an HTML error page. Check IP whitelist, accessCode, and instituteId.');
        }

        if (str_starts_with($raw, '<?xml') || (str_starts_with($raw, '<') && ! str_starts_with($raw, '<!'))) {
            return $raw;
        }

        if (str_starts_with($raw, '{') || str_starts_with($raw, '[')) {
            return $raw;
        }

        if (ctype_xdigit($raw) && strlen($raw) % 2 === 0) {
            $decoded = $this->tryDecrypt(hex2bin($raw));

            if ($decoded !== null) {
                return $decoded;
            }
        }

        $base64Decoded = base64_decode($raw, true);

        if ($base64Decoded !== false) {
            $decoded = $this->tryDecrypt($base64Decoded);

            if ($decoded !== null) {
                return $decoded;
            }

            // Not AES-block-aligned — might just be plain base64-encoded text.
            return $base64Decoded;
        }

        return $raw;
    }

    private function tryDecrypt(string $bytes): ?string
    {
        if (strlen($bytes) === 0 || strlen($bytes) % 16 !== 0) {
            return null;
        }

        $plaintext = openssl_decrypt($bytes, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $this->iv);

        return $plaintext === false ? null : $plaintext;
    }
}
