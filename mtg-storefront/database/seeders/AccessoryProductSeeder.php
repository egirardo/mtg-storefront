<?php

namespace Database\Seeders;

use App\Models\AccessoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class AccessoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private function priceByType(string $type): float
    {
        return match ($type) {
            'Playmat'          => 34.99,
            'Deck Box'         => 19.99,
            'Card Sleeves'     => 9.99,
            'Binder'           => 24.99,
            'Toploader'        => 4.99,
            'Card Storage Box' => 14.99,
            default            => 14.99,
        };
    }
    private function resolveImage(string $brand, string $type): string
    {
        $images = [
            'Dragon Shield' => [
                'Card Sleeves' => 'https://www.dragonshield.com/_next/image?url=https%3A%2F%2Fimages.cdn.europe-west1.gcp.commercetools.com%2Fe7c2ee64-8f38-4279-b057-5d3aeb215469%2FAT-16501-MTG100-MATT-_w_o5J9r.png&w=1080&q=75',
                'Deck Box'     => 'https://www.dragonshield.com/_next/image?url=https%3A%2F%2F97bc04b8bc9c8225faf2-4d11409729ec20784fbb81e5e6afe111.ssl.cf3.rackcdn.com%2FAT-20006-DS-STRONGBO-FTI8eZB-.png&w=1080&q=75',
                'Playmat'      => 'https://www.dragonshield.com/_next/image?url=https%3A%2F%2Fimages.cdn.europe-west1.gcp.commercetools.com%2Fe7c2ee64-8f38-4279-b057-5d3aeb215469%2FAT-20519-DS-PLAYMAT--_uSgk8O2.png&w=1080&q=75',
                'Binder'       => 'https://www.dragonshield.com/_next/image?url=https%3A%2F%2Fimages.cdn.europe-west1.gcp.commercetools.com%2Fe7c2ee64-8f38-4279-b057-5d3aeb215469%2FAT-39503-DS-ART-ZIPS-LwwOcTj2.png&w=1080&q=75',
            ],
            'Ultra Pro' => [
                'Card Sleeves' => 'https://ultrapro.com/cdn/shop/files/38801_DP_MTG_TDM_TemurCommander_Single.jpg?v=1762444837&width=900',
                'Deck Box'     => 'https://ultrapro.com/cdn/shop/products/Xm0NZHQA.png?v=1762440401&width=900',
                'Playmat'      => 'https://ultrapro.com/cdn/shop/files/38848_Blk_Mat_MTG_TDM_Temur_Front_d0a0677c-1da4-452a-bf6c-8c737d0517f6.jpg?v=1759500667&width=900',
                'Toploader'    => 'https://ultrapro.com/cdn/shop/products/84916_TL_GreenBrdr_Angle.jpg?v=1766531398&width=900',
                'Binder'       => 'https://ultrapro.com/cdn/shop/files/38735_12PktProBinder_MTG_FIN_Front-min.png?v=1762445053&width=900',
            ],
            'Ultimate Guard' => [
                'Deck Box'         => 'https://ultimateguard.com/thumbnail/b8/36/95/1772485826/UGD011808_0001_solo_1006x1200.webp',
                'Binder'           => 'https://ultimateguard.com/thumbnail/b1/02/e0/1772486430/UGD011715_0003_solo_1092x1200.webp',
                'Card Storage Box' => 'https://ultimateguard.com/thumbnail/90/53/0e/1772486612/UGD011250_m_1200x837.webp',
                'Card Sleeves'     => 'https://ultimateguard.com/thumbnail/40/f2/84/1772487124/UGD011771_0000_solo_1061x1200.webp',
            ],
            'Gamegenic' => [
                'Deck Box'         => 'https://www.gamegenic.com/wp-content/uploads/2022/06/GG_Squire_XL-Red-0003_8kxUSwQfo.jpg',
                'Card Sleeves'     => 'https://www.gamegenic.com/wp-content/uploads/2026/01/GG-MTG-Lorwyn-Eclipsed-Art-Sleeves-Auntie-Ool-Cursewretch-0000_B5LFQWkAx.jpg',
                'Card Storage Box' => 'https://www.gamegenic.com/wp-content/uploads/GG_CardsLair400_Blue_0000.jpg',
                'Binder'           => 'https://www.gamegenic.com/wp-content/uploads/2026/01/GG_MTG_Casual-18-Pocket_ECL-Merfolk_Render_Front_0000_SKi6vpsrf.jpg',
            ],
            'BCW' => [
                'Toploader'        => 'https://www.bcwsupplies.com/media/catalog/product/cache/b62e8586ee0110916688f2b39b35a685/1/-/1-tlch_4_mtg.png',
                'Card Storage Box' => 'https://www.bcwsupplies.com/media/catalog/product/cache/b62e8586ee0110916688f2b39b35a685/1/-/1-ccat-whi_angle-open-mtg.png',
                'Card Dividers'    => 'https://www.bcwsupplies.com/media/catalog/product/cache/b62e8586ee0110916688f2b39b35a685/1/-/1-tcd_1_pair.jpg',
            ],
        ];

        $url = $images[$brand][$type] ?? '';

        return $url !== ''
            ? $url
            : "https://placehold.co/400x400?text=" . urlencode("{$brand} {$type}");
    }

    public function run(): void
    {
        $accessories = [
            ['brand' => 'Dragon Shield', 'type' => 'Card Sleeves'],
            ['brand' => 'Dragon Shield', 'type' => 'Deck Box'],
            ['brand' => 'Ultra Pro',     'type' => 'Playmat'],
            ['brand' => 'Ultra Pro',     'type' => 'Binder'],
            ['brand' => 'Ultimate Guard', 'type' => 'Deck Box'],
            ['brand' => 'Ultimate Guard', 'type' => 'Card Sleeves'],
            ['brand' => 'Gamegenic',     'type' => 'Card Storage Box'],
            ['brand' => 'Gamegenic',     'type' => 'Binder'],
            ['brand' => 'BCW',           'type' => 'Toploader'],
            ['brand' => 'BCW',           'type' => 'Card Storage Box'],
        ];

        foreach ($accessories as $item) {
            $product = Product::create([
                'category_id'  => 3,
                'product_name' => "{$item['brand']} {$item['type']}",
                'price'        => $this->priceByType($item['type']),
                'stock'        => 30,
                'image'        => $this->resolveImage($item['brand'], $item['type']),
            ]);

            AccessoryProduct::create([
                'product_id'   => $product->product_id,
                'brand'        => $item['brand'],
                'product_type' => $item['type'],
            ]);
        }
    }
}
