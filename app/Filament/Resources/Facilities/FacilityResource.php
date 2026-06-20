<?php

namespace App\Filament\Resources\Facilities;

use App\Filament\Resources\Facilities\Pages\ManageFacilities;
use App\Models\Category;
use App\Models\Facility;
use App\Models\SubCategory;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::BuildingOffice2;
    protected static string|UnitEnum|null $navigationGroup = 'Facility Management';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        $generateFacilityCode = function (Get $get, Set $set) {
            $categoryId = $get('category_id');
            $subCategoryId = $get('subcategory_id'); 

            // 1. Jika Kategori belum dipilih, jangan lakukan apa-apa
            if (!$categoryId) {
                return; 
            }

            $category = Category::whereKey($categoryId)->first();
            if (!$category) {
                return;
            }

            // 2. Buat Prefix Dasar dari Kategori (3 Huruf Pertama)
            $catPrefix = strtoupper(Str::substr($category->name, 0, 3));
            $prefix = $catPrefix . '-'; // Contoh: "GED-"

            // 3. Cek apakah Subkategori dipilih (Karena sekarang opsional)
            if ($subCategoryId) {
                $subCategory = SubCategory::whereKey($subCategoryId)->first();
                
                if ($subCategory) {
                    $name = $subCategory->name;
                    $len = strlen($name);
                    
                    // Ambil karakter: Awal, Tengah, Akhir (minimal panjang nama 3 karakter)
                    if ($len >= 3) {
                        $first = substr($name, 0, 1); // Huruf ke-1
                        $middle = substr($name, floor($len / 2), 1); // Huruf tengah
                        $last = substr($name, -1); // Karakter/Angka di akhir
                        
                        $subPrefix = strtoupper($first . $middle . $last);
                    } else {
                        // Jika nama subkategori cuma 1-2 huruf, ambil apa adanya
                        $subPrefix = strtoupper($name);
                    }
                    
                    // Tambahkan prefix subkategori ke prefix utama (Contoh: "GED-LPR-")
                    $prefix .= $subPrefix . '-'; 
                }
            }

            // 4. Cari urutan kode terakhir di database berdasarkan prefix saat ini
            $lastCode = Facility::where('code', 'like', $prefix . '%', 'and')
                ->orderBy('code', 'desc')
                ->value('code');

            if ($lastCode) {
                // Ambil angka di belakang prefix dan tambahkan 1
                $number = (int) substr($lastCode, strlen($prefix));
                $nextNumber = $number + 1;
            } else {
                $nextNumber = 1;
            }

            // 5. Format menjadi 3 digit dan gabungkan
            $code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            
            $set('code', $code);
        };


        return $schema
            ->components([
                Select::make('category_id')
                    ->required()
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->live()
                    ->afterStateUpdated($generateFacilityCode), // Panggil fungsi di atas
                Select::make('subcategory_id')
                    ->label('Subcategory')
                    ->relationship('subcategory', 'name')
                    ->live()
                    ->afterStateUpdated($generateFacilityCode), // Panggil fungsi yang sama
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->readOnly()
                    ->required(),
                TextInput::make('capacity')
                    ->numeric(),
                Toggle::make('is_available')
                    ->required(),
                RichEditor::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('subcategory.name')
                    ->label('Subcategory'),
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('capacity')
                    ->numeric(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->html()
                    ->columnSpanFull(),
                IconEntry::make('is_available')
                    ->boolean(),
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
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('subcategory.name')
                    ->label('Location')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_available')
                    ->boolean()
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
            'index' => ManageFacilities::route('/'),
        ];
    }
}
