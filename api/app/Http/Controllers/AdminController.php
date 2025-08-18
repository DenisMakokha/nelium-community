<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\AuditLog;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_members' => User::where('role', 'member')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'monthly_revenue' => Payment::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount_cents'),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount_cents'),
            'recent_members' => User::where('role', 'member')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(['id', 'name', 'email', 'created_at']),
            'recent_payments' => Payment::with(['user', 'subscription.plan'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'subscription_breakdown' => Subscription::join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->select('plans.name', DB::raw('count(*) as count'))
                ->where('subscriptions.status', 'active')
                ->groupBy('plans.name')
                ->get(),
            'monthly_signups' => User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
        ];

        return response()->json($stats);
    }

    public function members(Request $request)
    {
        $query = User::with(['subscription.plan'])
            ->where('role', 'member');

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by plan
        if ($request->has('plan') && $request->plan !== 'all') {
            $query->whereHas('subscription.plan', function($q) use ($request) {
                $q->where('code', $request->plan);
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'active') {
                $query->whereHas('subscription', function($q) {
                    $q->where('status', 'active');
                });
            } elseif ($request->status === 'inactive') {
                $query->whereDoesntHave('subscription');
            } else {
                $query->whereHas('subscription', function($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }
        }

        $members = $query->paginate(20);

        // Add CORS headers
        return response()->json($members)->header('Access-Control-Allow-Origin', '*');
    }

    public function createMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:160',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'org' => 'sometimes|string|max:160',
            'country' => 'sometimes|string|max:100',
            'profession' => 'sometimes|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'org' => $request->org,
            'country' => $request->country,
            'profession' => $request->profession,
            'email_verified_at' => now()
        ]);

        // Log the action
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'member_created',
            'description' => "Created member: {$user->name} ({$user->email})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'message' => 'Member created successfully',
            'user' => $user
        ]);
    }

    public function updateMember(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:160',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'status' => 'sometimes|in:active,suspended',
            'plan_id' => 'sometimes|exists:plans,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update user
            $user->update($request->only(['name', 'email']));

            // Update subscription if plan changed
            if ($request->has('plan_id') && $user->subscription) {
                $user->subscription->update([
                    'plan_id' => $request->plan_id
                ]);
            }

            // Log the action
            AuditLog::create([
                'actor_id' => auth()->id(),
                'action' => 'member_updated',
                'entity_type' => 'User',
                'entity_id' => $user->id,
                'meta' => $request->only(['name', 'email', 'plan_id']),
                'created_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Member updated successfully',
                'user' => $user->fresh(['subscription.plan'])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to update member'
            ], 500);
        }
    }

    public function suspendMember(User $user)
    {
        DB::beginTransaction();
        try {
            // Cancel active subscription
            if ($user->subscription && $user->subscription->status === 'active') {
                $user->subscription->update([
                    'status' => 'cancelled',
                    'cancel_at_period_end' => true
                ]);
            }

            // Log the action
            AuditLog::create([
                'actor_id' => auth()->id(),
                'action' => 'member_suspended',
                'entity_type' => 'User',
                'entity_id' => $user->id,
                'created_at' => now()
            ]);

            DB::commit();

            return response()->json(['message' => 'Member suspended successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to suspend member'
            ], 500);
        }
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['user', 'subscription.plan'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from') && $request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->has('to') && $request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $payments = $query->paginate(20);

        return response()->json($payments);
    }

    public function subscriptions(Request $request)
    {
        $query = Subscription::with(['user', 'plan'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->has('plan') && $request->plan !== 'all') {
            $query->whereHas('plan', function($q) use ($request) {
                $q->where('code', $request->plan);
            });
        }

        $subscriptions = $query->paginate(20);

        return response()->json($subscriptions);
    }

    public function announcements(Request $request)
    {
        try {
            $query = Announcement::with('author');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }

            // Filter by status
            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            // Filter by priority
            if ($request->has('priority') && $request->priority !== 'all') {
                $query->where('priority', $request->priority);
            }

            $announcements = $query->orderBy('created_at', 'desc')->paginate(20);
            
            \Log::info('Announcements query result: ', [
                'total' => $announcements->total(),
                'count' => $announcements->count(),
                'items' => $announcements->items()
            ]);

            return response()->json($announcements);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch announcements: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to fetch announcements',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createAnnouncement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:draft,published,archived',
            'scheduled_at' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $announcement = Announcement::create([
                'title' => $request->title,
                'content' => $request->content,
                'priority' => $request->priority,
                'status' => $request->status,
                'scheduled_at' => $request->scheduled_at,
                'author_id' => auth()->id()
            ]);

            // Log the action
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'announcement_created',
                'description' => "Created announcement: {$announcement->title}",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'message' => 'Announcement created successfully',
                'announcement' => $announcement->load('author')
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create announcement: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:draft,published,archived',
            'scheduled_at' => 'nullable|date|after:now'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $announcement->update($request->only([
            'title', 'content', 'priority', 'status', 'scheduled_at'
        ]));

        // Log the action
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'announcement_updated',
            'description' => "Updated announcement: {$announcement->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'message' => 'Announcement updated successfully',
            'announcement' => $announcement->load('author')
        ]);
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        // Log the action before deletion
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'announcement_deleted',
            'description' => "Deleted announcement: {$announcement->title}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        $announcement->delete();

        return response()->json(['message' => 'Announcement deleted successfully']);
    }

    public function events(Request $request)
    {
        $query = Event::with('creator');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location_text', 'like', "%{$search}%");
            });
        }

        // Filter by location type
        if ($request->has('location_type') && $request->location_type !== 'all') {
            $query->where('location_type', $request->location_type);
        }

        // Filter by tier
        if ($request->has('tier') && $request->tier !== 'all') {
            $query->where('tier_min', $request->tier);
        }

        $events = $query->orderBy('starts_at', 'desc')->paginate(20);

        return response()->json($events);
    }

    public function createEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starts_at' => 'required|date|after:now',
            'ends_at' => 'required|date|after:starts_at',
            'location_type' => 'required|in:online,physical,hybrid',
            'location_text' => 'required|string|max:500',
            'tier_min' => 'required|in:FREE,IND,INST',
            'rsvp_required' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'description' => $request->description,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'location_type' => $request->location_type,
            'location_text' => $request->location_text,
            'tier_min' => $request->tier_min,
            'rsvp_required' => $request->rsvp_required ?? false,
            'created_by' => auth()->id()
        ]);

        // Log the action
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'event_created',
            'description' => "Created event: {$event->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event->load('creator')
        ]);
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'starts_at' => 'sometimes|date',
            'ends_at' => 'sometimes|date|after:starts_at',
            'location_type' => 'sometimes|in:online,physical,hybrid',
            'location_text' => 'sometimes|string|max:500',
            'tier_min' => 'sometimes|in:FREE,IND,INST',
            'rsvp_required' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only([
            'title', 'description', 'starts_at', 'ends_at', 
            'location_type', 'location_text', 'tier_min', 'rsvp_required'
        ]);

        if (isset($updateData['title'])) {
            $updateData['slug'] = \Str::slug($updateData['title']);
        }

        $event->update($updateData);

        // Log the action
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'event_updated',
            'description' => "Updated event: {$event->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event->load('creator')
        ]);
    }

    public function deleteEvent(Event $event)
    {
        // Log the action before deletion
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'event_deleted',
            'description' => "Deleted event: {$event->title}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function resources(Request $request)
    {
        $query = Resource::with('creator');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by tier
        if ($request->has('tier') && $request->tier !== 'all') {
            $query->where('tier_min', $request->tier);
        }

        $resources = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($resources);
    }

    public function createResource(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'tier_min' => 'required|in:FREE,IND,INST',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:10240',
            'tags' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle file upload
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('resources', $filename, 'public');

        $resource = Resource::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'description' => $request->description,
            'category' => $request->category,
            'tier_min' => $request->tier_min,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getClientMimeType(),
            'tags' => $request->tags,
            'created_by' => auth()->id()
        ]);

        // Log the action
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'resource_created',
            'description' => "Created resource: {$resource->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'message' => 'Resource created successfully',
            'resource' => $resource->load('creator')
        ]);
    }

    public function updateResource(Request $request, Resource $resource)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string|max:100',
            'tier_min' => 'sometimes|in:FREE,IND,INST',
            'file' => 'sometimes|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:10240',
            'tags' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only([
            'title', 'description', 'category', 'tier_min', 'tags'
        ]);

        if (isset($updateData['title'])) {
            $updateData['slug'] = \Str::slug($updateData['title']);
        }

        // Handle file replacement if new file uploaded
        if ($request->hasFile('file')) {
            // Delete old file
            if ($resource->file_path && \Storage::disk('public')->exists($resource->file_path)) {
                \Storage::disk('public')->delete($resource->file_path);
            }

            // Upload new file
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('resources', $filename, 'public');

            $updateData['file_path'] = $path;
            $updateData['file_name'] = $file->getClientOriginalName();
            $updateData['file_size'] = $file->getSize();
            $updateData['file_type'] = $file->getClientMimeType();
        }

        $resource->update($updateData);

        // Log the action
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'resource_updated',
            'description' => "Updated resource: {$resource->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'message' => 'Resource updated successfully',
            'resource' => $resource->load('creator')
        ]);
    }

    public function deleteResource(Resource $resource)
    {
        // Delete file from storage
        if ($resource->file_path && \Storage::disk('public')->exists($resource->file_path)) {
            \Storage::disk('public')->delete($resource->file_path);
        }

        // Log the action before deletion
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'resource_deleted',
            'description' => "Deleted resource: {$resource->title}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        $resource->delete();

        return response()->json(['message' => 'Resource deleted successfully']);
    }

    public function reports()
    {
        $reports = [
            'revenue_by_month' => Payment::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(amount_cents) as revenue')
                ->where('status', 'completed')
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get(),
            'signups_by_month' => User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as signups')
                ->where('role', 'member')
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get(),
            'plan_distribution' => Subscription::join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->select('plans.name', 'plans.code', DB::raw('count(*) as count'))
                ->where('subscriptions.status', 'active')
                ->groupBy('plans.id', 'plans.name', 'plans.code')
                ->get(),
            'churn_rate' => [
                'cancelled_this_month' => Subscription::where('status', 'cancelled')
                    ->whereMonth('updated_at', now()->month)
                    ->count(),
                'active_start_month' => Subscription::where('status', 'active')
                    ->whereMonth('created_at', '<=', now()->startOfMonth())
                    ->count()
            ]
        ];

        return response()->json($reports);
    }

    public function auditLogs(Request $request)
    {
        $query = AuditLog::with('actor')
            ->orderBy('created_at', 'desc');

        // Filter by action
        if ($request->has('action') && $request->action !== 'all') {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->has('from') && $request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->has('to') && $request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs = $query->paginate(50);

        return response()->json($logs);
    }
}
