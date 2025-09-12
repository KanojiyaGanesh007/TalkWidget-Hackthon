<?php
declare(strict_types=1);

namespace OCA\TalkWidget\AppInfo;

use OCA\TalkWidget\Dashboard\TalkWidget;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;

class Application extends App implements IBootstrap {
    public const APP_ID = 'talkwidget';

    public function __construct(array $urlParams = []) {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void {
        $context->registerDashboardWidget(TalkWidget::class);
    }

    public function boot(IBootContext $context): void {
    }
}
