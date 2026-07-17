<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Filament\Exports\TicketExporter;
use App\Filament\Resources\Tickets\TicketResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTickets extends ManageRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(TicketExporter::class),

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
