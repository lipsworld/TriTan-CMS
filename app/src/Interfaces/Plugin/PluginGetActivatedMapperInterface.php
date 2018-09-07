<?php
namespace TriTan\Interfaces\Plugin;

interface PluginGetActivatedMapperInterface
{
    /**
     * Returns a list of all plugins that have been activated.
     *
     * @since 0.9.9
     * @return mixed
     */
    public function get();
}
