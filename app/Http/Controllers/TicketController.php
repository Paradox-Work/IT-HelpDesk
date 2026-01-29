<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
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
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
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
        // Ensure user can only view their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
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
}