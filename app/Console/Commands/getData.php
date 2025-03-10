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
    *///php artisan app:get-data と入力すると、このコマンドが実行されます
    protected $signature = 'app:get-data';
    
    /**
    * The console command description.
    *
    * @var string
    *///商品のデータを取得し、データベースに保存する 
    protected $description = 'Command description';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        // データをリセットする
        Item::truncate();

        //APIのURLとカテゴリを定義
        $url = 'https://services.mybcapps.com/bc-sf-filter/filter?t=1740998853204&_=pf&shop=salomonjp.myshopify.com&limit=16&sort=best-selling&display=grid&collection_scope=637398188341&tag=&product_available=false&variant_available=false&build_filter_tree=false&check_cache=false&locale=ja&sid=f56616d6-dbf5-4e87-a455-9f8119baef18&callback=BoostPFSFilterCallback&event_type=page';
        $step = 1;
        //取得したい商品カテゴリ
        $getCategorys = [
            'スノーボードブーツ','スノーボードビンディング','オールマウンテン','フリースタイル','フリーライド',
            
        ];

        while (true) {
            // データ取得
            //APIにHTTPリクエストを送って、データを取得
            $response = Http::get($url . "&page=" . $step);
            //APIのレスポンス（データの本体）を取得
            $responseBody = $response->body();

            // データ加工 
            // 余計な文字列を削除し、JSONをデコード
            $torimingBody = preg_replace('/^.*?BoostPFSFilterCallback\(|\);?\s*$/s', '', $responseBody);
            $data = json_decode($torimingBody, true);
            //取得したデータが空ならループを終了
            if (count($data["products"]) == 0) {
                break;
            }

            // データ出力
            foreach ($data['products'] as $pref){
                // print_r($pref["title"] . " : " . $pref["price_max"] . "\r\n");
                //取得した商品のリストを pref という変数に入れてループ処理
                
                foreach($getCategorys as $category){
                    if (in_array($category, $pref['tags'])) {
                        Item::create([
                            'title' => $pref['title'],
                            'category' => $category,
                            'price' => $pref['price_max'], 
                            'detail' => $pref['body_html'],
                        ]);
                        break;
                    }
                }
            }
            
            
            $step++;
            //ページのデータ処理が終わったら、次のページへ進み、再びAPIを呼び出す
        }
        
        
        
        
    }
}
