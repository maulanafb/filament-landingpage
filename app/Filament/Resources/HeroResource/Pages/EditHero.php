<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditHero extends EditRecord
{
    protected static string $resource = HeroResource::class;
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $hero = parent::handleRecordUpdate($record, $data);
        if ($hero->is_active) {
            HeroResource::getModel()::where('id', '!=', $hero->id)->update(['is_active' => false]);
        }

        return $hero;
    }
}
