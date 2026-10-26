<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Portfolio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPortfolios();
        $this->seedArticles();
    }

    private function seedPortfolios(): void
    {
        $portfolios = [
            [
                'title' => 'The Campbell Family at Manly Beach',
                'slug' => 'the-campbell-family-at-manly-beach',
                'category' => 'Family',
                'description' => 'A relaxed, barefoot late-afternoon session with the Campbell family. Golden sunlight bouncing off the pacific ocean as their two young boys played tag in the sand.',
                'thumbnail' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1542037104857-ffbb0b9155fb?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1609220136736-443140cffec6?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => true,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Aria — Natural Light Golden Hour',
                'slug' => 'aria-natural-light-golden-hour',
                'category' => 'Portrait',
                'description' => 'Capturing candid expressions under soft 35mm lens rendering. Focused on natural skin tones, ambient rim light, and effortless gaze.',
                'thumbnail' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => true,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Liam & Chloe — Coastal Sunset Romance',
                'slug' => 'liam-chloe-coastal-sunset-romance',
                'category' => 'Couple',
                'description' => 'An intimate couple session along the rugged coastline of Byron Bay. Unscripted laughter, hand-in-hand seaside walks, and twilight warmth.',
                'thumbnail' => 'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => true,
                'published_at' => Carbon::now()->subDays(8),
            ],
            [
                'title' => 'Baby Leo — First Two Weeks of Wonder',
                'slug' => 'baby-leo-first-two-weeks-of-wonder',
                'category' => 'Newborn',
                'description' => 'A quiet, gentle in-home lifestyle newborn shoot. Wrapped in organic linen next to a window casting soft diffused morning light.',
                'thumbnail' => 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'The Artisan Ceramicist at Work',
                'slug' => 'the-artisan-ceramicist-at-work',
                'category' => 'Work Documentary',
                'description' => 'Documenting the tactile craft of hand-thrown stoneware pottery in an old Melbourne brick warehouse. Clay dust, wheel spin, and focused dedication.',
                'thumbnail' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Archie — Joyful Coastal Retriever',
                'slug' => 'archie-joyful-coastal-retriever',
                'category' => 'Animal',
                'description' => 'Energetic dog portraiture at dawn. Catching the pure, uninhibited happiness of Archie sprinting through tidal pools.',
                'thumbnail' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(18),
            ],
            [
                'title' => 'Eucalyptus & Morning Dew',
                'slug' => 'eucalyptus-and-morning-dew',
                'category' => 'Plant',
                'description' => 'Macro and ambient botanical study of native Australian eucalyptus leaves backlit by early morning mist.',
                'thumbnail' => 'https://images.unsplash.com/photo-1457530378978-8bac673b8062?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Chasing Ocean Barrels at Sunrise',
                'slug' => 'chasing-ocean-barrels-at-sunrise',
                'category' => 'Sports',
                'description' => 'Action surf photography at Snapper Rocks. Freezing the high-speed velocity, ocean spray, and golden water reflections.',
                'thumbnail' => 'https://images.unsplash.com/photo-1502680390469-be75c86b636f?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(22),
            ],
            [
                'title' => 'Acoustic Garden Gathering',
                'slug' => 'acoustic-garden-gathering',
                'category' => 'Event',
                'description' => 'Intimate backyard musical performance under warm string lights. Capturing the connection between musician and audience in natural ambience.',
                'thumbnail' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(25),
            ],
            [
                'title' => 'The Glasshouse 30th Birthday',
                'slug' => 'the-glasshouse-30th-birthday',
                'category' => 'Celebration',
                'description' => 'An evening of candlelit tables, sparkling toasts, and genuine celebratory embraces in a historic glasshouse venue.',
                'thumbnail' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(28),
            ],
            [
                'title' => 'Great Ocean Road Odyssey',
                'slug' => 'great-ocean-road-odyssey',
                'category' => 'Travel',
                'description' => 'Winding coastal cliffs, towering sea stacks, and dramatic tempestuous skies along Victoria\'s world-famous coastline.',
                'thumbnail' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?q=80&w=1200&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1200&auto=format&fit=crop',
                ],
                'is_published' => true,
                'is_highlight' => true,
                'published_at' => Carbon::now()->subDays(30),
            ],
        ];

        foreach ($portfolios as $data) {
            Portfolio::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }

    private function seedArticles(): void
    {
        $articles = [
            [
                'title' => 'The Magic of Golden Hour',
                'slug' => 'golden-hour',
                'excerpt' => 'Golden hour is every photographer’s best friend. Here is how I use ambient natural light to craft timeless photographs without heavy artificial flash equipment.',
                'content' => "Golden hour is a magical time for photographers. The soft, warm light transforms ordinary scenes into breathtaking images.\n\nI often schedule portrait and family sessions during the 60 minutes before sunset to take advantage of the gentle contrast, golden highlights, and long, flattering shadows.\n\nIn portraiture, this light brings an emotional depth and tenderness that flash photography struggles to replicate naturally. When the sun dips near the horizon, skin tones warm up, eyes catch genuine glints of golden light, and subjects feel inherently relaxed.\n\nMy advice to aspiring photographers: put down the external flashes for a season. Learn to read the direction of ambient light, position your subjects with intention, and let nature provide the magic.",
                'cover_image' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?q=80&w=1200&auto=format&fit=crop',
                'is_published' => true,
                'is_highlight' => true,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Why I Love Family Photography',
                'slug' => 'family-photography',
                'excerpt' => 'Family sessions are not just photos—they are living pieces of history that bridge generations. Here are reflections on documenting intimate family milestones.',
                'content' => "Family photography is about far more than matching outfits or posed smiles looking directly into the camera lens.\n\nIt is about capturing connection: the spontaneous burst of laughter when dad spins a toddler around, the quiet handhold between grandparents, the comforting embrace as the waves lap against little toes.\n\nEvery session brings something new and reminds me why I love what I do. Children grow remarkably fast, and before long, the messy toddler years transition into teenage independence. Having honest, artful photographs of these fleeting chapters allows families to travel back in time decades from now.",
                'cover_image' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?q=80&w=1200&auto=format&fit=crop',
                'is_published' => true,
                'is_highlight' => true,
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Minimal Gear, Maximum Impact',
                'slug' => 'minimal-gear',
                'excerpt' => 'Having an arsenal of camera lenses does not make an image evocative. Here is why I choose a single prime lens and deep human rapport.',
                'content' => "Early in my photography journey, I thought the secret to better photos lay inside gear catalogs. I carried multiple camera bodies, heavy zoom lenses, diffusers, and tripods.\n\nYet, my favorite images always happened when I stripped away the clutter. Today, I shoot almost 90% of my sessions with a single 35mm or 50mm prime lens.\n\nWhen you stop fidgeting with camera bags and lens swaps, something transformative happens: your subject stops feeling like a model under inspection and starts feeling like a partner in a shared creative moment. Minimal gear allows maximum presence.",
                'cover_image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=1200&auto=format&fit=crop',
                'is_published' => true,
                'is_highlight' => true,
                'published_at' => Carbon::now()->subDays(14),
            ],
            [
                'title' => 'Chasing Sydney Mornings: Coastal Walks with a Camera',
                'slug' => 'sydney-mornings',
                'excerpt' => 'Before the city awakens, the coastline belongs to the gentle roar of waves and soft pastel hues of early dawn.',
                'content' => "There is a profound stillness that envelops Sydney's coastal cliffs at 5:30 in the morning. Long before the joggers and surfers pack the promenade, the sky turns shades of lilac, blush pink, and pale gold.\n\nWalking the coastal path from Bondi to Bronte with a camera in hand has been my greatest teacher. It taught me patience: waiting for the exact wave break, waiting for a solitary silhouette against the infinite horizon.\n\nThese solitary morning walks continue to inspire the color palette and atmosphere I bring to my client sessions.",
                'cover_image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1200&auto=format&fit=crop',
                'is_published' => true,
                'is_highlight' => false,
                'published_at' => Carbon::now()->subDays(21),
            ],
        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}

