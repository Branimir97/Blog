<?php

namespace Models;

use Exceptions\TemplateNotFoundException;

class View
{
    public function render(string $file, array $data = [])
    {
        $file_name = 'Views/'.$file . '.php';
        if(!file_exists($file_name))
        {
            throw new TemplateNotFoundException('File '.$file . ' not found!');
        }

        ob_start();
        extract($data, EXTR_SKIP);
        include $file_name;
        $output = ob_get_clean();
        return $output;
    }
}