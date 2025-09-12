<?php
declare(strict_types=1);

namespace OCA\TalkWidget\Dashboard;

use OCP\Dashboard\IAPIWidget;
use OCP\AppFramework\Services\IInitialState;
use OCP\IL10N;
use OCP\Util;
use OCA\TalkWidget\AppInfo\Application;
use OCA\TalkWidget\Service\TalkService;

class TalkWidget implements IAPIWidget {
    private IL10N $l10n;
    private TalkService $talkService;
    private IInitialState $initialStateService;
    private ?string $userId;

    public function __construct(
        IL10N $l10n,
        TalkService $talkService,
        IInitialState $initialStateService,
        ?string $userId
    ) {
        $this->l10n = $l10n;
        $this->talkService = $talkService;
        $this->initialStateService = $initialStateService;
        $this->userId = $userId;
    }

    public function getId(): string {
        return 'talkwidget-dashboard-widget';
    }

    public function getTitle(): string {
        return $this->l10n->t('Talk Room Widget');
    }

    public function getOrder(): int {
        return 10;
    }

    public function getIconClass(): string {
        return 'icon-talkwidget';
    }

    public function getUrl(): ?string {
        return null;
    }

public function load(): void {
    if ($this->userId !== null) {
        $roomId = 'n3xtc10ud'; // Replace with actual room ID
        $items = $this->talkService->getRoomMessages($roomId);
        $this->initialStateService->provideInitialState('dashboard-talk-messages', $items);
    }

    // Load JS & CSS
    \OCP\Util::addScript(\OCA\TalkWidget\AppInfo\Application::APP_ID, 'dashboardTalk');
    \OCP\Util::addStyle(\OCA\TalkWidget\AppInfo\Application::APP_ID, 'dashboard');
}


    public function getItems(string $userId, ?string $since = null, int $limit = 7): array {
        $roomId = 'n3xtc10ud'; // Replace with actual room ID
        return $this->talkService->getRoomMessages($roomId, $limit, $since);
    }
}
