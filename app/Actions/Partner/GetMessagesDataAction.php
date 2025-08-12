<?php

namespace App\Actions\Partner;

use App\Services\Partner\MessageService;

class GetMessagesDataAction
{
    public function __construct(
        private MessageService $messageService
    ) {}

    public function execute(): array
    {
        return [
            'conversations' => $this->messageService->getConversations(),
            'activeConversation' => $this->messageService->getActiveConversation(),
            'unreadCount' => $this->messageService->getUnreadCount()
        ];
    }
}