<?php
namespace App\Service\Mercure;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class MercureService
{
    private $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }

    public function mercureMessage($data, $topic)
    {
        $topicUrl = '/chat_room/' . $topic;

        $update = new Update($topicUrl, json_encode([
            "username" => $data['username'],
            "user_id" => $data['user_id'],
            "value" => $data['message_value'],
            "createdAt" => $data['message_date'],
        ]), false);

        return $this->publishUpdate($update);
    }

    public function mercureRoom($message, $topic)
    {
        $topicUrl = 'select_room_' . $topic;

        $update = new Update($topicUrl, json_encode(['message' => $message]), false);

        return $this->publishUpdate($update);
    }

    private function publishUpdate($update)
    {
        try {
            $this->hub->publish($update);
            return [
                "code" => 200,
                "message" => 'published!'
            ];
        } catch (\Exception $e) {
            // Log the error for debugging
            error_log($e->getMessage());
            return [
                'code' => 500,
                'message' => 'Erreur lors de la publication : ' . $e->getMessage()
            ];
        }
    }
}
