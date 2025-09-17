<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            [
                'title' => 'إدارة الأعمال',
                'description' => "يُعد تخصص إدارة الأعمال من التخصصات الحيوية التي تهدف إلى إعداد كوادر مؤهلة تمتلك فهماً شاملاً للمفاهيم الإدارية والمهارات القيادية...",
                'image1' => 'assets/img/ic_settings.png',
                'image2' => 'assets/img/ic_tasks.png',
                'image3' => 'assets/img/ic_breafcase.png',
            ],
            [
                'title' => 'سلسلة الأمدادات',
                'description' => "يُعد تخصص سلسلة الإمدادات أحد التخصصات الحديثة التي تجمع بين مفاهيم الإدارة واللوجستيات والتقنيات الحديثة...",
                'image1' => 'assets/img/ic_logic.png',
                'image2' => 'assets/img/ic_automation.png',
                'image3' => 'assets/img/ic_supply_chain.png',
            ],
            [
                'title' => 'المحاسبة',
                'description' => "يُعد تخصص إدارة الأعمال من التخصصات الحيوية التي تهدف إلى إعداد كوادر مؤهلة تمتلك فهماً شاملاً للمفاهيم الإدارية والمهارات القيادية...",
                'image1' => 'assets/img/ic_budget.png',
                'image2' => 'assets/img/ic_bank.png',
                'image3' => 'assets/img/ic_budgeting.png',
            ],
            [
                'title' => 'المالية',
                'description' => "يُعد تخصص المالية من التخصصات الحيوية في عالم الأعمال، حيث يجمع بين المفاهيم الاقتصادية والمهارات التحليلية والقرارات الاستثمارية...",
                'image1' => 'assets/img/ic_economic.png',
                'image2' => 'assets/img/ic_financial.png',
                'image3' => 'assets/img/ic_saveing.png',
            ],
            [
                'title' => 'المخاطر والتأمين',
                'description' => "يُعد تخصص المخاطر والتأمين من التخصصات المهمة التي تجمع بين المفاهيم الإدارية والمالية والقانونية...",
                'image1' => 'assets/img/ic_risk.png',
                'image2' => 'assets/img/ic_risk_management.png',
                'image3' => 'assets/img/ic_gover.png',
            ],
            [
                'title' => 'نظم المعلومات',
                'description' => "يُعد تخصص نظم المعلومات الإدارية أحد التخصصات الحديثة التي تجمع بين تقنيات المعلومات ومفاهيم الإدارة...",
                'image1' => 'assets/img/ic_laptop.png',
                'image2' => 'assets/img/ic_pc.png',
                'image3' => 'assets/img/ic_db.png',
            ],
            [
                'title' => 'اقتصاديات الاعمال',
                'description' => "يُعد تخصص اقتصاديات الأعمال من التخصصات التي تمزج بين المفاهيم الاقتصادية والتطبيقات الإدارية...",
                'image1' => 'assets/img/ic_inversment.png',
                'image2' => 'assets/img/ic_s_ecomomecs.png',
                'image3' => 'assets/img/ic_economeic2.png',
            ],
        ];
        foreach ($specializations as $spec) {
            Specialization::create($spec);
        }
    }
}
