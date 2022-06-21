<?php

namespace SweMetaBox;

/**
 *
 */
abstract class Information
{
    /**
     * Get the default partials path.
     *
     * @param string $path
     * @return string
     */
    public final function getDefaultPath(string $path = ''): string
    {
        $partialsPath = str_replace('\\', '/', dirname(__DIR__)).'/partials';

        if (!empty($path)) {
            $partialsPath .= '/' . ltrim($path, '/');
        }

        return $partialsPath;
    }
}