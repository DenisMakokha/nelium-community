<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Announcement;

class TestAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:announcements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test announcements functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing announcements...');
        
        // Check total count
        $count = Announcement::count();
        $this->info("Total announcements in database: {$count}");
        
        // List recent announcements
        $announcements = Announcement::latest()->take(5)->get();
        $this->info("Recent announcements:");
        
        foreach ($announcements as $announcement) {
            $this->line("- ID: {$announcement->id}, Title: {$announcement->title}, Status: {$announcement->status}");
        }
        
        // Test creating an announcement
        try {
            $testAnnouncement = Announcement::create([
                'title' => 'Test Announcement ' . now()->format('Y-m-d H:i:s'),
                'content' => 'This is a test announcement content',
                'priority' => 'medium',
                'status' => 'draft',
                'author_id' => 1
            ]);
            
            $this->info("Successfully created test announcement with ID: {$testAnnouncement->id}");
        } catch (\Exception $e) {
            $this->error("Failed to create test announcement: " . $e->getMessage());
        }
        
        // Check count after creation
        $newCount = Announcement::count();
        $this->info("Total announcements after test: {$newCount}");
    }
}
