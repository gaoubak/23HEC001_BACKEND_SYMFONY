<?php

namespace App\Service\Mercure;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Bundle\MercureBundle\Mercure;

class MercureService{

    private $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }
    

    public function mercureMessage($data, $topic){
        // Ici, vous ajoutez le topic à l'URL
        $topicUrl = '/chat_room/' . $topic;

        // Créer un nouvel objet Update avec l'URL du topic
        $update = new Update($topicUrl, json_encode([
        "username" => $data['username'],
        "user_id" => $data['user_id'],
        "value" => $data['message_value'],
        "createdAt" => $data['message_date'],
    ]), false);
        
        // Publier l'update
        try {
            $this->hub->publish($update);
            return [
                "code" => 200,
                "message" => 'published!'
            ];
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            error_log($e->getMessage());
            return [
                'code' => 500,
                'message' => 'Erreur lors de la publication : '. $e
            ];
        }
    }
    public function mercureRoom($message, $topic){
        $topic = 8;
        // Ici, vous ajoutez le topic à l'URL
        $topicUrl = 'select_room_' . $topic;

        // Créer un nouvel objet Update avec l'URL du topic
        $update = new Update($topicUrl, json_encode(['message' => $message]), false);
        
        // Publier l'update
        try {
            $this->hub->publish($update);
            return [
                "code" => 200,
                "message" => 'published!'
            ];
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            error_log($e->getMessage());
            return [
                'code' => 500,
                'message' => 'Erreur lors de la publication : '. $e
            ];
        }
    }
    
}