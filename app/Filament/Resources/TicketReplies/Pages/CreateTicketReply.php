<?php

namespace App\Filament\Resources\TicketReplies\Pages;

use App\Filament\Resources\TicketReplies\TicketReplyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketReply extends CreateRecord
{
    protected static string $resource = TicketReplyResource::class;

    // <<< Add this method
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically assign the logged-in user
        $data['user_id'] = auth()->id();
        return $data;
    }
}
