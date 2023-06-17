<?php
/**
 * nethooks plugin for Craft CMS 3.x
 *
 * Add Deploy hooks for Netlify
 *
 * @link      https://jungleminds.com
 * @copyright Copyright (c) 2018 Jungle Minds
 */

namespace jungleminds\nethooks;

use craft\web\twig\variables\CraftVariable;
use jungleminds\nethooks\models\Settings;
use jungleminds\nethooks\utilities\NethooksUtility;

use Craft;
use craft\base\Plugin;
use craft\services\Utilities;
use craft\events\RegisterComponentTypesEvent;

use jungleminds\nethooks\web\twig\variables\NethooksVariable;
use yii\base\Event;

/**
 * Class Nethooks
 *
 * @author    Jungle Minds
 * @package   Nethooks
 * @since     1.0.2
 *
 */
class Nethooks extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Nethooks
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.2';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = NethooksUtility::class;
            }
        );

        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            /** @var CraftVariable $variable */
            $variable = $event->sender;
            $variable->set('nethooks', NethooksVariable::class);
        });

        Craft::info(
            Craft::t(
                'nethooks',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'nethooks/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
