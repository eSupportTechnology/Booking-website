<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveLanguagesDTO extends ValidatedDTO
{
    /** @var int[] */
    public array $languages;

    public function rules(): array
    {
        return [
            'languages' => ['required', 'array'],
            'languages.*' => ['exists:languages,id'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'languages' => [],
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
