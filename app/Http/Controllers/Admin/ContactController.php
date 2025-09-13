<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\DataTables\ContactDataTable;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the contact form submissions.
     */
    public function index(ContactDataTable $dataTable)
    {
        return $dataTable->render('admin.contacts.index');
    }

    /**
     * Display the specified contact form submission.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Remove the specified contact form submission from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return redirect()->route('admin.contacts.index')
                ->with('success', 'Contact form submission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.contacts.index')
                ->with('error', 'Error deleting contact form submission.');
        }
    }
}
