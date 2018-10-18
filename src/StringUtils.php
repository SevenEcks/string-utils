<?php
namespace SevenEcks\StringUtils;

use SevenEcks\Ansi\Colorize;
use SevenEcks\Ansi\ColorInterface;

/**
 * This class is a utility package for manipulating strings in ways that. Specifically designed
 * for formatting terminal output and log output
 *
 * @author Brendan Butts <bbutts@stormcode.net>
 *
 */
class StringUtils
{
    protected $line_length = 180;
    protected $split_mid_word = false;
    protected $break_string = "\n";
    protected $eol_string = "\n";
    public $colorize = null;

    /**
     * Construct the StringUtils object, accepting a class that defines the
     * ColorizeInterface, if it is not passed in, the constructor injects one
     * on it's own.
     *
     * @param interface $colorize;
     * @return void
     */
    public function __construct(ColorInterface $colorize = null)
    {
        if (!$colorize) {
            $colorize = new Colorize;
        }
        $this->colorize = $colorize;
    }

    /**
     * Display a string on the left, and pad it on the right $length
     * characters using $filler.
     *
     * @param string $string
     * @param int $length
     * @param optional string $filler
     * @return string
     */
    public function left($string, $length, $filler = ' ') 
    {
        return str_pad($string, $length, $filler, STR_PAD_RIGHT); 
    }

    /**
     * Display a string on the right, and pad it on the left $length
     * characters using $filler.
     *
     * @param string $string
     * @param int $length
     * @param optional string $filler
     * @return string
     */
    public function right($string, $length, $filler = ' ') 
    {
        return str_pad($string, $length, $filler, STR_PAD_LEFT); 
    }

    /**
     * Display a string in the center (passed in, or determined by the 
     * line_length / 2 - the length of the string being presented / 2
     * and pad it on the left $length and right as close to equal
     * characters using $filler / 2.
     *
     * @param string $string
     * @param optional int $length
     * @param optional string $filler
     * @return string
     */
    public function center($string, $length = null, $filler = ' ')
    {
        if (is_null($length)) {
            $length = ($this->line_length / 2) - (strlen($string) / 2);
        }
        return str_pad($string, $length, $filler, STR_PAD_BOTH);
    }

    /**
     * Create a string of $length with the filler characters $filler.
     * This function will return a string of length $length even if
     * $filler is greater than that length.
     *
     * @param int $length
     * @param string $filler
     * @return string
     */
    public function fill(int $length, string $filler = ' ')
    {
        return str_pad('', $length, $filler);
    }

    /**
     * Break a string at $this->line_length
     * and return an array of strings
     *
     * @param string $string
     * @return array
     */
    public function lineWrap($string)
    {
        $lines = str_split($string, $this->line_length);
        return $lines;
    }

    /**
     * Echo or return a string ending in $this->eol_string
     *
     * @param string $string
     * @param bool $echo
     * @return string
     */
    public function tell(string $string, $echo = true)
    {
        $full_string = $string . $this->eol_string;
        if ($echo) {
            echo $full_string;
            return;
        }
        return $full_string;
    }

    /** 
     * Take n arguments and combine them into a single
     * string and return that string
     * @param string $strings
     * @param ... $strings
     * @return string
     */
    public function tostr(...$strings)
    {
        $new_string = '';
        foreach ($strings as $temp) {
            switch (gettype($temp)) {
                case "array":
                    $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($temp));
                    foreach($it as $v) {
                        $temp_str .= ' ' . $this->tostr($v);
                    }
                    break;
                default:
                    $temp_str = (string)$temp;
                    break;
            }
            $new_string .= $temp_str;
        }
        return trim($new_string);
    }

    /**
     * Take an array of $lines and execute
     * $this->tell on each line
     *
     * @return none
     */
    public function tell_lines(array $lines)
    {
        foreach ($lines as $line) {
            $this->tell($line);
        }
    }

    /**
     * Return a string wrapped either at a word, or close to the words completion
     * using the break_string defined on the object
     *
     * @param string $string
     * @return none
     */
    public function wordWrap($string)
    {
        return wordwrap($string, $this->line_length, $this->break_string, $this->split_mid_word);
    }

    /**
     * Setter for $this->split_mid_word
     *
     * @param bool $split_mid_word
     * @return none
     */
    public function setSplitMidWord(bool $split_mid_word)
    {
        $this->split_mid_word = $split_mid_word;
    }

    /**
     * Getter for $this->get_split_word
     *
     * @return bool
     */
    public function getSplitMidWord()
    {
        return $this->split_mid_word;
    }

    /**
     * Setter for $this->line_length which defines
     * the line length for wrapping
     *
     * @param int $new_line_length
     * @return none
     */
    public function setLineLength(int $new_line_length)
    {
        $this->line_length = $new_line_length;
    }

    /**
     * Getter for $this->line_length
     *
     * @return int
     */
    public function getLineLength()
    {
        return $this->line_length;
    }

    /**
     * Setter for $this->break_string which defines what wordwrap
     * uses for line breaks when executing
     *
     * @param string $break_string
     * @return none
     */
    public function setBreakString(string $break_string)
    {
        $this->break_string = $break_string;
    }

    /**
     * Getter for $this->break_string
     *
     * @return string
     */
    public function getBreakString()
    {
        return $this->break_string;
    }

    /**
     * Getter for $this->eol_string which defines what tell()
     * uses when echoing out a string
     *
     * @return string
     */
    public function getEolString()
    {
        return $this->eol_string;
    }

    /**
     * Setter for $this->eol_string
     *
     * @return none
     */
    public function setEolString(string $eol_string)
    {
        $this->eol_string = $eol_string;
    }

    //TODO: do something better with this below code
    /**
     * Display an alert string
     *
     * @param string $string
     * @return none
     */
    public function alert(string $string)
    {
        $this->tell('[' . $this->colorize->cyan('ALERT') . '] ' .  $string);
    }

    /**
     * Display a warning string
     *
     * @param string $string
     * @return none
     */
    public function warning(string $string)
    {
        $this->tell('[' . $this->colorize->yellow('WARNING') . '] ' . $string);
    }

    /**
     * Display a critical string
     *
     * @param string $string
     * @return none
     */
    public function critical(string $string)
    {
        $this->tell('[' . $this->colorize->red('CRITICAL') . '] ' . $string);
    }

    /**
     * Mass colorize an array of strings
     *
     * @param array $strings
     * @param string $color
     * @return array
     */
    public function massColor(array $strings, string $color)
    {
        $len_array = count($strings);
        for ($i = 0; $i < $len_array; $i++) {
            $strings[$i] = $this->colorize->{$color}($strings[$i]);
        }
        return $strings;
    }
}
