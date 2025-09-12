<?php
declare(strict_types=1);

namespace OCA\TalkWidget\Controller;

use OCA\TalkWidget\Service\TalkService;
use OCP\AppFramework\Http\Attribute\ApiRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\OCSController;
use OCP\IRequest;

class ApiController extends OCSController {
    private TalkService $talkService;

    public function __construct(string $appName, IRequest $request, TalkService $talkService) {
        parent::__construct($appName, $request);
        $this->talkService = $talkService;
    }

    #[NoAdminRequired]
    #[ApiRoute(verb: 'GET', url: '/api/messages')]
    public function getMessages(): DataResponse {
        $roomId = $this->request->getParam('roomId');
        if (!$roomId) {
            return new DataResponse(['error' => 'Missing roomId'], 400);
        }

        $messages = $this->talkService->getRoomMessages($roomId);
        $result = [];
        foreach ($messages as $item) {
            $result[] = [
                'id' => $item->getId(),
                'message' => $item->getName(),
            ];
        }

        return new DataResponse($result);
    }

    #[NoAdminRequired]
    #[ApiRoute(verb: 'POST', url: '/api/send')]
    public function sendMessage(): DataResponse {
        $data = json_decode(file_get_contents('php://input'), true);
        $roomId = $data['roomId'] ?? '';
        $message = $data['message'] ?? '';

        if (!$roomId || !$message) {
            return new DataResponse(['error' => 'Missing roomId or message'], 400);
        }

        $success = $this->talkService->sendMessage($roomId, $message);

        return new DataResponse(['success' => $success]);
    }
}
