<?php

var_dump(VerifyPDF::get_pkcs7('teste.pdf'));

class VerifyPDF
{
    public static function getByteRange($filename)
    {
        $content = file_get_contents($filename);

        if (!preg_match_all('/ByteRange\[\s*(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s*\]/',
            $content, $matches))
        {
            throw new \Exception('Unable to get certificate');
        }

        return [
            intval($matches[1][0]), // Offset of the first part (usually 0)
            intval($matches[2][0]), // Size of the first part
            intval($matches[3][0]), // Offset to the second part
            intval($matches[4][0])  // Size of the second part
        ];
    }

    public static function get_pkcs7($filename)
    {
        [$o1, $l1, $o2, $l2] = self::getByteRange($filename);

        if (!$fp = fopen($filename, 'rb')) {
            throw new \Exception("Unable to open $filename");
        }

        $signature = stream_get_contents($fp, $o2 - $l1 - 2, $l1 + 1);
        fclose($fp);

        file_put_contents('out.pkcs7', hex2bin($signature));
    }

    public static function compute_hash($filename)
    {
        [$o1, $l1, $o2, $l2] = self::getByteRange($filename);

        if (!$fp = fopen($filename, 'rb')) {
            throw new \Exception("Unable to open $filename");
        }

        $i = stream_get_contents($fp, $l1, $o1);
        $j = stream_get_contents($fp, $l2, $o2);

        if (strlen($i) != $l1 || strlen($j) != $l2) {
            throw new \Exception('Invalid chunks');
        }

        fclose($fp);

        return hash('sha256', $i . $j);
    }
}




?>
