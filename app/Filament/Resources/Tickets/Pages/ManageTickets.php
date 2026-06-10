<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Filament\Resources\Tickets\TicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTickets extends ManageRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    return $this->mutateFormDataBeforeCreate($data);
                }),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ticket_code'] = 'REQ'.now()->format('Ymd').'-'.strtoupper(str()->random(4));

        return $data;
    }
}
