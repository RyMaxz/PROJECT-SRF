<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\Pages\ManageTickets;
use App\Models\Facility;
use App\Models\SubCategory;
use App\Models\Ticket;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Ticket;

    protected static ?string $recordTitleAttribute = 'ticket_code';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Reservation Information')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                        Select::make('facility_id')
                            ->label('Fasilitas')
                            ->options(function (Get $get) {
                                return Facility::query()
                                    ->where('subcategory_id', $get('subcategory_id'))
                                    ->pluck('name', 'id');
                            })
                            ->required(),
                        Select::make('subcategory_id')
                            ->label('Gedung / Sub Kategori')
                            ->options(SubCategory::pluck('name', 'id'))
                            ->live()
                            ->dehydrated(false),
                        TextInput::make('event_name')
                            ->required(),
                        Textarea::make('purpose')
                            ->columnSpanFull(),
                        RichEditor::make('note')
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'in_use' => 'In use',
                                'completed' => 'Completed',
                                'rejected' => 'Rejected',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required(),
                        DateTimePicker::make('date')
                            ->label('Schedule')
                            ->required(),
                        DateTimePicker::make('date_end')
                            ->label('End Schedule')
                            ->required(),
                    ])->columns(2)->columnSpanFull(),

            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('facility.name')
                    ->label('Facility'),
                TextEntry::make('subcategory.name')
                    ->label('Sub Facility')
                    ->placeholder('-'),
                TextEntry::make('ticket_code'),
                TextEntry::make('event_name'),
                TextEntry::make('purpose')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('date')
                    ->date('d M Y')
                    ->placeholder('-'),
                TextEntry::make('date_end')
                    ->date('d M Y')
                    ->placeholder('-'),
                TextEntry::make('approved_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('checked_in_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('completed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('cancelled_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ticket_code')
                    ->label('Ticket Code')
                    ->searchable(),
                TextColumn::make('facility.name')
                    ->label('Facility')
                    ->searchable(),
                TextColumn::make('event_name')
                    ->label('Event Name')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('date')
                    ->date('d M Y H:i')
                    ->placeholder('-')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->alignCenter(),
                TextColumn::make('date_end')
                    ->date('d M Y H:i')
                    ->placeholder('-')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('approved_at')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->alignCenter()
                    ->description(function ($record) {
                        if (! $record->approved_at) {
                            return match ($record->status) {
                                'pending' => 'Awaiting approval',
                                'rejected' => 'Rejected',
                                'cancelled' => 'Cancelled before approval',
                                default => null,
                            };
                        }

                        return match ($record->status) {
                            'approved' => 'Approved (Awaiting check-in)',
                            'in_use' => $record->checked_in_at
                                ? 'Checked in '.Carbon::parse($record->checked_in_at)->diffForHumans()
                                : 'In use',
                            'completed' => $record->completed_at
                                ? 'Completed '.Carbon::parse($record->completed_at)->diffForHumans()
                                : 'Completed',
                            'cancelled' => $record->cancelled_at
                                ? 'Cancelled '.Carbon::parse($record->cancelled_at)->diffForHumans()
                                : 'Cancelled',
                            default => 'Approved',
                        };
                    }),
                TextColumn::make('checked_in_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('cancelled_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(fn ($record) => $record->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                    ]))->button(),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(fn ($record) => $record->update([
                        'status' => 'rejected',
                    ]))->button(),
                Action::make('checkIn')
                    ->label('Check In')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-right-end-on-rectangle')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'approved')
                    ->action(fn ($record) => $record->update([
                        'status' => 'in_use',
                        'checked_in_at' => now(),
                    ]))->button(),
                Action::make('complete')
                    ->label('Complete')
                    ->color('success')
                    ->icon('heroicon-o-check-badge')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'in_use')
                    ->action(fn ($record) => $record->update([
                        'status' => 'completed',
                        'completed_at' => now(),
                    ]))->button(),
                Action::make('cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'approved']))
                    ->action(fn ($record) => $record->update([
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                    ]))->button(),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTickets::route('/'),
        ];
    }
}
