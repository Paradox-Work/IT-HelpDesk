<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the user's tickets.
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|image|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('ticket-attachments', 'public');
        }

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $attachmentPath,
            'priority' => $request->priority,
            'status' => 'open',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        if (! $this->canAccessTicket($ticket)) {
            abort(403);
        }
        $ticket->load(['replies.user']);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the ticket.
     */
    public function edit(Ticket $ticket)
    {
        // Ensure user can only edit their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Only allow editing if ticket is open
        if ($ticket->status === 'closed') {
            return redirect()->route('tickets.show', $ticket)
                ->with('error', 'Cannot edit a closed ticket.');
        }
        
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Ensure user can only update their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully!');
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy(Ticket $ticket)
    {
        // Ensure user can only delete their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Only allow deletion if ticket is open
        if ($ticket->status === 'closed') {
            return redirect()->route('tickets.show', $ticket)
                ->with('error', 'Cannot delete a closed ticket.');
        }
        
        $ticket->delete();
        
        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }

    /**
     * Store a reply (chat message) for a ticket.
     */
    public function storeReply(Request $request, Ticket $ticket)
    {
        if (! $this->canAccessTicket($ticket)) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('ticket-replies', 'public');
        }

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Reply sent.');
    }

    /**
     * Poll replies for a ticket (returns HTML partial).
     */
    public function pollReplies(Ticket $ticket)
    {
        if (! $this->canAccessTicket($ticket)) {
            abort(403);
        }

        $ticket->load(['replies.user']);

        return view('tickets.partials.replies', [
            'ticket' => $ticket,
        ]);
    }

    private function canAccessTicket(Ticket $ticket): bool
    {
        $user = Auth::user();
        if (! $user) {
            return false;
        }

        return $user->is_admin || $ticket->user_id === $user->id;
    }
}
