<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Hero;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HeroResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HeroResource\RelationManagers;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // add field for image
                FileUpload::make('image')

                    ->image(),

                // add field for title
                TextInput::make('title')
                    ->placeholder('Enter Title')
                    ->required(),
                // add field for subtitle
                TextInput::make('subtitle')
                    ->placeholder('Enter Subtitle')
                    ->required(),
                // add field for link1
                TextInput::make('link1')
                    ->placeholder('Enter Link 1')
                    ->required(),
                // add field for link2
                TextInput::make('link2')
                    ->placeholder('Enter Link 2')
                    ->required(),

                // add file is_active
                Toggle::make('is_active')

                    ->default(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image'),
                // add title column
                TextColumn::make('title')
                    ->wrap()
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                // add subtitle column
                TextColumn::make('subtitle')
                    ->wrap()
                    ->label('Subtitle')
                    ->searchable()
                    ->sortable(),

                // add is active column
                ToggleColumn::make('is_active')

                    ->afterStateUpdated(function (Hero $hero, $state) {
                        // dd($state);
                        // dd($hero);
                        // set current data to active and the other to inactive
                        if ($state) {
                            Hero::where('id', '!=', $hero->id)->update(['is_active' => false]);
                        }

                    })

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}
