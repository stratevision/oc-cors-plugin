<?php

namespace Sv\Cors;

use Config;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Sv\Cors\Models\Settings as PluginSettings;

/**
 * CORS Plugin Information File.
 */
class Plugin extends PluginBase
{
    /**
     * @var boolean Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'sv.cors::lang.plugin.name',
            'description' => 'sv.cors::lang.plugin.description',
            'author'      => 'Ricardo Lüders',
            'icon'        => 'icon-exchange',
        ];
    }

    /**
     * Register the plugin settings
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'sv.cors::lang.settings.menu_label',
                'description' => 'sv.cors::lang.settings.menu_description',
                'category'    => SettingsManager::CATEGORY_MISC,
                'icon'        => 'icon-exchange',
                'class'       => 'Sv\Cors\Models\Settings',
                'order'       => 600,
                'permissions' => ['sv.cors.access_settings'],
            ]
        ];
    }

    /**
     * Register the plugin permissions
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'sv.cors.access_settings' => [
                'tab' => 'sv.cors::lang.plugin.name',
                'label' => 'sv.cors::lang.permissions.settings'
            ]
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Sv\Cors\Providers\CorsServiceProvider::class);
        $this->app['router']->middleware('cors', \Fruitcake\Cors\HandleCors::class);
        $this->app['router']->prependMiddlewareToGroup('api', \Fruitcake\Cors\HandleCors::class);
    }
}
