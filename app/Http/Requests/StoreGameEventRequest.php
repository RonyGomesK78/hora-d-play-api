<?php

namespace App\Http\Requests;

use App\Enums\EventType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StoreGameEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "event_type" => ['required', Rule::in(EventType::values())],
            "minute" => "nullable|numeric",
            "team_id" => [
                "nullable",
                "uuid",
                "exists:teams,id",
                function ($attribute, $value, $fail) {
                    if (is_null($this->input('player_id')) && !is_null($value)) {
                        $fail("The {$attribute} must be null when player_id is null.");
                    }
                },
            ],
            "player_id" => [
                "nullable",
                "uuid",
                "exists:players,id",
                function ($attribute, $value, $fail) {
                    if (is_null($this->input('team_id')) && !is_null($value)) {
                        $fail("The {$attribute} must be null when team_id is null.");
                    }

                    // Check if player_id belongs to the provided team_id
                    if ($value && $this->input('team_id')) {
                        $player_exists = DB::table('players')
                            ->where('id', $value)
                            ->where('team_id', $this->input('team_id'))
                            ->exists();

                        if (!$player_exists) {
                            $fail("The selected player does not belong to the specified team.");
                        }
                    }
                },
            ],
        ];
    }
}
