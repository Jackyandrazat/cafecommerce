<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $role = $data['roles']; // Ambil role dari form
        unset($data['roles']); // Hapus dari $data agar tidak disimpan di tabel users

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->assignRole($this->data['roles']); // Tetapkan role ke pengguna
    }
}
