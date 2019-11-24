<?php

namespace Core;

/**
 * Interface IView
 */
interface IView
{
    /**
     * Generate the output of the view path and get it
     *
     * @return String
     */
    public function getOutput();

    /**
     * Treat the "\Core\View" object as string in printing
     *
     * @return String
     */
    public function __toString();
}