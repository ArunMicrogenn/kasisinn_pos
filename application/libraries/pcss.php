<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pcss {

    public function lcss()
    {
        $str = file_get_contents(spath.'app/link/lcss.json');
        $json = json_decode($str, true);
         
        foreach($json['css'] as $row)
        {
             echo '<link rel="stylesheet" href="'.scs_url.$row.'">';
        }
    }
    public function css()
    {
        $str = file_get_contents(spath.'app/link/css.json');
        $json = json_decode($str, true);
         
        foreach($json['css'] as $row)
        {
             echo '<link rel="stylesheet" href="'.scs_url.$row.'">';
        }
    }
    public function css_Report()
    {
        $str = file_get_contents(spath.'app/link/css_Report.json');
        $json = json_decode($str, true);
         
        foreach($json['css'] as $row)
        {
             echo '<link rel="stylesheet" href="'.scs_url.$row.'">';
        }
    }
    public function wjs()
    {
        $str = file_get_contents(spath.'app/link/wjs.json');
        $json = json_decode($str, true);
            echo '
            ';
        foreach($json['js'] as $row)
        {
                echo '<script src="'.scs_url.$row.'"></script>';
        }

    }
    public function hjs()
    {
        $str = file_get_contents(spath.'app/link/hjs.json');
        $json = json_decode($str, true);
            echo '
            ';
        foreach($json['js'] as $row)
        {
                echo '<script src="'.scs_url.$row.'"></script>';
        }

    }
}
?>