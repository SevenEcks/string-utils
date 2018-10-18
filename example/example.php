<?php
require_once __DIR__ . '/../vendor/autoload.php';
use SevenEcks\StringUtils\StringUtils;
use SevenEcks\Ansi\Colorize;

$su = new StringUtils;
$test_string = 'This is a test';
// echo out test string
$su->tell($test_string);
$su->setLineLength(10);
// echo out a string, ignores line len
$su->tell($su->colorize->red("This is a test of a long red string!"));
$su->setSplitMidWord(true);
// echo using line length and color color
$su->tell($su->colorize->red($su->wordWrap("This is a test of a long blue word wrapped string which breaks mid word!")));
$su->setSplitMidWord(false);
// echo using length and color color
$su->tell($su->colorize->blue($su->wordWrap("This is a test of a long blue word wrapped string which breaks at a word!")));
// set the line length break string to br instead of default of \n
$su->setBreakString("<br />");
$su->tell($su->colorize->red($su->wordWrap("This is a test of a long red string!")));
$su->tell("Not colored.");
// mass colorize a string wrapped by line
$su->tell_lines($su->massColor($su->lineWrap("This is a test of a long line wrapped red strings!"), 'blue'));
// break at specific linelen
$su->tell_lines($su->lineWrap('123456789123456789123456789'));
// formatting of left, right, and center
$su->tell($su->left("TEST", 10) . $su->left("TEST1", 10));
$su->tell($su->right("TEST", 10) . $su->right("TEST1", 10));
$su->tell($su->center("TEST", 10) . $su->center("TEST1", 10));
// update line len
$su->setLineLength(180);
// center
$su->tell($su->center("CENTER NO ARGS"));
$su->tell($su->center("CENTER W/ ARGS", 30));
// alerts crits and warnings for debugging
$su->alert("This is an alert!");
$su->warning("This is a warning");
$su->critical("This is critical!");
// using tostr to combine args into a string
$su->tell($su->tostr($su->center("THIS EXAMPLE", 10), ' ', $su->center("USES TOSTR", 10), ' ', 1,2,3));
$su->tell($su->tostr('1',2,'3','asdf',['a', 'b' => 'c', 1]));
