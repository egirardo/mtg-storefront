<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\SingleProduct;
use App\Models\SealedProduct;

class MtgSeeder extends Seeder
{

    protected array $sealedTypes = [
        'booster_box',
        'bundle',
        'prerelease_kit',
        'collector_booster_box',
    ];

    protected array $sealedLabels = [
        'booster_box'           => 'Booster Box',
        'bundle'                => 'Bundle',
        'prerelease_kit'        => 'Prerelease Kit',
        'collector_booster_box' => 'Collector Booster Box',
    ];
    protected array $sealedImages = [
        'MH3' => [
            'booster_box'           => 'https://tcgplayer-cdn.tcgplayer.com/product/541164_in_1000x1000.jpg',
            'bundle'                => 'https://tcgplayer-cdn.tcgplayer.com/product/541190_in_1000x1000.jpg',
            'prerelease_kit'        => 'https://tcgplayer-cdn.tcgplayer.com/product/541159_in_1000x1000.jpg',
            'collector_booster_box' => 'https://tcgplayer-cdn.tcgplayer.com/product/541179_in_1000x1000.jpg',
        ],
    ];

    public function run(): void
    {
        $setCode = 'MH3'; // Modern Horizons 3


        $this->command->info("Fetching {$setCode}...");

        $response = Http::timeout(30)->get("https://mtgjson.com/api/v5/{$setCode}.json");

        if (!$response->ok()) {
            $this->command->warn("Failed to fetch {$setCode}, skipping.");
            return;
        }

        $setData = $response->json('data');
        $setName = $setData['name'];
        $cards = array_slice(
            array_filter($setData['cards'] ?? [], fn($c) => ($c['layout'] ?? '') === 'normal'),
            0,
            10
        );

        // --- Seed Singles ---
        foreach ($cards as $card) {
            // Skip tokens, art cards, etc.
            if (($card['layout'] ?? '') !== 'normal') {
                continue;
            }

            $scryfallId = $card['identifiers']['scryfallId'] ?? null;
            $imageUrl   = $scryfallId
                ? $this->buildScryfallUrl($scryfallId)
                : null;

            $colors = $card['colors'] ?? [];
            $colorMap = [
                'W' => 'White',
                'U' => 'Blue',
                'B' => 'Black',
                'R' => 'Red',
                'G' => 'Green',
            ];
            $colorString = empty($colors)
                ? 'Colorless'
                : implode(',', array_map(fn($c) => $colorMap[$c] ?? $c, $colors));

            $product = Product::create([
                'product_name' => $card['name'],
                'category_id'  => 1,
                'price'        => $this->priceByRarity($card['rarity'] ?? 'common'),
                'stock'        => 20,
                'image'        => $imageUrl,
            ]);

            SingleProduct::create([
                'product_id'     => $product->product_id,
                'rarity'         => ucfirst($card['rarity'] ?? 'common'),
                'color'          => $colorString,
                'number'         => $card['number'] ?? null,
                'set_name_single' => $setName,
            ]);
        }

        $this->command->info("  ✓ Seeded " . count($cards) . " singles for {$setName}");

        // --- Seed Sealed ---

        foreach ($this->sealedTypes as $type) {
            $product = Product::create([
                'product_name' => $setName . ' ' . $this->sealedLabels[$type],
                'category_id'  => 2,
                'price'        => $this->priceByType($type),
                'stock'        => 15,
                'image'        => $this->sealedImages[$setCode][$type] ?? "https://svgs.scryfall.io/sets/" . strtolower($setCode) . ".svg",
            ]);

            SealedProduct::create([
                'product_id'          => $product->product_id,
                'set_name'            => $setName,
                'product_type_sealed' => $type,
            ]);
        }

        $this->command->info("  ✓ Seeded " . count($this->sealedTypes) . " sealed products for {$setName}");
    }

    private function buildScryfallUrl(string $scryfallId): string
    {
        $a = $scryfallId[0];
        $b = $scryfallId[1];
        return "https://cards.scryfall.io/normal/front/{$a}/{$b}/{$scryfallId}.jpg";
    }

    private function priceByRarity(string $rarity): float
    {
        return match (strtolower($rarity)) {
            'mythic'   => 29.99,
            'rare'     => 9.99,
            'uncommon' => 1.49,
            default    => 0.25,
        };
    }

    private function priceByType(string $type): float
    {
        return match ($type) {
            'booster_box'           => 119.99,
            'collector_booster_box' => 239.99,
            'bundle'                => 44.99,
            'prerelease_kit'        => 29.99,
            default                 => 29.99,
        };
    }
}
