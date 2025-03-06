<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Item;

class getData extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'app:get-data';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        // データをリセットする
        Item::truncate();

        $url = 'https://services.mybcapps.com/bc-sf-filter/filter?t=1740998853204&_=pf&shop=salomonjp.myshopify.com&limit=16&sort=best-selling&display=grid&collection_scope=637398188341&tag=&product_available=false&variant_available=false&build_filter_tree=false&check_cache=false&locale=ja&sid=f56616d6-dbf5-4e87-a455-9f8119baef18&callback=BoostPFSFilterCallback&event_type=page';
        $step = 1;

        $getCategorys = [
            'スノーボードブーツ',
            
        ];

        while (true) {
            // データ取得
            $response = Http::get($url . "&page=" . $step);
            $responseBody = $response->body();

            // データ加工 
            $torimingBody = preg_replace('/^.*?BoostPFSFilterCallback\(|\);?\s*$/s', '', $responseBody);
            $data = json_decode($torimingBody, true);

            if (count($data["products"]) == 0) {
                break;
            }

            // データ出力
            foreach ($data['products'] as $pref){
                // print_r($pref["title"] . " : " . $pref["price_max"] . "\r\n");
                
                foreach($getCategorys as $category){
                    if (in_array($category, $pref['tags'])) {
                        Item::create([
                            'title' => $pref['title'],
                            'category' => $category,
                        ]);
                        break;
                    }
                }
            }
            
            
            $step++;
        }
        
        
        
        
    }
}
