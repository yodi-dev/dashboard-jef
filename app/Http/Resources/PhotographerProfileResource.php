<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotographerProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $journeyParagraphs = array_values(array_filter(array_map('trim', explode("\n", $this->about_journey ?? ''))));

        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'tagline'             => $this->tagline,
            'headline'            => $this->headline,
            'sub_headline'        => $this->sub_headline,
            'quote'               => $this->quote,
            'about_title'         => $this->about_title,
            'about_journey'       => $this->about_journey,
            'about_philosophy'    => $this->about_philosophy,
            'journey_paragraphs'  => $journeyParagraphs,
            'philosophy_1_title'  => $this->philosophy_1_title,
            'philosophy_1_desc'   => $this->philosophy_1_desc,
            'philosophy_2_title'  => $this->philosophy_2_title,
            'philosophy_2_desc'   => $this->philosophy_2_desc,
            'philosophy_3_title'  => $this->philosophy_3_title,
            'philosophy_3_desc'   => $this->philosophy_3_desc,
            'philosophies'        => [
                [
                    'number'      => '01',
                    'title'       => $this->philosophy_1_title ?: 'Natural Ambient Light',
                    'description' => $this->philosophy_1_desc ?: '',
                ],
                [
                    'number'      => '02',
                    'title'       => $this->philosophy_2_title ?: 'The Unrehearsed Moment',
                    'description' => $this->philosophy_2_desc ?: '',
                ],
                [
                    'number'      => '03',
                    'title'       => $this->philosophy_3_title ?: 'Archival Craftsmanship',
                    'description' => $this->philosophy_3_desc ?: '',
                ],
            ],
            'avatar'              => $this->avatar_url,
            'location'            => $this->location,
            'email'               => $this->email,
            'phone'               => $this->phone,
            'instagram'           => $this->instagram,
            'instagram_url'       => $this->instagram_url,
        ];
    }
}
