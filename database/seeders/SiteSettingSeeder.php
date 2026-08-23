<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::firstOrCreate(
            ['key' => 'speaker_image'],
            ['type' => 'image', 'value' => '/images/speaker_portrait.png']
        );

        SiteSetting::firstOrCreate(
            ['key' => 'speaker_welcome_speech'],
            ['type' => 'text', 'value' => 'Dedicated to transparent governance, impactful legislation, and empowering citizens across the nation through visionary leadership.']
        );

        // Seed default about page settings
        SiteSetting::firstOrCreate(
            ['key' => 'about_title'],
            ['type' => 'text', 'value' => 'Office of the Speaker of the House of Representatives']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'about_subtitle'],
            ['type' => 'text', 'value' => 'The constitutional mandate, leadership profile, and structure of the House of Representatives.']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'about_constitutional_role'],
            ['type' => 'text', 'value' => 'Under Section 50 of the Constitution of the Federal Republic of Nigeria, the Speaker of the House of Representatives acts as the presiding officer of the House. The Speaker coordinates the legislative activity of the lower chamber of the National Assembly, represents the house in external communications, and acts on behalf of the constituency represented.']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'about_legislative_agenda'],
            ['type' => 'text', 'value' => 'The office focuses on steering the legislative agenda towards socio-economic development, robust security oversight, educational empowerment, infrastructural progress, and transparency in public resource utilization.']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'about_coat_of_arms_title'],
            ['type' => 'text', 'value' => 'Federal Republic of Nigeria']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'about_coat_of_arms_text'],
            ['type' => 'text', 'value' => 'Our institution acts as the voice of the Nigerian populace across 360 federal constituencies. All programs and projects published on this portal represent the verified stewardship of the Office.']
        );

        // Seed Speaker Biography settings
        SiteSetting::firstOrCreate(
            ['key' => 'speaker_name'],
            ['type' => 'text', 'value' => 'Rt. Hon. Tajudeen Abbas, Ph.D']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'speaker_title'],
            ['type' => 'text', 'value' => 'Speaker, 10th House of Representatives, Federal Republic of Nigeria']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'speaker_biography'],
            ['type' => 'text', 'value' => 'Rt. Hon. Tajudeen Abbas, Ph.D, is a distinguished academician, public administrator, and senior legislator. Serving as the Speaker of the 10th House of Representatives, he has sponsored numerous legislative bills and spearheaded reforms aimed at economic revitalisation, national security oversight, and transparent public resource governance. Prior to his ascension to the Speakership, he enjoyed an exemplary career in public service and academia, earning recognition for visionary leadership and legislative integrity.']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'speaker_constituency'],
            ['type' => 'text', 'value' => 'Zaria Federal Constituency, Kaduna State']
        );
        SiteSetting::firstOrCreate(
            ['key' => 'speaker_education'],
            ['type' => 'text', 'value' => 'Ph.D in Business Management (UDUS), M.Sc & B.Sc in Business Administration (ABU Zaria)']
        );
    }
}
