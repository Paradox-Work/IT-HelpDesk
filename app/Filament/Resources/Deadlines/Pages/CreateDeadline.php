<?php

namespace App\Filament\Resources\Deadlines\Pages;

use App\Filament\Resources\Deadlines\DeadlineResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeadline extends CreateRecord
{
    protected static string $resource = DeadlineResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
