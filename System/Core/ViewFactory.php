<?php

namespace Core;

class ViewFactory
{
    /**
     * Render the given view path with the passed variables and generate new View object
     * for it
     *
     * @param String $viewPath
     * @param array $data
     * @return \Core\View
     */
    public function render($viewPath, array $data = [])
    {
        return new View($viewPath, $data);
    }
}