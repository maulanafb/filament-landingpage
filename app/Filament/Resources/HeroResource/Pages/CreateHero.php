<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateHero extends CreateRecord
{
    protected static string $resource = HeroResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    // override handle record creation
    protected function handleRecordCreation(array $data): Model
    {
        //if the current data set to active and the other to inactive
        $hero = parent::handleRecordCreation($data);
        if ($hero->is_active) {
            HeroResource::getModel()::where('id', '!=', $hero->id)->update(['is_active' => false]);
        }

        return $hero;
    }

}
