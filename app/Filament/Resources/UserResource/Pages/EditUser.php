<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $role = $data['roles'];
        unset($data['roles']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncRoles([$this->data['roles']]); // Sinkronisasi role
    }
}
