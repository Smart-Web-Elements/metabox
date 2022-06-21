<?php

namespace SweMetaBox;

/**
 *
 */
abstract class Information
{
    /**
     * @param string $path
     * @return string
     */
    public final function getPartialsPath(string $path = ''): string
    {
        $partialsPath = str_replace('\\', '/', dirname(__DIR__)).'/partials';

        if (!empty($path)) {
            $partialsPath .= ltrim($path, '/');
        }

        return $partialsPath;
    }
}