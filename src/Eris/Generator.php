<?php
namespace Eris;

/**
 * Generic interface for a type <T>.
 */
interface Generator
{
    /**
     * @return T
     */
    public function __invoke();

    /**
     * @return T
     */
    public function shrink();
}