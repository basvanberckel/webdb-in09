<?php

                
                
function parse_bbcode_html($string) {
  $bbcode = array("[b]"=>"<strong>", "[/b]"=>"</strong>",
                  "[i]"=>"<em>", "[/i]"=>"</em>",
                  "[u]"=>"<span style='text-decoration:underline;'>", "[/u]"=>"</span>",
                  "[s]"=>"<del>", "[/s]"=>"</del>",
                  "[sub]"=>"<sub>","[/sub]"=>"</sub>",
                  "[sup]"=>"<sup>","[/sup]"=>"</sup>",
                  "[h1]"=>"<h1>","[/h1]"=>"</h1>",
                  "[h2]"=>"<h2>","[/h2]"=>"</h2>",
                  "[h3]"=>"<h3>","[/h3]"=>"</h3>",
                  "[h4]"=>"<h4>","[/h4]"=>"</h4>",
                  "[h5]"=>"<h5>","[/h5]"=>"</h5>",
                  "[h6]"=>"<h6>","[/h6]"=>"</h6>",
                  "[code]"=>"<code>","[/code]"=>"</code>",
				  "[q]"=>"<blockquote class='style'>", "[/q]"=>"</blockquote>");   
  $bbtags = array_keys($bbcode);
  $htmltags = array_values($bbcode);
  $parsed = str_replace($bbtags, $htmltags, $string);
  return $parsed;
}
