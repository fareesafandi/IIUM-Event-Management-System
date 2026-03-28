<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only event managers can create events
        return auth()->check() && auth()->user()->isEventManager();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'poster_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'poster_image_url' => ['nullable', 'url', 'max:500'],
            'status' => ['required', Rule::in(['open', 'closed', 'full', 'cancelled', 'upcoming'])],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'organizer_name' => ['nullable', 'string', 'max:255'],
            'organizer_contact' => ['nullable', 'string', 'max:20'],
            'organizer_email' => ['nullable', 'email', 'max:255'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The event title is required.',
            'description.required' => 'The event description is required.',
            'venue.required' => 'The venue is required.',
            'date.required' => 'The event date is required.',
            'date.after_or_equal' => 'The event date must be today or a future date.',
            'time.required' => 'The event time is required.',
            'time.date_format' => 'Please provide a valid time format (HH:MM).',
            'poster_image.image' => 'The poster must be an image file.',
            'poster_image.mimes' => 'The poster must be a JPG or PNG file.',
            'poster_image.max' => 'The poster image must not exceed 2MB.',
            'poster_image_url.url' => 'Please provide a valid image URL.',
            'status.required' => 'The event status is required.',
            'max_participants.min' => 'Maximum participants must be at least 1.',
            'categories.*.exists' => 'One or more selected categories are invalid.',
        ];
    }
}
