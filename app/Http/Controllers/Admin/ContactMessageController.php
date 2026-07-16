<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name, email, subject
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(20);
        
        // Count stats
        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('status', 'new')->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
            'archived' => ContactMessage::where('status', 'archived')->count(),
        ];

        return view($this->getRoutePrefix() . '.contact-messages.index', compact('messages', 'stats'));
    }

    /**
     * Display the specified contact message.
     */
    public function show(ContactMessage $message)
    {
        // Auto-mark as read when viewed
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        return view($this->getRoutePrefix() . '.contact-messages.show', compact('message'));
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(ContactMessage $message)
    {
        $message->update(['status' => 'read']);
        return back()->with('success', 'Message marqué comme lu.');
    }

    /**
     * Mark message as unread.
     */
    public function markAsUnread(ContactMessage $message)
    {
        $message->update(['status' => 'new']);
        return back()->with('success', 'Message marqué comme non lu.');
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route($this->getRoutePrefix() . '.contact-messages.index')
                     ->with('success', 'Message supprimé.');
    }

    protected function getRoutePrefix()
    {
        return auth()->user()->role === 'manager' ? 'manager' : 'admin';
    }
}