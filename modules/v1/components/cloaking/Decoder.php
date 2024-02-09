<?php


namespace app\api\modules\v1\components\cloaking;

class Decoder
{
    const LETTER = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    /**
     * @var string
     */
    public $string;
    /**
     * @var string
     */
    public $decoded_string;
    public function __construct($string = '')
    {
        $this->string = $string;
    }

    /**
     * @param string $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }

    public function decode($retun = true)
    {
        if (!empty($this->string) && strlen($this->string)>2) {
            $rot_shift = substr($this->string, 1, 1);
            if (intval($rot_shift) > 0) {
                $rot_encoded = substr($this->string, 2);
                $rot_encoded = $this->unmaskString($rot_encoded);
                $this->decoded_string = $this->strRot($rot_encoded, 26 - intval($rot_shift));
                if ($retun) {
                    return $this->decoded_string;
                }
            } else {
                if ($retun) {
                    return $this->string;
                }
            }
        } else {
            if ($retun) {
                return $this->string;
            }
        }
    }


    private function strRot($s, $n = 13)
    {
        $n = (int)$n % 26;
        if (!$n) {
            return $s;
        }
        if ($n == 13) {
            return str_rot13($s);
        }
        for ($i = 0, $l = strlen($s); $i < $l; $i++) {
            $c = $s[$i];
            if ($c >= 'a' && $c <= 'z') {
                $s[$i] = self::LETTER[(ord($c) - 71 + $n) % 26];
            } elseif ($c >= 'A' && $c <= 'Z') {
                $s[$i] = self::LETTER[(ord($c) - 39 + $n) % 26 + 26];
            }
        }
        return $s;
    }

    private function unmaskString($string)
    {
        $new_string = '';
        foreach (str_split($string) as $c) {
            if (!($c == "0" or intval($c) > 0)) {
                $new_string .= $c;
            }
        }
        return $new_string;
    }
}
