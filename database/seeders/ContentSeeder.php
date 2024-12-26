<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Content;
use Illuminate\Support\Carbon;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contents')->insert([
            [
                'text' => 'この間さ、なんかすごい大きなイベントがあってさ...',
                'title' => 'インフルエンサー効果とイベントの成功要因、課題を振り返る',
                'structure' => json_encode([
                    'イベントの概要' => [
                        '参加者' => '多岐にわたる年齢層',
                        '主なコンテンツ' => [
                            'インフルエンサーとの交流',
                            'VR体験',
                            'ゲーム大会',
                            '抽選会',
                        ],
                        '特徴' => 'インフルエンサーの登場による会場全体の盛り上がり、様々なアクティビティの提供',
                    ],
                    '成功要因' => [
                        'インフルエンサー効果' => 'SNSで人気のインフルエンサーの登場が...',
                        '多様なアクティビティ' => 'VR体験やゲーム大会など、幅広い層が楽しめる...',
                        'コミュニティの形成' => 'イベントを通じて参加者同士が交流し...',
                        '抽選会による高揚感' => '抽選会で思わぬ高額賞品が当たるなど...',
                    ],
                ]),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'text' => '先週末に開催された地域のフェスティバルに行ってきたんだけど、すごく楽しかった！',
                'title' => '地域フェスティバルの成功と住民のつながり強化',
                'structure' => json_encode([
                    'イベントの概要' => [
                        '参加者' => '家族連れや高齢者など幅広い層',
                        '主なコンテンツ' => [
                            '地元のフードブース',
                            'アート展示',
                            'ライブパフォーマンス',
                            '子ども向けワークショップ',
                        ],
                        '特徴' => '地域コミュニティ全体での参加と交流を目的としたイベント',
                    ],
                ]),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'text' => 'この前参加したオンラインカンファレンス、予想以上に充実してた！',
                'title' => 'オンラインカンファレンスの可能性と課題',
                'structure' => json_encode([
                    'イベントの概要' => [
                        '参加者' => 'IT業界の専門家や学生',
                        '主なコンテンツ' => [
                            '基調講演',
                            'パネルディスカッション',
                            'オンラインネットワーキングセッション',
                            '技術デモ',
                        ],
                        '特徴' => '全てオンラインで実施され、世界中の参加者がアクセス可能',
                    ],
                ]),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
