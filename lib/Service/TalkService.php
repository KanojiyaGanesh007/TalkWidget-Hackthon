<?php
declare(strict_types=1);

namespace OCA\TalkWidget\Service;

use OCP\IUserManager;
use OCP\IURLGenerator;
use OCP\Dashboard\Model\WidgetItem;

class TalkService {
    private IUserManager $userManager;
    private IURLGenerator $urlGenerator;
    private string $talkApiBase;

    public function __construct(IUserManager $userManager, IURLGenerator $urlGenerator) {
        $this->userManager = $userManager;
        $this->urlGenerator = $urlGenerator;

        // Standard Talk OCS API (no bot)
        $this->talkApiBase = \OC::$server->getURLGenerator()->getAbsoluteURL(
            '/ocs/v2.php/apps/spreed/api/v4'
        );
    }

    /**
     * Fetch messages from a conversation (room)
     * Falls back to dummy messages if API request fails
     */
    public function getRoomMessages(string $roomToken, int $limit = 10): array {
        $url = $this->talkApiBase . "/chat/{$roomToken}?limit=" . $limit;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "OCS-APIRequest: true"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $_SERVER['HTTP_COOKIE']); // use logged-in user's session

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $items = [];
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if (!empty($data['ocs']['data'])) {
                foreach ($data['ocs']['data'] as $msg) {
                    $items[] = new WidgetItem(
                        $msg['message'] ?? '',
                        '', '#', '#', (string)($msg['id'] ?? '0')
                    );
                }
            }
        }

        // ✅ Dummy fallback for presentation
        if (empty($items)) {
            $items = [
                new WidgetItem('User1: Hello!', '', '#', '#', '1'),
                new WidgetItem('User2: Hi there!', '', '#', '#', '2'),
                new WidgetItem('User3: How are you?', '', '#', '#', '3'),
            ];
        }

        return $items;
    }

    /**
     * Send a message to a conversation (room)
     */
    public function sendMessage(string $roomToken, string $message): bool {
        $url = $this->talkApiBase . "/chat/{$roomToken}";

        $payload = http_build_query([
            'message' => $message,
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "OCS-APIRequest: true",
            "Content-Type: application/x-www-form-urlencoded",
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $_SERVER['HTTP_COOKIE']); // reuse session

        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode === 201;
    }
}
