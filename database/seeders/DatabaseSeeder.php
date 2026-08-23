<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            StateAndLgaSeeder::class,
            DemoDataSeeder::class,
        ]);

        // Seed default settings
        \App\Models\SiteSetting::firstOrCreate(
            ['key' => 'speaker_image'],
            ['type' => 'image', 'value' => '/images/speaker_portrait.png']
        );
        \App\Models\SiteSetting::firstOrCreate(
            ['key' => 'speaker_welcome_speech'],
            ['type' => 'text', 'value' => 'Dedicated to transparent governance, impactful legislation, and empowering citizens across the nation through visionary leadership.']
        );

        // Seed default hero slides
        \App\Models\HeroSlide::firstOrCreate(
            ['title' => 'Speaker of the House of Representatives'],
            [
                'subtitle' => 'Leading Legislative Excellence for a Stronger Nigeria.',
                'badge' => 'Institutional Information Portal',
                'link_text' => 'Explore Achievements',
                'link_url' => '/achievements',
                'sort_order' => 1,
                'status' => 'published',
            ]
        );
        \App\Models\HeroSlide::firstOrCreate(
            ['title' => 'Empowering Communities Nationwide'],
            [
                'subtitle' => 'Delivering infrastructure, healthcare, and educational facilities to boost local economies.',
                'badge' => 'Constituency Development',
                'link_text' => 'View Projects',
                'link_url' => '/projects',
                'sort_order' => 2,
                'status' => 'published',
            ]
        );
        \App\Models\HeroSlide::firstOrCreate(
            ['title' => 'Enacting Laws for National Progress'],
            [
                'subtitle' => 'Fostering transparent debates and enacting citizen-centric reforms for a sustainable future.',
                'badge' => 'Legislative Mandate',
                'link_text' => 'Legislative Work',
                'link_url' => '/legislative-work',
                'sort_order' => 3,
                'status' => 'published',
            ]
        );

        // Create Admin User
        $admin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@speaker.gov.ng',
            'password' => Hash::make('AdminSecure2026!'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Super Admin');

        // Create Publisher User
        $publisher = User::create([
            'name' => 'Official Publisher',
            'email' => 'publisher@speaker.gov.ng',
            'password' => Hash::make('PublisherSecure2026!'),
            'email_verified_at' => now(),
        ]);
        $publisher->assignRole('Publisher');

        // Create Editor User
        $editor = User::create([
            'name' => 'Official Editor',
            'email' => 'editor@speaker.gov.ng',
            'password' => Hash::make('EditorSecure2026!'),
            'email_verified_at' => now(),
        ]);
        $editor->assignRole('Editor');
    }
}
